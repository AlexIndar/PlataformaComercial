var cuotas = [];
var subreglas = [];
var packageHeader;
var idPaquete = 0;
var cuotasList = [];
var categoriasDescuentos = [];

$('document').ready(function(){
    $( "#tipoCuota" ).change(function() {
        var tipo = document.getElementById('tipoCuota').value;
        if(tipo == 'General'){
            $('#preciomin').prop('disabled', false);
            $('#preciomin').css('cursor', 'auto');
            $('#plazos').prop('disabled', false);
            $(".selectpicker[data-id='plazos']").addClass("disabled");
            $('#plazos').selectpicker('refresh');
            $('.clientesGeneral').show();
            $('.clientesCuotas').hide();
        }
        else{
            $('#preciomin').prop('disabled', true);
            $('#preciomin').css('cursor', 'not-allowed');
            $('#plazos').prop('disabled', true);
            $(".selectpicker[data-id='plazos']").removeClass("disabled");
            $('#plazos').selectpicker('refresh');
            $('.clientesGeneral').hide();
            $('.clientesCuotas').show();
        }
    });

    const fileClientesCuotas = document.getElementById('clientesCuotasFile');
	fileClientesCuotas.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addClientesCuotas(jsonObj);
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});
});
 
function activateModalRulesPackage(){
    var modal = document.getElementById('reglasModal');
    modal.style.opacity = 1;
    modal.style.zIndex = 1000;
    modal.classList.add("active-modal");
}

function addClientesCuotas(json, id){
    var jsonObj = JSON.parse(json);
    var dataset = [];
    for(var x = 0; x < jsonObj.length; x++){
        var arr = [];
        var arrCuotas = [];
        
        var cuota = 0;

        if(jsonObj[x]['Cuota'].indexOf('$') > -1)
            jsonObj[x]['Cuota'] = jsonObj[x]['Cuota'].replace('$', '');
        if(jsonObj[x]['Cuota'].indexOf(',') > -1)
            jsonObj[x]['Cuota'] = jsonObj[x]['Cuota'].replaceAll(',', '');

        cuota = parseInt(jsonObj[x]['Cuota'].trim());

        var currencyCuota = (cuota).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        arr.push(jsonObj[x]['CompanyId'].trim());
        arr.push(currencyCuota);
        arr.push(jsonObj[x]['P1'].trim());
        arr.push(jsonObj[x]['P2'].trim());
        arr.push(jsonObj[x]['P3'].trim());

        arrCuotas.push(jsonObj[x]['CompanyId'].trim());
        arrCuotas.push(cuota);
        arrCuotas.push(jsonObj[x]['P1'].trim());
        arrCuotas.push(jsonObj[x]['P2'].trim());
        arrCuotas.push(jsonObj[x]['P3'].trim());

        var cuotasObj = {
            'customer': jsonObj[x]['CompanyId'].trim(),
            'cuota': cuota,
            'p1': jsonObj[x]['P1'].trim(),
            'p2': jsonObj[x]['P2'].trim(),
            'p3': jsonObj[x]['P3'].trim(),
        };
        cuotasList.push(cuotasObj);
        cuotas.push(arrCuotas);
        dataset.push(arr);
    }
    
    var cuotasTable = $("#tablaPreviewCuotas").DataTable({
        data: dataset,
        autoWidth: false, // might need this
        // scrollY: '70vh',
        scrollCollapse: true,
        pageLength : 20,
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'Todos']],
        "initComplete": function (settings, json) {  
            $("#tablaPreviewCuotas").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
    });

    var elems = document.querySelectorAll(".confirmCuotas");
    [].forEach.call(elems, function(el) {
        el.classList.remove("d-none");
    });

    console.log(cuotasList);
}

function validarPaquete(){
    document.getElementById('div-loading').style.opacity = '0';
    console.log(startDate);

    var bodyValidations = '';
    var save = true;
    if(document.getElementById('nombrePromo').value == ''){
        save = false;
        document.getElementById('nombrePromo').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un nombre para el cupón</h5>';
    }
    else{
        document.getElementById('nombrePromo').classList.remove('invalid-input');
        document.getElementById('nombrePromo').classList.add('valid-input');
    }


    if(startDate == undefined || endDate == undefined){
        save = false;
        document.getElementById('rangoFechas').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un rango de fechas para el cupón</h5>';
    }
    else{
        document.getElementById('rangoFechas').classList.remove('invalid-input');
        document.getElementById('rangoFechas').classList.add('valid-input');
    }

    if(document.getElementById('startTime').value == ""){
        save = false;
        document.getElementById('startTime').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa una hora de inicio</h5>';
    }
    else{
        document.getElementById('startTime').classList.remove('invalid-input');
        document.getElementById('startTime').classList.add('valid-input');
    }

    if(document.getElementById('endTime').value == ""){
        save = false;
        document.getElementById('endTime').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa una hora de fin</h5>';
    }
    else{
        document.getElementById('endTime').classList.remove('invalid-input');
        document.getElementById('endTime').classList.add('valid-input');
    }

    

    if(save && !document.getElementById('btn-add-sub').classList.contains('d-none')){
        var categorias = $('#categorias').chosen().val();
        var giros = $('#giros').chosen().val();
        var clientes = $('#clientes').chosen().val();
        var proveedores = $('#proveedores').chosen().val();
        var marcas = $('#marcas').chosen().val();
        var articulos = $('#articulos').chosen().val();
    
        var regalos = $('#regalos').chosen().val();

        var startTime = startDate+" "+document.getElementById('startTime').value+":00";
        var endTime = endDate+" "+document.getElementById('endTime').value+":00";

        var listaPedidoPromoRulesD = [];

            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: '',
                valor: '',
                incluye: false,
                idPedidoPromoNavigation: ''
            });
    
        var json = {
            id: 0,
            nombrePromo: document.getElementById('nombrePromo').value,
            descuento: 0,
            descuentoWeb: 0,
            puntosIndar: document.getElementById('puntos').value == "" ? 0 : parseInt( document.getElementById('puntos').value),
            plazosIndar: document.getElementById('tipoCuota').value == 'General' ? parseInt( document.getElementById('plazos').value) : 0,
            regalosIndar: regalos.toString(),
            categoriaClientes: categorias.toString(),
            categoriaClientesIncluye: 1,
            gruposclientesIds: giros.toString(),
            gruposclientesIncluye: true,
            clientesId: clientes.toString(),
            clientesIncluye: true,
            plazo: '',
            montoMinCash: document.getElementById('tipoCuota').value == 'General' ? parseInt(document.getElementById('preciomin').value) : 0,
            montoMinQty: document.getElementById('cantidadmin').value == "" ? 0 : parseInt(document.getElementById('cantidadmin').value),
            fechaInicio: startTime,
            fechaFin: endTime,
            paquete: true,
            idPaquete: 0,
            pedidoPromoRulesD: listaPedidoPromoRulesD.length >= 1 ? listaPedidoPromoRulesD : null,
            cuotas: document.getElementById('tipoCuota').value == 'General' ? null : cuotasList,
        }

        packageHeader = json;
        console.log(JSON.stringify(packageHeader));
        
        clearModalSubreglas();

        activateModalRulesPackage();
        document.getElementById("btn-add-sub").setAttribute( "onClick", "activateModalRulesPackage()" );

    }

    if(!save){
        document.getElementById('bodyValidations').innerHTML = bodyValidations;
        var modal = document.getElementById('validateModal');
        modal.style.opacity = 1;
        modal.style.zIndex = 1000;
        modal.classList.add("active-modal");
    }

    if(save && document.getElementById('btn-add-sub').classList.contains('d-none')){
        document.getElementById('btn-add-sub').classList.remove('d-none');
        document.getElementById('btn-validar').classList.add('d-none');
    }
}

function addRule(){
    if(validarSubregla()){
        if(document.getElementById('indexSubregla').value != ''){
            updateRule();
        }
        else{
            var json = {
                nombreSub: document.getElementById('nombreSubregla').value,
                descuentoSub: document.getElementById('descuentoSubregla1').value == "" ? 0 : parseInt(document.getElementById('descuentoSubregla1').value),
                descuentoWebSub: document.getElementById('descuentoWebSubregla1').value == "" ? 0 : parseInt(document.getElementById('descuentoWebSubregla1').value),
                montoMinCash: document.getElementById('preciominSub').value == "" ? 0 : parseInt(document.getElementById('preciominSub').value),
                montoMinQty: document.getElementById('cantidadminSub').value == "" ? 0 : parseInt(document.getElementById('cantidadminSub').value),
                regalos: $('#regalosSub').chosen().val(),
                proveedores: $('#proveedores').chosen().val(),
                marcas: $('#marcas').chosen().val(),
                articulos: $('#articulos').chosen().val(),
            };
        
            subreglas.push(json);
            
            createTableSubreglas();
           
        }
        closeModalSubreglas();
    }
    
}

function validarSubregla(){
    var bodyValidations = '';
    var save = true;
    var proveedores = $('#proveedores').chosen().val();
    var marcas = $('#marcas').chosen().val();
    var articulos = $('#articulos').chosen().val();
    if(document.getElementById('nombreSubregla').value == ''){
        save = false;
        document.getElementById('nombreSubregla').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un nombre para la subregla</h5>';
    }
    else{
        document.getElementById('nombreSubregla').classList.remove('invalid-input');
    }
    if(document.getElementById('descuentoSubregla1').value == ''){
        save = false;
        document.getElementById('descuentoSubregla1').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un descuento para la subregla</h5>';
    }
    else{
        document.getElementById('descuentoSubregla1').classList.remove('invalid-input');
    }
    if(document.getElementById('descuentoWebSubregla1').value == ''){
        save = false;
        document.getElementById('descuentoWebSubregla1').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un descuento web para la subregla</h5>';
    }
    else{
        document.getElementById('descuentoWebSubregla1').classList.remove('invalid-input');
    }
    if(document.getElementById('preciominSub').value == ''){
        save = false;
        document.getElementById('preciominSub').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un importe mínimo para la subregla</h5>';
    }
    else{
        document.getElementById('preciominSub').classList.remove('invalid-input');
    }
    if(document.getElementById('cantidadminSub').value == ''){
        save = false;
        document.getElementById('cantidadminSub').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa una cantidad mínima de artículos para la subregla</h5>';
    }
    else{
        document.getElementById('cantidadminSub').classList.remove('invalid-input');
    }
    if(proveedores.length == 0 && marcas.length == 0 && articulos.length == 0){
        save = false;
        bodyValidations += '<h5>Carga proveedores, marcas y/o artículos</h5>';
    }

    if(!save){
        document.getElementById('bodyValidations').innerHTML = bodyValidations;
        var modal = document.getElementById('validateModal');
        modal.style.opacity = 1;
        modal.style.zIndex = 1000;
        modal.classList.add("active-modal");
    }
    return save;
}

function clearSelectionCuotas(){
    document.getElementById('listaDeleteCuotas').innerHTML = 'Cuotas';
    var modal = document.getElementById('deleteModalCuotas');
    modal.style.opacity = 1;
    modal.style.zIndex = 1000;
    modal.classList.add("active-modal");
}

function clearCuotas(){
    cuotas = [];
    var table = $('#tablaPreviewCuotas').DataTable();
 
    table.clear().draw();

    table.destroy();

    var elems = document.querySelectorAll(".confirmCuotas");
    [].forEach.call(elems, function(el) {
        el.classList.add("d-none");
    }); 

    $('#clientesCuotasFile').val('');

    closeModalSubreglas();
}

function editSubregla(id){
    console.log(subreglas);
    var index = id - 1;

    document.getElementById('nombreSubregla').value = subreglas[index]['nombreSub'];
    document.getElementById('descuentoSubregla1').value = subreglas[index]['descuentoSub'];
    document.getElementById('descuentoWebSubregla1').value = subreglas[index]['descuentoWebSub'];
    document.getElementById('cantidadminSub').value = subreglas[index]['montoMinQty'];
    document.getElementById('preciominSub').value = subreglas[index]['montoMinCash'];

    $('#regalosSub').val(subreglas[index]['regalos']).trigger('chosen:updated');
    $('#proveedores').val(subreglas[index]['proveedores']).trigger('chosen:updated');
    $('#marcas').val(subreglas[index]['marcas']).trigger('chosen:updated');
    $('#articulos').val(subreglas[index]['articulos']).trigger('chosen:updated');

    document.getElementById('indexSubregla').value = index.toString();

    document.getElementById('btn-guardarSub').innerHTML = '<i class="fas fa-save"></i> Guardar';

    activateModalRulesPackage();

}

function clearModalSubreglas(){
    document.getElementById('indexSubregla').value = '';
    document.getElementById('nombreSubregla').value = '';
    document.getElementById('descuentoSubregla1').value = 1;
    document.getElementById('descuentoWebSubregla1').value = 1;
    document.getElementById('cantidadminSub').value = 1;
    document.getElementById('preciominSub').value = 1;

    $('#regalosSub').val('').trigger('chosen:updated');

    $('#proveedores').val('').trigger('chosen:updated');
    $('#proveedoresFile').val('');

    $('#marcas').val('').trigger('chosen:updated');
    $('#marcasFile').val('');

    $('#articulos').val('').trigger('chosen:updated');
    $('#articulosFile').val('');

    document.getElementById('btn-guardarSub').innerHTML = '<i class="fas fa-plus"></i> Agregar';
}

function closeModalSubreglas(){
    var activeModal = document.getElementsByClassName("active-modal");
    if(activeModal.length>1)
        activeModal = activeModal[1];
    else
        activeModal = activeModal[0];
    activeModal.style.opacity = 0;
    activeModal.style.zIndex = -1000;
    activeModal.classList.remove("active-modal");
    clearModalSubreglas();
}

function updateRule(){
    var index = document.getElementById('indexSubregla').value;
    subreglas[index]['nombreSub'] = document.getElementById('nombreSubregla').value;
    subreglas[index]['descuentoSub'] = document.getElementById('descuentoSubregla1').value;
    subreglas[index]['descuentoWebSub'] = document.getElementById('descuentoWebSubregla1').value;
    subreglas[index]['montoMinCash'] = document.getElementById('preciominSub').value;
    subreglas[index]['montoMinQty'] = document.getElementById('cantidadminSub').value;
    subreglas[index]['regalos'] = $('#regalosSub').chosen().val();
    subreglas[index]['proveedores'] = $('#proveedores').chosen().val();
    subreglas[index]['marcas'] = $('#marcas').chosen().val();
    subreglas[index]['articulos'] = $('#articulos').chosen().val();
    createTableSubreglas();
}

function deleteSubregla(id){
    var index = id - 1;
    subreglas.splice(index, 1);
    if(subreglas.length<1){
        document.getElementById('subreglasTitle').classList.add('d-none');
        document.getElementById('subreglasTable').classList.add('d-none');
        document.getElementById('btn-guardar').classList.add('d-none');
    }
    else{
        createTableSubreglas();
    }
}

function createTableSubreglas(){
    var table = document.getElementById('tablaPedido');
    var filas = table.rows.length - 1;
    
    while(filas > 1){
        table.deleteRow(filas);
        filas --;
    } 

    for(var x = 0; x < subreglas.length; x++){
        var row = table.insertRow(table.rows.length);

        row.id = 'row-subreglas-'+x;
    
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);
    
        var montoFormat = (parseInt(subreglas[x]['montoMinCash'])).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
    
        cell1.innerHTML = "<h5 class='textoSubreglas'>" + (x+1) + "</h5>";
        cell2.innerHTML = "<h5 class='textoSubreglas'>" + subreglas[x]['nombreSub'] + "</h5>";
        cell3.innerHTML = "<h5 class='textoSubreglas'>" + subreglas[x]['descuentoSub'] + "%</h5>";
        cell4.innerHTML = "<h5 class='textoSubreglas'>" + subreglas[x]['descuentoWebSub'] + "%</h5>";
        cell5.innerHTML = "<h5 class='textoSubreglas'>" + montoFormat + "</h5>";
        cell6.innerHTML = "<h5 class='textoSubreglas'>" + subreglas[x]['montoMinQty'] + "</h5>";
        cell7.innerHTML = "<a class='icons-subreglas' onclick='editSubregla("+(x+1)+")'><i class='fas fa-edit fa-lg'></i></a>&nbsp;<a class='icons-subreglas' onclick='deleteSubregla("+(x+1)+")'><i class='fas fa-trash fa-lg'></i></a>&nbsp;<a class='icons-subreglas d-none' onclick='deleteSubregla("+(x+1)+")'><i class='fas fa-trash fa-lg'></i></a>";
    
        cell7.classList.add('actions-subreglas');
    
        clearModalSubreglas();
    
        if(subreglas.length == 1){
            document.getElementById('subreglasTitle').classList.remove('d-none');
            document.getElementById('subreglasTable').classList.remove('d-none');
            document.getElementById('btn-guardar').classList.remove('d-none');
        }
    }
}

function storePaquete(){
    storeHeader();
    document.getElementById('btn-guardar').classList.add('d-none');
    document.getElementById('btn-add-sub').classList.add('d-none');
    document.getElementById('div-loading').style.opacity = '1';
    setTimeout(storeSubreglas, 2000);
}

function storeSubreglas(){
    for(var y = 0; y < subreglas.length; y++){
        var listaPedidoPromoRulesD = [];

       for(var x = 0; x < subreglas[y]['proveedores'].length; x++){
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'PROVEEDOR',
                valor: subreglas[y]['proveedores'][x],
                incluye: true,
                idPedidoPromoNavigation: ''
            });
        }

        for(var x = 0; x < subreglas[y]['marcas'].length; x++){
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'MARCA',
                valor: subreglas[y]['marcas'][x],
                incluye: true,
                idPedidoPromoNavigation: ''
            });
        }

        for(var x = 0; x < subreglas[y]['articulos'].length; x++){
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'ARTICULO',
                valor: subreglas[y]['articulos'][x],
                incluye: true,
                idPedidoPromoNavigation: ''
            });
        }

        var json = {
            id: 0,
            nombrePromo: subreglas[y]['nombreSub'],
            descuento: parseInt(subreglas[y]['descuentoSub']),
            descuentoWeb: parseInt(subreglas[y]['descuentoWebSub']),
            puntosIndar: packageHeader['puntosIndar'],
            plazosIndar: packageHeader['plazosIndar'],
            regalosIndar: subreglas[y]['regalos'].toString(),
            categoriaClientes: packageHeader['categoriaClientes'],
            categoriaClientesIncluye: packageHeader['categoriaClientesIncluye'],
            gruposclientesIds: packageHeader['gruposclientesIds'],
            gruposclientesIncluye: packageHeader['gruposclientesIncluye'],
            clientesId: packageHeader['clientesId'],
            clientesIncluye: packageHeader['clientesIncluye'],
            plazo: packageHeader['plazo'],
            montoMinCash: parseInt(subreglas[y]['montoMinCash']),
            montoMinQty: parseInt(subreglas[y]['montoMinQty']),
            fechaInicio: packageHeader['fechaInicio'],
            fechaFin: packageHeader['fechaFin'],
            paquete: false,
            idPaquete: idPaquete,
            pedidoPromoRulesD: listaPedidoPromoRulesD.length >= 1 ? listaPedidoPromoRulesD : null,
        }

        console.log(json);
        console.log(JSON.stringify(json));

        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "storePromo",
            'type': 'POST',
            'dataType': 'json', 
            'data': json,
            'enctype': 'multipart/form-data',
            'timeout': 2*60*60*1000,
            success: function(data){
                    console.log(data);
                    // document.getElementById(idRow).classList.add('success-sub');
            }, 
            error: function(error){
                    console.log(data);
                    // document.getElementById(idRow).classList.add('error-sub');
             }
        });
        
    }
    setTimeout(redirectPromociones, 2000);
   
}

function redirectPromociones(){
    document.getElementById('div-loading').style.opacity = '0';
    alert('Paquete guardado correctamente');
    window.location.href = '/promociones';
}

function storeHeader(){
    var categorias = $('#categorias').chosen().val();
        var giros = $('#giros').chosen().val();
        var clientes = $('#clientes').chosen().val();
        var proveedores = $('#proveedores').chosen().val();
        var marcas = $('#marcas').chosen().val();
        var articulos = $('#articulos').chosen().val();
    
        var regalos = $('#regalos').chosen().val();

        var startTime = startDate+" "+document.getElementById('startTime').value+":00";
        var endTime = endDate+" "+document.getElementById('endTime').value+":00";

        var listaPedidoPromoRulesD = [];

            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: '',
                valor: '',
                incluye: false,
                idPedidoPromoNavigation: ''
            });
    
        var json = {
            id: 0,
            nombrePromo: document.getElementById('nombrePromo').value,
            descuento: 0,
            descuentoWeb: 0,
            puntosIndar: document.getElementById('puntos').value == "" ? 0 : parseInt( document.getElementById('puntos').value),
            plazosIndar: document.getElementById('tipoCuota').value == 'General' ? parseInt( document.getElementById('plazos').value) : 0,
            regalosIndar: regalos.toString(),
            categoriaClientes: categorias.toString(),
            categoriaClientesIncluye: 1,
            gruposclientesIds: giros.toString(),
            gruposclientesIncluye: true,
            clientesId: clientes.toString(),
            clientesIncluye: true,
            plazo: '',
            montoMinCash: document.getElementById('tipoCuota').value == 'General' ? parseInt(document.getElementById('preciomin').value) : 0,
            montoMinQty: document.getElementById('cantidadmin').value == "" ? 0 : parseInt(document.getElementById('cantidadmin').value),
            fechaInicio: startTime,
            fechaFin: endTime,
            paquete: true,
            idPaquete: 0,
            pedidoPromoRulesD: listaPedidoPromoRulesD.length >= 1 ? listaPedidoPromoRulesD : null,
            cuotas: document.getElementById('tipoCuota').value == 'General' ? null : cuotasList,
        }

        packageHeader = json;
        console.log(JSON.stringify(packageHeader));

        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "storePromo",
            'type': 'POST',
            'dataType': 'json', 
            'data': packageHeader,
            'enctype': 'multipart/form-data',
            'timeout': 2*60*60*1000,
            success: function(data){
                    idPaquete = data;
            }, 
            error: function(error){
                    console.log(data);
             }
        });
}

function addRowCategoriaDescuento(id){
    console.log('add row');
    var container = document.getElementById('descuentosPorCategoria');
    var div1 = document.createElement('div');
    var div2 = document.createElement('div');
    var div3 = document.createElement('div');
    var div4 = document.createElement('div');
    var div5 = document.createElement('div');
    var div6 = document.createElement('div');

    div1.classList.add('col-lg-3', 'col-md-3', 'col-12');

    var select = document.createElement('select');

    select.setAttribute('id','categoriaCliente'+(id+1));
    select.setAttribute('class', 'form-control');

    var opt1 = document.createElement('option');
    opt1.value = 'master';
    opt1.innerHTML = 'MASTER';

    var opt2 = document.createElement('option');
    opt2.value = 'd';
    opt2.innerHTML = 'CLIENTE D';

    var opt3 = document.createElement('option');
    opt3.value = 'a';
    opt3.innerHTML = 'CLIENTE A';

    var opt4 = document.createElement('option');
    opt4.value = 'a light';
    opt4.innerHTML = 'CLIENTE A LIGHT';

    select.appendChild(opt1);
    select.appendChild(opt2);
    select.appendChild(opt3);
    select.appendChild(opt4);

    div1.appendChild(select);

    div2.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
    var h5div2 = document.createElement('h5');
    h5div2.innerHTML = 'Descuento subregla:';
    div2.appendChild(h5div2);

    div3.setAttribute('class', 'col-lg-2 col-md-2 col-12');
    var inputdiv3 = document.createElement('input');
    inputdiv3.setAttribute('type', 'number');
    inputdiv3.setAttribute('id', 'descuentoSubregla'+(id+1));
    inputdiv3.setAttribute('class', 'input-promociones');
    inputdiv3.setAttribute('value', '1');
    inputdiv3.setAttribute('step', '.01');
    inputdiv3.setAttribute('min', '0');
    div3.appendChild(inputdiv3);

    div4.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
    var h5div4 = document.createElement('h5');
    h5div4.innerHTML = 'Descuento web:';
    div4.appendChild(h5div4);

    div5.setAttribute('class', 'col-lg-2 col-md-2 col-11');
    var inputdiv5 = document.createElement('input');
    inputdiv5.setAttribute('type', 'number');
    inputdiv5.setAttribute('id', 'descuentoWebSubregla'+(id+1));
    inputdiv5.setAttribute('class', 'input-promociones');
    inputdiv5.setAttribute('value', '1');
    inputdiv5.setAttribute('step', '.01');
    inputdiv5.setAttribute('min', '0');
    div5.appendChild(inputdiv5);

    div6.setAttribute('class', 'col-1');
    var icon = document.createElement('i');
    icon.setAttribute('class', 'fas fa-plus-square btn-add-product fa-2x');
    icon.setAttribute('id', 'iconoAgregarCategoriaDescuento'+(id+1));
    icon.setAttribute('onclick', 'addRowCategoriaDescuento('+(id+1)+')');
    div6.appendChild(icon);

    document.getElementById('iconoAgregarCategoriaDescuento'+id).classList.add('d-none');

    container.appendChild(div1);
    container.appendChild(div2);
    container.appendChild(div3);
    container.appendChild(div4);
    container.appendChild(div5);
    container.appendChild(div6);


}