var info = [];
var addresses = [];
var shippingWays = [];
var packageDeliveries = [];
var items = [];
var jsonItemsSeparar = "";
var ignorarRegalos = [];


var selectedItemsFromInventory = [];
var cantItemsPorCargar = 0;
var cantItemsCargados = 0;

var pedido = [];

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
    if (entity.startsWith("C") || entity.startsWith("E")) { //si es codigo de cliente o empleado
        getItems(entity);
    }
    else{ //si es zona o all (vendedor o apoyo)
        document.getElementById('loading-message').innerHTML = 'Selecciona un cliente para cargar inventario';
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

    var bLazy = new Blazy({
        selector: '.b-lazy',
        offset: 180, // Loads images 180px before they're visible
        success: function(element) {
            // console.log("success blazy");
            setTimeout(function() {
                var parent = element.parentNode;
                parent.className = parent.className.replace(/\bloading\b/, '');
            }, 200);
        },
        error: function(element, message) {
            // console.log(element + " - " + message);
        }
    });

    function checkItems() {
        if (items.length > 0) {
            document.getElementById('pedido').style.display = "block";
            document.getElementById('loading').style.display = "none";
            document.getElementById('loading').classList.remove('d-flex');
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
        url: "getInfoHeatWeb/" + entity,
        data: FormData,
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data) {
            info = data;
            // console.log(info);
        },
        error: function(error) {
            // console.log(error);
        }
    });

    $('#modalInventario').on('hidden.bs.modal', function () {
        prepareJsonSeparaPedidos();
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
        var cant = table.cell(index, 10).nodes().to$().find('input').val();
        if (cell_clicked == "<i class='fas fa-plus-square btn-add-product fa-2x'></i>") {
            if (item['disponible'] == 0) {
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
                    title: 'Producto ' + item['itemid'] + ' Insuficiente',
                    icon: 'error'
                });
            } else {
                selectedItemsFromInventory.push({item: item['itemid'].trim(), cant: cant});
                // addRowPedido(item, cant);
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

    // UPDATE DEFAULT SHIPPING WAT / PACKAGING WHEN ADDRESS IS CHANGED -------------------------------------------------------------------------------------

    $('#sucursal').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex - 1;
        if (info.length == 1) {
            if (clickedIndex == 0) {
                indexAddress = 0;
                $('#envio').val(info[0]['shippingWayF']);
                $('#fletera').val(info[0]['packgeDeliveryF']);
            } else {
                indexAddress = selected;
                addresses = info[0]['addresses'];
                shippingWays = info[0]['shippingWays'];
                packageDeliveries = info[0]['packageDeliveries'];
                $('#envio').val(shippingWays[selected]);
                $('#fletera').val(packageDeliveries[selected]);
            }
        } else {
            if (clickedIndex == 0) {
                indexAddress = 0;
                $('#envio').val(info[indexCustomer]['shippingWayF']);
                $('#fletera').val(info[indexCustomer]['packgeDeliveryF']);
            } else {
                indexAddress = selected;
                $('#envio').val(shippingWays[selected]);
                $('#fletera').val(packageDeliveries[selected]);
            }
        }
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
    alert(row.rowIndex);
    document.getElementById("tablaPedido").deleteRow(row.rowIndex);
    var indexItem = pedido[index]['items'].findIndex(o => o.itemid === item);
    if(pedido[index]['items'][indexItem]['regalo']==1){
        pedido[index]['items'][indexItem]['addRegalo'] = 0; 
    }
    else{
        pedido[index]['items'].splice(indexItem, 1);
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = parseInt(selectedItemsFromInventory[indexInventory]['cant']) - cantidad;
        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) - cantidad).toString(); 
        jsonItemsSeparar = JSON.stringify(jsonObj);
    }

    if(pedido[index]['items'].length == 0){
        // console.log(pedido);
        pedido.splice(index, 1);
    }
    
    separarPedidosPromo(jsonItemsSeparar);

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
        var item = { "articulo": inputCodigo.value, "cantidad": inputCantidad.value };
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

    prepareJsonSeparaPedidos();
}

function cargarProductosExcel(json) {
    jsonObj = JSON.parse(json);
    cantItemsPorCargar = jsonObj.length;
    for (var x = 0; x < jsonObj.length; x++) {
        selectedItemsFromInventory.push({ item: jsonObj[x]['Codigos'].trim(), cant: jsonObj[x]['Cantidad'] });
    }

    prepareJsonSeparaPedidos();

    document.getElementById("excelCodes").value = "";
}


function prepareJsonSeparaPedidos(){
    cantItemsPorCargar = selectedItemsFromInventory.length;
    jsonItemsSeparar = "[";
    for (var x = 0; x < selectedItemsFromInventory.length; x++) {
        var item = { "articulo": selectedItemsFromInventory[x]['item'], "cantidad": selectedItemsFromInventory[x]['cant'] };
        getItemById(item);
    }
}

function separarPedidosPromo(json){
    console.log('SEPARAR PEDIDOS PROMO');
    console.log(JSON.parse(json));
    console.log(pedido);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "SepararPedidosPromo",
        timeout: 2 * 60 * 60 * 1000,
        contentType: "application/json",
        data: JSON.stringify({key: json}),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            // console.log(data);
            separarFilas(data);
        },
        error: function(error) {}
    });
}

function separarFilas(json){
    
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
            promo: art['promo'],
            marca: json[x]['marca'],
            plazo: json[x]['plazo'],
            regalo: json[x]['regalo'],
            addRegalo: ignorarRegalos.includes(json[x]['itemID']) ? 0 : 1,
            separa: json[x]['separa'],
            disponible: art['disponible']
        };
        if(x==0){
            // addHeaderPedido(json[x]['descuento'], json[x]['plazo'], json[x]['tipo']);
            var rowPedido = {
                descuento: json[x]['descuento'],
                plazo: json[x]['plazo'],
                marca: json[x]['marca'],
                tipo: json[x]['tipo'],
                regalo: json[x]['regalo'],
                items: []
            };
            rowPedido['items'].push(item);
            pedido.push(rowPedido);
        }
        else{
            var header = pedido.find(o => o.descuento === json[x]['descuento'] && o.plazo === json[x]['plazo'] && o.marca === json[x]['marca'] && o.tipo === json[x]['tipo'] && o.regalo === json[x]['regalo']);
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
                    items: []
                };
                rowPedido['items'].push(item);
                pedido.push(rowPedido);
            }
        }
    }
    createTablePedido();
}

function getItemById(item) {
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
        url: "getItemByID",
        timeout: 2 * 60 * 60 * 1000,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            // console.log(data);
            cantItemsCargados ++;
            if(data.length>0){
                var art = items.find(o => o.itemid === data[0]['itemid']);
                // console.log(data);
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
                    separarPedidosPromo(jsonItemsSeparar);
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
                    // console.log(newJson);
                    separarPedidosPromo(newJson);
                    cantItemsCargados = 0;
                    cantItemsPorCargar = 0;
            }
            
            // addRowPedido(item, cantidad);
        },
        error: function(error) {}
    });
}


function getItems(entity) {
    let data = { entity: entity };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "getItems/all",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
		'enctype': 'multipart/form-data',
		'timeout': 2*60*60*1000,
		success: function(data){
				items = data;
		}, 
		error: function(error){
			//   console.log(error);
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
            var notFound = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
            arr.push("<img src='/assets/articulos/img/01_JPG_CH/" + items[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_CH.jpg' onerror='noDisponible(this)' height='auto' width='80px'/><img src='/assets/articulos/img/LOGOTIPOS/" + items[x]['familia'].replaceAll(" ", "_").replaceAll("-", "_") + ".jpg' height='auto' width='80px'/>");
            arr.push(items[x]['categoriaItem']);
            arr.push(items[x]['clavefabricante']);
            arr.push(items[x]['familia']);
            arr.push(items[x]['grupoArticulo']);
            arr.push(items[x]['tipoArticulo']);
            arr.push(items[x]['id']);
            arr.push(items[x]['itemid']);
            arr.push(items[x]['purchasedescription']);
            arr.push(items[x]['multiploVenta']);
            arr.push("<input type='number' value=" + items[x]['multiploVenta'] + ">")
            arr.push(items[x]['price']);
            arr.push(items[x]['unidad']);
            arr.push(items[x]['promo']);
            arr.push(items[x]['disponible']);
            arr.push("<i class='fas fa-plus-square btn-add-product fa-2x'></i>");

            dataset.push(arr);
        }
        


        $("#tablaInventario").dataTable({
            data: dataset,
            autoWidth: false, // might need this
            scrollCollapse: true,
            columns: [
                { "width": "20%" },
                null, // automatically calculates
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ],
            "initComplete": function (settings, json) {  
                $("#tablaInventario").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
              },
        });

        document.getElementById('tablaInventario').columns.adjust().draw();


    }

}

function createTablePedido(){
    console.log(pedido);
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
            addHeaderPedido(pedido[x]['descuento'], pedido[x]['plazo'], pedido[x]['tipo'], subtotal);
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

    cell1.innerHTML = "<h4>" + fila + "</h4>";
    cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'>Unidad: <span id='unidad'>" + item["unidad"] + "</span> </div></div>";
    cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos' onClick='decreaseItemCant(\"" + item['itemid'] + "\", "+item['multiploVenta']+","+indexPedido+")'>-</button></div><input type='number' aria-label='cantidad' id='cant-"+item['itemid']+"-"+indexPedido+"' name='cantidad' class='form-control input-cantidad' value='" + cantidad + "'  min='" + item['multiploVenta'] + "' readonly='readonly'><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas' onClick='addItemCant(\"" + item['itemid'] + "\", "+item['multiploVenta']+","+indexPedido+")'>+</button></div></div>";

    if (item["categoriaItem"] == "CADUCADO" || item["categoriaItem"] == "S/PEDIDO")
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-pedido'>" + item["categoriaItem"] + "</span> Existencia: <span id='existencia'>" + item["disponible"] + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";
    else
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-linea'>" + item["categoriaItem"] + "</span> Existencia: <span id='existencia'>" + item["disponible"] + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";

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

}

function addHeaderPedido(descuento, plazo, tipo, subtotal){
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
    cell4.innerHTML = "<th>Descuento: "+descuento+"% Plazo: "+plazo+" Tipo: "+tipo+" SUBTOTAL: "+sub+"</th>";
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

    cell1.innerHTML = "<h4>" + fila + "</h4>";
    cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>" + item["itemid"] + "</h4></div><div class='col-12'>Unidad: <span id='unidad'>" + item["unidad"] + "</span> </div></div>";
    cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos'>-</button></div><input type='number' aria-label='cantidad' id='cant-"+item['itemid']+"-"+indexPedido+"' name='cantidad' class='form-control input-cantidad' value='" + cantidad + "'  min='" + item['multiploVenta'] + "' readonly='readonly'><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas'>+</button></div></div>";

    if (item["categoriaItem"] == "CADUCADO" || item["categoriaItem"] == "S/PEDIDO")
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-pedido'>" + item["categoriaItem"] + "</span> Existencia: <span id='existencia'>" + item["disponible"] + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";
    else
        cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>" + item["purchasedescription"] + "</h5></div><div class='col-12'>Categoría: <span id='categoria-linea'>" + item["categoriaItem"] + "</span> Existencia: <span id='existencia'>" + item["disponible"] + "</span> Múltiplo: <span id='multiplo'>" + item["multiploVenta"] + "</span></div></div>";

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
    console.log(selectedItemsFromInventory);
    console.log(item);
    var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
    console.log(indexInventory);
    selectedItemsFromInventory[indexInventory]['cant'] = parseInt(selectedItemsFromInventory[indexInventory]['cant']) + multiploVenta;
    var jsonObj = JSON.parse(jsonItemsSeparar);
    var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
    jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) + multiploVenta).toString(); 
    jsonItemsSeparar = JSON.stringify(jsonObj);
    separarPedidosPromo(jsonItemsSeparar);
}

function decreaseItemCant(item, cant, index) {
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
    if(cantidad - multiploVenta >= multiploVenta){
        pedido[index]['items'][indexItem]['cantidad'] = cantidad - multiploVenta;
        
        var indexInventory = selectedItemsFromInventory.findIndex(o => o.item === item);
        selectedItemsFromInventory[indexInventory]['cant'] = cantidad - multiploVenta;
        var jsonObj = JSON.parse(jsonItemsSeparar);
        var indexjsonObj = jsonObj.findIndex(o => o.itemID === item);
        jsonObj[indexjsonObj]['quantity'] = (parseInt(jsonObj[indexjsonObj]['quantity']) - multiploVenta).toString(); 
        jsonItemsSeparar = JSON.stringify(jsonObj);
        separarPedidosPromo(jsonItemsSeparar);
    }            
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

function save(){
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
    
        if (!entity.startsWith("Z")) {
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
    
        dividir2000 = document.getElementById("dividir").checked ? 1 : 0;
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
                    prepareJsonSeparaPedidos();
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
        };

        if(!update){ // No hubo modificaciones y puede guardarse el pedido
            console.log(JSON.stringify(json));
            alert('Guardar Pedido');
        }
    }    
}