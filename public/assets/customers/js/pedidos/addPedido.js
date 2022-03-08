var info = []; //result getInfoHeatWeb
var addresses = [];
var shippingWays = [];
var packageDeliveries = [];
var items = []; //result inventario getItems/All
var promocionesCliente = []; //result getEventosCliente para cargar codigos de promociones activas para el cliente
var checkPromocionesCliente = true;
var jsonItemsSeparar = "";
var ignorarRegalos = [];
var noCotizacionNS = 0;

var indexFocus = []; //guardar el index de las filas editadas para que parpadeen después de crear nuevamente la tabla
var intervalVar; //variable para asignar intervalo y hacer clear al intervalo después de x segundos+
var itemToFocus; //saber qué artículo debe resaltarse después de crear nuevamente la tabla

var selectedItemsFromInventory = [];
var cantItemsPorCargar = 0;
var cantItemsCargados = 0;

var pedido = [];
var pedidoSeparado = []; //result separaPedidosPromo

var tipoDesc; //variable para cuando se aplique desneg o desgar identificar cuál de los dos es

// VARIABLES GLOBALES PARA CAMBIAR DE FLETERA Y FORMA DE ENVÍO CUANDO CAMBIA CLIENTE O SUCURSAL
indexCustomer = 0;
indexAddress = 0;
// VARIABLE PARA DETECTAR CUANDO EL INVENTARIO ESTÁ CARGADO
var intervalInventario;
// VARIABLE PARA VALIDAR QUE EL CLICK EN LA TABLA HAYA SIDO EN EL BOTÓN DE AGREGAR
var cell_clicked;
// CODIGO DE CLIENTE
var entity;
var entityCte;

$(document).ready(function() {

    entity = document.getElementById('entity').value;
    entity = entity.toUpperCase();
    if (entity.startsWith("C") || entity.startsWith("E")) { //si es codigo de cliente o empleado
        getItems(entity);
    }
    else{ //si es zona o all (vendedor o apoyo)
        document.getElementById('loading-message').innerHTML = 'Selecciona un cliente para cargar inventario';
    }

    if(window.location.href.includes('pedido/editar')){ //SI EL PEDIDO VA A SER ACTUALIZADO, CARGAR INFORMACIÓN PREVIA
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
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data) {
                
                $('#sucursal').val(data['addressId']); //Seleccionar la primera opcion
                $('#sucursal').selectpicker('refresh');

                if(data['pickUp']==1){
                    $('#cliente_recoge').prop("checked", true);
                } 

                if(data['divide']==1){
                    $('#dividir').prop("checked", true);
                }
            
                for (var x = 0; x < data['order'].length; x++) {
                    for(var y = 0; y < data['order'][x]['items'].length; y++){
                        var art = selectedItemsFromInventory.find(o => o.item === data['order'][x]['items'][y]['itemid'].trim());
                        if(art != undefined)
                            art['cant'] = (parseInt(art['cant']) + parseInt(data['order'][x]['items'][y]['cantidad'])).toString();
                        else
                            selectedItemsFromInventory.push({ item: data['order'][x]['items'][y]['itemid'].trim(), cant: data['order'][x]['items'][y]['cantidad'] });
                        cantItemsPorCargar ++;
                    }
                }

            },
            error: function(error) {
                alert('Error cargando pedido');
            }
        });
    }

    const fileSelector = document.getElementById('excelCodes');
    fileSelector.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function(sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                cargarProductosExcel(jsonObj);

            })
        };
        reader.readAsBinaryString(input.files[0]);
    });



    intervalInventario = window.setInterval(checkItems, 1000);

    // var bLazy = new Blazy({
    //     selector: '.b-lazy',
    //     offset: 180, // Loads images 180px before they're visible
    //     success: function(element) {
    
    //         setTimeout(function() {
    //             var parent = element.parentNode;
    //             parent.className = parent.className.replace(/\bloading\b/, '');
    //         }, 200);
    //     },
    //     error: function(element, message) {
    
    //     }
    // });

    function checkItems() {
        if(promocionesCliente.length > 0 && checkPromocionesCliente){
            checkPromocionesCliente = false;
            $("#tags-promo").empty();
            for(var x = 0; x<promocionesCliente.length; x++){
                if(x+1 == promocionesCliente.length)
                    $("#tags-promo").append('<li class="tags last">'+promocionesCliente[x]['nombrePromo']+'<i class="fa fa-times"></i></li>');
                else
                    $("#tags-promo").append('<li class="tags">'+promocionesCliente[x]['nombrePromo']+'<i class="fa fa-times"></i></li>');
            }
        }
        if (items.length > 0) {
            document.getElementById('pedido').style.display = "block";
            document.getElementById('loading').style.display = "none";
            document.getElementById('loading').classList.remove('d-flex');
            if(window.location.href.includes('pedido/editar')){ //SI EL PEDIDO VA A SER ACTUALIZADO, CARGAR INFORMACIÓN PREVIA
                prepareJsonSeparaPedidos(false);
            }
            clearInterval(intervalInventario);
        } else {
            document.getElementById('pedido').style.display = "none";
            document.getElementById('loading').style.display = "block";
            document.getElementById('loading').classList.add('d-flex');
        }
    }

   

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
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data) {
            info = data;
        },
        error: function(error) {
            
        }
    });

    $('#modalInventario').on('hidden.bs.modal', function () {
        prepareJsonSeparaPedidos(false);
    })



    // INVENTARIO ON CLICK ADD ROW TO ORDER
    $('#tablaInventario tbody').on('click', 'td', function() {
        table = $("#tablaInventario").DataTable();
        cell_clicked = table.cell(this).data();
    });

    $('#tablaInventario tbody').on('click', 'tr', function() {
        table = $("#tablaInventario").DataTable();
        var index = table.row(this).index();
        var item = items[index];
        var cant = table.cell(index, 7).nodes().to$().find('input').val();
        if (cell_clicked == "<div class='table-actions'><i class='fas fa-plus-square btn-add-product fa-2x'></i></div>") {
            var art = selectedItemsFromInventory.find(o => o.item === (item['itemid']).trim());
            if(art != undefined)
                art['cant'] = (parseInt(art['cant']) + parseInt(cant)).toString();
            else
                selectedItemsFromInventory.push({ item: item['itemid'].trim(), cant: cant });
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
                title: 'Producto ' + item['itemid'] + ' Agregado',
                icon: 'success'
            });
        }



    });




    // UPDATE ADDRESSES AND DEFAULT SHIPPING WAT / PACKAGING WHEN CUSTOMER IS SELECTED ----------------------------------------------------------------

    $('#customerID').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex - 1;
        indexCustomer = selected;
        addresses = info[selected]['addresses'];
        shippingWays = info[selected]['shippingWays'];
        packageDeliveries = info[selected]['packageDeliveries'];

        document.getElementById('loading-message').innerHTML = 'Cargando inventario ...';

        document.getElementById('categoryCte').innerHTML = 'Categoría Cliente: '+info[selected]['category'];
        document.getElementById('categoryCte').classList.remove('d-none');

        items = [];
        intervalInventario = window.setInterval(checkItems, 1000);
        checkPromocionesCliente = true;
        document.getElementById('entity').value = info[selected]["companyId"];
        entityCte = info[selected]["companyId"];
        getItems(info[selected]["companyId"]);

        var itemSelectorOption = $('#sucursal option');
        itemSelectorOption.remove();
        $('#sucursal').selectpicker('refresh');

        $('#sucursal').append('<option value="none"></option>'); //Agregar Primera opción de Sucursal en Blanco
        $('#sucursal').val('none');
        $('#sucursal').selectpicker("refresh");

        for (var x = 0; x < addresses.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal
            $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '">' + addresses[x]['address'] + '</option>');
            $('#sucursal').val(addresses[x]['addressID']);
            $('#sucursal').selectpicker("refresh");
        }

        $('#sucursal').val('none'); //Seleccionar la primera opcion
        $('#sucursal').selectpicker('refresh');

        $('#envio').val(info[selected]['shippingWayF']);
        $('#fletera').val(info[selected]['packgeDeliveryF']);
        $('#correo').val(info[selected]['email']);

    });

    // UPDATE DEFAULT SHIPPING WAT / PACKAGING WHEN ADDRESS IS CHANGED -------------------------------------------------------------------------------------

    $('#sucursal').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex - 1;
        if (info.length == 1) {
            if (clickedIndex == 0) {
                indexAddress = 0;
                $('#envio').val(info[0]['shippingWayF']);
                $('#fletera').val(info[0]['packgeDeliveryF']);
                document.getElementById('envio').classList.add('d-none');
                document.getElementById('containerSelectEnvio').classList.remove('d-none');
            } else {
                indexAddress = selected;
                addresses = info[0]['addresses'];
                shippingWays = info[0]['shippingWays'];
                packageDeliveries = info[0]['packageDeliveries'];
                $('#envio').val(shippingWays[selected]);
                $('#fletera').val(packageDeliveries[selected]);
                document.getElementById('envio').classList.remove('d-none');
                document.getElementById('containerSelectEnvio').classList.add('d-none');
            }
        } else {
            if (clickedIndex == 0) {
                indexAddress = 0;
                $('#fletera').val('');
                document.getElementById('envio').classList.add('d-none');
                document.getElementById('containerSelectEnvio').classList.remove('d-none');
                shippingWays = info[indexCustomer]['shippingWays'];
                var itemSelectorOption = $('#selectEnvio option');
                itemSelectorOption.remove();
                $('#selectEnvio').selectpicker('refresh');
        
                $('#selectEnvio').append('<option value="none"></option>'); //Agregar Primera opción de Sucursal en Blanco
                $('#selectEnvio').val('none');
                $('#selectEnvio').selectpicker("refresh");
                for (var x = 0; x < shippingWays.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal
                    $('#selectEnvio').append('<option value="' + x + '">' + shippingWays[x] + '</option>');
                    $('#selectEnvio').val(shippingWays[x]);
                    $('#selectEnvio').selectpicker("refresh");
                }
        
                $('#sucursal').val('none'); //Seleccionar la primera opcion
                $('#sucursal').selectpicker('refresh');
        
                
            } else {
                indexAddress = selected;
                $('#envio').val(shippingWays[selected]);
                $('#fletera').val(packageDeliveries[selected]);
                document.getElementById('envio').classList.remove('d-none');
                document.getElementById('containerSelectEnvio').classList.add('d-none');
            }
        }
    });

    // UPDATE PACKAGING WHEN SHIPPING WAY IS SELECTED ----------------------------------------------------------------

    $('#selectEnvio').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex - 1;
        indexCustomer = selected;
        addresses = info[selected]['addresses'];
        shippingWays = info[selected]['shippingWays'];
        packageDeliveries = info[selected]['packageDeliveries'];

        document.getElementById('loading-message').innerHTML = 'Cargando inventario ...';

        document.getElementById('categoryCte').innerHTML = 'Categoría Cliente: '+info[selected]['category'];
        document.getElementById('categoryCte').classList.remove('d-none');

        items = [];
        intervalInventario = window.setInterval(checkItems, 1000);
        document.getElementById('entity').value = info[selected]["companyId"];
        entityCte = info[selected]["companyId"];
        getItems(info[selected]["companyId"]);

        var itemSelectorOption = $('#sucursal option');
        itemSelectorOption.remove();
        $('#sucursal').selectpicker('refresh');

        $('#sucursal').append('<option value="none"></option>'); //Agregar Primera opción de Sucursal en Blanco
        $('#sucursal').val('none');
        $('#sucursal').selectpicker("refresh");

        for (var x = 0; x < addresses.length; x++) { //Agregar todas las sucursales del cliente seleccionado al select Sucursal
            $('#sucursal').append('<option value="' + addresses[x]['addressID'] + '">' + addresses[x]['address'] + '</option>');
            $('#sucursal').val(addresses[x]['addressID']);
            $('#sucursal').selectpicker("refresh");
        }

        $('#sucursal').val('none'); //Seleccionar la primera opcion
        $('#sucursal').selectpicker('refresh');

        $('#envio').val(info[selected]['shippingWayF']);
        $('#fletera').val(info[selected]['packgeDeliveryF']);
        $('#correo').val(info[selected]['email']);

    });

});




function existingTag(text) {
    var existing = false,
        text = text.toLowerCase();

    $(".tags").each(function() {
        if ($(this).text().toLowerCase() == text) {
            existing = true;
            return "";
        }
    });

    return existing;
}



$(function() {
    $(".tags-new input").focus();

    $(".tags-new input").keyup(function(e) {

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

    $(document).on("click", ".tags i", function() {
        $(this).parent("li").remove();
    });

});

//ELIMINAR ARTICULO DE LA TABLA 
function deleteRowPedido(t, item, index, cantidad, tipo) {
    if(tipo == 'regalo'){
        var row = t.parentNode.parentNode.parentNode;
    }
    else{
        var row = t.parentNode.parentNode;
    }
    itemToFocus = item;
    document.getElementById("tablaPedido").deleteRow(row.rowIndex);
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
    if(pedido[index]['items'][indexItem]['regalo']==1){
        pedido[index]['items'][indexItem]['addRegalo'] = 0; 
    }
    else{
        console.log('Delete row Pedido');
        console.log(pedido);
        pedido[index]['items'].splice(indexItem, 1);
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = parseInt(selectedItemsFromInventory[indexInventory]['cant']) - cantidad;
        
        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) - cantidad).toString(); 
        jsonItemsSeparar = JSON.stringify(jsonObj);
    }

    if(pedido[index]['items'].length == 0){
        
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
    cell2.innerHTML = "<input id='input-cantidad-" + (table.rows.length - 1) + "' type='text'>";
    cell3.innerHTML = "<i class='fas fa-minus-square fa-xl fa-delete' onclick='deleteRowCodigo(this)'></i>";

    document.getElementById('btnCargarPorCodigo').classList.remove('d-none');
}

function cargarProductosPorCodigo() {
    var rows = document.getElementsByClassName('input-codigo');
    cantItemsPorCargar = rows.length;
    for (var x = 1; x <= rows.length; x++) {
        var inputCodigo = document.getElementById('input-codigo-' + x);
        var inputCantidad = document.getElementById('input-cantidad-' + x);
        var art = selectedItemsFromInventory.find(o => o.item === (inputCodigo.value).trim());
        if(art != undefined)
            art['cant'] = (parseInt(art['cant']) + parseInt(inputCantidad.value)).toString();
        else
            selectedItemsFromInventory.push({ item: (inputCodigo.value).trim(), cant: inputCantidad.value });   
    }

    var table = document.getElementById('tableCargarPorCodigo');
    var filas = table.rows.length - 1;
    while(filas > 0){
        table.deleteRow(filas);
        filas --;
    } 

    document.getElementById('tableCargarPorCodigo').style.display = 'none';
    table.classList.remove('active');
    table.classList.add('inactive');
    document.getElementById('btnCargarPorCodigo').classList.add('d-none');

    prepareJsonSeparaPedidos(false);
}

function cargarProductosExcel(json) {
    jsonObj = JSON.parse(json);
    
    cantItemsPorCargar = jsonObj.length;
    for (var x = 0; x < jsonObj.length; x++) {
        var art = selectedItemsFromInventory.find(o => o.item === jsonObj[x]['Codigos'].trim());
        if(art != undefined)
            art['cant'] = (parseInt(art['cant']) + parseInt(jsonObj[x]['Cantidad'])).toString();
        else
            selectedItemsFromInventory.push({ item: jsonObj[x]['Codigos'].trim(), cant: jsonObj[x]['Cantidad'] });
    }

    prepareJsonSeparaPedidos(false);

    document.getElementById("excelCodes").value = "";
}


function prepareJsonSeparaPedidos(separa){
    cantItemsPorCargar = selectedItemsFromInventory.length;
    jsonItemsSeparar = "[";
    for (var x = 0; x < selectedItemsFromInventory.length; x++) {
        var item = { "articulo": selectedItemsFromInventory[x]['item'], "cantidad": selectedItemsFromInventory[x]['cant'] };
        getItemById(item, separa);
    }
}


function separarPedidosPromo(json, separar){  //envía json a back y recibe pedido separado
    if(separar && json == null){
        prepareJsonSeparaPedidos(true);
    }
    if(separar && json != null){
        
        if(document.getElementById('cupon').value != ''){
            json = JSON.parse(json);
            for(var x = 0; x < json.length; x++){
                json[x]['cupon'] = document.getElementById('cupon').value;
            }
            console.log(json);
            json = JSON.stringify(json);
            console.log(json);
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
                data: JSON.stringify({key: json}),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    pedidoSeparado = data;
                    console.log(data);
                    separarFilas(data);
                },
                error: function(error) {}
            });
        }
        else{
            console.log(json);
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
                data: JSON.stringify({key: json}),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    pedidoSeparado = data;
                    separarFilas(data);
                },
                error: function(error) {}
            });
        }
    }
    if(!separar){
        console.log('No separar, solo agregar fila');
        json = JSON.parse(json);
        console.log(json);
        console.log(selectedItemsFromInventory);
        console.log(pedido);
        var arr = [];
        for(var x = 0; x < json.length; x++){
            var art = items.find(o => o.itemid === json[x]['itemID']);
            var artArr = arr.find(o => o.itemID === json[x]['itemID'])
            if(artArr != undefined){
                artArr['quantity'] = (parseInt(json[x]['quantity']) + parseInt(artArr['quantity'])).toString();
                console.log(artArr['quantity']);
            }
            else{
                if(json[x]['quantity'] > 0){
                    json[x]['descuento'] = 0;
                    json[x]['plazo'] = 0;
                    json[x]['marca'] = '';
                    json[x]['evento'] = '';
                    // json[x]['tipo'] = art['categoriaItem'];
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

function separarFilas(json){ //prepara arreglo de pedido, agregando encabezados de subpedidos y articulos a cada subpedido
    console.log('Separar filas');
    console.log(json);
    for(var i=0; i<pedido.length; i++){
        for(var z=0; z<pedido[i]['items'].length; z++){
            if(pedido[i]['items'][z]['addRegalo']==0){
                ignorarRegalos.push(pedido[i]['items'][z]['itemid']);
            }
        }
    }

    pedido = [];
    for(var x=0; x<json.length; x++){
        var art = items.find(o => o.itemid === json[x]['itemID']);
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
            price: json[x]['punitario'],
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
        if(x==0){
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
        else{
            var header = pedido.find(o => o.descuento == json[x]['descuento'] && o.plazo == json[x]['plazo'] && o.marca == json[x]['marca'] && o.tipo == json[x]['tipo']);
            if(header != undefined){
                header['items'].push(item);
            }
            else{
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
    createTablePedido();
}

function getItemById(item, separa) {
    console.clear();
    var entity = document.getElementById('entity').value;
    var data = { id: item['articulo'], entity: entity };
    var cantidad = item['cantidad'];
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
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            cantItemsCargados ++;
            if(data.length>0){
                var art = items.find(o => o.itemid === data[0]['itemid']);
                var itemSeparar = {
                    itemID: data[0]['itemid'],
                    codCustomer: entity,
                    quantity: validarMultiplo(data[0]['multiploVenta'], cantidad),
                    punitario: data[0]['price'],
                    multiplo: data[0]['multiploVenta'] != null ? data[0]['multiploVenta'] : 1,
                    regalo: 0,
                    existencia: art['disponible']
                };
    
                // alert('CORRIENDO SEPARAR PEDIDO\nITEMS POR CARGAR: '+cantItemsPorCargar+"\nITEMS CARGADOS: "+cantItemsCargados+"\nCODIGO ARTICULO: "+item['articulo']);
                
                if(cantItemsCargados == cantItemsPorCargar){
                    jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ']';
                    separarPedidosPromo(jsonItemsSeparar, separa);
                    cantItemsCargados = 0;
                    cantItemsPorCargar = 0;
                }
                else{
                    jsonItemsSeparar = jsonItemsSeparar + JSON.stringify(itemSeparar) + ',';
                }
            }
            if(data.length==0 && cantItemsCargados == cantItemsPorCargar){
                    var newJson = jsonItemsSeparar.substring(0, jsonItemsSeparar.length - 1);
                    newJson = newJson + ']';
                    jsonItemsSeparar = newJson;
                    separarPedidosPromo(newJson, separa);
                    cantItemsCargados = 0;
                    cantItemsPorCargar = 0;
            }
            
            // addRowPedido(item, cantidad);
        },
        error: function(error) {
            // alert('error');
        }
    });
}


function getItems(entity) {
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
		'timeout': 2*60*60*1000,
		success: function(data){
				promocionesCliente = data;
		}, 
		error: function(error){
		 }
	});
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "nuevo/getItems/all",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
		'enctype': 'multipart/form-data',
		'timeout': 2*60*60*1000,
		success: function(data){
				items = data;
		}, 
		error: function(error){
		 }
	});
}

function noDisponible(img) {
    img.src = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
    // console.clear();
}

function cargarInventario() {
    // var dataset = {"data":items};
    var empty = document.getElementById('empty').value;

    if (empty == "yes") { //si la tabla está vacía, inicializarla

        document.getElementById('empty').value = 'No';
        var dataset = [];

        for (var x = 0; x < items.length; x++) {
            var arr = [];
            // arr.push("<img src='/assets/customers/img/jpg/imagen_no_disponible.jpg' height='auto' width='100px'/>");

            var precio = (items[x]['price']).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            var precioIVA = ((items[x]['price']*((100-4)/100)*1.16)).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            var existenciaFormat = (parseFloat(items[x]['disponible'])).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });
        
            existenciaFormat = existenciaFormat.slice(1, -1);
            existenciaFormat = existenciaFormat.split('.')[0];

            var notFound = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
            //arr.push("<img src='/assets/articulos/img/01_JPG_CH/" + items[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_CH.jpg' onerror='noDisponible(this)' height='auto' class='img-item'/><img src='/assets/articulos/img/LOGOTIPOS/" + items[x]['familia'].replaceAll(" ", "_").replaceAll("-", "_") + ".jpg' height='auto' class='img-item'/>");
            arr.push("<img src='/assets/customers/img/jpg/imagen_no_disponible.jpg' onerror='noDisponible(this)' height='auto' class='img-item'/><img src='/assets/customers/img/jpg/imagen_no_disponible.jpg' height='auto' class='img-item'/>");
            arr.push(items[x]['categoriaItem']);
            arr.push(items[x]['clavefabricante']);
            arr.push(items[x]['familia']);
            arr.push(items[x]['itemid']);
            arr.push(items[x]['purchasedescription']);
            
            var detalles = "";
            detalles = detalles + "<p class='detalles-item detalles-green'>Existencia: <span class='detalles-item-right'>"+existenciaFormat+"</span></p>";
            detalles = detalles + "<p class='detalles-item'>Min. compra: <span class='detalles-item-right'>"+items[x]['minVenta']+"</span></p>";
            detalles = detalles + "<p class='detalles-item'>Cant. en empaque: <span class='detalles-item-right'>"+items[x]['inner']+"</span></p>";
            detalles = detalles + "<p class='detalles-item'>Cant. master: <span class='detalles-item-right'>"+items[x]['master']+"</span></p>";
            detalles = detalles + "<p class='detalles-item'>Múltiplo: <span class='detalles-item-right'>"+items[x]['multiploVenta']+"</span></p>";
            detalles = detalles + "<p class='detalles-item'>Unidad: <span class='detalles-item-right'>"+items[x]['unidad']+"</span></p>";
            detalles = detalles + "<p class='detalles-item'>Clasificación: <span class='detalles-item-right'>"+items[x]['clasificacionArt']+"</span></p>";

            arr.push(detalles);
            arr.push("<input type='number' value=" + items[x]['multiploVenta'] + "><div class='input-group mt-2'><input type='text' class='form-control input-descuento' id='descuentoInventario' name='descuentoInventario' value='4' onkeyup='updatePrecioIVA(this,\"" + items[x]['itemid'] + "\", \""+items[x]['price']+"\")'><div class='input-group-append append-inventario text-center'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div>")
            arr.push("<p class='text-inventario'><strong>"+precio + " + IVA </strong></p><p class='text-inventario' id='precioIVA-"+items[x]['itemid']+"'><strong>"+precioIVA+"</strong> <br> P. Pago IVA incluído</p>");
            if(items[x]['promoART'] == null){
                arr.push("<p>Sin promoción</p>");
            }
            else{
                var promociones = "";
                for(var y=0; y < items[x]['promoART'].length; y++){
                    if(items[x]['promoART'][y]['cantidad'] == 1)
                        var temp = "<p class='text-promo'>Compra "+items[x]['promoART'][y]['cantidad']+" pieza y obtén el <span class='text-red'> "+items[x]['promoART'][y]['descuento']+"% de descuento</span></p>";
                    else
                        var temp = "<p class='text-promo'>Compra "+items[x]['promoART'][y]['cantidad']+" piezas y obtén el <span class='text-red'> "+items[x]['promoART'][y]['descuento']+"% de descuento</span></p>";
                    promociones = promociones + temp;
                }
                arr.push(promociones)
            }
            arr.push("<div class='table-actions'><i class='fas fa-plus-square btn-add-product fa-2x'></i></div>");

            dataset.push(arr);
        }
        
        var inventarioTable = $("#tablaInventario").DataTable({
            data: dataset,
            autoWidth: false, // might need this
            // scrollY: '70vh',
            scrollCollapse: true,
            pageLength : 5,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
            "initComplete": function (settings, json) {  
                $("#tablaInventario").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
            'columnDefs': [
                {
                    "targets": 1, // your case first column
                    "className": "td-center",
               },
               {
                    "targets": 2,
                    "className": "td-center",
               },
               {
                    "targets": 3,
                    "className": "td-center",
               },
               {
                    "targets": 4,
                    "className": "td-center",
               }
             ]
        });
    }

}

function createTablePedido(){
    var table = document.getElementById('tablaPedido');
    var filas = table.rows.length - 1;
    
    while(filas > 1){
        table.deleteRow(filas);
        filas --;
    } 

    var subtotalPedido = 0;
    var ivaPedido;
    var totalPedido;

    var fila = 1;
    for(var x = 0; x < pedido.length; x++){
        var subtotal = 0;
        for(var y = 0; y < pedido[x]['items'].length; y++){
            var cantidad = validarMultiplo(pedido[x]['items'][y]['multiploVenta'], pedido[x]['items'][y]['cantidad']);
            var pUnitario = ((100 - parseFloat(pedido[x]['items'][y]['promo'])) * parseFloat(pedido[x]['items'][y]['price']) / 100).toFixed(2);
            var importe = (cantidad * pUnitario).toFixed(2);
            subtotal += parseFloat(importe);
        }
        subtotalPedido = subtotalPedido + subtotal;
        if(pedido[x]['regalo']==0){
            addHeaderPedido(pedido[x]['descuento'], pedido[x]['plazo'], pedido[x]['tipo'], pedido[x]['evento'], subtotal);
        }
        for(var y = 0; y < pedido[x]['items'].length; y++){
            if(pedido[x]['items'][y]['regalo'] == 0){
                addRowPedido(pedido[x]['items'][y], fila, x);
            }
            else if(pedido[x]['items'][y]['addRegalo'] == 1){
                addRowRegalo(pedido[x]['items'][y], fila, x);
            }
            
            fila ++;
        }
    }

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
    for(var x = 0; x < table.rows.length; x++){
       if(table.rows[x].cells[1].innerText.indexOf(itemToFocus) >=0){
            indexFocus.push(x);
       }
    }

    if(indexFocus.length > 1){
        intervalVar =  setInterval(function(){
            for(var x = 0; x < indexFocus.length; x++){
                table.rows[indexFocus[x]].classList.toggle('focusRow');
            }
        }, 500);         
    }

    setTimeout(function( ) { 
        clearInterval( intervalVar ); 
        for(var x = 0; x < indexFocus.length; x++){
            table.rows[indexFocus[x]].classList.remove('focusRow');
        }
        indexFocus = [];
        itemToFocus = 'XXXXXXX';
    }, 3000);


    if(filas == 1){
        document.getElementById('messageAddProducts').classList.remove('d-none');
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

    var cantidad = validarMultiplo(item['multiploVenta'], item['cantidad']);
    var pUnitario = ((100 - parseFloat(item['promo'])) * parseFloat(item['price']) / 100).toFixed(2);
    var importe = (cantidad * pUnitario).toFixed(2);

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
    

    cell1.innerHTML = "<h4>" + fila + "</h4>";
    if (item["categoriaItem"] == "LINEA" && item['desneg'] == 0)
        cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'><select id='desneg' name='desneg' class='select-descuento' onchange='applyDesneg(\"" + item['itemid'] + "\",this, "+indexPedido+")'><option selected value=''>Descuento</option><option value='desneg'>DesNeg</option><option value='desgar'>DesGar</option></select></div><div><div class='row d-none' id='row-descuento-detalles-"+item['itemid']+"-"+indexPedido+"'><div class='col-6 mt-2'><div class='input-group'><input type='number' class='form-control input-descuento' id='cantDesneg-"+item['itemid']+"-"+indexPedido+"' name='cantDesneg'><div class='input-group-append text-center append-inventario'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div></div><div class='col-6 mt-2'><select id='autoriza-desneg-"+item['itemid']+"-"+indexPedido+"' name='autoriza-desneg-"+item['itemid']+"-"+indexPedido+"' class='select-descuento' onchange='updatePedidoDesneg(\"" + item['itemid'] + "\",this, "+indexPedido+")'><option selected value=''>Autoriza</option><option value='JMGA'>JMGA</option><option value='EOEGA'>EOEGA</option><option value='JSB'>JSB</option></select></div></div>";
    
    else if (item["categoriaItem"] == "LINEA" && item['desneg'] != 0)
        cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'><select id='desneg' name='desneg' class='select-descuento' onchange='applyDesneg(\"" + item['itemid'] + "\",this, "+indexPedido+")'><option value=''>Descuento</option><option selected value='desneg'>DesNeg</option><option value='desgar'>DesGar</option></select></div><div><div class='row' id='row-descuento-detalles-"+item['itemid']+"-"+indexPedido+"'><div class='col-6 mt-2'><div class='input-group'><input type='number' class='form-control input-descuento' id='cantDesneg-"+item['itemid']+"-"+indexPedido+"' name='cantDesneg' value='"+item['desneg']+"'><div class='input-group-append text-center append-inventario'><button id='percent-desneg' class='input-group-text' name='percent-desneg'>%</button></div></div></div><div class='col-6 mt-2'><select id='autoriza-desneg-"+item['itemid']+"-"+indexPedido+"' name='autoriza-desneg-"+item['itemid']+"-"+indexPedido+"' class='select-descuento' onchange='updatePedidoDesneg(\"" + item['itemid'] + "\",this, "+indexPedido+")'><option selected value=''>Autoriza</option><option value='JMGA'>JMGA</option><option value='EOEGA'>EOEGA</option><option value='JSB'>JSB</option></select></div></div>";
    
    else 
        cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div></div>";

    cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos' onClick='decreaseItemCant(\"" + item['itemid'] + "\", "+item['multiploVenta']+","+indexPedido+")'>-</button></div><input type='number' aria-label='cantidad' id='cant-"+item['itemid']+"-"+indexPedido+"' name='cantidad' class='form-control input-cantidad' value='" + cantidad + "'  min='" + item['multiploVenta'] + "' readonly='readonly'><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas' onClick='addItemCant(\"" + item['itemid'] + "\", "+item['multiploVenta']+","+indexPedido+")'>+</button></div></div>";

    if (item["categoriaItem"] == "CADUCADO" || item["categoriaItem"] == "S/PEDIDO" || item["categoriaItem"] == 'NO RESURTIBLE' || item["categoriaItem"] == 'OUTLET' )
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-pedido'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> Existencia: <span id='existencia'>" + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";
    else
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-linea'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> Existencia: <span id='existencia'>" + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";

    cell5.innerHTML = "<h5 id='precioLista'>" + price + "</h5>";
    cell6.innerHTML = "<h5 id='promo'>" + item["promo"] + "%</h5>";
    cell7.innerHTML = "<h5 id='precioUnitario'>" + unitario + "</h5>";
    cell8.innerHTML = "<h5 id='importe-"+item["itemid"]+"-"+indexPedido+"'>" + imp + "</h5>";
    cell9.innerHTML = "<i class='fas fa-minus-square fa-2x fa-delete' onclick='deleteRowPedido(this, \"" + item['itemid'] + "\", "+indexPedido+", "+cantidad+", \"" + 'item' + "\")'></i>";

    cell1.classList.add('td-center');
    cell2.classList.add('td-center');
    cell3.classList.add('td-center');
    cell4.classList.add('td-center');
    cell5.classList.add('td-center');
    cell6.classList.add('td-center');
    cell7.classList.add('td-center');
    cell8.classList.add('td-center');
    cell9.classList.add('td-center');

    if(item['desneg'] != 0)
        document.getElementById("autoriza-desneg-"+item['itemid']+"-"+indexPedido).value = item['autorizaDesneg'];

}

function addHeaderPedido(descuento, plazo, tipo, evento, subtotal){
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

    cell1.innerHTML = "<th></th>";
    cell2.innerHTML = "<th></th>";
    cell3.innerHTML = "<th></th>";
    cell4.innerHTML = "<th>Descuento: "+descuento+"% Plazo: "+plazo+" Tipo: "+tipo+" SUBTOTAL: "+sub+" Evento: "+evento+"</th>";
    cell5.innerHTML = "<th></th>";
    cell6.innerHTML = "<th></th>";
    cell7.innerHTML = "<th></th>";
    cell8.innerHTML = "<th></th>";
    cell9.innerHTML = "<th></th>";

    if(tipo == 'BO'){
        cell1.classList.add('bg-bo');
        cell2.classList.add('bg-bo');
        cell3.classList.add('bg-bo');
        cell4.classList.add('bg-bo');
        cell5.classList.add('bg-bo');
        cell6.classList.add('bg-bo');
        cell7.classList.add('bg-bo');
        cell8.classList.add('bg-bo');
        cell9.classList.add('bg-bo');
    
    }
    else{
        cell1.classList.add('bg-blue');
        cell2.classList.add('bg-blue');
        cell3.classList.add('bg-blue');
        cell4.classList.add('bg-blue');
        cell5.classList.add('bg-blue');
        cell6.classList.add('bg-blue');
        cell7.classList.add('bg-blue');
        cell8.classList.add('bg-blue');
        cell9.classList.add('bg-blue');
    
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

    var cantidad = validarMultiplo(item['multiploVenta'], item['cantidad']);
    var pUnitario = ((100 - parseFloat(item['promo'])) * parseFloat(item['price']) / 100).toFixed(2);
    var importe = (cantidad * pUnitario).toFixed(2);

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

    cell1.innerHTML = "<h4>" + fila + "</h4>";
    cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div></div>";
    cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos'>-</button></div><input type='number' aria-label='cantidad' id='cant-"+item['itemid']+"-"+indexPedido+"' name='cantidad' class='form-control input-cantidad' value='" + cantidad + "'  min='" + item['multiploVenta'] + "' readonly='readonly'><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas'>+</button></div></div>";

    if (item["categoriaItem"] == "CADUCADO" || item["categoriaItem"] == "S/PEDIDO" || item["categoriaItem"] == 'NO RESURTIBLE' || item["categoriaItem"] == 'OUTLET' )
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-pedido'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> Existencia: <span id='existencia'>" + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";
    else
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-linea'>" + item["categoriaItem"] + "</span> Unidad: <span id='unidad'>" + item["unidad"] + "</span> Existencia: <span id='existencia'>" + existenciaFormat + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";

    cell5.innerHTML = "<h5 id='precioLista'>" + price + "</h5>";
    cell6.innerHTML = "<h5 id='promo'>0%</h5>";
    cell7.innerHTML = "<h5 id='precioUnitario'>" + unitario + "</h5>";
    cell8.innerHTML = "<h5 id='importe-"+item["itemid"]+"-"+indexPedido+"'>" + imp + "</h5>";
    cell9.innerHTML = "<a><i class='fas fa-gift fa-2x'></i></a><a><i class='fas fa-minus-square fa-delete-gift fa-2x' onclick='deleteRowPedido(this, \"" + item['itemid'] + "\", "+indexPedido+", "+cantidad+", \"" + 'regalo' + "\")'></i></a>";

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

function addItemCant(item, cant, index) {
    var table = document.getElementById('tablaPedido');
    for(var x = 0; x < table.rows.length; x++){
        if(table.rows[x].cells[1].innerText.indexOf(item) >=0){
             table.rows[x].classList.add('fadeOut');
        }
     }
    itemToFocus = item;
    document.getElementById('cant-'+item+"-"+index).stepUp(cant);
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
    var cantidad = pedido[index]['items'][indexItem]['cantidad'];
    var multiploVenta = pedido[index]['items'][indexItem]['multiploVenta'];
    var price = pedido[index]['items'][indexItem]['price'];
    var promo = pedido[index]['items'][indexItem]['promo'];
    var pUnitario = ((100 - parseFloat(promo)) * parseFloat(price) / 100).toFixed(2);
    var importe = ((cantidad + multiploVenta) * pUnitario).toFixed(2);
    var imp = (parseFloat(importe)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });
    pedido[index]['items'][indexItem]['cantidad'] = cantidad + multiploVenta;
    
    
    var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
    selectedItemsFromInventory[indexInventory]['cant'] = parseInt(selectedItemsFromInventory[indexInventory]['cant']) + multiploVenta;
    var jsonObj = JSON.parse(jsonItemsSeparar);
    var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
    jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) + multiploVenta).toString(); 
    jsonItemsSeparar = JSON.stringify(jsonObj);
    separarPedidosPromo(jsonItemsSeparar, false);
}

function decreaseItemCant(item, cant, index) {
    itemToFocus = item;
    document.getElementById('cant-'+item+"-"+index).stepDown(cant);
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
    var cantidad = pedido[index]['items'][indexItem]['cantidad'];
    var multiploVenta = pedido[index]['items'][indexItem]['multiploVenta'];
    var price = pedido[index]['items'][indexItem]['price'];
    var promo = pedido[index]['items'][indexItem]['promo'];
    var pUnitario = ((100 - parseFloat(promo)) * parseFloat(price) / 100).toFixed(2);
    var importe = ((cantidad - multiploVenta) * pUnitario).toFixed(2);
    var imp = (parseFloat(importe)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });
        var table = document.getElementById('tablaPedido');
        for(var x = 0; x < table.rows.length; x++){
            if(table.rows[x].cells[1].innerText.indexOf(item) >=0){
                 table.rows[x].classList.add('fadeOut');
            }
        }
        pedido[index]['items'][indexItem]['cantidad'] = cantidad - multiploVenta;
        
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = cantidad - multiploVenta;
        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) - multiploVenta).toString(); 
        jsonItemsSeparar = JSON.stringify(jsonObj);
        separarPedidosPromo(jsonItemsSeparar, false);
}



function triggerInputFile() {
    document.getElementById('excelCodes').click();
}

function pedidosAnteriores() {
    window.open("/pedidosAnteriores/" + document.getElementById('entity').value, '_blank');
}

function downloadPlantillaPedido(){
    window.location.href = '/downloadTemplatePedido';
}

// FUNCIÓN GUARDAR PEDIDO WEB
function save(type){ //TYPE: 1 = GUARDAR PEDIDO NUEVO, 2 = GUARDAR EDITADO (UPDATE), 3 = LEVANTAR PEDIDO (SAVE AND SEND TO NETSUITE), 4 = ACTUALIZAR Y LEVANTAR PEDIDO
    if(pedido.length == 0){
        alert('Agrega artículos al pedido');
    }
    else{
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
            idSucursal = info[0]['addresses'][indexAddress]["addressID"];
            shippingWay = info[0]['shippingWays'][indexAddress];
            packageDelivery = info[0]['packageDeliveries'][indexAddress];
        }
        else{
            idCustomer = entityCte;
            idSucursal = info[indexCustomer]['addresses'][indexAddress]["addressID"];
            shippingWay = info[indexCustomer]['shippingWays'][indexAddress];
            packageDelivery = info[indexCustomer]['packageDeliveries'][indexAddress];
        }

        var indexCustomerInfo = info.findIndex(o => o.companyId.toUpperCase() === idCustomer.toUpperCase());
        var internalId = info[indexCustomerInfo]['internalID'];
        var listaPrecio = info[indexCustomerInfo]['priceList'];
    
        // dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
        dividir2000 = 0;
        cteRecoge = document.getElementById("cliente_recoge").checked ? 1 : 0;
        correo = document.getElementById("correo").value;
        ordenCompra = document.getElementById("ordenCompra").value;
        comentarios = document.getElementById("comments").value;


        pedidoJson = [];
        var itemsJson = [];

        for(var x = 0; x < pedido.length; x++){
            var descuento = pedido[x]['descuento'];
            var plazo = pedido[x]['plazo'];
            var marca = pedido[x]['marca'];
            var tipo = pedido[x]['tipo'];
            var evento = pedido[x]['evento'];

            for(var y = 0; y < pedido[x]['items'].length; y++){
                if(pedido[x]['items'][y]['cantidad'] > pedido[x]['items'][y]['disponible'] && pedido[x]['tipo'] != 'BO'){
                    prepareJsonSeparaPedidos(false);
                    alert('El pedido se modificará, debido a que un artículo pasó a Back Order. Favor de revisarlo y guardar / enviar nuevamente.');
                    update = true;
                }
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
            var items = itemsJson;
            var temp = {
                descuento: descuento,
                plazo: plazo,
                marca: marca,
                tipo: tipo,
                evento: evento,
                listPrice: listaPrecio,
                idWeb: (x+1).toString(),
                items: items,
            };
            pedidoJson.push(temp); 
            itemsJson = [];
        }
    
        var json = {
            idCotizacion: type == 2 || type == 4 ? document.getElementById('idCotizacion').value : 0,
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
            enviado: type == 3 || type == 4 ? 1: 0, //solo es 1 si se envia a netsuite (levantar pedido)
            type: type,
        };


        if(!update){ // No hubo modificaciones y puede guardarse el pedido
            

            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "storePedido",
                'type': 'POST',
                'dataType': 'json',
                'data': json,
                'enctype': 'multipart/form-data',
                'timeout': 2*60*60*1000,
                success: function(data){
                        if(type == 3){
                            noCotizacionNS = data['idCotizacion']; //el pedido se acaba de ingresar, necesito el número de cotización que me retorna
                            saveNS();
                        }
                        else if (type == 4){ //se está editando el pedido, ya tengo el numero de cotización en el html 
                            noCotizacionNS = document.getElementById('idCotizacion').value;
                            saveNS();
                        }
                        else{
                            window.location.href = '/pedidos';
                        }
                }, 
                error: function(error){
                        window.location.href = '/pedidos';
                 }
            });
        }
    }    
}


function applyDesneg(itemid, select, index){
    tipoDesc = select.value;
    if(select.value == ''){
        document.getElementById('row-descuento-detalles-'+itemid+'-'+index).classList.add('d-none');
    }
    if(select.value == 'desneg'){
        document.getElementById('row-descuento-detalles-'+itemid+'-'+index).classList.remove('d-none');
    }
    if(select.value == 'desgar'){
        document.getElementById('row-descuento-detalles-'+itemid+'-'+index).classList.remove('d-none');
    }
}

function updatePedidoDesneg(itemid, select, index){
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === itemid);
    var newDesc;
    var item;
    if(tipoDesc == 'desneg'){
        var desneg = parseInt(document.getElementById('cantDesneg-'+itemid+'-'+index).value) + pedido[index]['descuento'];
        newDesc = desneg;
        var autorizaDesneg = select.value;
        item = pedido[index]['items'][indexItem];
        item['desneg'] = parseInt(document.getElementById('cantDesneg-'+itemid+'-'+index).value);
        item['autorizaDesneg'] = autorizaDesneg;
    }
    if(tipoDesc == 'desgar'){
        var desgar = parseInt(document.getElementById('cantDesneg-'+itemid+'-'+index).value) + pedido[index]['descuento'];
        newDesc = desgar;
        var autorizaDesgar = select.value;
        item = pedido[index]['items'][indexItem];
        item['desgar'] = parseInt(document.getElementById('cantDesneg-'+itemid+'-'+index).value);
        item['autorizaDesgar'] = autorizaDesgar;
    }
    
    pedido[index]['items'].splice(indexItem, 1);
    if(pedido[index]['items'].length == 0){
        pedido.splice(index, 1);
        var rowPedido = {
            descuento: newDesc,
            plazo: pedido[index]['plazo'],
            marca: pedido[index]['marca'],
            tipo: pedido[index]['tipo'],
            regalo: pedido[index]['regalo'],
            items: []
        };
        rowPedido['items'].push(item);
    
        pedido.splice(index, 0, rowPedido);
    }
    else{
        var rowPedido = {
            descuento: newDesc,
            plazo: pedido[index]['plazo'],
            marca: pedido[index]['marca'],
            tipo: pedido[index]['tipo'],
            regalo: pedido[index]['regalo'],
            items: []
        };
        rowPedido['items'].push(item);
    
        pedido.splice(index+1, 0, rowPedido);
    }
    

    createTablePedido();
}

// FUNCIÓN ENVIAR A NETSUITE

function saveNS(){

    if(pedido.length == 0){
        alert('Agrega artículos al pedido');
    }
    else{
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
            shippingWay = info[0]['shippingWays'][indexAddress];
            packageDelivery = info[0]['packageDeliveries'][indexAddress];
        }
        else{
            idCustomer = entityCte;
            idSucursal = info[indexCustomer]['addresses'][indexAddress]["addressID"];
            shippingWay = info[indexCustomer]['shippingWays'][indexAddress];
            packageDelivery = info[indexCustomer]['packageDeliveries'][indexAddress];
        }
    

        var indexCustomerInfo = info.findIndex(o => o.companyId.toUpperCase() === idCustomer.toUpperCase());
        var internalId = info[indexCustomerInfo]['internalID'];

        // dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
        dividir2000 = 0;
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

        for(var x = 0; x < pedido.length; x++){
            var descuento = pedido[x]['descuento'];
            var plazo = pedido[x]['plazo'];
            var marca = pedido[x]['marca'];
            var tipo = pedido[x]['tipo'];
            var desneg = 0;
            var desgar = 0;
            var specialAuthorization = "";
            var indexItemSeparado;
            if(pedido[x]['items'][0]['desneg'] != 0){
                indexItemSeparado = pedidoSeparado.findIndex(o => o.descuento == (pedido[x]['descuento'] - pedido[x]['items'][0]['desneg']) && o.marca == pedido[x]['marca'] && o.plazo == pedido[x]['plazo'] && o.tipo == pedido[x]['tipo']);
            }
            else if(pedido[x]['items'][0]['desgar'] != 0){
                indexItemSeparado = pedidoSeparado.findIndex(o => o.descuento == (pedido[x]['descuento'] - pedido[x]['items'][0]['desgar']) && o.marca == pedido[x]['marca'] && o.plazo == pedido[x]['plazo'] && o.tipo == pedido[x]['tipo']);
            }
            else{
                indexItemSeparado = pedidoSeparado.findIndex(o => o.descuento == (pedido[x]['descuento'] - pedido[x]['items'][0]['desneg']) && o.marca == pedido[x]['marca'] && o.plazo == pedido[x]['plazo'] && o.tipo == pedido[x]['tipo']);
            }
            
            var evento = pedidoSeparado[indexItemSeparado]['evento'];

            for(var y = 0; y < pedido[x]['items'].length; y++){
                
                var listaPrecio = info[indexCustomerInfo]['priceList'];
                

                var item = {
                    itemid: pedido[x]['items'][y]['itemid'],
                    quantity: pedido[x]['items'][y]['cantidad'],
                    listprice: pedido[x]['items'][y]['regalo'] == 0 ? listaPrecio : -1,
                };
                if(pedido[x]['items'][y]['desneg'] != 0){
                    desneg = pedido[x]['items'][y]['desneg'];
                    specialAuthorization = pedido[x]['items'][y]['autorizaDesneg'];
                }
                if(pedido[x]['items'][y]['desgar'] != 0){
                    desgar = pedido[x]['items'][y]['desgar'];
                    specialAuthorization = pedido[x]['items'][y]['autorizaDesgar'];
                }
                lineItems.push(item);
            }
            var temp = {
                internalId: 0,
                idCustomer: internalId,
                date: dd + "/" + mm + "/" + yyyy,
                location: marca == 'OUTLET' ? "36" : "1",
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
                idWeb: numCotizacion.toString() + "-" + (x+1) + "/" + pedido.length, //no tengo este dato
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
                    id: pedido[x]['tipo'] == 'BO' ? "6" : "5",
                    txt: ""
                },
                user: "USUARIO",
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
                eventSpecialDiscount: descuento - desneg, //descuento original del subpedido
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

    
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "storePedidoNS",
                'type': 'POST',
                'dataType': 'json',
                'data': {json: listNS},
                'enctype': 'multipart/form-data',
                'timeout': 2*60*60*1000,
                success: function(data){
                        // alert('success');
                        sendEmail();
                        // window.location.href = '/pedidos';
                }, 
                error: function(error){
                        alert('error');
                        sendEmail();
                        // window.location.href = '/pedidos';
                 }
            });
    }    
}

function saveAndGetIDCotizacion(){
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
                shippingWay = info[0]['shippingWays'][indexAddress];
                packageDelivery = info[0]['packageDeliveries'][indexAddress];
            }
            else{
                idCustomer = entityCte;
                idSucursal = info[indexCustomer]['addresses'][indexAddress]["addressID"];
                shippingWay = info[indexCustomer]['shippingWays'][indexAddress];
                packageDelivery = info[indexCustomer]['packageDeliveries'][indexAddress];
            }
        
            // dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
            dividir2000 = 0;
            cteRecoge = document.getElementById("cliente_recoge").checked ? 1 : 0;
            correo = document.getElementById("correo").value;
            ordenCompra = document.getElementById("ordenCompra").value;
            comentarios = document.getElementById("comments").value;

            pedidoJson = [];
            var itemsJson = [];

            for(var x = 0; x < pedido.length; x++){
                var descuento = pedido[x]['descuento'];
                var plazo = pedido[x]['plazo'];
                var marca = pedido[x]['marca'];
                var tipo = pedido[x]['tipo'];
                for(var y = 0; y < pedido[x]['items'].length; y++){
                    if(pedido[x]['items'][y]['cantidad'] > pedido[x]['items'][y]['disponible'] && pedido[x]['tipo'] != 'BO'){
                        prepareJsonSeparaPedidos(false);
                        alert('El pedido se modificará, debido a que un artículo pasó a Back Order. Favor de revisarlo y guardar / enviar nuevamente.');
                        update = true;
                    }
                    var item = {
                        id: pedido[x]['items'][y]['id'],
                        itemid: pedido[x]['items'][y]['itemid'],
                        cantidad: pedido[x]['items'][y]['cantidad'],
                    };
                    itemsJson.push(item);
                }
                var items = itemsJson;
                var temp = {
                    descuento: descuento,
                    plazo: plazo,
                    marca: marca,
                    tipo: tipo,
                    items: items,
                };
                pedidoJson.push(temp);
                itemsJson = [];
            }
    
            var json = {
                companyId: idCustomer,
                orderC: ordenCompra,
                email: correo,
                addressId: idSucursal,
                shippingWay: shippingWay,
                packageDelivery: packageDelivery,
                divide: dividir2000,
                pickUp: cteRecoge,
                order: pedidoJson,
                comments: comentarios,
                enviado: 1,
            };

            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "storePedido",
                'type': 'POST',
                'dataType': 'json',
                'data': json,
                'enctype': 'multipart/form-data',
                'timeout': 2*60*60*1000,
                success: function(data){
                        noCotizacionNS = data;
                        saveNS();
                }, 
                error: function(error){
                        // window.location.href = '/pedidos';
                 }
            });
}

function update(action){
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
            idSucursal = info[0]['addresses'][indexAddress]["addressID"];
            shippingWay = info[0]['shippingWays'][indexAddress];
            packageDelivery = info[0]['packageDeliveries'][indexAddress];
        }
        else{
            idCustomer = entityCte;
            idSucursal = info[indexCustomer]['addresses'][indexAddress]["addressID"];
            shippingWay = info[indexCustomer]['shippingWays'][indexAddress];
            packageDelivery = info[indexCustomer]['packageDeliveries'][indexAddress];
        }
    
        // dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
        dividir2000 = 0;
        cteRecoge = document.getElementById("cliente_recoge").checked ? 1 : 0;
        correo = document.getElementById("correo").value;
        ordenCompra = document.getElementById("ordenCompra").value;
        comentarios = document.getElementById("comments").value;

        pedidoJson = [];
        var itemsJson = [];

        for(var x = 0; x < pedido.length; x++){
            var descuento = pedido[x]['descuento'];
            var plazo = pedido[x]['plazo'];
            var marca = pedido[x]['marca'];
            var tipo = pedido[x]['tipo'];
            for(var y = 0; y < pedido[x]['items'].length; y++){
                if(pedido[x]['items'][y]['cantidad'] > pedido[x]['items'][y]['disponible'] && pedido[x]['tipo'] != 'BO'){
                    prepareJsonSeparaPedidos(false);
                    alert('El pedido se modificará, debido a que un artículo pasó a Back Order. Favor de revisarlo y guardar / enviar nuevamente.');
                    update = true;
                }
                var item = {
                    id: pedido[x]['items'][y]['id'],
                    itemid: pedido[x]['items'][y]['itemid'],
                    cantidad: pedido[x]['items'][y]['cantidad'],
                };
                itemsJson.push(item);
            }
            var items = itemsJson;
            var temp = {
                descuento: descuento,
                plazo: plazo,
                marca: marca,
                tipo: tipo,
                items: items,
            };
            pedidoJson.push(temp);
            itemsJson = [];
        }
    
        var json = {
            idCotizacion: document.getElementById('idCotizacion').value,
            companyId: idCustomer,
            orderC: ordenCompra,
            email: correo,
            addressId: idSucursal,
            shippingWay: shippingWay,
            packageDelivery: packageDelivery,
            divide: dividir2000,
            pickUp: cteRecoge,
            order: pedidoJson,
            comments: comentarios,
            enviado: action == 'save' ? 0 : 1, //si es un pedido editado, se actualiza y después se envía a ns
        };

        if(!update){ // No hubo modificaciones y puede guardarse el pedido
            

            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "updatePedido",
                'type': 'POST',
                'data': json,
                'enctype': 'multipart/form-data',
                'timeout': 2*60*60*1000,
                success: function(data){
                        if(action == 'save'){
                            window.location.href = '/pedidos';
                        }
                        else{
                            noCotizacionNS = document.getElementById('idCotizacion').value;
                            saveNS();
                        }
                }, 
                error: function(error){
                        alert('Error actualizando cotización');
                 }
            });
        }
}

function updatePrecioIVA(input, itemid, precio){
    var desc = input.value;
    var precioIVA = ((precio*((100-desc)/100)*1.16)).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    document.getElementById('precioIVA-'+itemid).innerHTML = "<strong>"+precioIVA+"</strong> <br> P. Pago IVA incluído";
}

function sendEmail(){
    var correo = document.getElementById("correo").value;
    var numCotizacion = noCotizacionNS;
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmail",
        'type': 'POST',
        'dataType': 'json',
        'data': {pedido: pedido, email: correo, idCotizacion: numCotizacion},
        'enctype': 'multipart/form-data',
        'timeout': 2*60*60*1000,
        success: function(data){
                alert(data['success']);
        }, 
        error: function(data){
                alert(data['error']);
         }
    });
}

function nuevaCotizacion(){
    $("#formNuevo").submit();
}

function activarEliminarModal(){
    //type indica si se quiere  borrar una cotización que ya estaba guardada o una cotización que se estaba realizando pero nunca se guardó
    $('#confirmDeleteModal').modal('show');
}

function closeModalDelete(){
    $('#confirmDeleteModal').modal('hide');
}

function eliminarCotizacion(type){
    if(type == 'nueva'){
        window.location.href = '/pedidos';
    }
    else{
        $("#formDelete").submit();
        // window.location.href = '/pedidos';
    }
}

function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}