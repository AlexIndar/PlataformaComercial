var info = [];
var addresses = [];
var shippingWays = [];
var packageDeliveries = [];
var items = [];

indexCustomer = 0;
indexAddress = 0;

$(document ).ready(function() {
    
	var entity = document.getElementById('entity').value;

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
            success: function(data){
                    info = data;
            }, 
            error: function(error){
                  console.log(error);
             }
    }); 
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
			  console.log(error);
		 }
	});


	// INVENTARIO ON CLICK ADD ROW TO ORDER

	$('#example1 tbody').on('click', 'tr', function () {
		table = $("#example1").DataTable();
		var index = table.row( this ).index();
		var item = items[index];
		if(item['disponible']==0){
			var toast = Swal.mixin({
				toast: true,
				icon: 'success',
				title: 'General Title',
				animation: true,
				position: 'top-right',
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
				title: 'Producto '+item['itemid']+' Insuficiente',
				icon: 'error'
			});
		}
		else{
			addRowPedido(item);
			var toast = Swal.mixin({
				toast: true,
				icon: 'success',
				title: 'General Title',
				animation: true,
				position: 'top-right',
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
				title: 'Producto '+item['itemid']+' Agregado',
				icon: 'success'
			});
		}
	} );
	
	
	

	// UPDATE ADDRESSES AND DEFAULT SHIPPING WAT / PACKAGING WHEN CUSTOMER IS SELECTED ----------------------------------------------------------------

	$('#customerID').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var selected = clickedIndex - 1;
		indexCustomer = selected;
		addresses = info[selected]['addresses'];
		shippingWays = info[selected]['shippingWays'];
		packageDeliveries = info[selected]['packageDeliveries'];

		var itemSelectorOption = $('#sucursal option');
		itemSelectorOption.remove(); 
		$('#sucursal').selectpicker('refresh');

		$('#sucursal').append('<option value="none"></option>'); //Agregar Primera opción de Sucursal en Blanco
		$('#sucursal').val('none');
		$('#sucursal').selectpicker("refresh");

		for (var x = 0; x < addresses.length ; x++){ //Agregar todas las sucursales del cliente seleccionado al select Sucursal
			$('#sucursal').append('<option value="'+addresses[x]['addressID']+'">'+addresses[x]['address']+'</option>');
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

	$('#sucursal').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var selected = clickedIndex-1;
		if(info.length == 1){
			if(clickedIndex == 0){
				indexAddress = 0;
				$('#envio').val(info[0]['shippingWayF']);
				$('#fletera').val(info[0]['packgeDeliveryF']);
			}
			else{
				indexAddress = selected;
				addresses = info[0]['addresses'];
				shippingWays = info[0]['shippingWays'];
				packageDeliveries = info[0]['packageDeliveries'];
				$('#envio').val(shippingWays[selected]);
				$('#fletera').val(packageDeliveries[selected]);
			}
		}
		else{
			if(clickedIndex == 0){
				indexAddress = 0;
				$('#envio').val(info[indexCustomer]['shippingWayF']);
				$('#fletera').val(info[indexCustomer]['packgeDeliveryF']);
			}
			else{
				indexAddress = selected;
				$('#envio').val(shippingWays[selected]);
				$('#fletera').val(packageDeliveries[selected]);
			}
		}
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

//ELIMINAR ARTICULO DE LA TABLA 
function deleteRowPedido(t){
	var row = t.parentNode.parentNode;
    document.getElementById("tablaPedido").deleteRow(row.rowIndex);
}

//ELIMINAR FILA DE LA TABLA CARGAR POR CODIGO
function deleteRowCodigo(t){
	var row = t.parentNode.parentNode;
	var table = document.getElementById('tableCargarPorCodigo');
    table.deleteRow(row.rowIndex);
	if(table.rows.length == 1){
		document.getElementById('tableCargarPorCodigo').style.display = 'none';
		table.classList.remove('active');
		table.classList.add('inactive');
		document.getElementById('btnCargarPorCodigo').classList.add('d-none');
	}
}


function addRowCargarPorCodigo(){
	var table = document.getElementById('tableCargarPorCodigo');
	if(table.classList.contains('inactive')){
		table.style.display = 'block';
		table.classList.remove('inactive');
		table.classList.add('active');
		addInputsCodigo(table);
	}
	else{
		addInputsCodigo(table);
	}
}

function addInputsCodigo(table){
		var row = table.insertRow(table.rows.length);

		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);

		cell1.innerHTML = "<input class='input-codigo' id='input-codigo-"+(table.rows.length-1)+"' type='text'>";
		cell2.innerHTML = "<input id='input-cantidad-"+(table.rows.length-1)+"' type='text'>";
		cell3.innerHTML = "<i class='fas fa-minus-square fa-xl fa-delete' onclick='deleteRowCodigo(this)'></i>";

		document.getElementById('btnCargarPorCodigo').classList.remove('d-none');
}
               
function cargarProductosPorCodigo(){
	var rows = document.getElementsByClassName('input-codigo');
	var entity = document.getElementById('entity').value;
	var item = [];
	var articulos = [];
	for(var x=1; x<=rows.length;x++){
		var inputCodigo = document.getElementById('input-codigo-'+x);
		var inputCantidad = document.getElementById('input-cantidad-'+x);
		var temp = {"articulo" : inputCodigo.value, "cantidad" : inputCantidad.value};
		articulos.push(temp);
	}

	for(var x = 0; x < articulos.length ; x ++){
		let data = {id: articulos[x]['articulo'], entity: entity};

		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url: "getItemByID",
			timeout: 2*60*60*1000,
			data: JSON.stringify(data),
			headers: {
				'Content-Type':'application/json',
				X_CSRF_TOKEN:('meta[name="csrf-token"]').content,
				'Accept':'application/json'
			},
			success: function(data){
				console.log(data);
					var item = {
						categoriaItem: 'PENDIENTE',
						clavefabricante: "XX",
						familia: "PENDIENTE",
						grupoArticulo: "PENDIENTE",
						tipoArticulo: "PENDIENTE",
						id: data[0]['id'],
						itemid: data[0]['itemid'],
						purchasedescription: data[0]['purchasedescription'],
						multiploVenta: data[0]['multiploVenta'],
						price: data[0]['price'],
						unidad: data[0]['unidad'],
						promo: data[0]['promo'],
						disponible: data[0]['disponible']
					};
					addRowPedido(item);

			}, 
			error: function(error){
				  console.log(error);
			 }
		});
	}



}

function cargarInventario(){
	// var dataset = {"data":items};
		var empty = document.getElementById('empty').value;

		if(empty == "yes"){ //si la tabla está vacía, inicializarla
			
			document.getElementById('empty').value='No' ; 
			var dataset = [];

			for (var x = 0; x < items.length; x ++){
				var arr = [];
				arr.push("<img src='/assets/customers/img/jpg/imagen_no_disponible.jpg' height='auto' width='100px'/>");
				arr.push(items[x]['categoriaItem']);
				arr.push(items[x]['clavefabricante']);
				arr.push(items[x]['familia']);
				arr.push(items[x]['grupoArticulo']);
				arr.push(items[x]['tipoArticulo']);
				arr.push(items[x]['id']);
				arr.push(items[x]['itemid']);
				arr.push(items[x]['purchasedescription']);
				arr.push(items[x]['multiploVenta']);
				arr.push(items[x]['price']);
				arr.push(items[x]['unidad']);
				arr.push(items[x]['promo']);
				arr.push(items[x]['disponible']);
				dataset.push(arr);
			}
		
			// console.log(JSON.stringify(dataset));
		
			var table = $("#example1").DataTable({
				"data": dataset,
				"scrollX": 900,
				"responsive": true,
				"lengthChange": true,
				"autoWidth": false,
				"paging": true,
				"searching": true,
				"ordering": true,
				"info": true,
			});
		}

}


function addRowPedido(item){
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

		cell1.innerHTML = "<h4>"+(row.rowIndex)+"</h4>";
		cell2.innerHTML = "<div class='row'><div class='col-12'><h4 id='codArticulo'>"+item["itemid"]+"</h4></div><div class='col-12'>Unidad: <span id='unidad'>"+item["unidad"]+"</span> </div></div>";
		cell3.innerHTML = "<div class='input-group'><div class='input-group-prepend'><button id='menos' class='quantityBtn' name='menos'>-</button></div><input type='text' aria-label='cantidad' id='cantidad' name='cantidad' class='form-control input-cantidad' value='"+item['multiploVenta']+"'><div class='input-group-append'><button id='mas' class='quantityBtn' name='mas'>+</button></div></div>";

		if(item["categoriaItem"]=="CADUCADO" || item["categoriaItem"]=="S/PEDIDO")
			cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>"+item["purchasedescription"]+"</h5></div><div class='col-12'>Categoría: <span id='categoria-pedido'>"+item["categoriaItem"]+"</span> Existencia: <span id='existencia'>"+item["disponible"]+"</span> Múltiplo: <span id='multiplo'>"+item["multiploVenta"]+"</span></div></div>";
		else
			cell4.innerHTML = "<div class='row'><div class='col-12'><h5 id='descripcion'>"+item["purchasedescription"]+"</h5></div><div class='col-12'>Categoría: <span id='categoria-linea'>"+item["categoriaItem"]+"</span> Existencia: <span id='existencia'>"+item["disponible"]+"</span> Múltiplo: <span id='multiplo'>"+item["multiploVenta"]+"</span></div></div>";
		
		cell5.innerHTML = "<h5 id='precioLista'>$"+item["price"]+"</h5>";
		cell6.innerHTML = "<h5 id='promo'>"+item["promo"]+"</h5>";
		cell7.innerHTML = "<h5 id='precioUnitario'>$"+item["price"]+"</h5>";
		cell8.innerHTML = "<h5 id='importe'>CALCULAR</h5>";
		cell9.innerHTML = "<i class='fas fa-minus-square fa-2x fa-delete' onclick='deleteRowPedido(this)'></i>";

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