var info = []; //result getInfoHeatWeb
var addresses = []; //Sucursales del cliente seleccionado
var shippingWays = [];
var shippingWaysList = [];
var packageDeliveries = [];
var items = []; //result inventario getItems/All
var pendingSaleOrders = []; //result PedidosPendientesCTE
var promocionesCliente = []; //result getEventosCliente para cargar codigos de promociones activas para el cliente
var checkPromocionesCliente = true;
var jsonItemsSeparar = "";
var ignorarRegalos = [];
var noCotizacionNS = 0;
var ofertasVolumen = "";

var indexFocus = []; //guardar el index de las filas editadas para que parpadeen después de crear nuevamente la tabla
var intervalVar; //variable para asignar intervalo y hacer clear al intervalo después de x segundos+
var itemToFocus; //saber qué artículo debe resaltarse después de crear nuevamente la tabla

var selectedItemsFromInventory = [];
var cantItemsPorCargar = 0;
var cantItemsCargados = 0;

var pedido = [];
var pedidoSeparado = []; //result separaPedidosPromo
var tranIds = []; //arreglo con transids que retorna netsuite para indicarlos en correo
var dataset = []; //arreglo cargado en datatable de inventario 
var currentDataset = []; //variable para guardar actual dataset de inventario cuando filtran existencias


var tipoDesc; //variable para cuando se aplique desneg o desgar identificar cuál de los dos es

// VARIABLES GLOBALES PARA CAMBIAR DE FLETERA Y FORMA DE ENVÍO CUANDO CAMBIA CLIENTE O SUCURSAL
var indexCustomer = 0;
var indexAddress = 0;
var priceList = ''; //guardar lista de precio para no refrescar el invenrario al cambiar cliente, si la lista es la misma al cliente anterior
var lastRefreshInventory = ''; //datetime de ultimo refresh de inventario. Si pasó más de 1 hora refrescar aunque la lista sea la misma. 
var oneHour = 60 * 60 * 1000; /* ms */

// VARIABLE PARA DETECTAR CUANDO EL INVENTARIO ESTÁ CARGADO
var intervalInventario;
// CODIGO DE CLIENTE
var entity;
var entityCte;

//TIPO PEDIDO. 1 = PEDIDO CREADO POR CLIENTE;  0 = PEDIDO CREADO POR VENDEDOR
var tipoPedido = 0;
//TIPO GET ITEM BY ID. 0 = CON AJAX, EJECUTAR REQUEST DE API GETITEMBYID; 1 = DEL INVENTARIO, SIRVE PARA CARGAR PEDIDOS CREADOS POR CLIENTES Y CUANDO SON MUY LARGOS (MUCHAS PARTIDAS) NO DE PROBLEMAS PARA CARGARLOS
var tipoGetItemById = 0;
var pedidoCargadoCte = 0;

$(document).ready(function () {

    window['adrum-config'] = {
        xhr: {
            maxPerPageView: "UNLIMITED"
        }
    };

    //Inicia Ajax
    $(document).ajaxStart(function () {
        document.getElementById("btnSpinner").style.display = "block";
        var btnActions = document.getElementsByClassName('btn-group-buttons');
        for (var x = 0; x < btnActions.length; x++) {
            btnActions[x].disabled = true;
        }
    });

    //Func Termina Ajax
    $(document).ajaxStop(function () {
        document.getElementById("btnSpinner").style.display = "none";
        var btnActions = document.getElementsByClassName('btn-group-buttons');
        for (var x = 0; x < btnActions.length; x++) {
            btnActions[x].disabled = false;
        }
    });

    entity = document.getElementById('entity').value;
    entity = entity.toUpperCase();
    if (entity.startsWith("C") || entity.startsWith("E")) { //si es codigo de cliente o empleado
        getEventosCliente(entity);
        intervalInventario = window.setInterval(checkItems, 1000);
        getItems(entity, true);
    }
    else { //si es zona o all (vendedor o apoyo)
        document.getElementById('loading-message').innerHTML = 'Selecciona un cliente para cargar inventario';
    }

    const fileSelector = document.getElementById('excelCodes');
    fileSelector.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[wb['SheetNames'][0]]);
            var jsonObj = JSON.stringify(rowObj);
            cargarProductosExcel(jsonObj);
        };
        reader.readAsBinaryString(input.files[0]);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "GET",
        enctype: 'multipart/form-data',
        url: "nuevo/getInfoHeatWeb/" + entity,
        data: FormData,
        'async': false,
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function (data) {
            info = data;
            var skeleton = document.getElementsByClassName('skeleton-input');
            for (var x = 0; x < skeleton.length; x++) {
                skeleton[x].classList.add('d-none');
            }

            var dropdown = document.getElementsByClassName('dropdown');
            for (var x = 0; x < dropdown.length; x++) {
                dropdown[x].classList.remove('d-none');
            }

            document.getElementById('cliente_recogeSkeleton').classList.add('d-none');
            document.getElementById('cliente_recogeLabel').classList.remove('d-none');
            document.getElementById('separar2000Label').classList.remove('d-none');
            document.getElementById('customerID').classList.remove('d-none');
            document.getElementById('customerIDLabel').classList.remove('d-none');
            document.getElementById('ordenCompra').classList.remove('d-none');
            document.getElementById('ordenCompraLabel').classList.remove('d-none');
            document.getElementById('correo').classList.remove('d-none');
            document.getElementById('correoLabel').classList.remove('d-none');
            document.getElementById('sucursal').classList.remove('d-none');
            document.getElementById('sucursalLabel').classList.remove('d-none');
            document.getElementById('containerSelectEnvio').classList.remove('d-none');
            document.getElementById('envioLabel').classList.remove('d-none');
            document.getElementById('fletera').classList.remove('d-none');
            document.getElementById('fleteraLabel').classList.remove('d-none');
            document.getElementById('tags-promo').classList.remove('d-none');
            document.getElementById('tags-promoLabel').classList.remove('d-none');
            document.getElementById('cupon').classList.remove('d-none');
            document.getElementById('cuponLabel').classList.remove('d-none');

        },
        error: function (error) {

        }
    });

    if (window.location.href.includes('pedido/editar')) { //SI EL PEDIDO VA A SER ACTUALIZADO, CARGAR INFORMACIÓN PREVIA
        var addresses = info[0]['addresses'];
        for (var x = 0; x < addresses.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal
            // AGREGAR ICONO DE BILLING O SHIPPING PARA IDENTIFICAR LAS DIRECCIONES DEL CLIENTE
            if (addresses[x]['defaultShipping'] == true && addresses[x]['defaultBilling'] == true) //SI ES BILLING Y SHIPPING AGREGAR LOS 2 ICONOS
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-shipping-fast\'></i> <i class=\'fas fa-file-invoice\'></i> ' + addresses[x]['address'] + '"</option>');
            if (addresses[x]['defaultShipping'] == false && addresses[x]['defaultBilling'] == true) //SI ES BILLING PERO NO ES SHIPPING
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-file-invoice\'></i> ' + addresses[x]['address'] + '"</option>');
            if (addresses[x]['defaultShipping'] == true && addresses[x]['defaultBilling'] == false) //SI ES SHIPPING PERO NO BILLING
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-shipping-fast\'></i> ' + addresses[x]['address'] + '"</option>');
            if (addresses[x]['defaultShipping'] == false && addresses[x]['defaultBilling'] == false) //SI ES SHIPPING PERO NO BILLING
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="' + addresses[x]['address'] + '"</option>');
        }
        $('#sucursal').selectpicker('refresh');

        fillShippingWaysList();

        document.getElementById('loading-message').innerHTML = 'Cargando pedido ...';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            url: "/pedido/getCotizacionIdWeb/" + document.getElementById('idCotizacion').value,
            data: FormData,
            'async': false,
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function (data) {
                $('#sucursal').val(data['addressId']); //Seleccionar la sucursal que se guardó en la cotizacion
                $('#sucursal').selectpicker('refresh');
                var indexShippingWay = shippingWaysList.findIndex(o => o.fletera === data['shippingWay']);
                $('#selectEnvio').val(indexShippingWay); //Seleccionar fletera que corresponde a la sucursal guardada
                $('#selectEnvio').selectpicker('refresh');
                $('#fletera').val(data['packageDelivery']);
                $('#correo').val(data['email']);

                if (data['pickUp'] == 1) {
                    $('#cliente_recoge').prop("checked", true);
                }

                if (data['divide'] == 1) {
                    $('#dividir').prop("checked", true);
                }

                for (var x = 0; x < data['order'].length; x++) {
                    for (var y = 0; y < data['order'][x]['items'].length; y++) {
                        var art = selectedItemsFromInventory.find(o => o.item === data['order'][x]['items'][y]['itemid'].trim());
                        if (art != undefined)
                            art['cant'] = (parseInt(art['cant']) + parseInt(data['order'][x]['items'][y]['cantidad'])).toString();
                        else
                            selectedItemsFromInventory.push({ item: data['order'][x]['items'][y]['itemid'].trim(), cant: data['order'][x]['items'][y]['cantidad'] });
                        cantItemsPorCargar++;
                    }
                }

            },
            error: function (error) {
                alert('Error cargando pedido');
            }
        });
    }

    $('#modalInventario').on('hidden.bs.modal', function () {
        prepareJsonSeparaPedidos(false);
        // save(5) //pre guardar el pedido después de cargar excel
    })

    $('#modalNetsuiteLoading').on('hidden.bs.modal', function () {
        selectedItemsFromInventory = []; //vaciar arreglo de articulos seleccionados
        pedido = []; //vaciar pedido
        ignorarRegalos = [];
        document.getElementById('cupon').value = ''; //limpiar campo cupon
        document.getElementById('comments').value = ''; //limpiar campo comentarios
        document.getElementById('ordenCompra').value = ''; //limpiar campo orden compra
        $('#separar2000').prop("checked", false);
        createTablePedido(); //limpiar tabla pedido
        clearNetsuiteModal(); //limpiar modal de pedidos enviados a netsuite
    })


    // UPDATE ADDRESSES AND DEFAULT SHIPPING WAT / PACKAGING WHEN CUSTOMER IS SELECTED ----------------------------------------------------------------

    $('#customerID').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) { //AQUI DECLARAR TODO LO QUE PASE AL CAMBIAR DE CLIENTE
        var selected = clickedIndex - 1;
        indexCustomer = selected;
        var refrescaInventario = false;
        tipoPedido = 0; // esta variable controla el campo CapturadoXCte, si cambia el cliente poner en 0 nuevamente 
        tipoGetItemById = 0;
        //INFO es la lista de todos los clientes con su información correspondiente
        addresses = info[selected]['addresses']; //obtener lista de domicilios del cliente seleccionado
        shippingWays = info[selected]['shippingWays']; //obtener formas de envío del cliente seleccionado
        packageDeliveries = info[selected]['packageDeliveries']; //obtener paqueterías del cliente seleccionado
        document.getElementById('entity').value = info[selected]["companyId"];
        entityCte = info[selected]["companyId"];

        if (priceList != '' && priceList != info[selected]['priceList']) { refrescaInventario = true; } //si ya existe una lista de precio cargada y es diferente a a del nuevo cliente seleccionado
        if (priceList == '') { refrescaInventario = true; } //si aún no se ha cargado ninguna lista
        if (((new Date) - lastRefreshInventory) > oneHour) { refrescaInventario = true; } //si ha pasado más de 1 hora desde la última recarga

        document.getElementById('loading-message').innerHTML = 'Cargando inventario ...';

        document.getElementById('categoryCte').innerHTML = 'Categoría Cliente: ' + info[selected]['category'];

        document.getElementById('categoryCte').classList.remove('d-none');

        selectedItemsFromInventory = []; //vaciar arreglo de articulos seleccionados
        pedido = []; //vaciar pedido
        ignorarRegalos = [];
        document.getElementById('cupon').value = ''; //limpiar campo cupon
        createTablePedido(); //limpiar tabla pedido
        clearNetsuiteModal(); //limpiar modal de pedidos enviados a netsuite

        checkPromocionesCliente = true;
        intervalInventario = window.setInterval(checkItems, 1000);
        getEventosCliente(entityCte);

        if (refrescaInventario) {
            lastRefreshInventory = new Date;
            priceList = info[selected]['priceList'];
            items = [];
            getItems(entityCte, true);
        }

        var selectSucursales = $('#sucursal option');
        selectSucursales.remove();
        $('#sucursal').selectpicker('refresh');

        var defaultShippingSelected = false;
        var indexDefaultShipping = 0;
        for (var x = 0; x < addresses.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal

            // AGREGAR ICONO DE BILLING O SHIPPING PARA IDENTIFICAR LAS DIRECCIONES DEL CLIENTE
            if (addresses[x]['defaultShipping'] == true && addresses[x]['defaultBilling'] == true) //SI ES BILLING Y SHIPPING AGREGAR LOS 2 ICONOS
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-shipping-fast\'></i> <i class=\'fas fa-file-invoice\'></i> ' + addresses[x]['address'] + '"</option>');
            if (addresses[x]['defaultShipping'] == false && addresses[x]['defaultBilling'] == true) //SI ES BILLING PERO NO ES SHIPPING
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-file-invoice\'></i> ' + addresses[x]['address'] + '"</option>');
            if (addresses[x]['defaultShipping'] == true && addresses[x]['defaultBilling'] == false) //SI ES SHIPPING PERO NO BILLING
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-shipping-fast\'></i> ' + addresses[x]['address'] + '"</option>');
            if (addresses[x]['defaultShipping'] == false && addresses[x]['defaultBilling'] == false) //SI ES SHIPPING PERO NO BILLING
                $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="' + addresses[x]['address'] + '"</option>');


            if (addresses[x]['defaultShipping'] == true && !defaultShippingSelected) {//Seleccionar la primera opcion que tenga defaultshipping
                defaultShippingSelected = true;
                indexDefaultShipping = x;
                indexAddress = x;
                $('#sucursal').val(addresses[x]['addressID']);
            }
        }

        if (!defaultShippingSelected) { //si ninguna dirección es defaultshipping, seleccionar la primera
            $('#sucursal').val(addresses[0]['addressID']);
        }

        $('#sucursal').selectpicker('refresh'); //el refresh debe ir después de todos los cambios

        fillShippingWaysList();

        var indexShippingWay = shippingWaysList.findIndex(o => o.fletera === shippingWays[indexDefaultShipping]);
        $('#selectEnvio').val(indexShippingWay); //Seleccionar fletera según el index de default shipping
        $('#selectEnvio').selectpicker('refresh');
        $('#fletera').val(packageDeliveries[indexDefaultShipping]);
        $('#correo').val(info[selected]['email']);
    });

    // UPDATE DEFAULT SHIPPING WAT / PACKAGING WHEN ADDRESS IS CHANGED -------------------------------------------------------------------------------------

    $('#sucursal').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex;
        if (info.length == 1) {
            indexAddress = selected;
            addresses = info[0]['addresses'];
            shippingWays = info[0]['shippingWays'];
            packageDeliveries = info[0]['packageDeliveries'];
            $('#envio').val(shippingWays[selected]);
            $('#fletera').val(packageDeliveries[selected]);
            document.getElementById('envio').classList.remove('d-none');
            document.getElementById('containerSelectEnvio').classList.add('d-none');
        } else {
            indexAddress = selected;
            var indexShippingWay = shippingWaysList.findIndex(o => o.fletera === shippingWays[selected]);
            $('#selectEnvio').val(indexShippingWay); //Seleccionar fletera según la forma de envío
            $('#selectEnvio').selectpicker('refresh');
            $('#fletera').val(packageDeliveries[selected]);
        }

    });

    // UPDATE PACKAGING WHEN SHIPPING WAY IS SELECTED ----------------------------------------------------------------

    $('#selectEnvio').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex;
        $('#fletera').val(shippingWaysList[selected]['paqueteria']);
        prepareJsonSeparaPedidos(true);
    });

    // ZOOM EFFECT

    var native_width = 0;
    var native_height = 0;

    $(".magnify").mousemove(function (e) {
        if (!native_width && !native_height) {

            var image_object = new Image();
            image_object.src = $(".small").attr("src");
            native_width = image_object.width;
            native_height = image_object.height;
        }
        else {
            var src = $(".small").attr("src");
            document.getElementById('zoom').style.background = "url('" + src + "') no-repeat";

            var magnify_offset = $(this).offset();

            var mx = e.pageX - magnify_offset.left;
            var my = e.pageY - magnify_offset.top;

            if (mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0) {
                $(".large").fadeIn(100);
            }
            else {
                $(".large").fadeOut(100);
            }
            if ($(".large").is(":visible")) {

                var rx = Math.round(mx / $(".small").width() * native_width - $(".large").width() / 2) * -1;
                var ry = Math.round(my / $(".small").height() * native_height - $(".large").height() / 2) * -1;
                var bgp = rx + "px " + ry + "px";

                var px = mx - $(".large").width() / 2;
                var py = my - $(".large").height() / 2;

                $(".large").css({ left: px, top: py, backgroundPosition: bgp });
            }
        }
    });



    // FILTER INVENTARIO PRICE RANGE -------------------------------------------------------------------------------------------
    $('#filterInventario').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) { //AQUI DECLARAR TODO LO QUE PASE AL CAMBIAR DE CLIENTE
        var filterValue = $("#filterInventario").val();
        var table = $('#tablaInventario').DataTable();
        if (filterValue == 'precioDown')
            table.column('10').order('desc').draw();
        if (filterValue == 'precioUp')
            table.column('10').order('asc').draw();

    });
});


function checkItems() {
    if (promocionesCliente.length > 0 && checkPromocionesCliente) {
        checkPromocionesCliente = false;
        $("#tags-promo").empty();
        for (var x = 0; x < promocionesCliente.length; x++) {
            if (x + 1 == promocionesCliente.length)
                $("#tags-promo").append('<li class="tags last">' + promocionesCliente[x]['nombrePromo'] + '<i class="fa fa-times"></i></li>');
            else
                $("#tags-promo").append('<li class="tags">' + promocionesCliente[x]['nombrePromo'] + '<i class="fa fa-times"></i></li>');
        }
    }
    if (items.length > 0) {
        clearInterval(intervalInventario);
        document.getElementById('pedido').style.display = "block";
        document.getElementById('loading').style.display = "none";
        document.getElementById('loading').classList.remove('d-flex');
        if (window.location.href.includes('pedido/editar')) { //SI EL PEDIDO VA A SER ACTUALIZADO, CARGAR INFORMACIÓN PREVIA
            prepareJsonSeparaPedidos(false);
        }
        cargarInventario();
    } else {
        document.getElementById('pedido').style.display = "none";
        document.getElementById('loading').style.display = "block";
        document.getElementById('loading').classList.add('d-flex');
    }
}


function existingTag(text) {
    text = text.toLowerCase();
    $(".tags").each(function () {
        if ($(this).text().toLowerCase() == text) {
            return true;
        }
    });
    return false;
}



$(function () {
    $(".tags-new input").focus();

    $(".tags-new input").keyup(function (e) {

        var tag = $(this).val().trim(),
            length = tag.length;

        if (e.key === "Enter" || e.keyCode === 13) {
            tag = tag.substring(0, length);

            if (!existingTag(tag)) {
                var last = document.querySelector('.last');
                if (last != null) {
                    document.querySelector('.last').classList.remove('last');
                }
                $('<li class="tags last"><span>' + tag + '</span><i class="fa fa-times"></i></i></li>').insertBefore($(".tags-new"));
                $(this).val("");
            } else {
                $(this).val(tag);
            }
        }


        if (e.key === "Backspace" || e.keyCode === 46) {
            var tag = document.querySelector('.last');
            if (tag != null) {
                if (tag.style.background == "rgb(250, 91, 91)") {
                    tag.remove();
                } else {
                    tag.style.background = "rgb(250, 91, 91)";
                }
            }

            var lastTag = document.querySelectorAll(".tags");
            if (lastTag.length != 0) {
                lastTag[lastTag.length - 1].classList.add('last');
            }
        }


    });

    $(document).on("click", ".tags i", function () {
        $(this).parent("li").remove();
    });

});

//ELIMINAR ARTICULO DE LA TABLA 
function deleteRowPedido(t, item, index, cantidad, tipo) {
    if (tipo == 'regalo') {
        var row = t.parentNode.parentNode.parentNode;
    }
    else {
        var row = t.parentNode.parentNode;
    }
    itemToFocus = item;
    document.getElementById("tablaPedido").deleteRow(row.rowIndex);
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
    if (pedido[index]['items'][indexItem]['regalo'] == 1) {
        pedido[index]['items'][indexItem]['addRegalo'] = 0;
    }
    else {
        pedido[index]['items'].splice(indexItem, 1);
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = parseInt(selectedItemsFromInventory[indexInventory]['cant']) - cantidad;

        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) - cantidad).toString();
        jsonItemsSeparar = JSON.stringify(jsonObj);
    }

    if (pedido[index]['items'].length == 0) {

        pedido.splice(index, 1);
    }

    separarPedidosPromo(jsonItemsSeparar, false);

}

//ELIMINAR FILA DE LA TABLA CARGAR POR CODIGO
function deleteRowCodigo(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('tableCargarPorCodigo');
    table.deleteRow(row.rowIndex);
    if (table.rows.length == 1) {
        document.getElementById('tableCargarPorCodigo').style.display = 'none';
        table.classList.remove('active');
        table.classList.add('inactive');
        document.getElementById('btnCargarPorCodigo').classList.add('d-none');
    }
}


function addRowCargarPorCodigo() {
    var table = document.getElementById('tableCargarPorCodigo');
    if (table.classList.contains('inactive')) {
        table.style.display = 'block';
        table.classList.remove('inactive');
        table.classList.add('active');
        addInputsCodigo(table);
    } else {
        addInputsCodigo(table);
    }
}

function addInputsCodigo(table) {
    var row = table.insertRow(table.rows.length);

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.innerHTML = "<input class='input-codigo' id='input-codigo-" + (table.rows.length - 1) + "' type='text'>";
    cell2.innerHTML = "<input id='input-cantidad-" + (table.rows.length - 1) + "' type='text' onkeyup ='validateEnter(event)' onkeydown ='validateTab(event)'>";
    cell3.innerHTML = "<i class='fas fa-minus-square fa-xl fa-delete' onclick='deleteRowCodigo(this)'></i>";

    document.getElementById('btnCargarPorCodigo').classList.remove('d-none');
}

function cargarProductosPorCodigo() {
    var rows = document.getElementsByClassName('input-codigo');
    cantItemsPorCargar = rows.length;
    for (var x = 1; x <= rows.length; x++) {
        var inputCodigo = document.getElementById('input-codigo-' + x);
        var inputCantidad = document.getElementById('input-cantidad-' + x);
        var art = selectedItemsFromInventory.find(o => o.item === (inputCodigo.value).trim().toUpperCase());
        if (art != undefined)
            art['cant'] = (parseInt(art['cant']) + parseInt(inputCantidad.value)).toString();
        else {
            art = items.find(o => o.itemid.toUpperCase() === (inputCodigo.value).trim().toUpperCase());
            if (art != undefined && inputCantidad.value != '') { selectedItemsFromInventory.push({ item: (inputCodigo.value).trim().toUpperCase(), cant: inputCantidad.value }); }
            else if (art == undefined) { alert('El artículo ' + (inputCodigo.value).trim().toUpperCase() + ' no existe'); }
            else if (inputCantidad.value == '') { alert('Agrega cantidad para el artículo ' + (inputCodigo.value).trim().toUpperCase()); }
        }
    }

    var table = document.getElementById('tableCargarPorCodigo');
    var filas = table.rows.length - 1;
    while (filas > 0) {
        table.deleteRow(filas);
        filas--;
    }

    document.getElementById('tableCargarPorCodigo').style.display = 'none';
    table.classList.remove('active');
    table.classList.add('inactive');
    document.getElementById('btnCargarPorCodigo').classList.add('d-none');
    prepareJsonSeparaPedidos(false);
    // save(5); //pre guardar el pedido después de cargar excel
}

function cargarProductosExcel(json) {
    jsonObj = JSON.parse(json);
    cantItemsPorCargar = jsonObj.length;
    for (var x = 0; x < jsonObj.length; x++) {
        var art = selectedItemsFromInventory.find(o => o.item === jsonObj[x]['Codigos'].trim());
        if (art != undefined)
            art['cant'] = (parseInt(art['cant']) + parseInt(jsonObj[x]['Cantidad'])).toString();
        else
            selectedItemsFromInventory.push({ item: jsonObj[x]['Codigos'].trim(), cant: jsonObj[x]['Cantidad'] });
    }

    document.getElementById("btnSpinner").style.display = "block";
    var btnActions = document.getElementsByClassName('btn-group-buttons');
    for (var x = 0; x < btnActions.length; x++) {
        btnActions[x].disabled = true;
    }

    prepareJsonSeparaPedidos(false);

    document.getElementById("excelCodes").value = "";
    // save(5); //pre guardar el pedido después de cargar excel
}

function validateEnter(e) {
    var keycode = e.keyCode || e.which;
    if (keycode == 13) {
        cargarProductosPorCodigo();
    }
}

function validateTab(e) {
    var keycode = e.keyCode || e.which;
    if (keycode == 9) {
        addRowCargarPorCodigo();
    }
}

function prepareJsonSeparaPedidos(separa) { //Convierte arreglo con todos los items cargados en JSON para enviarlo al back a separar pedido
    if (!separa) {
        tipoGetItemById = 1;
    }
    var formaEnvío = document.getElementById('envio').classList.contains('d-none') ? $('#selectEnvio option:selected').text() : $("#envio").val();
    if(formaEnvío == 'CCI FLETERA'){ //si la forma de envío es CCI FLETERA validar que no tenga artículos que NO pueden venderse por esta fletera
        for(var x = 0; x < selectedItemsFromInventory.length; x++){
            console.log(selectedItemsFromInventory[x]['item']);
            if(articulosBloqueadosCCIFletera.includes(selectedItemsFromInventory[x]['item'])){
                alert('No se puede vender el articulo '+selectedItemsFromInventory[x]['item']);
                selectedItemsFromInventory.splice(x, 1); //quitar el artículo que no puede venderse
                x--; //restar a variable de loop para que termine de recorrer items seleccionados
            }
        }
    }
    cantItemsPorCargar = selectedItemsFromInventory.length;
    if(selectedItemsFromInventory.length > 0){
        jsonItemsSeparar = "[";
        for (var x = 0; x < selectedItemsFromInventory.length; x++) {
            var item = { "articulo": selectedItemsFromInventory[x]['item'], "cantidad": selectedItemsFromInventory[x]['cant'] };
            getItemById(item, separa);
        }
    }
 
}


function separarPedidosPromo(json, separar) {  //envía json a back y recibe pedido separado

    if (separar && json == null) {
        tipoGetItemById = 0;
        setTimeout(prepareJsonSeparaPedidos(true), 1000);
    }
    if (separar && json != null) {
        var cupon = document.getElementById('cupon').value;
        if (cupon != '') {
            json = JSON.parse(json);
            for (var x = 0; x < json.length; x++) {
                json[x]['cupon'] = cupon;
                json[x]['CapturadoXcte'] = tipoPedido;
                json[x]['Separa2000'] = document.getElementById("separar2000").checked ? 1 : 0;
            }
            json = JSON.stringify(json);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "nuevo/SepararPedidosPaquete",
                timeout: 2 * 60 * 60 * 1000,
                contentType: "application/json",
                data: JSON.stringify({ key: json }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    pedidoSeparado = data;
                    var x = 0;
                    while (x < pedidoSeparado.length) {
                        pedidoSeparado[x]['evento'] = cupon;
                        if (pedidoSeparado[x]['mgsFalta'] != null) { console.log('mgsFalta: ' + pedidoSeparado[x]['mgsFalta']); }
                        x++;
                    }
                    separarFilas(data);
                },
                error: function (error) { }
            });
        }
        else {
            json = JSON.parse(json);
            for (var x = 0; x < json.length; x++) {
                json[x]['CapturadoXcte'] = tipoPedido;
                json[x]['Separa2000'] = document.getElementById("separar2000").checked ? 1 : 0;
                json[x]['punitario'] = getPUnitario(json[x]);
            }
            json = JSON.stringify(json);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "nuevo/SepararPedidosPromo",
                timeout: 2 * 60 * 60 * 1000,
                contentType: "application/json",
                data: JSON.stringify({ key: json }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    pedidoSeparado = data;
                    separarFilas(data);
                },
                error: function (error) { }
            });
        }
    }
    if (!separar) {
        json = JSON.parse(json);
        var arr = [];
        for (var x = 0; x < json.length; x++) {
            var art = items.find(o => o.itemid === json[x]['itemID']);
            var artArr = arr.find(o => o.itemID === json[x]['itemID'])
            if (artArr != undefined) {
                artArr['quantity'] = (parseInt(json[x]['quantity']) + parseInt(artArr['quantity'])).toString();
            }
            else {
                if (art == undefined) {
                    alert("Artículo " + json[x]['itemID'] + " no encontrado en inventario");
                    var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === json[x]['itemID']);
                    selectedItemsFromInventory.splice(indexInventory, 1);
                    cantItemsPorCargar--;
                }
                else if (json[x]['quantity'] > 0) {
                    json[x]['descuento'] = 0;
                    json[x]['plazo'] = 0;
                    json[x]['marca'] = '';
                    json[x]['evento'] = '';
                    json[x]['tipo'] = '';
                    json[x]['regalo'] = 0;
                    json[x]['separa'] = 1;
                    json[x]['disponible'] = art['disponible'];
                    json[x]['promo'] = 0;
                    arr.push(json[x]);
                }
            }
        }
        separarFilas(arr);
    }

}

function separarFilas(json) { //prepara arreglo de pedido para armar tabla, agregando encabezados de subpedidos y articulos a cada subpedido
    for (var i = 0; i < pedido.length; i++) {
        for (var z = 0; z < pedido[i]['items'].length; z++) {
            if (pedido[i]['items'][z]['addRegalo'] == 0) {
                ignorarRegalos.push(pedido[i]['items'][z]['itemid']);
            }
        }
    }
    if (json.length > 0) {
        pedido = [];
        for (var x = 0; x < json.length; x++) {
            var art;
            if (json[x]['itemID'] != '' && json[x]['itemID'] != null && json[x]['itemID'] != undefined) { //REVISAR SI EXISTEN PROMOS DE VOLUMEN Y OBTENER CUÁL APLICA SEGÚN LA CANTIDAD
                art = items.find(o => o.itemid === json[x]['itemID']);
                ofertasVolumen = "";
                if (art != undefined) {
                    if (art['promoART'] != null) {
                        for (var i = 0; i < art['promoART'].length; i++) {
                            if (json[x]['quantity'] >= art['promoART'][i]['cantidad']) {
                                json[x]['promo'] = art['promoART'][i]['descuento'];
                            }
                            else if (i > 0) {
                                ofertasVolumen += 'Compra ' + art['promoART'][i]['cantidad'] + ' piezas de ' + json[x]['itemID'] + ' y llévate un ' + art['promoART'][i]['descuento'] + '% de descuento.\n';
                            }
                        }
                    }
                }
            }

            var item = {
                categoriaItem: art['categoriaItem'],
                clavefabricante: art['claveFabricante'],
                familia: art['familia'],
                grupoArticulo: art['grupoArticulo'],
                tipoArticulo: json[x]['tipo'],
                id: art['id'],
                itemid: json[x]['itemID'],
                purchasedescription: art['purchasedescription'],
                multiploVenta: json[x]['multiplo'],
                cantidad: json[x]['quantity'],
                price: art['price'],
                unidad: art['unidad'],
                promo: json[x]['promo'],
                marca: json[x]['marca'],
                plazo: json[x]['plazo'],
                regalo: json[x]['regalo'],
                addRegalo: ignorarRegalos.includes(json[x]['itemID']) ? 0 : 1,
                separa: json[x]['separa'],
                disponible: art['disponible'],
                desneg: 0,
                autorizaDesneg: "",
                desgar: 0,
                autorizaDesgar: "",
            };
            if (x == 0) {
                var rowPedido = {
                    descuento: json[x]['descuento'],
                    plazo: json[x]['plazo'],
                    marca: json[x]['marca'],
                    tipo: json[x]['tipo'],
                    regalo: json[x]['regalo'],
                    evento: json[x]['evento'],
                    items: []
                };
                rowPedido['items'].push(item);
                pedido.push(rowPedido);
            }
            else {
                var header = pedido.find(o => o.descuento == json[x]['descuento'] && o.plazo == json[x]['plazo'] && o.marca == json[x]['marca'] && o.tipo == json[x]['tipo']); //BUSCAR SI EXISTE UNA FILA EN EL PEDIDO QUE YA TENGA MISMAS CONDICIONES (DESCUENTO, PLAZO, MARCA Y TIPO)
                if (header != undefined) { //SI EXISTE, AGREGAR ITEM A ESA FILA (FORMA PARTE DEL MISMO SUBPEDIDO)
                    header['items'].push(item);
                }
                else { //SI NO EXISTE, AGREGAR NUEVA FILA AL PEDIDO (CREAR UN NUEVO SUBPEDIDO)
                    var rowPedido = {
                        descuento: json[x]['descuento'],
                        plazo: json[x]['plazo'],
                        marca: json[x]['marca'],
                        tipo: json[x]['tipo'],
                        regalo: json[x]['regalo'],
                        evento: json[x]['evento'],
                        items: []
                    };
                    rowPedido['items'].push(item);
                    pedido.push(rowPedido);
                }
            }
        }
    }
    else {
        console.log('No hay promociones disponibles para separar pedido.');
    }
    createTablePedido();
}

function getItemById(item, separa) {
    var entity = document.getElementById('entity').value;
    var data = { id: item['articulo'], entity: entity };
    var cantidad = item['cantidad'];
    if (tipoGetItemById == 1) {
        var art = items.find(o => o.itemid === item['articulo']);
        cantItemsCargados++;
        if (art != undefined) {
            var itemSeparar = {
                itemID: art['itemid'],
                codCustomer: entity,
                quantity: cantidad,
                plista: art['price'],
                punitario: parseFloat(((100 - parseFloat(art['promo'])) * parseFloat(art['price']) / 100).toFixed(2)),
                multiplo: art['multiploVenta'] != null ? art['multiploVenta'] : 1,
                regalo: 0,
                existencia: art['disponible']
            };
            if (cantItemsCargados == cantItemsPorCargar) {
                jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ']';
                separarPedidosPromo(jsonItemsSeparar, separa);
                cantItemsCargados = 0;
                cantItemsPorCargar = 0;
            }
            else {
                jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ',';
            }
        }
        else if (art == undefined && cantItemsCargados == cantItemsPorCargar) {
            alert("Artículo " + item['articulo'] + " no encontrado en inventario");
            var newJson = jsonItemsSeparar.substring(0, jsonItemsSeparar.length - 1);
            newJson = newJson + ']';
            jsonItemsSeparar = newJson;
            separarPedidosPromo(newJson, separa);
            cantItemsCargados = 0;
            cantItemsPorCargar = 0;
        }
        if (art == undefined) {
            alert("Artículo " + item['articulo'] + " no encontrado en inventario");
            var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item['articulo']);
            selectedItemsFromInventory.splice(indexInventory, 1);
            cantItemsPorCargar--;
        }
    }
    else {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "nuevo/getItemByID",
            timeout: 2 * 60 * 60 * 1000,
            async: true,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                //  -------------------------------------------------------------- AJUSTAR MULTIPLO AUTOMÁTICAMENTE SIEMPRE HACIA ARRIBA ---------------------------------------

                cantItemsCargados++;
                if (data.length > 0) {
                    var itemSeparar = {
                        itemID: data[0]['itemid'],
                        codCustomer: entity,
                        quantity: validarMultiplo(data[0]['multiploVenta'], cantidad),
                        plista: data[0]['price'],
                        punitario: parseFloat(((100 - parseFloat(data[0]['promo'])) * parseFloat(data[0]['price']) / 100).toFixed(2)),
                        multiplo: data[0]['multiploVenta'] != null ? data[0]['multiploVenta'] : 1,
                        regalo: 0,
                        existencia: data[0]['disponible']
                    };

                    if (cantItemsCargados == cantItemsPorCargar) {
                        jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ']';
                        separarPedidosPromo(jsonItemsSeparar, separa);
                        cantItemsCargados = 0;
                        cantItemsPorCargar = 0;
                    }
                    else {
                        jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ',';
                    }
                }
                if (data.length == 0 && cantItemsCargados == cantItemsPorCargar) {
                    var newJson = jsonItemsSeparar.substring(0, jsonItemsSeparar.length - 1);
                    newJson = newJson + ']';
                    jsonItemsSeparar = newJson;
                    separarPedidosPromo(newJson, separa);
                    cantItemsCargados = 0;
                    cantItemsPorCargar = 0;
                }

            },
            error: function (error) {
                var art = items.find(o => o.itemid === item['articulo']);
                console.log("Existencia de " + art['itemid'] + " obtenida de inventario");
                var precioCliente = 0;
                if (art['promoART'] != null) {
                    var y = 0;
                    while (y < art['promoART'].length) {
                        if (art['multiploVenta'] >= art['promoART'][y]['cantidad']) {
                            precioCliente = ((100 - art['promoART'][y]['descuento']) / 100) * art['price'];
                        }
                        y++;
                    }
                    if (precioCliente == 0)
                        precioCliente = ((100 - art['promoART'][0]['descuento']) / 100) * art['price'];
                }
                else
                    precioCliente = art['price'];

                cantItemsCargados++;
                var itemSeparar = {
                    itemID: art['itemid'],
                    codCustomer: entity,
                    quantity: validarMultiplo(art['multiploVenta'], cantidad),
                    plista: art['price'],
                    punitario: precioCliente,
                    multiplo: art['multiploVenta'] != null ? art['multiploVenta'] : 1,
                    regalo: 0,
                    existencia: art['disponible']
                };

                if (cantItemsCargados == cantItemsPorCargar) {
                    jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ']';
                    separarPedidosPromo(jsonItemsSeparar, separa);
                    cantItemsCargados = 0;
                    cantItemsPorCargar = 0;
                }
                else {
                    jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ',';
                }
                console.log(error);
            }
        });
    }
}


function getItems(entity, async) {
    let data = { entity: entity };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "nuevo/getItems/all",
        'type': 'POST',
        'data': data,
        'enctype': 'multipart/form-data',
        'async': async,
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            console.log(data);
            items = JSON.parse(data);
            console.log(items);
            var empty = document.getElementById('empty').value;
            if (empty == 'no')
                reloadInventario();
        },
        error: function (error) {
        }
    });
}

function getEventosCliente(entity) {
    let data = { entity: entity };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/pedido/getEventosCliente",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            promocionesCliente = data;
        },
        error: function (error) {
        }
    });
}

function noDisponible(img) {
    img.src = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
}

async function cargarInventario() {
    console.log('creando datatable');
    var empty = document.getElementById('empty').value;
    document.getElementById('mostrar_existenciasLabel').innerText = 'Mostrar solo existencias';
    $('#mostrar_existencias').prop("checked", false);
    if (empty == "yes") { //si la tabla está vacía, inicializarla
        document.getElementById('empty').value = 'no';
        document.getElementById('mostrarInventario').removeAttribute('onclick');
        dataset = [];
        var x = 0;
        while (x < items.length) {
            var arr = [];
            if (items[x]['categoriaItem'] != 'PROMOCIONAL') {
                var precioCliente = 0;
                if (items[x]['promoART'] != null) {
                    var y = 0;
                    while (y < items[x]['promoART'].length) {
                        if(y == 0 && items[x]['promoART'][y]['cantidad'] != 1){
                            console.log('PROMO VOLUMEN: '+items[x]['itemid']);
                        }
                        if (items[x]['multiploVenta'] >= items[x]['promoART'][y]['cantidad']) {
                            precioCliente = ((100 - items[x]['promoART'][y]['descuento']) / 100) * items[x]['price'];
                        }
                        y++;
                    }
                    if (precioCliente == 0)
                        precioCliente = ((100 - items[x]['promoART'][0]['descuento']) / 100) * items[x]['price'];
                }
                else
                    precioCliente = items[x]['price'];
                var precioLista = (items[x]['price']).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

                var precioIVA = ((precioCliente * ((100 - 4) / 100) * 1.16)).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

                var existenciaFormat = (parseFloat(items[x]['disponible'])).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

                existenciaFormat = existenciaFormat.slice(1, -1);
                existenciaFormat = existenciaFormat.split('.')[0];

                arr.push("<img src='http://indarweb.dyndns.org:8080/assets/articulos/img/01_JPG_CH/" + items[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_CH.jpg' onerror='noDisponible(this)' height='auto' onclick='verImagenProducto(\"" + items[x]['itemid'] + "\")' class='img-item'/><img src='http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + items[x]['familia'].replaceAll(" ", "_").replaceAll("-", "_") + ".jpg' height='auto' class='img-item'/>");
                arr.push("<p class='datos-item'>" + items[x]['categoriaItem'] + "</p>");
                arr.push("<p class='datos-item'>" + items[x]['clavefabricante'] + "</p>");
                arr.push("<p class='datos-item'>" + items[x]['familia'] + "</p>");
                arr.push("<p class='datos-item'>" + items[x]['itemid'] + "</p>");
                arr.push("<p class='datos-item'>" + items[x]['purchasedescription'] + "</p>");

                var detalles = "";
                detalles = detalles + "<p class='detalles-item detalles-green'>Existencia: <span class='detalles-item-right'>" + existenciaFormat + "</span></p>";
                detalles = detalles + "<p class='detalles-item'>Min. compra: <span class='detalles-item-right'>" + items[x]['minVenta'] + "</span></p>";
                detalles = detalles + "<p class='detalles-item'>Cant. en empaque: <span class='detalles-item-right'>" + items[x]['inner'] + "</span></p>";
                detalles = detalles + "<p class='detalles-item'>Cant. master: <span class='detalles-item-right'>" + items[x]['master'] + "</span></p>";
                detalles = detalles + "<p class='detalles-item'>Múltiplo: <span class='detalles-item-right'>" + items[x]['multiploVenta'] + "</span></p>";
                detalles = detalles + "<p class='detalles-item'>Unidad: <span class='detalles-item-right'>" + items[x]['unidad'] + "</span></p>";
                detalles = detalles + "<p class='detalles-item'>Clasificación: <span class='detalles-item-right'>" + items[x]['clasificacionArt'] + "</span></p>";

                arr.push(detalles);

                var precioSugerido;
                var descuentos = "<p class='detalles-item detalles-item-descuentos'>Precio lista: <span class='detalles-item-right'>" + precioLista + " + IVA</span></p>";
                var promociones = "";
                if (items[x]['promoART'] == null) {
                    precioSugerido = items[x]['price'] / 0.65;
                    precioSugerido = (precioSugerido).toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'USD',
                    });

                    descuentos = descuentos + "<p class='detalles-item detalles-item-descuentos'>Prec. sug. de venta: <span class='detalles-item-right' style='width: auto !important'>" + precioSugerido + " con IVA</span></p>"
                    promociones = "<p>Sin promoción</p>";
                }
                else {
                    precioSugerido = (((100 - items[x]['promoART'][0]['descuento']) * items[x]['price']) / 100) / 0.65;
                    var y = 0;
                    while (y < items[x]['promoART'].length) {
                        if (items[x]['promoART'][y]['cantidad'] == 1 && items[x]['multiploVenta'] == 1)
                            var temp = "<p class='text-promo'>Compra " + items[x]['promoART'][y]['cantidad'] + " pieza y obtén el <span class='text-red'> " + items[x]['promoART'][y]['descuento'] + "% de descuento</span></p>";
                        else if (items[x]['promoART'][y]['cantidad'] == 1 && items[x]['multiploVenta'] > 1)
                            var temp = "<p class='text-promo'>Compra " + items[x]['multiploVenta'] + " piezas y obtén el <span class='text-red'> " + items[x]['promoART'][y]['descuento'] + "% de descuento</span></p>";
                        else
                            var temp = "<p class='text-promo'>Compra " + items[x]['promoART'][y]['cantidad'] + " piezas y obtén el <span class='text-red'> " + items[x]['promoART'][y]['descuento'] + "% de descuento</span></p>";
                        promociones = promociones + temp;
                        var precioClienteDescuento = ((100 - items[x]['promoART'][y]['descuento']) * items[x]['price']) / 100;
                        precioClienteDescuento = (precioClienteDescuento).toLocaleString('en-US', {
                            style: 'currency',
                            currency: 'USD',
                        });
                        descuentos = descuentos + "<p class='detalles-item detalles-item-descuentos'>Precio cliente: <span class='text-red'> (-" + items[x]['promoART'][y]['descuento'] + "%) </span> <span class='detalles-item-right' style='width: auto !important'> <span class='text-blue'>" + precioClienteDescuento + "</span> + IVA</span></p>"
                        y++;
                    }
                    precioSugerido = (precioSugerido).toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'USD',
                    });
                    descuentos = descuentos + "<p class='detalles-item detalles-item-descuentos'>Prec. sug. de venta: <span class='detalles-item-right' style='width: auto !important'>" + precioSugerido + " con IVA</span></p>";
                }
                descuentos = descuentos + "<p class='detalles-item detalles-item-descuentos'>P. Pago IVA incluído: <span class='detalles-item-right' id='precioIVA-" + items[x]['itemid'] + "' style='width: auto !important'>" + precioIVA + "</span></p>"
                descuentos = descuentos + "<div class='input-group mt-2'><input type='text' class='form-control input-descuento' id='inputDescuentoInventario-" + items[x]['itemid'] + "' value='4' onkeyup='updatePrecioIVA(\"" + items[x]['itemid'] + "\")'><div class='input-group-append append-inventario text-center'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div>";
                arr.push(descuentos);
                arr.push(promociones);
                arr.push("<div class='table-actions'><input type='number' value=" + items[x]['multiploVenta'] + " min=" + items[x]['multiploVenta'] + " step=" + items[x]['multiploVenta'] + " onkeyup='updatePrecioCliente(\"" + items[x]['itemid'] + "\")' id='inputPrecioCliente-" + items[x]['itemid'] + "'><i class='fas fa-plus-square btn-add-product fa-2x mt-2' onclick='addItemInventory(\"" + items[x]['itemid'] + "\")'></i></div>");
                arr.push(precioIVA); //CAMPO PARA ORDENAR POR PRECIO
                dataset.push(arr);
            }
            x++;
        }

        console.log('terminó de acomodar info');

        $('#tablaInventario thead tr:eq(1) th').each(function () {
            var title = $(this).text();
            var id = $(this).attr('id');
            if(id == 'search'){
                $(this).html('<input type="text" placeholder="' + title + '" class="column_search" />');
            }
            else{
                $(this).html('');
            }
        });

        console.log('Pasando info a tabla');

        var table = $("#tablaInventario").DataTable({
            data: dataset,
            pageLength: 5,
            orderCellsTop: true,
            fixedHeader: true,
            deferRender: true,
            lengthMenu: [[5, 10, 20, 100], [5, 10, 20, 100]],
            'columnDefs': [
                { "targets": 0, "className": "td-center", "orderable": false },
                { "targets": 1, "className": "td-center" },
                { "targets": 2, "className": "td-center" },
                { "targets": 3, "className": "td-center" },
                { "targets": 4, "className": "td-center" },
                { "targets": 6, "searchable": false, "orderable": false },
                { "targets": 7, "searchable": false, "orderable": false },
                { "targets": 8, "searchable": false, "orderable": false },
                { "targets": 9, "searchable": false, "orderable": false },
                { "targets": 10, "visible": false, "searchable": false, "orderable": false }
            ]
        });
        $('#tablaInventario thead').on('keyup', ".column_search", function () {
            table.column($(this).parent().index()).search(this.value).draw();
        });
        $('.dataTables_filter input').off().on('keyup', function() {
            table.column('4').order('asc').draw();
            $('#tablaInventario').DataTable().search(this.value.trim(), true, true).draw();
       });   
    }
}

function activeSwitch(type) { //remove scrollable class to tablePedido when constructing it
    var checkBox = document.getElementById("checkbox1");
    type == 1 ? flag = true : flag = false;
    if (pedido.length > 0) {
        if (checkBox.checked == flag) {
            document.getElementById('tablaPedido').classList.remove('tablaPedidoScrollable');
        } else {
            document.getElementById('tablaPedido').classList.add('tablaPedidoScrollable');
        }
    }
}
function reloadInventario() {
    document.getElementById('empty').value = 'yes';
    $("#tablaInventario").dataTable().fnClearTable();
    $("#tablaInventario").dataTable().fnDraw();
    $("#tablaInventario").dataTable().fnDestroy();
    document.getElementById('mostrarInventario').setAttribute('onclick', 'cargarInventario()');
}

function createTablePedido() { //CREAR TABLA QUE VE EL USUARIO CON EL PEDIDO SEPARADO, ENCABEZADOS, FILAS DE ARTICULOS Y REGALOS
    var table = document.getElementById('tablaPedido');
    var filas = table.rows.length - 1;
    activeSwitch(2);
    while (filas > 1) {
        table.deleteRow(filas);
        filas--;
    }

    var subtotalPedido = 0;
    var ivaPedido;
    var totalPedido;

    var fila = 1;
    console.log(pedido);
    for (var x = 0; x < pedido.length; x++) {
        var subtotal = 0;
        for (var y = 0; y < pedido[x]['items'].length; y++) {
            var cantidad = pedido[x]['items'][y]['cantidad'];
            var price = 0;
            if (pedido[x]['items'][y]['regalo'] == 1)
                price = 0.01;
            else
                price = parseFloat(pedido[x]['items'][y]['price']);
            var pUnitario = ((100 - parseFloat(pedido[x]['items'][y]['promo'])) * price / 100).toFixed(2);
            var importe = (cantidad * pUnitario).toFixed(2);
            subtotal += parseFloat(importe);
        }
        subtotalPedido = subtotalPedido + subtotal;
        addHeaderPedido(pedido[x]['descuento'], pedido[x]['plazo'], pedido[x]['tipo'], pedido[x]['evento'], subtotal);
        for (var y = 0; y < pedido[x]['items'].length; y++) { //NO CONSIDERAR LAS LÍNEAS QUE SEAN REGALO Y TENGAN EL ADDREGALO EN 0 (QUE SE HAYAN ELIMINADO)
            if (pedido[x]['items'][y]['regalo'] == 0) {
                addRowPedido(pedido[x]['items'][y], fila, x);
            }
            else if (pedido[x]['items'][y]['addRegalo'] == 1) {
                pedido[x]['items'][y]['price'] = 0.01;
                addRowRegalo(pedido[x]['items'][y], fila, x);
            }
            fila++;
        }
    }

    document.getElementById('totalFilasCant').innerText = fila - 1;

    ivaPedido = subtotalPedido * .16;
    totalPedido = subtotalPedido + ivaPedido;

    var subtotalFinal = (subtotalPedido).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var ivaFinal = (ivaPedido).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var totalFinal = (totalPedido).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    document.getElementById('subtotalPedido').innerHTML = subtotalFinal;
    document.getElementById('ivaPedido').innerHTML = ivaFinal;
    document.getElementById('totalPedido').innerHTML = totalFinal;

    var table = document.getElementById('tablaPedido');
    for (var x = 0; x < table.rows.length; x++) {
        if (table.rows[x].cells[1].innerText.indexOf(itemToFocus) >= 0) {
            indexFocus.push(x);
        }
    }

    if (indexFocus.length > 1) {
        intervalVar = setInterval(function () {
            for (var x = 0; x < indexFocus.length; x++) {
                table.rows[indexFocus[x]].classList.toggle('focusRow');
            }
        }, 500);
    }

    setTimeout(function () {
        clearInterval(intervalVar);
        for (var x = 0; x < indexFocus.length; x++) {
            table.rows[indexFocus[x]].classList.remove('focusRow');
        }
        indexFocus = [];
        itemToFocus = 'XXXXXXX';
    }, 3000);


    if (filas == 1) {
        document.getElementById('messageAddProducts').classList.remove('d-none');
    }

    document.getElementById("btnSpinner").style.display = "none";
    var btnActions = document.getElementsByClassName('btn-group-buttons');
    for (var x = 0; x < btnActions.length; x++) {
        btnActions[x].disabled = false;
    }

}




function addRowPedido(item, fila, indexPedido) {
    var table = document.getElementById('tablaPedido');
    var row = table.insertRow(table.rows.length);

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);

    var cantidadItems = item['cantidad'];
    var pUnitario = ((100 - parseFloat(item['promo'])) * parseFloat(item['price']) / 100).toFixed(2);
    var importe = (cantidadItems * pUnitario).toFixed(2);


    var price = (item["price"]).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var unitario = (parseFloat(pUnitario)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var imp = (parseFloat(importe)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var existenciaFormat = (parseFloat(item['disponible'])).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });


    var cantidad = (parseFloat(item['cantidad'])).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    cantidad = cantidad.slice(1, -1);
    cantidad = cantidad.split('.')[0];

    existenciaFormat = existenciaFormat.slice(1, -1);
    existenciaFormat = existenciaFormat.split('.')[0];
    cell1.innerHTML = "<h4>" + fila + "</h4>";
    var marca = "";
    if (item['marca'] != null)
        marca = item['marca'];
    else
        marca = 'marca';
    if (item["categoriaItem"] == "LINEA" && item['desneg'] == 0 && item['desgar'] == 0 && !marca.includes('MBajo'))
        cell2.innerHTML = "<div class='row'><div class='col-12 col-codArticulo'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'><select id='desneg' name='desneg' class='select-descuento' onchange='applyDesneg(\"" + item['itemid'] + "\",this, " + indexPedido + ")'><option selected value=''>Descuento</option><option value='desneg'>DesNeg</option><option value='desgar'>DesGar</option></select></div><div><div class='row d-none' id='row-descuento-detalles-" + item['itemid'] + "-" + indexPedido + "'><div class='col-6 mt-2'><div class='input-group'><input type='number' class='form-control input-descuento' id='cantDesneg-" + item['itemid'] + "-" + indexPedido + "' name='cantDesneg'><div class='input-group-append text-center append-inventario'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div></div><div class='col-6 mt-2'><select id='autoriza-desneg-" + item['itemid'] + "-" + indexPedido + "' name='autoriza-desneg-" + item['itemid'] + "-" + indexPedido + "' class='select-descuento' onchange='updatePedidoDesneg(\"" + item['itemid'] + "\",this, " + indexPedido + ")'><option selected value=''>Autoriza</option><option value='JMGA'>JMGA</option><option value='EOEGA'>EOEGA</option><option value='JSB'>JSB</option></select></div></div>";

    else if (item["categoriaItem"] == "LINEA" && item['desneg'] != 0 && !marca.includes('MBajo'))
        cell2.innerHTML = "<div class='row'><div class='col-12 col-codArticulo'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'><select id='desneg' name='desneg' class='select-descuento' onchange='applyDesneg(\"" + item['itemid'] + "\",this, " + indexPedido + ")'><option value=''>Descuento</option><option selected value='desneg'>DesNeg</option><option value='desgar'>DesGar</option></select></div><div><div class='row' id='row-descuento-detalles-" + item['itemid'] + "-" + indexPedido + "'><div class='col-6 mt-2'><div class='input-group'><input type='number' class='form-control input-descuento' id='cantDesneg-" + item['itemid'] + "-" + indexPedido + "' name='cantDesneg' value='" + item['desneg'] + "'><div class='input-group-append text-center append-inventario'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div></div><div class='col-6 mt-2'><select id='autoriza-desneg-" + item['itemid'] + "-" + indexPedido + "' name='autoriza-desneg-" + item['itemid'] + "-" + indexPedido + "' class='select-descuento' onchange='updatePedidoDesneg(\"" + item['itemid'] + "\",this, " + indexPedido + ")'><option selected value=''>Autoriza</option><option value='JMGA'>JMGA</option><option value='EOEGA'>EOEGA</option><option value='JSB'>JSB</option></select></div></div>";

    else if (item["categoriaItem"] == "LINEA" && item['desgar'] != 0 && !marca.includes('MBajo'))
        cell2.innerHTML = "<div class='row'><div class='col-12 col-codArticulo'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'><select id='desneg' name='desneg' class='select-descuento' onchange='applyDesneg(\"" + item['itemid'] + "\",this, " + indexPedido + ")'><option value=''>Descuento</option><option value='desneg'>DesNeg</option><option selected value='desgar'>DesGar</option></select></div><div><div class='row' id='row-descuento-detalles-" + item['itemid'] + "-" + indexPedido + "'><div class='col-6 mt-2'><div class='input-group'><input type='number' class='form-control input-descuento' id='cantDesneg-" + item['itemid'] + "-" + indexPedido + "' name='cantDesneg' value='" + item['desgar'] + "'><div class='input-group-append text-center append-inventario'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div></div><div class='col-6 mt-2'><select id='autoriza-desneg-" + item['itemid'] + "-" + indexPedido + "' name='autoriza-desneg-" + item['itemid'] + "-" + indexPedido + "' class='select-descuento' onchange='updatePedidoDesneg(\"" + item['itemid'] + "\",this, " + indexPedido + ")'><option selected value=''>Autoriza</option><option value='JMGA'>JMGA</option><option value='EOEGA'>EOEGA</option><option value='JSB'>JSB</option></select></div></div>";

    else
        cell2.innerHTML = "<div class='row'><div class='col-12 col-codArticulo'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div></div>";

    cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos' onClick='decreaseItemCant(\"" + item['itemid'] + "\", " + item['multiploVenta'] + "," + cantidadItems + "," + indexPedido + ")'>-</button></div><input type='text' onkeyup='updateRowQuantity(\"" + item['itemid'] + "\", " + item['multiploVenta'] + "," + cantidadItems + "," + indexPedido + ", event)' id='cant-" + item['itemid'] + "-" + indexPedido + "' value='" + cantidad + "' class='form-control input-cantidad' name='cantidad' placeholder='" + cantidad + "' title='" + cantidad + "' aria-label='cantidad' aria-describedby='basic-addon2'><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas' onClick='addItemCant(\"" + item['itemid'] + "\", " + item['multiploVenta'] + ", " + cantidadItems + "," + indexPedido + ")'>+</button></div></div>";

    var colorExistencia = '';
    existenciaFormat == 0 ? colorExistencia = "#C82333" : colorExistencia = "#000";

    if (item["categoriaItem"] == "CADUCADO" || item["categoriaItem"] == "S/PEDIDO" || item["categoriaItem"] == 'NO RESURTIBLE' || item["categoriaItem"] == 'OUTLET')
        cell4.innerHTML = "<div class='row'><div class='col-12 col-descripcion'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12 col-descripcion'>Categoría: <span id='categoria-red'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> <span id='existencia' style='color:" + colorExistencia + "'>Existencia: " + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";
    else
        cell4.innerHTML = "<div class='row'><div class='col-12 col-descripcion'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12 col-descripcion'>Categoría: <span id='categoria-green'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> <span id='existencia' style='color:" + colorExistencia + "'>Existencia: " + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";


    cell5.innerHTML = "<h5 id='precioLista'>" + price + "</h5>";
    cell6.innerHTML = "<h5 id='promo'>" + item["promo"] + "%</h5>";
    cell7.innerHTML = "<h5 id='precioUnitario'>" + unitario + "</h5>";
    cell8.innerHTML = "<h5 id='importe-" + item["itemid"] + "-" + indexPedido + "'>" + imp + "</h5>";
    cell9.innerHTML = "<i class='fas fa-minus-square fa-2x fa-delete' onclick='deleteRowPedido(this, \"" + item['itemid'] + "\", " + indexPedido + ", " + cantidadItems + ", \"" + 'item' + "\")'></i>";

    cell1.classList.add('td-center');
    cell2.classList.add('td-center');
    cell3.classList.add('td-center');
    cell4.classList.add('td-center');
    cell5.classList.add('td-center');
    cell6.classList.add('td-center');
    cell7.classList.add('td-center');
    cell8.classList.add('td-center');
    cell9.classList.add('td-center');
    if (item['desneg'] != 0)
        document.getElementById("autoriza-desneg-" + item['itemid'] + "-" + indexPedido).value = item['autorizaDesneg'];
    if (item['desgar'] != 0)
        document.getElementById("autoriza-desneg-" + item['itemid'] + "-" + indexPedido).value = item['autorizaDesgar'];

}

function addHeaderPedido(descuento, plazo, tipo, evento, subtotal) {
    var table = document.getElementById('tablaPedido');
    var row = table.insertRow(table.rows.length);

    var sub = (subtotal).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);

    cell1.innerHTML = "<th>Descuento: " + descuento + "% Plazo: " + plazo + " Tipo: " + tipo + " SUBTOTAL: " + sub + " Evento: " + evento + "</th>";
    cell2.innerHTML = "<th></th>";
    cell3.innerHTML = "<th></th>";
    cell4.innerHTML = "<th></th>";
    cell5.innerHTML = "<th></th>";
    cell6.innerHTML = "<th></th>";
    cell7.innerHTML = "<th></th>";
    cell8.innerHTML = "<th></th>";
    cell9.innerHTML = "<th></th>";

    cell1.colSpan = '9';

    if (tipo == 'BO') {
        cell1.classList.add('bg-bo');
        cell2.classList.add('bg-bo', 'hidden');
        cell3.classList.add('bg-bo', 'hidden');
        cell4.classList.add('bg-bo', 'hidden');
        cell5.classList.add('bg-bo', 'hidden');
        cell6.classList.add('bg-bo', 'hidden');
        cell7.classList.add('bg-bo', 'hidden');
        cell8.classList.add('bg-bo', 'hidden');
        cell9.classList.add('bg-bo', 'hidden');

    }
    else {
        cell1.classList.add('bg-blue');
        cell2.classList.add('bg-blue', 'hidden');
        cell3.classList.add('bg-blue', 'hidden');
        cell4.classList.add('bg-blue', 'hidden');
        cell5.classList.add('bg-blue', 'hidden');
        cell6.classList.add('bg-blue', 'hidden');
        cell7.classList.add('bg-blue', 'hidden');
        cell8.classList.add('bg-blue', 'hidden');
        cell9.classList.add('bg-blue', 'hidden');

    }
}

function addRowRegalo(item, fila, indexPedido) {
    var table = document.getElementById('tablaPedido');
    var row = table.insertRow(table.rows.length);

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);

    var cantidadItems = item['cantidad'];
    var pUnitario = ((100 - parseFloat(item['promo'])) * parseFloat(item['price']) / 100).toFixed(2);
    var importe = (cantidadItems * pUnitario).toFixed(2);

    var price = (item["price"]).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var unitario = (parseFloat(pUnitario)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var imp = (parseFloat(importe)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var existenciaFormat = (parseFloat(item['disponible'])).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    existenciaFormat = existenciaFormat.slice(1, -1);
    existenciaFormat = existenciaFormat.split('.')[0];

    var cantidad = (parseFloat(item['cantidad'])).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    cantidad = cantidad.slice(1, -1);
    cantidad = cantidad.split('.')[0];

    cell1.innerHTML = "<h4>" + fila + "</h4>";
    cell2.innerHTML = "<div class='row'><div class='col-12 col-codArticulo'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div></div>";
    cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos'>-</button></div><input type='text' id='cant-" + item['itemid'] + "-" + indexPedido + "' value='" + cantidad + "' class='form-control input-cantidad' name='cantidad' placeholder='" + cantidad + "' title='" + cantidad + "' aria-label='cantidad' aria-describedby='basic-addon2' readonly><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas'>+</button></div></div>";

    var colorExistencia = '';
    existenciaFormat == 0 ? colorExistencia = "#C82333" : colorExistencia = "#000";

    if (item["categoriaItem"] == "CADUCADO" || item["categoriaItem"] == "S/PEDIDO" || item["categoriaItem"] == 'NO RESURTIBLE' || item["categoriaItem"] == 'OUTLET')
        cell4.innerHTML = "<div class='row'><div class='col-12 col-descripcion'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12 col-descripcion'>Categoría: <span id='categoria-red'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> Existencia: <span id='existencia' style='color:" + colorExistencia + "'>" + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";
    else
        cell4.innerHTML = "<div class='row'><div class='col-12 col-descripcion'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12 col-descripcion'>Categoría: <span id='categoria-green'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> Existencia: <span id='existencia' style='color:" + colorExistencia + "'>" + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";

    cell5.innerHTML = "<h5 id='precioLista'>" + price + "</h5>";
    cell6.innerHTML = "<h5 id='promo'>0%</h5>";
    cell7.innerHTML = "<h5 id='precioUnitario'>" + unitario + "</h5>";
    cell8.innerHTML = "<h5 id='importe-" + item["itemid"] + "-" + indexPedido + "'>" + imp + "</h5>";
    cell9.innerHTML = "<a><i class='fas fa-gift fa-2x'></i></a><a><i class='fas fa-minus-square fa-delete-gift fa-2x' onclick='deleteRowPedido(this, \"" + item['itemid'] + "\", " + indexPedido + ", " + cantidad + ", \"" + 'regalo' + "\")'></i></a>";

    cell1.classList.add('td-center');
    cell2.classList.add('td-center');
    cell3.classList.add('td-center');
    cell4.classList.add('td-center');
    cell5.classList.add('td-center');
    cell6.classList.add('td-center');
    cell7.classList.add('td-center');
    cell8.classList.add('td-center');
    cell9.classList.add('td-center');

}

function validarMultiplo(multiplo, cant) {
    var done = false;
    var cantidad = 0;
    var tempMult = multiplo != null ? multiplo : 1;
    while (!done) {
        if (cant % tempMult == 0) {
            cantidad = cant;
            done = true;
        } else if (tempMult > cant) {
            cantidad = tempMult;
            done = true;
        } else if (tempMult == cant) {
            cantidad = tempMult;
            done = true;
        } else if (multiplo < cant) {
            tempMult = tempMult + multiplo;
        }
    }
    return cantidad;
}

function addItemCant(item, multiplo, cant, index) {
    //en caso de que el pedido ya esté separado, hay que sumar todas las cantidades del mismo articuulo para saber cuánto es la cantidad total
    var cantPedidoTotal = 0;
    var x = 0;
    while (x < pedido.length) {
        var y = 0;
        while (y < pedido[x]['items'].length) {
            if (pedido[x]['items'][y]['itemid'] == item) {
                cantPedidoTotal += parseInt(pedido[x]['items'][y]['cantidad']);
            }
            y++;
        }
        x++;
    }
    var table = document.getElementById('tablaPedido');
    for (var x = 0; x < table.rows.length; x++) {
        if (table.rows[x].cells[1].innerText.indexOf(item) >= 0) {
            table.rows[x].classList.add('fadeOut');
        }
    }
    itemToFocus = item;
    var newCant = (parseFloat(cant + multiplo)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    newCant = newCant.slice(1, -1);
    newCant = newCant.split('.')[0];
    document.getElementById('cant-' + item + "-" + index).value = newCant;
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
    var multiploVenta = pedido[index]['items'][indexItem]['multiploVenta'];
    pedido[index]['items'][indexItem]['cantidad'] = cantPedidoTotal + multiploVenta;
    var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
    selectedItemsFromInventory[indexInventory]['cant'] = parseInt(selectedItemsFromInventory[indexInventory]['cant']) + multiploVenta;
    var jsonObj = JSON.parse(jsonItemsSeparar);
    var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
    jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) + multiploVenta).toString();
    jsonItemsSeparar = JSON.stringify(jsonObj);
    separarPedidosPromo(jsonItemsSeparar, false);
}

function decreaseItemCant(item, multiplo, cant, index) {
    //en caso de que el pedido ya esté separado, hay que sumar todas las cantidades del mismo articulo para saber cuánto es la cantidad total
    var cantPedidoTotal = 0;
    var x = 0;
    while (x < pedido.length) {
        var y = 0;
        while (y < pedido[x]['items'].length) {
            if (pedido[x]['items'][y]['itemid'] == item) {
                cantPedidoTotal += parseInt(pedido[x]['items'][y]['cantidad']);
            }
            y++;
        }
        x++;
    }

    if (cantPedidoTotal - multiplo > 0) {
        itemToFocus = item;
        var newCant = (parseFloat(cantPedidoTotal - multiplo)).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        newCant = newCant.slice(1, -1);
        newCant = newCant.split('.')[0];
        document.getElementById('cant-' + item + "-" + index).value = newCant;
        var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
        var multiploVenta = pedido[index]['items'][indexItem]['multiploVenta'];
        var table = document.getElementById('tablaPedido');
        for (var x = 0; x < table.rows.length; x++) {
            if (table.rows[x].cells[1].innerText.indexOf(item) >= 0) {
                table.rows[x].classList.add('fadeOut');
            }
        }
        pedido[index]['items'][indexItem]['cantidad'] = cantPedidoTotal - multiploVenta;
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = cantPedidoTotal - multiploVenta;
        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) - multiploVenta).toString();
        jsonItemsSeparar = JSON.stringify(jsonObj);
        separarPedidosPromo(jsonItemsSeparar, false);
    }
}

function updateRowQuantity(item, multiplo, cant, index, e) {
    var keycode = e.keyCode || e.which;
    if (keycode == 13) {
        itemToFocus = item;
        cant = document.getElementById('cant-' + item + "-" + index).value;
        var newCant = (parseFloat(cant)).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        newCant = newCant.slice(1, -1);
        newCant = newCant.split('.')[0];
        document.getElementById('cant-' + item + "-" + index).value = newCant;
        var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
        var multiploVenta = pedido[index]['items'][indexItem]['multiploVenta'];
        var cantidadPorMultiplo = validarMultiplo(multiploVenta, cant);
        var table = document.getElementById('tablaPedido');
        for (var x = 0; x < table.rows.length; x++) {
            if (table.rows[x].cells[1].innerText.indexOf(item) >= 0) {
                table.rows[x].classList.add('fadeOut');
            }
        }
        pedido[index]['items'][indexItem]['cantidad'] = cantidadPorMultiplo;
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = cantidadPorMultiplo;
        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (cantidadPorMultiplo).toString();
        jsonItemsSeparar = JSON.stringify(jsonObj);
        separarPedidosPromo(jsonItemsSeparar, false);
    }
}


function triggerInputFile() {
    document.getElementById('excelCodes').click();
}

function pedidosAnteriores() {
    window.open("/pedidosAnteriores/" + document.getElementById('entity').value, '_blank');
}

function downloadPlantillaPedido() {
    window.location.href = '/downloadTemplatePedido';
}

//----------------------------------------------------------------------------  FUNCIÓN GUARDAR PEDIDO WEB  -------------------------------------------------------------------


function save(type) { //TYPE: 1 = GUARDAR PEDIDO NUEVO, 2 = GUARDAR EDITADO (UPDATE), 3 = LEVANTAR PEDIDO (SAVE AND SEND TO NETSUITE), 4 = LEVANTAR PEDIDO (UPDATE AND SEND TO NETSUITE), 5 = PRE GUARDAR PEDIDO AL CARGAR POR EXCEL, CERRAR INVENTARIO O CARGAR POR CÓDIGO
    validarToken();
    if (pedido.length == 0) {
        alert('Agrega artículos al pedido');
    }
    else if ((type == 3 || type == 4) && pedido.length == 1 && pedido[0]['descuento'] == 0 && pedido[0]['marca'] == "" && pedido[0]['evento'] == "" && pedido[0]['plazo'] == 0 && pedido[0]['tipo'] == "") { //si va a levantar pedido y no está separado ya sea que el pedido sea nuevo o editado
        alert('Separa Pedido');
        $('#modalNetsuiteLoading').modal('hide');
    }
    else {
        var update = false; // indica si el pedido se debe modificar, en caso de haber agregado cantidad de algún artículo y este sobrepase la existencia, teniendo que hacer un bo

        var idCustomer; //id
        var correo; //texto
        var ordenCompra; //texto
        var idSucursal; //id
        var dividir2000; // 1 o 0
        var cteRecoge; //1 o 0
        var shippingWay; //id
        var packageDelivery; //id
        var comentarios; //maximo 400 caracteres

        if (!entity.startsWith("Z") && !entity.startsWith("A")) {
            idCustomer = entity;
            idSucursal = $("#sucursal").val();
            shippingWay = document.getElementById('envio').classList.contains('d-none') ? $('#selectEnvio option:selected').text() : $("#envio").val();
            packageDelivery = $("#fletera").val();
        }
        else {
            idCustomer = entityCte;
            idSucursal = $("#sucursal").val();
            shippingWay = document.getElementById('envio').classList.contains('d-none') ? $('#selectEnvio option:selected').text() : $("#envio").val();
            packageDelivery = $("#fletera").val();
        }

        var indexCustomerInfo = info.findIndex(o => o.companyId.toUpperCase() === idCustomer.toUpperCase());
        var internalId = info[indexCustomerInfo]['internalID'];
        var listaPrecio = info[indexCustomerInfo]['priceList'];

        // dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
        dividir2000 = document.getElementById("separar2000").checked ? 1 : 0;
        cteRecoge = document.getElementById("cliente_recoge").checked ? 1 : 0;
        correo = document.getElementById("correo").value;
        ordenCompra = document.getElementById("ordenCompra").value;
        comentarios = document.getElementById("comments").value;


        pedidoJson = [];
        var itemsJson = [];
        if (type == 1 || type == 2) {
            pedido.forEach(function (row, index, object) { //NO GUARDAR PEDIDOS CON REGALOS PARA QUE NO SE DUPLIQUEN AL ENVIARLO
                var index = row['items'].length - 1;
                while (index >= 0) {
                    if (row['items'][index]['categoriaItem'] == 'PROMOCIONAL') {
                        row['items'].splice(index, 1);
                    }
                    index -= 1;
                }
            });
        }

        // -------------------------- SEPARAR ARTICULOS BACK ORDER EN PEDIDOS INDEPENDIENTES (1 ARTICULO POR PEDIDO) --------------------------------------------------
        var x = 0;
        while (x < pedido.length) { //RECORRER TODO EL PEDIDO
            if (pedido[x]['tipo'] == 'BO' && pedido[x]['items'].length > 1) { //SI EL TIPO DEL PEDIDO ES BACKORDER Y TIENE MÁS DE 1 ITEM
                var descuento = pedido[x]['descuento']; //OBTENER VALORES GENERALES DEL PEDIDO
                var evento = pedido[x]['evento'];
                var marca = pedido[x]['marca'];
                var plazo = pedido[x]['plazo'];
                var regalo = pedido[x]['regalo'];
                var tipo = pedido[x]['tipo'];
                var items = [];
                var y = 0;
                while (y < pedido[x]['items'].length) { //RECORRER TODOS LOS ITEMS QUE TIENE EL PEDIDO
                    items.push(pedido[x]['items'][y]); //GUARDAR LOS ITEMS EN UN ARREGLO PARA PODER ELIMINAR LA FILA DEL PEDIDO
                    y++;
                }
                pedido.splice(x, 1); //ELIMINAR FILA DEL PEDIDO
                var z = 0;
                while (z < items.length) { //POR CADA ITEM QUE TENÍA EL PEDIDO, HACER UNA NUEVA FILA DEL PEDIDO
                    var rowPedido = {
                        descuento: descuento,
                        plazo: plazo,
                        marca: marca,
                        tipo: tipo,
                        regalo: regalo,
                        evento: evento,
                        items: []
                    };
                    rowPedido['items'].push(items[z]); //AGREGAR 1 ITEM POR FILA
                    pedido.push(rowPedido); //AGREGAR NUEVA FILA AL PEDIDO, 1 A 1 LOS ITEMS
                    z++;
                }
            }
            x++;
        }

        // ------------------------------------------------------- ARMAR JSON PARA ENVIAR A BACK ----------------------------------------------------------------------

        for (var x = 0; x < pedido.length; x++) {
            var descuento = pedido[x]['descuento'];
            var plazo = pedido[x]['plazo'];
            var marca = pedido[x]['marca'];
            var tipo = pedido[x]['tipo'];
            var evento = "";
            if (tipoPedido == 1) { //si el pedido es cargado por cliente, poner WEB antes del evento cuando se envía a LWS
                evento = "WEB " + pedido[x]['evento'];
            }
            else {
                evento = pedido[x]['evento'];
            }

            for (var y = 0; y < pedido[x]['items'].length; y++) {
                if (pedido[x]['items'][y]['regalo'] == 0 || pedido[x]['items'][y]['addRegalo'] == 1) { //NO CONSIDERAR LAS LÍNEAS QUE SEAN REGALO Y TENGAN EL ADDREGALO EN 0 (QUE SE HAYAN ELIMINADO)
                    var item = {
                        id: pedido[x]['items'][y]['id'],
                        itemid: pedido[x]['items'][y]['itemid'],
                        cantidad: pedido[x]['items'][y]['cantidad'],
                        desneg: pedido[x]['items'][y]['desneg'],
                        desgar: pedido[x]['items'][y]['desgar'],
                        autorizaDesneg: pedido[x]['items'][y]['autorizaDesneg'],
                        autorizaDesgar: pedido[x]['items'][y]['autorizaDesgar'],
                    };
                    itemsJson.push(item);
                }
            }
            var items = itemsJson;
            var temp = {
                descuento: descuento,
                plazo: plazo,
                marca: marca,
                tipo: tipo,
                evento: evento,
                listPrice: listaPrecio,
                idWeb: (x + 1).toString(),
                items: items,
            };
            pedidoJson.push(temp);
            itemsJson = [];
        }

        var json = {
            idCotizacion: document.getElementById('idCotizacion').value == 'X' ? 0 : document.getElementById('idCotizacion').value,
            companyId: idCustomer,
            internalId: internalId,
            orderC: ordenCompra,
            email: correo,
            addressId: idSucursal,
            shippingWay: shippingWay,
            packageDelivery: packageDelivery,
            divide: dividir2000,
            pickUp: cteRecoge,
            order: pedidoJson,
            comments: comentarios,
            enviado: type == 3 || type == 4 ? 1 : 0, //solo es 1 si se envia a netsuite (levantar pedido)
            type: type,
        };

        console.log(JSON.stringify(json));
        console.log(json);

        if (!update) { // No hubo modificaciones y puede guardarse el pedido
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "storePedido",
                'type': 'POST',
                'dataType': 'json',
                'async': false,
                'data': json,
                'enctype': 'multipart/form-data',
                'timeout': 2 * 60 * 60 * 1000,
                success: function (data) {
                    console.log(data);
                    console.log('Num Cotizacion: ' + data['idCotizacion']);
                    if (data['idCotizacion'] != undefined) { //Si es undefined significa que hubo algún error
                        alert('Enviando pedido a Netsuite. Guarda el siguiente número de cotización para cualquier aclaración con tu pedido.\nCotización #'+data['idCotizacion']);
                        if (type == 3) { //el pedido se acaba de ingresar, necesito el número de cotización que me retorna
                            noCotizacionNS = data['idCotizacion'];
                            setTimeout(saveNS(), 2000);
                        }
                        else if (type == 4) { //se está editando el pedido, ya tengo el numero de cotización en el html 
                            noCotizacionNS = document.getElementById('idCotizacion').value;
                            setTimeout(saveNS(), 2000);
                        }
                        else if (type == 5) {
                            noCotizacionNS = data['idCotizacion'];
                            document.getElementById('idCotizacion').setAttribute("value", data['idCotizacion']);
                        }
                        else { // No se va a levantar el pedido, solo se guardó, retornar a pantalla de pedidos
                            alert('Pedido guardado correctamente');
                            window.location.href = '/pedidos';
                        }
                    }
                    else { //si el número de cotización es indefinido
                        alert('Error al guardar pedido');
                    }

                },
                error: function (error) {
                    alert('Error al guardar pedido');
                    console.log(error);
                    // window.location.href = '/pedidos';
                }
            });
        }
    }
}


function applyDesneg(itemid, select, index) {
    tipoDesc = select.value;
    if (select.value == '') {
        document.getElementById('row-descuento-detalles-' + itemid + '-' + index).classList.add('d-none');
    }
    if (select.value == 'desneg') {
        document.getElementById('row-descuento-detalles-' + itemid + '-' + index).classList.remove('d-none');
    }
    if (select.value == 'desgar') {
        document.getElementById('row-descuento-detalles-' + itemid + '-' + index).classList.remove('d-none');
    }
}

function updatePedidoDesneg(itemid, select, index) {
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === itemid);
    var newDesc;
    var item;
    if (tipoDesc == 'desneg') {
        var desneg = parseInt(document.getElementById('cantDesneg-' + itemid + '-' + index).value) + pedido[index]['descuento'];
        newDesc = desneg;
        var autorizaDesneg = select.value;
        item = pedido[index]['items'][indexItem];
        item['desneg'] = parseInt(document.getElementById('cantDesneg-' + itemid + '-' + index).value);
        item['autorizaDesneg'] = autorizaDesneg;
        item['desgar'] = 0;
        item['autorizaDesgar'] = "";
    }
    if (tipoDesc == 'desgar') {
        var desgar = parseInt(document.getElementById('cantDesneg-' + itemid + '-' + index).value) + pedido[index]['descuento'];
        newDesc = desgar;
        var autorizaDesgar = select.value;
        item = pedido[index]['items'][indexItem];
        item['desgar'] = parseInt(document.getElementById('cantDesneg-' + itemid + '-' + index).value);
        item['autorizaDesgar'] = autorizaDesgar;
        item['desneg'] = 0;
        item['autorizaDesneg'] = "";
    }
    pedido[index]['items'].splice(indexItem, 1);
    if (pedido[index]['items'].length == 0) {
        var rowPedido = {
            descuento: newDesc,
            plazo: pedido[index]['plazo'],
            marca: pedido[index]['marca'],
            tipo: pedido[index]['tipo'],
            regalo: pedido[index]['regalo'],
            evento: pedido[index]['evento'],
            items: []
        };
        rowPedido['items'].push(item);
        pedido.splice(index, 1);
        pedido.splice(index, 0, rowPedido);
    }
    else {
        var rowPedido = {
            descuento: newDesc,
            plazo: pedido[index]['plazo'],
            marca: pedido[index]['marca'],
            tipo: pedido[index]['tipo'],
            regalo: pedido[index]['regalo'],
            evento: pedido[index]['evento'],
            items: []
        };
        rowPedido['items'].push(item);

        pedido.splice(index + 1, 0, rowPedido);
    }


    createTablePedido();
}

// FUNCIÓN ENVIAR A NETSUITE

function saveNS() {
    console.log('Guardando en Netsuite');
    levantandoPedidoLoading();

    if (pedido.length == 0) {
        alert('Agrega artículos al pedido');
    }
    else {
        console.log(noCotizacionNS);
        var numCotizacion = noCotizacionNS;
        var idCustomer; //id
        var correo; //texto
        var ordenCompra; //texto
        var idSucursal; //id
        var dividir2000; // 1 o 0
        var cteRecoge; //1 o 0
        var shippingWay; //id
        var packageDelivery; //id
        var comentarios; //maximo 400 caracteres

        if (!entity.startsWith("Z") && !entity.startsWith("A")) {
            idCustomer = entity;
            idSucursal = info[0]['addresses'][indexAddress]["addressID"];
            shippingWay = document.getElementById('envio').classList.contains('d-none') ? $('#selectEnvio option:selected').text() : $("#envio").val();
            packageDelivery = $("#fletera").val();
        }
        else {
            idCustomer = entityCte;
            console.log('Index Customer: '+indexCustomer);
            console.log('Index Address: '+indexAddress);
            idSucursal = info[indexCustomer]['addresses'][indexAddress]["addressID"];
            shippingWay = document.getElementById('envio').classList.contains('d-none') ? $('#selectEnvio option:selected').text() : $("#envio").val();
            packageDelivery = $("#fletera").val();
        }


        var indexCustomerInfo = info.findIndex(o => o.companyId.toUpperCase() === idCustomer.toUpperCase());
        var internalId = info[indexCustomerInfo]['internalID'];

        // dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
        dividir2000 = document.getElementById("separar2000").checked ? 1 : 0;
        cteRecoge = document.getElementById("cliente_recoge").checked ? 1 : 0;
        correo = document.getElementById("correo").value;
        ordenCompra = document.getElementById("ordenCompra").value;
        comentarios = document.getElementById("comments").value;

        var lineItems = [];
        var listNS = [];

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var date = dd + "/" + mm + "/" + yyyy;

        for (var x = 0; x < pedido.length; x++) {
            var descuento = pedido[x]['descuento'];
            var plazo = pedido[x]['plazo'];
            var marca = pedido[x]['marca'];
            var tipo = pedido[x]['tipo'];
            var desneg = 0;
            var desgar = 0;
            var specialAuthorization = "";
            var indexItemSeparado;

            if (pedido[x]['items'][0]['desneg'] != 0 && pedidoSeparado.length > 0) {
                indexItemSeparado = pedidoSeparado.findIndex(o => o.descuento == (pedido[x]['descuento'] - pedido[x]['items'][0]['desneg']) && o.marca == pedido[x]['marca'] && o.plazo == pedido[x]['plazo'] && o.tipo == pedido[x]['tipo']);
            }
            else if (pedido[x]['items'][0]['desgar'] != 0 && pedidoSeparado.length > 0) {
                indexItemSeparado = pedidoSeparado.findIndex(o => o.descuento == (pedido[x]['descuento'] - pedido[x]['items'][0]['desgar']) && o.marca == pedido[x]['marca'] && o.plazo == pedido[x]['plazo'] && o.tipo == pedido[x]['tipo']);
            }
            else if (pedidoSeparado.length > 0) {
                indexItemSeparado = pedidoSeparado.findIndex(o => o.descuento == (pedido[x]['descuento'] - pedido[x]['items'][0]['desneg']) && o.marca == pedido[x]['marca'] && o.plazo == pedido[x]['plazo'] && o.tipo == pedido[x]['tipo']);
            }
            var evento = "";
            if (tipoPedido == 1) { //si el pedido es cargado por cliente, poner WEB antes del evento cuando se envía a Netsuite
                evento = pedidoSeparado[indexItemSeparado]['evento'] != undefined ? "WEB " + pedidoSeparado[indexItemSeparado]['evento'] : "";
            }
            else {
                evento = pedidoSeparado[indexItemSeparado]['evento'] != undefined ? pedidoSeparado[indexItemSeparado]['evento'] : "";
            }
            var username = "USERNAME";
            for (var y = 0; y < pedido[x]['items'].length; y++) {
                var listaPrecio = info[indexCustomerInfo]['priceList'];
                if (pedido[x]['items'][y]['desneg'] != 0) {
                    desneg = pedido[x]['items'][y]['desneg'];
                    specialAuthorization = pedido[x]['items'][y]['autorizaDesneg'];
                }
                if (pedido[x]['items'][y]['desgar'] != 0) {
                    desgar = pedido[x]['items'][y]['desgar'];
                    specialAuthorization = pedido[x]['items'][y]['autorizaDesgar'];
                }
                if (pedido[x]['items'][y]['regalo'] == 0 || pedido[x]['items'][y]['addRegalo'] == 1) { //NO CONSIDERAR LAS LÍNEAS QUE SEAN REGALO Y TENGAN EL ADDREGALO EN 0 (QUE SE HAYAN ELIMINADO)
                    var item = {
                        itemid: pedido[x]['items'][y]['itemid'],
                        quantity: pedido[x]['items'][y]['cantidad'],
                        listprice: pedido[x]['items'][y]['regalo'] == 0 ? listaPrecio : -1,
                    };
                    lineItems.push(item);
                }
            }
            var temp = {
                internalId: 0,
                idCustomer: internalId,
                date: date,
                location: marca == 'OUTLET' ? "30" : "1",
                billingAddress: {
                    id: "XXXXXX" //se llena en el back
                },
                shippingAddress: {
                    id: idSucursal
                },
                typeOrder: {
                    id: "1",
                    txt: ""
                },
                idWeb: numCotizacion.toString() + "-" + (x + 1) + "/" + pedido.length, //no tengo este dato
                noCotizacion: numCotizacion.toString(), //no tengo este dato
                lineItems: lineItems,
                shippingWay: {
                    id: 0,
                    txt: shippingWay
                },
                package: {
                    id: 0,
                    txt: packageDelivery
                },
                typeSale: {
                    id: pedido[x]['tipo'] == 'BO' ? "6" : "1",
                    txt: ""
                },
                user: username,
                methodPayment: {
                    id: "10",
                    txt: ""
                },
                useCFDI: null,
                comments: comentarios,
                events: {
                    id: "0",
                    txt: evento
                },
                plazoEvento: {
                    id: "0",
                    txt: plazo
                },
                eventSpecialDiscount: desneg != 0 ? descuento - desneg : descuento - desgar, //descuento original del subpedido
                customerDiscountPP: descuento, //total de descuento cabecera con desneg o desgar
                discountSpecial: desneg != 0 ? desneg : desgar, //desneg o desgar
                specialAuthorization: specialAuthorization,
                numPurchase: ordenCompra,
                desneg: desneg != 0 ? 1 : 0,
                desgar: desgar != 0 ? 1 : 0
            };
            listNS.push(temp);
            lineItems = [];
        }
        console.log(JSON.stringify(listNS));
        console.log(listNS);

        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "storePedidoNS",
            'type': 'POST',
            'data': { json: listNS },
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (data) {
                console.log(data);
                var error = 0;
                for (var x = 0; x < data.length; x++) {
                    if (data[x]['status'] == 'OK') {
                        document.getElementById('spinner-' + x).classList.add('d-none');
                        document.getElementById('check-' + x).classList.remove('d-none');
                        document.getElementById('tranId-' + x).innerText = data[x]['tranId'];
                        tranIds.push(data[x]['tranId']);
                        if (listNS[x]['specialAuthorization'] != "") {
                            var typeDes = listNS[x]['desneg'] != 0 ? 'Desneg' : 'Desgar';
                            var autoriza = listNS[x]['specialAuthorization'];
                            var descuento = listNS[x]['discountSpecial'];
                            sendEmailDesneg(typeDes, autoriza, descuento, date, x);
                        }
                        document.getElementById('levantarPedido').disabled = true;
                    }
                    else {
                        var json = JSON.parse(data[x]['json']);
                        document.getElementById('spinner-' + x).classList.add('d-none');
                        document.getElementById('cross-' + x).classList.remove('d-none');
                        document.getElementById('idWebError-' + x).innerText = json['idWeb'];
                        error++;
                    }
                }
                sendEmail();
                if (error > 0)
                    sendEmailErrorPedido(data);
                // window.location.href = '/pedidos';
            },
            error: function (error) {
                console.log(error);
                alert('Error al enviar pedido a Netsuite');
                // sendEmail();
                // window.location.href = '/pedidos';
            }
        });
    }
}

function closeModalNetsuiteLoading() {
    $('#modalNetsuiteLoading').modal('hide');
}

function updatePrecioIVA(itemid) {
    var desc = document.getElementById('inputDescuentoInventario-' + itemid).value;
    var cant = document.getElementById('inputPrecioCliente-' + itemid).value;
    var art = items.find(o => o.itemid === itemid);
    var precioClienteActual = 0;
    if (cant != '' && cant != '0') {
        var precio = getPrecioClientePromo(itemid).replace('$', '');
        var precio = precio.replace(',', '');
        precioClienteActual = parseFloat(precio);
    }
    else {
        precioClienteActual = art['price'];
    }

    var precioIVA = ((precioClienteActual * ((100 - desc) / 100) * 1.16)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    document.getElementById('precioIVA-' + itemid).innerHTML = precioIVA;
}

function updatePrecioCliente(itemid) {
    var precio = getPrecioClientePromo(itemid);
    updatePrecioIVA(itemid);
}

function getPrecioClientePromo(itemid) {
    var cant = document.getElementById('inputPrecioCliente-' + itemid).value;
    var precio;
    if (cant != '' && cant != '0') {
        var art = items.find(o => o.itemid === itemid);
        var promos = art['promoART'];
        var precioCliente = 0;
        if (promos != null) {
            for (var y = 0; y < promos.length; y++) {
                if (cant >= promos[y]['cantidad']) {
                    precioCliente = ((100 - promos[y]['descuento']) / 100) * art['price'];
                }
                if (precioCliente == 0)
                    precioCliente = ((100 - promos[0]['descuento']) / 100) * art['price'];
            }
        }

        if (precioCliente == 0)
            precioCliente = art['price'];


        precio = (precioCliente).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });


    }
    else {
        var art = items.find(o => o.itemid === itemid);
        precioCliente = art['price'];
        precio = (precioCliente).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
    }

    return precio;
}

function sendEmail() {
    var correo = document.getElementById("correo").value;
    var numCotizacion = noCotizacionNS;
    var ordenCompra = document.getElementById("ordenCompra").value;
    var comentarios = document.getElementById("comments").value;
    var cte = $('#customerID option:selected').text() == '' ? document.getElementById('customerID').value : $('#customerID option:selected').text();
    var formaEnvio = $('#selectEnvio option:selected').text() == 'Selecciona una forma de envío' ? document.getElementById('envio').value : $('#selectEnvio option:selected').text();
    var fletera = $("#fletera").val();
    var sucursal = info[indexCustomer]['addresses'][indexAddress]['address'];
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmail",
        'type': 'POST',
        'dataType': 'json',
        'data': { pedido: pedido, email: correo, idCotizacion: numCotizacion, ordenCompra: ordenCompra, comentarios: comentarios, cliente: cte, sucursal: sucursal, formaEnvio: formaEnvio, fletera: fletera, tranIds: tranIds },
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            alert(data['success']);
        },
        error: function (data) {
            alert('Error al enviar correo de cotización');
            console.log(data);
        }
    });
}

function sendEmailErrorPedido(data) {
    var correo = document.getElementById("correo").value;
    var numCotizacion = noCotizacionNS;
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmailErrorNS",
        'type': 'POST',
        'dataType': 'json',
        'data': { pedido: pedido, email: correo, idCotizacion: numCotizacion, responseNS: data },
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            alert(data['success']);
        },
        error: function (data) {
            alert('Error al enviar correo de pedido');
        }
    });
}

function sendEmailDesneg(type, autoriza, descuento, date, indexPedido) {
    var correo = document.getElementById("correo").value;
    var numCotizacion = noCotizacionNS;
    var ordenCompra = document.getElementById("ordenCompra").value;
    var comentarios = document.getElementById("comments").value;
    var cte = $('#customerID option:selected').text();
    var formaEnvio = $('#selectEnvio option:selected').text();
    var fletera = $("#fletera").val();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmailDesneg",
        'type': 'POST',
        'dataType': 'json',
        'data': { pedido: pedido, email: correo, idCotizacion: numCotizacion, ordenCompra: ordenCompra, comentarios: comentarios, cliente: cte, formaEnvio: formaEnvio, fletera: fletera, tipoDescuento: type, autoriza: autoriza, descuento: descuento, fecha: date, indexPedido: indexPedido },
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            alert(data['success']);
        },
        error: function (data) {
            alert('Error al enviar correo de autorización de descuento negociado');
            console.log(data);
        }
    });
}

function nuevaCotizacion() {
    $("#formNuevo").submit();
}

function activarEliminarModal() {
    $('#confirmDeleteModal').modal('show');
}

function closeModalDelete() {
    $('#confirmDeleteModal').modal('hide');
}

function closeModalInventario() {
    $('#modalInventario').modal('hide');
}

function eliminarCotizacion(type) {
    if (type == 'nueva') {
        window.location.href = '/pedidos';
    }
    else {
        $("#formDelete").submit();
        // window.location.href = '/pedidos';
    }
}

function exportTableToExcel(tableID, filename) {
    var arrayRows = [];
    arrayRows.push([
        '#',
        'ARTÍCULO',
        'CANTIDAD',
        'UNIDAD',
        'DESCRIPCIÓN',
        'MÚLTIPLO',
        'PRECIO LISTA',
        'PROMO',
        'PRECIO UNITARIO',
        'IMPORTE',
    ]);

    $.each(pedido, function (key, value) {
        $.each(value['items'], function (key, value) {
            var pUnitario = ((100 - parseFloat(value.promo)) * parseFloat(value.price) / 100).toFixed(2);
            var importe = (value.cantidad * pUnitario).toFixed(2);
            var descripcion = value.purchasedescription.replaceAll(',', ' ');
            let data = [
                key + 1,
                value.itemid,
                value.cantidad,
                value.unidad,
                descripcion,
                value.multiploVenta,
                value.price,
                value.promo,
                pUnitario,
                importe,
            ];
            arrayRows.push(data);
        });
    });

    var CsvString = "";
    arrayRows.forEach(function (RowItem, RowIndex) {
        RowItem.forEach(function (ColItem, ColIndex) {
            CsvString += ColItem + ',';
        });
        CsvString += "\r\n";
    });
    var x = document.createElement("A");
    x.setAttribute("href", 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(CsvString));
    x.setAttribute("download", filename + '.csv');
    document.body.appendChild(x);
    x.click();
}


function clearNetsuiteModal() {
    $('#container-netsuite-loading').empty();
}

function levantandoPedidoLoading() {
    var container = document.getElementById('container-netsuite-loading');
    for (var x = 0; x < pedido.length; x++) {
        var row = document.createElement('div');
        row.setAttribute('class', 'row mt-2');

        var div1 = document.createElement('div');
        div1.setAttribute('class', 'col-lg-1 col-md-1 col-12 text-center');
        var index = document.createElement('h5');
        index.innerHTML = x + 1;
        div1.appendChild(index);

        var div2 = document.createElement('div');
        div2.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
        var descuento = document.createElement('h5');
        descuento.innerHTML = 'Descuento: ' + pedido[x]['descuento'] + '%';
        div2.appendChild(descuento);

        var div3 = document.createElement('div');
        div3.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
        var plazo = document.createElement('h5');
        plazo.innerHTML = 'Plazo: ' + pedido[x]['plazo'];
        div3.appendChild(plazo);

        var div4 = document.createElement('div');
        div4.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
        var tipo = document.createElement('h5');
        tipo.innerHTML = 'Tipo: ' + pedido[x]['tipo'];
        div4.appendChild(tipo);

        var div5 = document.createElement('div');
        div5.setAttribute('class', 'col-lg-3 col-md-3 col-12 text-center');
        var evento = document.createElement('h5');
        evento.innerHTML = 'Evento: ' + pedido[x]['evento'];
        div5.appendChild(evento);

        var div6 = document.createElement('div');
        div6.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
        div6.setAttribute('id', 'spinner-' + x);
        var spinner = document.createElement('div');
        spinner.setAttribute('class', 'spinner-border text-secondary')
        spinner.setAttribute('style', 'width: 20px; height: 20px;')
        div6.appendChild(spinner);

        var div7 = document.createElement('div');
        div7.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center d-none');
        div7.setAttribute('id', 'check-' + x);
        div7.setAttribute('style', 'display: flex; justify-content: space-between;')
        var check = document.createElement('img');
        check.src = '/assets/customers/img/png/check.png';
        check.setAttribute('style', 'width: 20px; height: 20px;')
        var tranId = document.createElement('p');
        tranId.setAttribute('id', 'tranId-' + x);
        div7.appendChild(check);
        div7.appendChild(tranId);

        var div8 = document.createElement('div');
        div8.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center d-none');
        div8.setAttribute('id', 'cross-' + x);
        div8.setAttribute('style', 'display: flex; justify-content: space-between;')
        var check = document.createElement('img');
        check.src = '/assets/customers/img/png/cross.png';
        check.setAttribute('style', 'width: 20px; height: 20px;')
        var idWebError = document.createElement('p');
        idWebError.setAttribute('id', 'idWebError-' + x);

        div8.appendChild(check);
        div8.appendChild(idWebError);

        row.appendChild(div1);
        row.appendChild(div2);
        row.appendChild(div3);
        row.appendChild(div4);
        row.appendChild(div5);
        row.appendChild(div6);
        row.appendChild(div7);
        row.appendChild(div8);

        container.appendChild(row);

    }
    $('#modalNetsuiteLoading').modal('show');
}


function verImagenProducto(itemid) {
    var art = items.find(o => o.itemid === itemid);
    document.getElementById('codigoArticuloMD').innerText = itemid;
    document.getElementById('descripcionArticuloMD').innerText = art['purchasedescription'];
    var src = "http://indarweb.dyndns.org:8080/assets/articulos/img/02_JPG_MD/" + itemid.replaceAll(" ", "_").replaceAll("-", "_") + "_MD.jpg";
    document.getElementById('containerImgProduct').style.display = 'flex';
    document.getElementById('imgProductMD').src = src;
}

function closeImgProductMD() {
    document.getElementById('containerImgProduct').style.display = 'none';
}

function addItemInventory(item) {
    var cant = document.getElementById('inputPrecioCliente-' + item).value;
    var art = selectedItemsFromInventory.find(o => o.item === item.trim());
    if (art != undefined)
        art['cant'] = (parseInt(art['cant']) + parseInt(cant)).toString();
    else
        selectedItemsFromInventory.push({ item: item.trim(), cant: cant });
    var toast = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        animation: true,
        position: 'top-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    toast.fire({
        animation: true,
        title: 'Producto ' + item + ' Agregado',
        icon: 'success'
    });
}

function fillShippingWaysList() {
    $('#fletera').val('');
    $.ajax({
        type: "GET",
        enctype: 'multipart/form-data',
        url: "/pedido/getformaEnvioFletera/",
        data: FormData,
        'async': false,
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function (data) {
            shippingWaysList = data;
        },
        error: function (error) {
            alert('Error obteniendo formas de envio');
        }
    });

    document.getElementById('envio').classList.add('d-none');
    document.getElementById('containerSelectEnvio').classList.remove('d-none');
    var itemSelectorOption = $('#selectEnvio option');
    itemSelectorOption.remove();
    for (var x = 0; x < shippingWaysList.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal
        $('#selectEnvio').append('<option value="' + x + '">' + shippingWaysList[x]['fletera'] + '</option>');
    }
    $('#selectEnvio').val(0); //Seleccionar la primera opcion
    $('#selectEnvio').selectpicker('refresh');
}

function mostrarSoloExistencias() {
    var checkBox = document.getElementById("mostrar_existencias");
    dataset = [];
    if (checkBox.checked == true) {
        document.getElementById('mostrar_existenciasLabel').innerText = 'Mostrar todo';
        let currentTable = $('#tablaInventario').DataTable();
        let data = currentTable.rows({ filter: 'applied' }).data(); //obtiene información de tabla considerando si tiene algún filtro aplicado
        currentDataset = currentTable.rows().data(); //Obtiene toda la información de la tabla, sin tomar en cuenta el filtro que tenga
        let currentFilter = currentTable.search();
        for (let x = 0; x < data.length; x++) {
            let existencia = data[x][6].split('>')[2].split('<')[0];
            if (existencia > 0) {
                dataset.push(data[x]);
            }
        }
        $("#tablaInventario").dataTable().fnClearTable();
        $("#tablaInventario").dataTable().fnDraw();
        $("#tablaInventario").dataTable().fnDestroy();
        let newTable = $("#tablaInventario").DataTable({
            data: dataset,
            pageLength: 5,
            orderCellsTop: true,
            fixedHeader: true,
            deferRender: true,
            lengthMenu: [[5, 10, 20, 100], [5, 10, 20, 100]],
            "initComplete": function (settings, json) {
                $("#tablaInventario").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            'columnDefs': [
                { "targets": 0, "className": "td-center", "orderable": false },
                { "targets": 1, "className": "td-center" },
                { "targets": 2, "className": "td-center" },
                { "targets": 3, "className": "td-center" },
                { "targets": 4, "className": "td-center" },
                { "targets": 6, "searchable": false, "orderable": false },
                { "targets": 7, "searchable": false, "orderable": false },
                { "targets": 8, "searchable": false, "orderable": false },
                { "targets": 9, "searchable": false, "orderable": false },
                { "targets": 10, "visible": false, "searchable": false, "orderable": false }
            ]
        });

        newTable.search(currentFilter);
        $('#tablaInventario thead').on('keyup', ".column_search", function () {
            newTable.column($(this).parent().index()).search(this.value).draw();
        });
        $('.dataTables_filter input').off().on('keyup', function() {
            newTable.column('4').order('asc').draw();
            $('#tablaInventario').DataTable().search(this.value.trim(), true, true).draw();
        });  
    } else {
        document.getElementById('mostrar_existenciasLabel').innerText = 'Mostrar solo existencias';
        let currentTable = $('#tablaInventario').DataTable();
        let currentFilter = currentTable.search();
        $("#tablaInventario").dataTable().fnClearTable();
        $("#tablaInventario").dataTable().fnDraw();
        $("#tablaInventario").dataTable().fnDestroy();
        let newTable = $("#tablaInventario").DataTable({
            data: currentDataset,
            pageLength: 5,
            orderCellsTop: true,
            fixedHeader: true,
            deferRender: true,
            lengthMenu: [[5, 10, 20, 100], [5, 10, 20, 100]],
            "initComplete": function (settings, json) {
                $("#tablaInventario").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            'columnDefs': [
                { "targets": 0, "className": "td-center", "orderable": false },
                { "targets": 1, "className": "td-center" },
                { "targets": 2, "className": "td-center" },
                { "targets": 3, "className": "td-center" },
                { "targets": 4, "className": "td-center" },
                { "targets": 6, "searchable": false, "orderable": false },
                { "targets": 7, "searchable": false, "orderable": false },
                { "targets": 8, "searchable": false, "orderable": false },
                { "targets": 9, "searchable": false, "orderable": false },
                { "targets": 10, "visible": false, "searchable": false, "orderable": false }
            ]
        });
        newTable.search(currentFilter).draw();
        $('#tablaInventario thead').on('keyup', ".column_search", function () {
            newTable.column($(this).parent().index()).search(this.value).draw();
        });
        $('.dataTables_filter input').off().on('keyup', function() {
            newTable.column('4').order('asc').draw();
            $('#tablaInventario').DataTable().search(this.value.trim(), true, true).draw();
        });  
    }
}

function pedidosClientes() {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/getPedidosPendientesCTE",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            pendingSaleOrders = data;
            loadDatasetPedidosClientes();
        },
        error: function (error) {
        }
    });
}

function closeModalPedidosClientes() {
    $('#modalPedidosClientes').modal('hide');
}

function loadDatasetPedidosClientes() {
    var empty = document.getElementById('emptyPedidosClientes').value;
    if (empty == 'yes') {
        document.getElementById('emptyPedidosClientes').value = 'no';
        var dataset = [];
        var x = 0;
        var data = [];
        var ids = [];
        while (x < pendingSaleOrders.length) {
            if (data.length == 0) { data.push(pendingSaleOrders[x]); ids.push(pendingSaleOrders[x]['id']); }
            else {
                if (!ids.includes(pendingSaleOrders[x]['id'])) {
                    data.push(pendingSaleOrders[x]); ids.push(pendingSaleOrders[x]['id']);
                }
            }
            x++;
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = parseInt(yyyy + '' + mm + '' + dd);

        x = 0;

        while (x < data.length) {
            var arr = [];
            var importe = (data[x]['importe']).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            arr.push("<p class='datos-pedidos-cliente'>" + data[x]['zona'] + "</p>");
            arr.push("<p class='datos-pedidos-cliente'>" + data[x]['cliente'] + " - " + data[x]['nombre'] + "</p>");
            arr.push("<p class='datos-pedidos-cliente'>" + data[x]['id'] + "</p>");
            arr.push("<p class='datos-pedidos-cliente'>" + importe + "</p>");
            var fechaOrden = data[x]['fecha'].split('/');
            fechaOrden = parseInt(fechaOrden[2] + "" + fechaOrden[1] + "" + fechaOrden[0]);
            var datetime = "";
            if (fechaOrden < today) {
                datetime = datetime + "<p class='datos-pedidos-cliente text-red'>" + data[x]['fecha'] + "</p>";
                datetime = datetime + "<p class='datos-pedidos-cliente text-red'>" + data[x]['hora'] + "</p>";
            }
            else {
                datetime = datetime + "<p class='datos-pedidos-cliente'>" + data[x]['fecha'] + "</p>";
                datetime = datetime + "<p class='datos-pedidos-cliente'>" + data[x]['hora'] + "</p>";
            }

            arr.push(datetime);
            arr.push("<div class='table-actions'><i class='fas fa-plus-square btn-add-product fa-2x mt-2' id='btnAddPedidosClientes-" + data[x]['id'] + "' onclick='loadPendingCustomerSaleOrder(\"" + data[x]['id'] + "\")'></i><div class='spinner-border text-secondary' style='display:none; width: 25px; height: 25px;' id='btnSpinnerPedidosClientes-" + data[x]['id'] + "' ></div></div>");
            dataset.push(arr);
            x++;
        }

        $('#tablaPedidosClientes thead tr:eq(1) th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" class="column_search" />');
        });

        var table = $("#tablaPedidosClientes").DataTable({
            data: dataset,
            pageLength: 10,
            orderCellsTop: true,
            fixedHeader: true,
            deferRender: true,
            lengthMenu: [[10, 20, 100], [10, 20, 100]],
            'columnDefs': [
                { "targets": 0, "className": "td-center" },
                { "targets": 1, "className": "td-center" },
                { "targets": 2, "className": "td-center" },
                { "targets": 3, "className": "td-right" },
                { "targets": 4, "className": "td-center" },
            ]
        });
        $('#tablaPedidosClientes thead').on('keyup', ".column_search", function () {
            table.column($(this).parent().index()).search(this.value).draw();
        });
    }
    $('#modalPedidosClientes').modal('show');
}

function loadPendingCustomerSaleOrder(id) { //Cargar orden capturada por el cliente
    var order = [];
    var x = 0;
    while (x < pendingSaleOrders.length) {
        if (pendingSaleOrders[x]['id'] == id) { order.push(pendingSaleOrders[x]); }
        x++;
    }
    var indexCustomerInfo = info.findIndex(o => o.companyId.toUpperCase() === order[0]['cliente'].toUpperCase());
    $('#customerID').val(indexCustomerInfo); //Seleccionar la primera opcion
    $('#customerID').selectpicker('refresh');
    updateCustomerInfo(indexCustomerInfo);
    cantItemsPorCargar = order.length;
    for (var x = 0; x < order.length; x++) {
        var art = selectedItemsFromInventory.find(o => o.item === order[x]['articulo'].trim());
        if (art != undefined)
            art['cant'] = (parseInt(art['cant']) + parseInt(order[x]['cantidad'])).toString();
        else
            selectedItemsFromInventory.push({ item: order[x]['articulo'].trim(), cant: order[x]['cantidad'] });
    }
    document.getElementById('comments').value = order[0]['comentario'];
    document.getElementById('ordenCompra').value = order[0]['ordenCompra'];
    var indexShippingWay = shippingWaysList.findIndex(o => o.fletera === order[0]['formaEnvio']);
    if (indexShippingWay == -1) { //si no se encuentra la forma de envío
        if (order[0]['formaEnvio'] == 'GDL-07 CLIENTE RECOGE') { //esta forma de envío no existe en netsuite, hay que cambiarla por la que sí existe
            indexShippingWay = shippingWaysList.findIndex(o => o.fletera === "GDL07 CLIENTE RECOGE");
        }
        else {
            var message = "";
            if (order[0]['formaEnvio'] == "") { //si la forma de envío viene vacía
                message = 'El pedido no cuenta con forma de envío';
            }
            else { //no se encuentra esa forma de envío
                message = 'Forma envio: ' + order[0]['formaEnvio'] + ' no encontrada';
            }
            Swal.fire('Alerta', message, 'info');
        }
    }
    pedidoCargadoCte = order[0]['id'];
    $('#selectEnvio').val(indexShippingWay); //Seleccionar Forma Envío según el index de la forma envío que seleccionó el cliente
    $('#selectEnvio').selectpicker('refresh');
    $('#fletera').val(order[0]['fletera']); //Poner Fletera que seleccionó el cliente
    if (order[0]['fletera'] == "") { //si la fletera viene vacía
        Swal.fire('Alerta', 'El pedido no cuenta con fletera', 'info');
    }
    tipoPedido = 1;
    tipoGetItemById = 1;
    $('#modalPedidosClientes').modal('hide');
    prepareJsonSeparaPedidos(false);
}


function updateCustomerInfo(selected) { //RECARGA TODO EL ENCABEZADO DEL PEDIDO (SUCURSALES, FORMAS DE ENVIO, FLETERAS, CATEGORÍA, CLIENTE, EMAIL ... )
    indexCustomer = selected;
    var refrescaInventario = false;
    //INFO es la lista de todos los clientes con su información correspondiente
    addresses = info[selected]['addresses']; //obtener lista de domicilios del cliente seleccionado
    shippingWays = info[selected]['shippingWays']; //obtener formas de envío del cliente seleccionado
    packageDeliveries = info[selected]['packageDeliveries']; //obtener paqueterías del cliente seleccionado
    document.getElementById('entity').value = info[selected]["companyId"];
    entityCte = info[selected]["companyId"];
    if (priceList != '' && priceList != info[selected]['priceList']) { refrescaInventario = true; } //si ya existe una lista de precio cargada y es diferente a a del nuevo cliente seleccionado
    if (priceList == '') { refrescaInventario = true; } //si aún no se ha cargado ninguna lista
    if (((new Date) - lastRefreshInventory) > oneHour) { refrescaInventario = true; } //si ha pasado más de 1 hora desde la última recarga

    document.getElementById('loading-message').innerHTML = 'Cargando cotización ...';

    document.getElementById('categoryCte').innerHTML = 'Categoría Cliente: ' + info[selected]['category'];

    document.getElementById('categoryCte').classList.remove('d-none');

    selectedItemsFromInventory = []; //vaciar arreglo de articulos seleccionados
    pedido = []; //vaciar pedido
    ignorarRegalos = [];
    document.getElementById('cupon').value = ''; //limpiar campo cupon
    document.getElementById('comments').value = ''; //limpiar campo comentarios
    document.getElementById('ordenCompra').value = ''; //limpiar campo orden compra
    createTablePedido(); //limpiar tabla pedido
    clearNetsuiteModal(); //limpiar modal de pedidos enviados a netsuite

    checkPromocionesCliente = true;
    intervalInventario = window.setInterval(checkItems, 1000);
    getEventosCliente(entityCte);

    if (refrescaInventario) {
        lastRefreshInventory = new Date;
        priceList = info[selected]['priceList'];
        items = [];
        getItems(entityCte, false);
    }

    var selectSucursales = $('#sucursal option');
    selectSucursales.remove();
    $('#sucursal').selectpicker('refresh');

    var defaultShippingSelected = false;
    var indexDefaultShipping = 0;

    for (var x = 0; x < addresses.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal
        // AGREGAR ICONO DE BILLING O SHIPPING PARA IDENTIFICAR LAS DIRECCIONES DEL CLIENTE
        if (addresses[x]['defaultShipping'] == true && addresses[x]['defaultBilling'] == true) //SI ES BILLING Y SHIPPING AGREGAR LOS 2 ICONOS
            $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-shipping-fast\'></i> <i class=\'fas fa-file-invoice\'></i> ' + addresses[x]['address'] + '"</option>');
        if (addresses[x]['defaultShipping'] == false && addresses[x]['defaultBilling'] == true) //SI ES BILLING PERO NO ES SHIPPING
            $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-file-invoice\'></i> ' + addresses[x]['address'] + '"</option>');
        if (addresses[x]['defaultShipping'] == true && addresses[x]['defaultBilling'] == false) //SI ES SHIPPING PERO NO BILLING
            $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="<i class=\'fas fa-shipping-fast\'></i> ' + addresses[x]['address'] + '"</option>');
        if (addresses[x]['defaultShipping'] == false && addresses[x]['defaultBilling'] == false) //SI ES SHIPPING PERO NO BILLING
            $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '"data-content="' + addresses[x]['address'] + '"</option>');


        if (addresses[x]['defaultShipping'] == true && !defaultShippingSelected) {//Seleccionar la primera opcion que tenga defaultshipping
            defaultShippingSelected = true;
            indexDefaultShipping = x;
            indexAddress = x;
            $('#sucursal').val(addresses[x]['addressID']);
        }
    }

    if (!defaultShippingSelected) { //si ninguna dirección es defaultshipping, seleccionar la primera
        $('#sucursal').val(addresses[0]['addressID']);
    }

    $('#sucursal').selectpicker('refresh');

    fillShippingWaysList();

    var indexShippingWay = shippingWaysList.findIndex(o => o.fletera === shippingWays[indexDefaultShipping]);
    $('#selectEnvio').val(indexShippingWay); //Seleccionar fletera según el index de default shipping
    $('#selectEnvio').selectpicker('refresh');
    $('#fletera').val(packageDeliveries[indexDefaultShipping]);
    $('#correo').val(info[selected]['email']);
}


function getPUnitario(item) {
    var art = items.find(o => o.itemid === item['itemID']);
    var precioCliente = 0;
    var cantidad = parseInt(item['quantity']);
    if (art == undefined) {
        precioCliente = item['plista'];
    }
    else {
        if (art['promoART'] != null) {
            var y = 0;
            while (y < art['promoART'].length) {
                if (cantidad >= art['promoART'][y]['cantidad']) {
                    precioCliente = ((100 - art['promoART'][y]['descuento']) / 100) * art['price'];
                }
                y++;
            }
            if (precioCliente == 0)
                precioCliente = ((100 - art['promoART'][0]['descuento']) / 100) * art['price'];
        }
        else
            precioCliente = art['price'];
    }


    return parseFloat(precioCliente.toFixed(2));
}