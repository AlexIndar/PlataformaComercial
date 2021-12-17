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
                  console.log(error);
             }
    
        }); 

        var today = new Date();
        var hour =  today.getHours();
        var suffix = hour >= 12 ? "PM":"AM";
        var hours = ("0"+(hour + 11) % 12 + 1).slice(-2) +":"+("0"+today.getMinutes()).slice(-2)+" " + suffix;
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
        }
    });


    // FILTRO POR MES ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $('#findMonth').on('change', function() {
        var mes = this.value;
        var mesText = this.options[mes].text;
        var row = document.getElementById('rowCotizaciones');
        document.getElementById('findCotizacion').value = "";


        while (row.firstChild) {
            row.removeChild(row.firstChild);
        }




        if(mes == "all"){ // -------------------------------------------------------------------------------- MOSTRAR TODAS LAS COTIZACIONES ------------------------------------------------------------------------------------
           showAll();
        }
        else{ //----------------------------------------------------------------------------------------------- MOSTRAR UNICAMENTE LO QUE COINCIDA CON LA COTIZACION --------------------------------------------------------------------------------------------------------------------------------
            var cont = 0;
            for(var x = 0; x < saleOrders.length; x++){
                if(saleOrders[x].trandate.split('/')[1]==mes){
                    cont ++;
                    var div = document.createElement('div');
                    div.classList = "col-lg-1 col-md-2 col-sm-3 col-6 box";
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
                h4.innerHTML = "<br><br> No se encontraron pedidos del mes de "+mesText;

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
                  console.log(error);
             }
    
        }); 

        var today = new Date();
        var hour =  today.getHours();
        var suffix = hour >= 12 ? "PM":"AM";
        var hours = ("0"+(hour + 11) % 12 + 1).slice(-2) +":"+("0"+today.getMinutes()).slice(-2)+" " + suffix;
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
    console.log(number);
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