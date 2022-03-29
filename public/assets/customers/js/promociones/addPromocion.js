var startDate;
var endDate;
var reglas = [];
$('document').ready(function(){

    // $('.modal-background').click(function() {
    //     closeModal();
    // });


    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/promociones/getPromocionesInfo",
        'type': 'GET',
		'enctype': 'multipart/form-data',
		'timeout': 2*60*60*1000,
		success: function(data){
				reglas = data;
		}, 
		error: function(error){
		 }
	});

    intervalRules = window.setInterval(checkRules, 1000);

    $(".chosen").chosen({
        no_results_text: "Sin resultados para",
        placeholder_text_single: "Buscar",
        placeholder_text_multiple: "Seleccione una o más opciones"
    });
 
    

    const fileArticulos = document.getElementById('articulosFile');
	fileArticulos.addEventListener('change', (event) => {
		var input = event.target; 
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, 'articulos');
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});

    const fileCategorias = document.getElementById('categoriasFile');
	fileCategorias.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, 'categorias');
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});

    const fileGiros = document.getElementById('girosFile');
	fileGiros.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, 'giros');
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});

    const fileClientes = document.getElementById('clientesFile');
	fileClientes.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, 'clientes');
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});

    const fileProveedores = document.getElementById('proveedoresFile');
	fileProveedores.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, 'proveedores');
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});

    const fileMarcas = document.getElementById('marcasFile');
	fileMarcas.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'}); 
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, 'marcas');
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});





    $('#fechas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-fechas').innerHTML = "Estas fechas <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-fechas').classList.remove('green');
            document.getElementById('mensaje-fechas').classList.add('red');
        }
        else{
            document.getElementById('mensaje-fechas').innerHTML = "<strong>Sólo estas fechas</strong> participan en la promoción";
            document.getElementById('mensaje-fechas').classList.add('green');
            document.getElementById('mensaje-fechas').classList.remove('red');
        }
    });

    $('#listaCategoriaClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-categorias').innerHTML = "Estas categorías de clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-categorias').classList.remove('green');
            document.getElementById('mensaje-categorias').classList.add('red');
        }
        else{
            document.getElementById('mensaje-categorias').innerHTML = "<strong>Sólo estas categorías de clientes</strong> participan en la promoción";
            document.getElementById('mensaje-categorias').classList.add('green');
            document.getElementById('mensaje-categorias').classList.remove('red');
        }
    });

    $('#listaGirosClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-giros').innerHTML = "Estos giros de clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-giros').classList.remove('green');
            document.getElementById('mensaje-giros').classList.add('red');
        }
        else{
            document.getElementById('mensaje-giros').innerHTML = "<strong>Sólo estos giros de clientes</strong> participan en la promoción";
            document.getElementById('mensaje-giros').classList.add('green');
            document.getElementById('mensaje-giros').classList.remove('red');
        }
    });

    $('#listaClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-clientes').innerHTML = "Estos clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-clientes').classList.remove('green');
            document.getElementById('mensaje-clientes').classList.add('red');
        }
        else{
            document.getElementById('mensaje-clientes').innerHTML = "<strong>Sólo estos clientes</strong> participan en la promoción";
            document.getElementById('mensaje-clientes').classList.add('green');
            document.getElementById('mensaje-clientes').classList.remove('red');
        }
    });

    $('#listaProveedores').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-proveedores').innerHTML = "Estos proveedores <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-proveedores').classList.remove('green');
            document.getElementById('mensaje-proveedores').classList.add('red');
        }
        else{
            document.getElementById('mensaje-proveedores').innerHTML = "<strong>Sólo estos proveedores</strong> participan en la promoción";
            document.getElementById('mensaje-proveedores').classList.add('green');
            document.getElementById('mensaje-proveedores').classList.remove('red');
        }
    });

    $('#listaMarcas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-marcas').innerHTML = "Estas marcas <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-marcas').classList.remove('green');
            document.getElementById('mensaje-marcas').classList.add('red');
        }
        else{
            document.getElementById('mensaje-marcas').innerHTML = "<strong>Sólo estas marcas</strong> participan en la promoción";
            document.getElementById('mensaje-marcas').classList.add('green');
            document.getElementById('mensaje-marcas').classList.remove('red');
        }
    });

    $('#listaArticulos').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-articulos').innerHTML = "Estos artículos <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-articulos').classList.remove('green');
            document.getElementById('mensaje-articulos').classList.add('red');
        }
        else{
            document.getElementById('mensaje-articulos').innerHTML = "<strong>Sólo estos artículos</strong> participan en la promoción";
            document.getElementById('mensaje-articulos').classList.add('green');
            document.getElementById('mensaje-articulos').classList.remove('red');
        }
    });

    $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        autoUpdateInput: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: 'Aplicar',
            daysOfWeek: [
                'Do',
                'Lu',
                'Ma',
                'Mi',
                'Ju',
                'Vi',
                'Sa'
            ],
            monthNames: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ]
        }
      }, function(start, end, label) {
        startDate = start.format('YYYY-MM-DD');
        endDate = end.format('YYYY-MM-DD');
    });


    $('#descuento').on('input', function() {
        var val = document.getElementById('descuento').value;
       document.getElementById('percent-disccount').innerHTML = val;
    });

});

function existingTag(text)
{
	var existing = false,
		text = text.toLowerCase();

	$(".tags").each(function(){
		if ($(this).text().toLowerCase() == text) 
		{
			existing = true;
			return "";
		}
	});

	return existing;
}



$(function(){
    $(".tags-new input").focus();
    
    $(".tags-new input").keyup(function(e){
  
          var tag = $(this).val().trim(),
          length = tag.length;
  
          if(e.key === "Enter" || e.keyCode === 13)
          {
              tag = tag.substring(0, length);
  
              if(!existingTag(tag))
              {
                  var last = document.querySelector('.last');
                  if(last!=null){
                      document.querySelector('.last').classList.remove('last');
                  }
                  $('<li class="tags last"><span>' + tag + '</span><i class="fa fa-times"></i></i></li>').insertBefore($(".tags-new"));
                  $(this).val("");	
              }
              else
              {
                  $(this).val(tag);
              }
          }
  
  
          if(e.key === "Backspace" || e.keyCode === 46){
                 var tag = document.querySelector('.last');
                 if(tag!=null){
                  if(tag.style.background == "rgb(250, 91, 91)"){
                      tag.remove();
                  }
                  else{
                          tag.style.background = "rgb(250, 91, 91)";
                  }
                 }
  
                 var lastTag = document.querySelectorAll(".tags");
              if(lastTag.length != 0){
                  lastTag[lastTag.length -1].classList.add('last');
              }
          }
  
  
      });
    
    $(document).on("click", ".tags i", function(){
      $(this).parent("li").remove();
    });
  
  });


function triggerInputFile(input){
	document.getElementById(input+'File').click();
}


function checkRules() {
    if (reglas.length > 0) {
        document.getElementById('regalos_chosen').style.display = "block";
        document.getElementById('regalosLoading').style.display = "none";
        var selectRegalos = document.getElementById('regalos');
        for(var x = 0; x<reglas[7].length; x++){
            var option = document.createElement("option");
            option.text = reglas[7][x];
            option.value = (reglas[7][x].split(']'))[0].substring(1);
            selectRegalos.appendChild(option);
        }
        $('#regalos').trigger("chosen:updated");
        document.getElementById('regalos_chosen').style.width = '100%';

        document.getElementById('reemplaza_chosen').style.display = "block";
        document.getElementById('reemplazaLoading').style.display = "none";
        var selectReemplaza = document.getElementById('reemplaza');
        for(var x = 0; x<reglas[8].length; x++){
            if(!reglas[8][x]['paquete'] && reglas[8][x]['idPaquete'] == 0){
                var option = document.createElement("option");
                option.text = reglas[8][x]['nombrePromo'];
                option.value = reglas[8][x]['id'];
                selectReemplaza.appendChild(option);
            }
        }
        $('#reemplaza').trigger("chosen:updated");
        document.getElementById('reemplaza_chosen').style.width = '100%';

        document.getElementById('categorias_chosen').style.display = "block";
        document.getElementById('categoriasLoading').style.display = "none";
        var selectCategorias = document.getElementById('categorias');
        for(var x = 0; x<reglas[1].length; x++){
            var option = document.createElement("option");
            option.text = reglas[1][x];
            option.value =  reglas[1][x];
            selectCategorias.appendChild(option);
        }
        $('#categorias').trigger("chosen:updated");
        document.getElementById('categorias_chosen').style.width = '100%';


        document.getElementById('clientes_chosen').style.display = "block";
        document.getElementById('clientesLoading').style.display = "none";
        var selectClientes = document.getElementById('clientes');
        for(var x = 0; x<reglas[3].length; x++){
            var option = document.createElement("option");
            option.text = reglas[3][x];
            option.value = (reglas[3][x].split(']'))[0].substring(1);
            selectClientes.appendChild(option);
        }
        $('#clientes').trigger("chosen:updated");
        document.getElementById('clientes_chosen').style.width = '100%';

        document.getElementById('proveedores_chosen').style.display = "block";
        document.getElementById('proveedoresLoading').style.display = "none";
        var selectProveedores = document.getElementById('proveedores');
        for(var x = 0; x<reglas[5].length; x++){
            var option = document.createElement("option");
            option.text = reglas[5][x];
            option.value = reglas[5][x];
            selectProveedores.appendChild(option);
        }
        $('#proveedores').trigger("chosen:updated");
        document.getElementById('proveedores_chosen').style.width = '100%';

        document.getElementById('marcas_chosen').style.display = "block";
        document.getElementById('marcasLoading').style.display = "none";
        var selectMarcas = document.getElementById('marcas');
        for(var x = 0; x<reglas[6].length; x++){
            var option = document.createElement("option");
            option.text = reglas[6][x];
            option.value = reglas[6][x];
            selectMarcas.appendChild(option);
        }
        $('#marcas').trigger("chosen:updated");
        document.getElementById('marcas_chosen').style.width = '100%';

        document.getElementById('articulos_chosen').style.display = "block";
        document.getElementById('articulosLoading').style.display = "none";
        var selectArticulos = document.getElementById('articulos');
        for(var x = 0; x<reglas[7].length; x++){
            var option = document.createElement("option");
            option.text = reglas[7][x];
            option.value = (reglas[7][x].split(']'))[0].substring(1);
            selectArticulos.appendChild(option);
        }
        $('#articulos').trigger("chosen:updated");
        document.getElementById('articulos_chosen').style.width = '100%'; 

        if(window.location.href.includes('promociones/paquete') || (window.location.href.includes('promociones/editar') && document.getElementById('tipoPromo').value == 'paquete')){ //SI ES PAQUETE, AGREGAR REGALOS A SUBREGLAS
            document.getElementById('regalosSub_chosen').style.display = "block";
            document.getElementById('regalosSubLoading').style.display = "none";
            var selectregalosSub = document.getElementById('regalosSub');
            for(var x = 0; x<reglas[7].length; x++){
                var option = document.createElement("option");
                option.text = reglas[7][x];
                option.value = (reglas[7][x].split(']'))[0].substring(1);
                selectregalosSub.appendChild(option);
            }
            $('#regalosSub').trigger("chosen:updated");
            document.getElementById('regalosSub_chosen').style.width = '100%';
        }

        clearInterval(intervalRules);
        if(window.location.href.includes('promociones/editar')){ //SI LA PROMOCION VA A SER ACTUALIZADA, CARGAR INFORMACIÓN DEL EVENTO
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "/promociones/getEventById/" + document.getElementById('idPromo').value,
                'type': 'GET',
                'enctype': 'multipart/form-data',
                'timeout': 2*60*60*1000,
                success: function(data){
                        addPromoRules(data);
                }, 
                error: function(error){
                 }
            });
        }
        
    } 
    else{
        document.getElementById('regalos_chosen').style.display = "none";
        document.getElementById('reemplaza_chosen').style.display = "none";
        document.getElementById('giros_chosen').style.display = "none";
        document.getElementById('marcas_chosen').style.display = "none";
        document.getElementById('proveedores_chosen').style.display = "none";
        document.getElementById('articulos_chosen').style.display = "none";
        document.getElementById('categorias_chosen').style.display = "none";
        document.getElementById('clientes_chosen').style.display = "none";
    }
}

function addTags(json, id){
    var jsonObj = JSON.parse(json);
    var selectedOptions = [];
    var key = '';
    switch(id){
        case 'categorias': key = 'Categoria'; break;
        case 'giros': key = 'Giro'; break;
        case 'clientes': key = 'CompanyId'; break;
        case 'proveedores': key = 'Proveedor'; break;
        case 'marcas': key = 'Marca'; break;
        case 'articulos': key = 'Codigo'; break;
        case 'clientesCuotas': key = 'CompanyId'; break;
        default: break;
    }
    jsonObj.forEach(function(valor, indice, array){
        selectedOptions.push(valor[key]);
    });
    $('#'+id).val(selectedOptions).trigger('chosen:updated');
}

function downloadTemplate(template){
    window.location.href = '/downloadTemplate'+template;
}

function guardarPromocion(){   
    if(document.getElementById('btn-guardar').disabled){
        document.getElementById('div-loading').style.opacity = '1';
        setTimeout(validarPromo, 2000);
    }
    else{
        validarPromo();
    } 
}

function validarPromo(){
    document.getElementById('div-loading').style.opacity = '0';
    var bodyValidations = '';
    var save = true;
    if(document.getElementById('nombrePromo').value == ''){
        save = false;
        document.getElementById('nombrePromo').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un nombre para la promoción</h5>';
    }
    else{
        document.getElementById('nombrePromo').classList.remove('invalid-input');
        document.getElementById('nombrePromo').classList.add('valid-input');
    }

    if(startDate == undefined || endDate == undefined){
        save = false;
        document.getElementById('rangoFechas').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un rango de fechas para la promoción</h5>';
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

    

    if(save && !document.getElementById('btn-guardar').disabled){
        var categorias = $('#categorias').chosen().val();
        var giros = $('#giros').chosen().val();
        var clientes = $('#clientes').chosen().val();
        var proveedores = $('#proveedores').chosen().val();
        var marcas = $('#marcas').chosen().val();
        var articulos = $('#articulos').chosen().val();
    
        var regalos = $('#regalos').chosen().val();
        var reemplaza = $('#reemplaza').chosen().val();
    
        var startTime = startDate+" "+document.getElementById('startTime').value+":00";
        var endTime = endDate+" "+document.getElementById('endTime').value+":00";

        var listaPedidoPromoRulesD = [];

       for(var x = 0; x < proveedores.length; x++){
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'PROVEEDOR',
                valor: proveedores[x],
                incluye: document.getElementById('listaProveedores').value == 'blanca' ? true:false,
                idPedidoPromoNavigation: ''
            });
        }


        for(var x = 0; x < marcas.length; x++){
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'MARCA',
                valor: marcas[x],
                incluye: document.getElementById('listaMarcas').value == 'blanca' ? true:false,
                idPedidoPromoNavigation: ''
            });
        }



        for(var x = 0; x < articulos.length; x++){
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'ARTICULO',
                valor: articulos[x],
                incluye: document.getElementById('listaArticulos').value == 'blanca' ? true:false,
                idPedidoPromoNavigation: ''
            });
        }

        var cuotasList = [];
        var cuotasObj = {
            'customer': '',
            'importeCuota': 0,
            'p1': '0',
            'p2': '0',
            'p3': '0',
        };
        cuotasList.push(cuotasObj);

        var idPromo;
        if(window.location.href.includes('promociones/editar'))//SI LA PROMO SERÁ ACTUALIZADA, ENVIAR ID PROMO
            idPromo = document.getElementById('idPromo').value;
        else    
            idPromo = 0;

        

        var json = { 
            id: idPromo, 
            nombrePromo: document.getElementById('nombrePromo').value,
            descuento: document.getElementById('descuento').value = "" ? 0 : parseFloat(document.getElementById('descuento').value),
            descuentoWeb: document.getElementById('descuentoWeb').value = "" ? 0 : parseFloat(document.getElementById('descuentoWeb').value),
            puntosIndar: document.getElementById('puntos').value == "" ? 0 : parseInt( document.getElementById('puntos').value),
            plazosIndar: parseInt( document.getElementById('plazos').value),
            regalosIndar: regalos.toString(),
            reemplazaRegalo: reemplaza.toString() != '' ? parseInt(reemplaza.toString()) : 0,
            categoriaClientes: categorias.toString(),
            categoriaClientesIncluye: document.getElementById('listaCategoriaClientes').value == 'blanca' ? parseInt('1'): parseInt('0'),
            gruposclientesIds: giros.toString(),
            gruposclientesIncluye: document.getElementById('listaGirosClientes').value == 'blanca' ? true:false,
            clientesId: clientes.toString(),
            clientesIncluye: document.getElementById('listaClientes').value == 'blanca' ? true:false,
            plazo: '',
            montoMinCash: document.getElementById('preciomin').value == "" ? 0 : parseFloat(document.getElementById('preciomin').value),
            montoMinQty: document.getElementById('cantidadmin').value == "" ? 0 : parseInt(document.getElementById('cantidadmin').value),
            fechaInicio: startTime,
            fechaFin: endTime,
            paquete: false,
            idPaquete: 0,
            pedidoPromoRulesD: listaPedidoPromoRulesD,
            cuotasPersonalizadas: cuotasList,
        }

        console.log(json);
        console.log(JSON.stringify(json));

        // $.ajax({
        //     'headers': {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     'url': "storePromo",
        //     'type': 'POST',
        //     'dataType': 'json', 
        //     'data': json,
        //     'enctype': 'multipart/form-data',
        //     'timeout': 2*60*60*1000,
        //     success: function(data){
        //         if(data['status'] != undefined){
        //             alert(Object.entries(data['errors']));
        //         }
        //         else{
        //             window.location.href = '/promociones';
        //         }
        //     }, 
        //     error: function(error){
        //             // window.location.href = '/promociones';
        //      }
        // });
    }

    if(!save){
        document.getElementById('bodyValidations').innerHTML = bodyValidations;
        var modal = document.getElementById('validateModal');
        modal.style.opacity = 1;
        modal.style.zIndex = 1000;
        modal.classList.add("active-modal");
    }

    if(save && document.getElementById('btn-guardar').disabled){
        document.getElementById('btn-guardar').disabled = false;
    }
}

function clearSelection(id){
    document.getElementById('listaDelete').innerHTML = id;
    var modal = document.getElementById('deleteModal');
    modal.style.opacity = 1;
    modal.style.zIndex = 1000;
    modal.classList.add("active-modal");
}

function closeModal(){
    var activeModal = document.getElementsByClassName("active-modal");
    if(activeModal.length>1)
        activeModal = activeModal[1];
    else
        activeModal = activeModal[0];
    activeModal.style.opacity = 0;
    activeModal.style.zIndex = -1000;
    activeModal.classList.remove("active-modal");
}

function clearSelectionAccept(){
    var list = document.getElementById('listaDelete').innerHTML.toLowerCase();
    closeModal();
    $('#'+list).val('').trigger('chosen:updated');
    $('#'+list+"File").val('');
}

function addPromoRules(rules){
    console.log(rules);
    startDate = rules['fechaInicio'].split('T')[0];
    endDate = rules['fechaFin'].split('T')[0];
    var pedidoPromoRules = rules['pedidoPromoRulesD'];
    var regalos = rules['regalosIndar'];
    var clientes = rules['clientesId'];
    var categorias = rules['categoriaClientes'];
    var proveedores = [];
    var marcas = [];
    var articulos = [];

    if(regalos != null){
        regalos = regalos.split(',');
        $('#regalos').val(regalos).trigger('chosen:updated');
    }
    if(clientes != null){
        clientes = clientes.split(',');
        $('#clientes').val(clientes).trigger('chosen:updated');
    }
    if(categorias != null){
        categorias = categorias.split(',');
        $('#categorias').val(categorias).trigger('chosen:updated');
    }

    for(var x = 0; x < pedidoPromoRules.length; x++){
        if(pedidoPromoRules[x]['tipo'] == 'PROVEEDOR')
            proveedores.push(pedidoPromoRules[x]['valor']);
        if(pedidoPromoRules[x]['tipo'] == 'MARCA')
            marcas.push(pedidoPromoRules[x]['valor']);
        if(pedidoPromoRules[x]['tipo'] == 'ARTICULO')
            articulos.push(pedidoPromoRules[x]['valor']);
    }

    if(proveedores.length > 0)
        $('#proveedores').val(proveedores).trigger('chosen:updated');
    if(articulos.length > 0)
        $('#articulos').val(articulos).trigger('chosen:updated');
    if(marcas.length > 0)
        $('#marcas').val(marcas).trigger('chosen:updated');

    if(rules['paquete'])
        validarPaquete();
}


