var saleOrders= [];

$(document).ready(function(){
    var companyId = document.getElementById('companyId').value;
    var token = getCookie('laravel-token');    

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            url: "getSaleOrders/" + companyId,
            data: FormData,
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            }, 
            success: function(data){
                    saleOrders = data;
            }, 
            error: function(error){
                //   console.log(error);
             }
    
        }); 

        var today = new Date();
        var hour =  today.getHours();
        var suffix = hour >= 12 ? "PM":"AM";
        var hours = (hour+":"+today.getMinutes()+" " + suffix);
        var date = ("0"+today.getDate()).slice(-2) + "/" + ("0"+(today.getMonth()+1)).slice(-2) + "/" + today.getFullYear() + " - "+hours;

        document.getElementById('hora').innerHTML = date;



    // FILTRO POR COTIZACIÓN ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $('#findCotizacion').keyup(function(){
        document.getElementById('findMonth').options[0].selected = 'selected';
        var cotizacion = this.value;
        var row = document.getElementById('rowCotizaciones');

        while (row.firstChild) {
            row.removeChild(row.firstChild);
        }


        if(cotizacion == ""){ // -------------------------------------------------------------------------------- MOSTRAR TODAS LAS COTIZACIONES ------------------------------------------------------------------------------------
            showAll();
        }
        else{ //----------------------------------------------------------------------------------------------- MOSTRAR UNICAMENTE LO QUE COINCIDA CON LA COTIZACION --------------------------------------------------------------------------------------------------------------------------------
            for(var x = 0; x < saleOrders.length; x++){
                if(saleOrders[x].cotizacion.startsWith(cotizacion)){
                    var div = document.createElement('div');
                    div.classList = "col-lg-1 col-md-2 col-sm-3 col-6 box"; 
                    div.setAttribute('onclick', "openDetail(\""+saleOrders[x]['numPedido']+"\")");
                    var inner = document.createElement('div');
                    if(saleOrders[x]['numFactura'] != null){
                        inner.classList = "inner inner-green";
                    }
                    else{
                        var inner = document.createElement('div');
                        inner.classList = "inner inner-red";
                    }

                    var hcotizacion = document.createElement('h5');
                    hcotizacion.innerHTML = " <strong>Cotización <br> </strong> " + saleOrders[x]['cotizacion'];

                    var hdate = document.createElement('h5');
                    hdate.innerHTML = "<br>" + saleOrders[x]['trandate'];

                    var hpedido = document.createElement('h5');
                    hpedido.innerHTML = " <strong>Pedido Web <br> </strong> " + saleOrders[x]['idWeb'];

                    var himportePedido = document.createElement('h5');
                    himportePedido.innerHTML = "<br>" + formatCurrency(saleOrders[x]['importePedido']);

                    var hr = document.createElement('hr');

                    var hsalesOrder = document.createElement('h5');
                    hsalesOrder.innerHTML = " <strong>Sales Order <br> </strong> " + saleOrders[x]['numPedido'];

                    var hnumFactura = document.createElement('h5');
                    hnumFactura.innerHTML = " <strong>Num Factura <br> </strong> " + saleOrders[x]['numFactura'];

                    var hestatus = document.createElement('h5');
                    hestatus.innerHTML = " <strong>Estatus:</strong>";

                    if(saleOrders[x]['numFactura'] != null){
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "FACTURADO";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador green";
                    }
                    else if(saleOrders[x]['status'] == "Pending Approval"){
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "POR APROBAR";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador orange";
                    }
                    else {
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "PENDIENTE";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador red";
                    }

                    inner.appendChild(hcotizacion);
                    inner.appendChild(hdate);
                    inner.appendChild(hpedido);
                    inner.appendChild(himportePedido);
                    inner.appendChild(hr);
                    inner.appendChild(hsalesOrder);
                    inner.appendChild(hnumFactura);
                    inner.appendChild(hestatus);
                    inner.appendChild(hestatusDesc);
                    inner.appendChild(indicador);



                    div.appendChild(inner);
                    row.appendChild(div);
                }
            }
        }
    });


    // FILTRO POR MES ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $('#findMonth').on('change', function() {
        var mes = this.value;
        // var mesText = this.options[mes].text;
        var row = document.getElementById('rowCotizaciones');
        document.getElementById('findCotizacion').value = "";
        var year = document.getElementById('findYear').value;
        if (year == 'all')
            year = "2";

        while (row.firstChild) {
            row.removeChild(row.firstChild);
        }

        if(mes == "all"){ // -------------------------------------------------------------------------------- MOSTRAR TODAS LAS COTIZACIONES ------------------------------------------------------------------------------------
           showAll();
        }
        else{ //----------------------------------------------------------------------------------------------- MOSTRAR UNICAMENTE LO QUE COINCIDA CON EL MES FILTRADO --------------------------------------------------------------------------------------------------------------------------------
            var cont = 0;
            for(var x = 0; x < saleOrders.length; x++){
                if(saleOrders[x].trandate.split('/')[1]==mes && saleOrders[x].trandate.split('/')[2].startsWith(year)){
                    cont ++;
                    var div = document.createElement('div');
                    div.classList = "col-lg-1 col-md-2 col-sm-3 col-6 box";
                    div.setAttribute('onclick', "openDetail(\""+saleOrders[x]['numPedido']+"\")");
                    var inner = document.createElement('div');
                    if(saleOrders[x]['numFactura'] != null){
                        inner.classList = "inner inner-green";
                    }
                    else{
                        var inner = document.createElement('div');
                        inner.classList = "inner inner-red";
                    }

                    var hcotizacion = document.createElement('h5');
                    hcotizacion.innerHTML = " <strong>Cotización <br> </strong> " + saleOrders[x]['cotizacion'];

                    var hdate = document.createElement('h5');
                    hdate.innerHTML = "<br>" + saleOrders[x]['trandate'];

                    var hpedido = document.createElement('h5');
                    hpedido.innerHTML = " <strong>Pedido Web <br> </strong> " + saleOrders[x]['idWeb'];

                    var himportePedido = document.createElement('h5');
                    himportePedido.innerHTML = "<br>" + formatCurrency(saleOrders[x]['importePedido']);

                    var hr = document.createElement('hr');

                    var hsalesOrder = document.createElement('h5');
                    hsalesOrder.innerHTML = " <strong>Sales Order <br> </strong> " + saleOrders[x]['numPedido'];

                    var hnumFactura = document.createElement('h5');
                    hnumFactura.innerHTML = " <strong>Num Factura <br> </strong> " + saleOrders[x]['numFactura'];

                    var hestatus = document.createElement('h5');
                    hestatus.innerHTML = " <strong>Estatus:</strong>";

                    if(saleOrders[x]['numFactura'] != null){
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "FACTURADO";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador green";
                    }
                    else if(saleOrders[x]['status'] == "Pending Approval"){
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "POR APROBAR";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador orange";
                    }
                    else{
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "PENDIENTE";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador red";
                    }

                    inner.appendChild(hcotizacion);
                    inner.appendChild(hdate);
                    inner.appendChild(hpedido);
                    inner.appendChild(himportePedido);
                    inner.appendChild(hr);
                    inner.appendChild(hsalesOrder);
                    inner.appendChild(hnumFactura);
                    inner.appendChild(hestatus);
                    inner.appendChild(hestatusDesc);
                    inner.appendChild(indicador);



                    div.appendChild(inner);
                    row.appendChild(div);
                }
            }

            if(cont == 0){
                var div = document.createElement('div');
                div.classList = "col-12 text-center";

                var h4 = document.createElement('h4');
                if (year == '2')
                    h4.innerHTML = "<br><br> No se encontraron pedidos de "+this.options[mes].text+" en ningún año";
                else    
                    h4.innerHTML = "<br><br> No se encontraron pedidos de "+this.options[mes].text+" "+year;
                div.appendChild(h4);
                row.appendChild(div);
            }
        }
    });

    // ZOOM EFFECT

    var native_width = 0;
	var native_height = 0;

	$(".magnify").mousemove(function(e){
		if(!native_width && !native_height)
		{
		
			var image_object = new Image();
			image_object.src = $(".small").attr("src");
			native_width = image_object.width;
			native_height = image_object.height;
		}
		else
		{
            var src = $(".small").attr("src");
            document.getElementById('zoom').style.background = "url('"+src+"') no-repeat";

			var magnify_offset = $(this).offset();
		
			var mx = e.pageX - magnify_offset.left;
			var my = e.pageY - magnify_offset.top;
		
			if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
			{
				$(".large").fadeIn(100);
			}
			else
			{
				$(".large").fadeOut(100);
			}
			if($(".large").is(":visible"))
			{

				var rx = Math.round(mx/$(".small").width()*native_width - $(".large").width()/2)*-1;
				var ry = Math.round(my/$(".small").height()*native_height - $(".large").height()/2)*-1;
				var bgp = rx + "px " + ry + "px";
				
				var px = mx - $(".large").width()/2;
				var py = my - $(".large").height()/2;
			
				$(".large").css({left: px, top: py, backgroundPosition: bgp});
			}
		}
	});
    
    // FILTRO POR AÑO ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $('#findYear').on('change', function() {
        var year = this.value;
        var row = document.getElementById('rowCotizaciones');
        var month = document.getElementById('findMonth').value;
        if (month == 'all')
            month = "";
        document.getElementById('findCotizacion').value = "";
        while (row.firstChild) {
            row.removeChild(row.firstChild);
        }
        if(year == "all"){ // -------------------------------------------------------------------------------- MOSTRAR TODAS LAS COTIZACIONES ------------------------------------------------------------------------------------
           showAll();
        }
        else{ //----------------------------------------------------------------------------------------------- MOSTRAR UNICAMENTE LO QUE COINCIDA CON EL AÑO FILTRADO --------------------------------------------------------------------------------------------------------------------------------
            var cont = 0;
            for(var x = 0; x < saleOrders.length; x++){
                if(saleOrders[x].trandate.split('/')[2]==year && saleOrders[x].trandate.split('/')[1].startsWith(month)){
                    cont ++;
                    var div = document.createElement('div');
                    div.classList = "col-lg-1 col-md-2 col-sm-3 col-6 box";
                    div.setAttribute('onclick', "openDetail(\""+saleOrders[x]['numPedido']+"\")");
                    var inner = document.createElement('div');
                    if(saleOrders[x]['numFactura'] != null){
                        inner.classList = "inner inner-green";
                    }
                    else{
                        var inner = document.createElement('div');
                        inner.classList = "inner inner-red";
                    }

                    var hcotizacion = document.createElement('h5');
                    hcotizacion.innerHTML = " <strong>Cotización <br> </strong> " + saleOrders[x]['cotizacion'];

                    var hdate = document.createElement('h5');
                    hdate.innerHTML = "<br>" + saleOrders[x]['trandate'];

                    var hpedido = document.createElement('h5');
                    hpedido.innerHTML = " <strong>Pedido Web <br> </strong> " + saleOrders[x]['idWeb'];

                    var himportePedido = document.createElement('h5');
                    himportePedido.innerHTML = "<br>" + formatCurrency(saleOrders[x]['importePedido']);

                    var hr = document.createElement('hr');

                    var hsalesOrder = document.createElement('h5');
                    hsalesOrder.innerHTML = " <strong>Sales Order <br> </strong> " + saleOrders[x]['numPedido'];

                    var hnumFactura = document.createElement('h5');
                    hnumFactura.innerHTML = " <strong>Num Factura <br> </strong> " + saleOrders[x]['numFactura'];

                    var hestatus = document.createElement('h5');
                    hestatus.innerHTML = " <strong>Estatus:</strong>";

                    if(saleOrders[x]['numFactura'] != null){
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "FACTURADO";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador green";
                    }
                    else if(saleOrders[x]['status'] == "Pending Approval"){
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "POR APROBAR";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador orange";
                    }
                    else{
                        var hestatusDesc = document.createElement('h5');
                        hestatusDesc.innerHTML = "PENDIENTE";
                        var indicador = document.createElement('div');
                        indicador.classList = "indicador red";
                    }

                    inner.appendChild(hcotizacion);
                    inner.appendChild(hdate);
                    inner.appendChild(hpedido);
                    inner.appendChild(himportePedido);
                    inner.appendChild(hr);
                    inner.appendChild(hsalesOrder);
                    inner.appendChild(hnumFactura);
                    inner.appendChild(hestatus);
                    inner.appendChild(hestatusDesc);
                    inner.appendChild(indicador);



                    div.appendChild(inner);
                    row.appendChild(div);
                }
            }

            if(cont == 0){
                var div = document.createElement('div');
                div.classList = "col-12 text-center";

                var h4 = document.createElement('h4');
                var h4 = document.createElement('h4');
                if (month == '')
                    h4.innerHTML = "<br><br> No se encontraron pedidos de ningún mes en el año "+year;
                else    
                    h4.innerHTML = "<br><br> No se encontraron pedidos de "+ document.getElementById('findMonth').options[month].text +" "+year;

                div.appendChild(h4);
                row.appendChild(div);
            }
        }
    });

    $( ".fa-refresh" ).on( "click", function( e ) {
        var icon = $(this).find( ".fa-refresh" ),
        animateClass = "glyphicon-refresh-animate";
    
        $(this).addClass( animateClass );
        // setTimeout is to indicate some async operation
        window.setTimeout( function() {
          $( ".fa-refresh" ).removeClass( animateClass );
        }, 1000 );

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            url: "getSaleOrders/" + companyId,
            data: FormData,
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data){
                    saleOrders = data;
            }, 
            error: function(error){
                //   console.log(error);
             }
    
        }); 

        var today = new Date();
        var hour =  today.getHours();
        var suffix = hour >= 12 ? "PM":"AM";
        var hours = (hour+":"+today.getMinutes()+" " + suffix);
        var date = ("0"+today.getDate()).slice(-2) + "/" + ("0"+(today.getMonth()+1)).slice(-2) + "/" + today.getFullYear() + " - "+hours;

        document.getElementById('hora').innerHTML = date;

        showAll();

    });    

});



function getCookie(name) { //saber si una cookie existe 
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
} 


function formatCurrency(number){
    const options = { style: 'currency', currency: 'USD' };
    const numberFormat = new Intl.NumberFormat('en-US', options);
    var format = numberFormat.format(number);

    return format;
}

function showAll(){
    var row = document.getElementById('rowCotizaciones');
    document.getElementById('findMonth').options[0].selected = 'selected';
    document.getElementById('findCotizacion').value = "";
    document.getElementById('findYear').options[0].selected = 'selected';

    while (row.firstChild) {
        row.removeChild(row.firstChild);
    }

    for(var x = 0; x < saleOrders.length; x++){
        var div = document.createElement('div');
        div.classList = "col-lg-1 col-md-2 col-sm-3 col-6 box";
        div.setAttribute('onclick', "openDetail(\""+saleOrders[x]['numPedido']+"\")");
        var inner = document.createElement('div');
        if(saleOrders[x]['numFactura'] != null){
            inner.classList = "inner inner-green";
        }
        else{
            var inner = document.createElement('div');
            inner.classList = "inner inner-red";
        }

        var hcotizacion = document.createElement('h5');
        hcotizacion.innerHTML = " <strong>Cotización <br> </strong> " + saleOrders[x]['cotizacion'];

        var hdate = document.createElement('h5');
        hdate.innerHTML = "<br>" + saleOrders[x]['trandate'];

        var hpedido = document.createElement('h5');
        hpedido.innerHTML = " <strong>Pedido Web <br> </strong> " + saleOrders[x]['idWeb'];

        var himportePedido = document.createElement('h5');
        himportePedido.innerHTML = "<br>" + formatCurrency(saleOrders[x]['importePedido']);

        var hr = document.createElement('hr');

        var hsalesOrder = document.createElement('h5');
        hsalesOrder.innerHTML = " <strong>Sales Order <br> </strong> " + saleOrders[x]['numPedido'];

        var hnumFactura = document.createElement('h5');
        hnumFactura.innerHTML = " <strong>Num Factura <br> </strong> " + saleOrders[x]['numFactura'];

        var hestatus = document.createElement('h5');
        hestatus.innerHTML = " <strong>Estatus:</strong>";

        if(saleOrders[x]['numFactura'] != null){
            var hestatusDesc = document.createElement('h5');
            hestatusDesc.innerHTML = "FACTURADO";
            var indicador = document.createElement('div');
            indicador.classList = "indicador green";
        }
        else if(saleOrders[x]['status'] == "Pending Approval"){
            var hestatusDesc = document.createElement('h5');
            hestatusDesc.innerHTML = "POR APROBAR";
            var indicador = document.createElement('div');
            indicador.classList = "indicador orange";
        }
        else{
            var hestatusDesc = document.createElement('h5');
            hestatusDesc.innerHTML = "PENDIENTE";
            var indicador = document.createElement('div');
            indicador.classList = "indicador red";
        }

        inner.appendChild(hcotizacion);
        inner.appendChild(hdate);
        inner.appendChild(hpedido);
        inner.appendChild(himportePedido);
        inner.appendChild(hr);
        inner.appendChild(hsalesOrder);
        inner.appendChild(hnumFactura);
        inner.appendChild(hestatus);
        inner.appendChild(hestatusDesc);
        inner.appendChild(indicador);

        div.appendChild(inner);
        row.appendChild(div);
    }
}

function openDetail(numPedido){
    $("#tablaDetalle").dataTable().fnClearTable();
    $("#tablaDetalle").dataTable().fnDraw();
    $("#tablaDetalle").dataTable().fnDestroy();
    $('#modalDetail').modal('show');
    document.getElementById('titleModalDetail').innerHTML = '<h3>Estatus Pedido: '+numPedido+'</h3>';
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "RegresaEstadoPedido",
        'type': 'POST',
        'dataType': 'json',
        'data': {id: numPedido},
		'enctype': 'multipart/form-data',
		'timeout': 2*60*60*1000,
		success: function(data){
                if(data==null){
                    document.getElementById("labelWMS").innerHTML = 'WMS';
                    document.getElementById("labelWMS").classList.remove('active');
                    document.getElementById("labelFactura").innerHTML = 'FACTURA';
                    document.getElementById("labelFactura").classList.remove('active');
                    document.getElementById("labelEmbarque").innerHTML = 'EMBARQUE';
                    document.getElementById("labelEmbarque").classList.remove('active');
                }
                else{
                    if(data[0]['wms'] != null){
                        var statusWMS = '';
                        switch(data[0]['wms']){
                            case 0: statusWMS = 'Ingresado'; break;
                            case 1: statusWMS = 'Liberado'; break;
                            case 2: statusWMS = 'Pausado'; break;
                            case 3: statusWMS = 'Cancelado'; break;
                            case 4: statusWMS = 'En Proceso'; break;
                            case 5: statusWMS = 'Surtido'; break;
                            case 6: statusWMS = 'Empacado'; break;
                        }
                        document.getElementById("labelWMS").innerHTML = 'EN ALMACÉN: '+statusWMS;
                        document.getElementById("labelWMS").classList.add('active');
                    }
                    else{
                        document.getElementById("labelWMS").innerHTML = 'WMS';
                        document.getElementById("labelWMS").classList.remove('active');
                    }
                    if(data[0]['factura'] != null && data[0]['factura'] != ''){
                        document.getElementById("labelFactura").innerHTML = 'FACTURADO';
                        document.getElementById("labelFactura").classList.add('active');
                    }
                    else{
                        document.getElementById("labelFactura").innerHTML = 'FACTURA';
                        document.getElementById("labelFactura").classList.remove('active');
                    }
                    if(data[0]['embarque'] != null && data[0]['embarque'] != ''){
                        document.getElementById("labelEmbarque").innerHTML = 'EN EMBARQUE: '+data[0]['embarque'];
                        document.getElementById("labelEmbarque").classList.add('active');
                    }
                    else{
                        document.getElementById("labelEmbarque").innerHTML = 'EMBARQUE';
                        document.getElementById("labelEmbarque").classList.remove('active');
                    }
                }

                getDetalleFacturado(numPedido);
				
		}, 
		error: function(error){
			alert('error');
		 }
	});
}

function noDisponible(img) {
    img.src = 'http://indarweb.dyndns.org:8080/assets/customers/img/jpg/imagen_no_disponible.jpg';
}

function getDetalleFacturado(numPedido){
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "getDetalleFacturado",
        'type': 'POST',
        'dataType': 'json',
        'data': {id: numPedido},
		'enctype': 'multipart/form-data',
		'timeout': 2*60*60*1000,
		success: function(data){
                var body = document.getElementById('saleOrderDetail');
                var sinDetalle = document.getElementById('sinDetalle');
                sinDetalle.innerHTML = '';
                var dataset = [];
                if(data != null){
                    body.style.display = 'block';
                    for(var x = 0; x < data.length; x++){
                        var arr = [];
                        arr.push("<img src='http://indarweb.dyndns.org:8080/assets/articulos/img/01_JPG_CH/" + data[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_CH.jpg' height='auto' onclick='verImagenProducto(\"" + data[x]['itemid'] + "\")' class='img-item' onerror='noDisponible(this)'/>");
                        arr.push("<p style='display: inline;'>"+data[x]['itemid']+"</p>");
                        arr.push(data[0]['cantPedido']);
                        arr.push(data[0]['cantEmpacada']);
                        data[0]['cantFacturada'] != '' ? arr.push(data[0]['cantFacturada']) : arr.push('<p style="display: inline; margin-left: 20px;"><i class="fas fa-times" style="margin-right: 10px; color: red;"></i><strong>Sin Factura </strong></p>');
                        // var row = document.createElement('div');
                        // row.setAttribute('class', 'row d-flex align-items-center');
                        // row.setAttribute('style', 'height: 80px; margin-bottom: 0 !important;');
                        // var div = document.createElement('div');
                        // div.setAttribute('class', 'col-4 d-flex align-items-center h-100');
                        // div.setAttribute('style', 'border-right: 1px solid #0000005e;');
                        // var div2 = document.createElement('div');
                        // div2.setAttribute('class', 'col-8 d-flex justify-content-start align-items-center h-100');
                        // var innerItem = "<br><img src='http://indarweb.dyndns.org:8080/assets/articulos/img/01_JPG_CH/" + data[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_CH.jpg' height='auto' onclick='verImagenProducto(\"" + data[x]['itemid'] + "\")' class='img-item' onerror='noDisponible(this)'/><p style='display: inline;'>"+data[x]['itemid']+"</p>";
                        // var innerDetail = '';
                        // innerDetail += '<p style="display: inline; margin-left: 20px;"><i class="fas fa-shopping-bag" style="margin-right: 10px; color:#002868;"></i><strong>Pedido: </strong>'+data[0]['cantPedido']+'</p>'
                        // innerDetail += '<p style="display: inline; margin-left: 20px;"><i class="fas fa-shipping-fast" style="margin-right: 10px; color:#002868;"></i><strong>Empacado: </strong>'+data[0]['cantEmpacada']+'</p>'
                        // data[0]['cantFacturada'] != '' ? innerDetail += '<p style="display: inline; margin-left: 20px;"><i class="fas fa-file-invoice" style="margin-right: 10px; color:#002868;"></i><strong>Facturado: </strong>'+data[0]['cantFacturada']+'</p>' : innerDetail += '<p style="display: inline; margin-left: 20px;"><i class="fas fa-times" style="margin-right: 10px; color: red;"></i><strong>Sin Factura </strong></p>' ;
                        // div.innerHTML = innerItem;
                        // div2.innerHTML = innerDetail;
                        // row.appendChild(div);
                        // row.appendChild(div2);
                        // body.appendChild(row);
                        dataset.push(arr);
                    }  
                    var table = $("#tablaDetalle").DataTable({
                        data: dataset,
                        pageLength : 5,
                        deferRender: true,
                        lengthMenu: [[5, 10, 20, 100], [5, 10, 20, 100]],
                        "initComplete": function (settings, json) {  
                            $("#tablaInventario").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        },
                        'columnDefs': [
                            {"targets": 0,"className": "td-center"},
                            {"targets": 1,"className": "td-center"},
                            {"targets": 2,"className": "td-center"},
                            {"targets": 3,"className": "td-center"},
                            {"targets": 4,"className": "td-center"}
                         ]
                    });
                }
                else{
                    body.style.display = 'none';
                    var row = document.createElement('div');
                    row.setAttribute('class', 'row d-flex align-items-center justify-content-center');
                    row.setAttribute('style', 'height: 80px; margin-bottom: 0 !important;');
                    var div = document.createElement('div');
                    div.setAttribute('class', 'col-12 d-flex align-items-center justify-content-center h-100');
                    var innerDetail = "<h3 style='display: inline;'>Sin Detalle</h3>";
                    div.innerHTML = innerDetail;
                    row.appendChild(div);
                    sinDetalle.appendChild(row);
                }
                
                

              
		}, 
		error: function(error){
			alert('error');
		 }
	});
}

function verImagenProducto(itemid){
    var src = "http://indarweb.dyndns.org:8080/assets/articulos/img/02_JPG_MD/" + itemid.replaceAll(" ", "_").replaceAll("-", "_") + "_MD.jpg";
    document.getElementById('containerImgProduct').style.display = 'flex';
    document.getElementById('imgProductMD').src = src;
}

function closeImgProductMD(){
    document.getElementById('containerImgProduct').style.display = 'none';
}