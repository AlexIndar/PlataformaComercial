@extends('layouts.intranet.main', ['active' =>'Comisiones', 'permissions' => $permissions])

@section('title') Indar | Comisiones @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection

@section('body')
<div id = "hidde" class="content-wrapper" style="min-height: 2128.12px;">
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h5 class="m-0">Comisiones | General </h5>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Comisiones</a></li>
                </ol>
             </div>
                <div class="col-sm-6">
                   <h6 id="companyname" class="m-0"></h6>
                   <h6 id="companyid" class="m-0"></h6>
                </div>
          </div>
       </div>
    </div>
    <div class="content">
       <div class="container-fluid">
          <div class="row">
             <div class="col-lg-12">
                <div class="card">
                   <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                         {{-- <h3 class="card-title">Seleccione una zona</h3> --}}
                      </div>
                   </div>
                   <div  id="divFiltroCli" class="card-body">
                    <div class="col-lg-12">
                        <div class="row ">
                            <div class="col-sm-4">
                                <select name="zonas"  class="form-control js-example-basic-single" id="zonas"></select>
                            </div>
                            <div class="col-sm-4">
                                <input type="month" name="fechaCliente" id="fechaCliente" class="form-control" value="<?php echo date("Y-m");?>" max = "<?php echo date("Y-m");?>">
                            </div>
                            <div class="col-md-4">
                                    <div class="spinner-border text-secondary" style="display:none" id="btnSpinner" ></div>
                                    <button type="submit" class="btn btn-primary mb-3" style="background-color:#002868" style="display: block" onclick="consultar()" id="btnConsultar">Consultar </button>
                            </div>
                         </div>
                     </div>
                    </div>
                    <div id="divClientes" style="display: block" class="card-body">
                        <div class="col-lg-12">
                            <div class="card-body table-responsive p-0">
                               <table id="comisionesTable" class="table table-striped table-bordered table-hover" style="width:100% ; font-size:60% ;font-weight: bold ">
                                  <thead style="background-color:#002868; color:white">
                                   <tr>
                                        <th id="headerMes" class="text-center" style="font-size:15px " colspan =16  >  </th>
                                    </tr>
                                     <tr >
                                        <th>Id</th>
                                        <th>Cliente</th>
                                        <th>Recibida en el mes con IVA</th>
                                        <th>Pagada en el mes sin IVA</th>
                                        <th>Pendiente Saldar mes anterior sin IVA</th>
                                        <th>Pendiente de saldar este mes sin IVA</th>
                                        <th>Sal dada en el mes sin IVA</th>
                                        <th>Cobranza de 0 a 30 dias</th>
                                        <th>Cobranza de 31 a 60 dias</th>
                                        <th>Cobranza de 61 a 90 dias</th>
                                        <th>Cobranza + de 90 dias</th>
                                        <th>Desc Neg</th>
                                        <th>Desc. Fuera de Tiempo (Neto a Des contar)</th>
                                        <th>Nota de Credito por Incobra bilidad</th>
                                        <th>Incobra bilidad (Neto a Des contar)</th>
                                        <th>Comisión Base</th>
                                     </tr>
                                  </thead>
                                  <tbody id="llenaTable">
                                  </tbody>
                               </table>
                            </div>
                         </div>
                    </div>
                    <div id='divDetalle' style="display: none"  class="card-body">
                        <div class="col-lg-12">
                           <div class="row ">
                            <div class="col-md-2">
                              <button class="btn btn-primary " style="background-color:#002868" onclick="regresar()">  <i class="fas fa-arrow-left"></i></button>
                            </div>
                            </div>
                            <br>
                            <div class="card-body table-responsive p-0">
                               <table id="comisionesDetalle" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:63%">
                                  <thead style="background-color:#002868; color:white">
                                   <tr>
                                        <th id="headerMesDetalle" class="text-center" style="font-size:15px " colspan =16  >  </th>
                                    </tr>
                                     <tr>
                                        <th>Documento</th>
                                        <th>Reci bida en el Mes con IVA</th>
                                        <th>Pagada en el Mes sin IVA</th>
                                        <th>Pendiente Saldar Mes Anterior sin IVA</th>
                                        <th>Pendiente Saldar Este Mes sin IVA</th>
                                        <th>Saldada en el Mes sin IVA</th>
                                        <th>Fecha Factura</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>Fecha Saldada</th>
                                        <th>Días</th>
                                        <th>Importe Factura</th>
                                        <th>Saldo</th>
                                        <th>Dif. en Precio</th>
                                        <th>Desc. Fuera de Tiempo</th>
                                        <th>Incob.</th>
                                        <th>Comis. Base</th>
                                     </tr>
                                  </thead>
                                  <tbody id="llenaDetalle">

                                  </tbody>

                               </table>
                            </div>
                         </div>
                        </div>
                </div>
             </div>

          </div>
       </div>
    </div>
</div>
@endsection

@section('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {

    //Collapse sideBar
    $("body").addClass("sidebar-collapse");
    //Recibe Json
    var zonas = JSON.parse({!! json_encode($zonas) !!});
    //console.log(zonas);
    //Llena select zonas
    $('.js-example-basic-single').select2();

    //Llena select Clientes
    var $selectZonas = $('#zonas');
    $.each(zonas, function(id, name) {
        $selectZonas.append('<option value='+name.zona+'>'+name.zona+'</option>');
    });


    //Inicia Ajax
    $(document).ajaxStart(function() {
        document.getElementById("btnSpinner").style.display = "block";
        document.getElementById("btnConsultar").style.display = "none";
    });

    //Func Termina Ajax
    $(document).ajaxStop(function() {
        //Esconde y muestra DIVISORES
        document.getElementById("btnSpinner").style.display = "none";
        document.getElementById("btnConsultar").style.display = "block";
    } );

});
function consultar() {
    $.fn.dataTable.ext.errMode = 'none';
$("#comisionesTable").dataTable().fnDestroy();
$("#comisionesDetalle").dataTable().fnDestroy();

var id = document.getElementById("zonas").value;
var pfecha = document.getElementById("fechaCliente").value;
var mes = pfecha.slice(5,7);
var año = pfecha.slice(0,4);
var date = mes+'-01-'+año;
var dateprueba = new Date(año, mes-1, 01);  // 2009-11-10
var month = dateprueba.toLocaleString('default', { month: 'long' });
document.getElementById("headerMes").innerHTML = month.toUpperCase()+' '+año;
$.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/comisiones/getInfoCobranzaZonaWeb",
        'type': 'GET',
        'dataType': 'json',
        'data': {referencia:id, fecha : date},
        'enctype': 'multipart/form-data',
        'timeout': 8 * 60 * 60 * 1000,
        success: function(data){
            //var o= JSON.parse(data);
            var rawtData = data;
            var groupBy = function (miarray, prop) {
               return miarray.reduce(function(groups, item) {
                   var val = item[prop];
                   groups[val] = groups[val] || {companyid: item.companyid, companyname: item.companyname,recibo_mes_actual: 0,recibo_mes_actual_siniva: 0,pendiente_saldar_mes_anteriorl_siniva: 0,pendiente_saldar_mes_actual: 0,saldada_mes_actual_siniva: 0,de0a30: 0,de31a60: 0,de61a90: 0,de91oMayor: 0,diferencias_precio: 0,descuento_fuera_tiempo: 0,incobrabilidad: 0, incobrabilidadADescontar: 0, descneg: 0, comision_base: 0};
                   groups[val].recibo_mes_actual += item.recibo_mes_actual;
                   groups[val].recibo_mes_actual_siniva += item.recibo_mes_actual_siniva;
                   groups[val].pendiente_saldar_mes_anteriorl_siniva += item.pendiente_saldar_mes_anteriorl_siniva;
                   groups[val].pendiente_saldar_mes_actual += item.pendiente_saldar_mes_actual;
                   groups[val].saldada_mes_actual_siniva += item.saldada_mes_actual_siniva;
                   groups[val].de0a30 += item.de0a30;
                   groups[val].de31a60 += item.de31a60;
                   groups[val].de61a90 += item.de61a90;
                   groups[val].de91oMayor += item.de91oMayor;
                   groups[val].diferencias_precio += item.diferencias_precio;
                   groups[val].descuento_fuera_tiempo += item.descuento_fuera_tiempo;
                   groups[val].incobrabilidadADescontar += item.incobrabilidadADescontar;
                   groups[val].incobrabilidad += item.incobrabilidad;
                   groups[val].descneg += item.descneg;
                   groups[val].comision_base +=  item.comision_base;

                   return groups;
               }, {});
            }
            //console.log(groupBy(rawtData,'companyname'));
            var resultData = Object.values(groupBy(rawtData,'companyid'));
            console.log(resultData);
            var table = $('#comisionesTable').dataTable( {
                dom : 'Brtip',
                paging: false,
                fixedHeader:true,
                scrollY:500,
                scrollX: true,
                scrollCollapse: true,
                responsive: true,
                data : resultData,
                columnDefs: [
                                {
                                  targets: [2,3,4,5,6,7,8,9,10,11,12,13,14,15,],
                                  render:$.fn.dataTable.render.number(',', '.', 2)
                                },
                                {
                                  targets: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,],
                                  orderable: false,
                                },
                ],
                order: [[1,'asc']],
                buttons: [
                    {
                extend:    'excel',
                text:      'Descargar &nbsp <i class="fas fa-file-excel"></i>',
                titleAttr: 'Descargar Excel'
            }
                ],
                initComplete: function () {
                var btns = $('.dt-button');
                btns.addClass('btn btn-success ');
                btns.removeClass('dt-button');

                },
                columns: [  //or different depending on the structure of the object
                { "data": "companyid"},
                { "data": "companyname" },
                { "data": "recibo_mes_actual"},
                { "data": "recibo_mes_actual_siniva" },
                { "data": "pendiente_saldar_mes_anteriorl_siniva" },
                { "data": "pendiente_saldar_mes_anteriorl_siniva" },/* "saldada_mes_actual_siniva" */
                { "data": "recibo_mes_actual_siniva" },
                { "data": "de0a30" },
                { "data": "de31a60" },
                { "data": "de61a90" },
                { "data": "de91oMayor" },
                { "data" : "descneg" },
                { "data": "descuento_fuera_tiempo" },
                { "data": "incobrabilidadADescontar" },
                { "data": "incobrabilidad" },
                { "data": "comision_base" }
                ],

            });

            $('#comisionesTable tbody').on('click', 'tr', function () {
                //$(this).toggleClass('select');
                var row = table.api().row(this).data();
                //console.log(row['companyid']);
                var id = row['companyid'];
                console.log(date) ;
                document.getElementById("headerMesDetalle").innerHTML = month.toUpperCase()+' '+año;

               $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url': "/comisiones/getInfoCobranzaZonaWeb",
                    'type': 'GET',
                    'dataType': 'json',
                    'data': {referencia:id, fecha: date},
                    'enctype': 'multipart/form-data',
                    'timeout': 4 * 60 * 60 * 1000,
                    success: function(data){
                        var html = '';
                        var i;
                        var sumaRMCI = 0;
                        var sumaRMSI = 0;
                        var sumaPSMASI = 0;
                        var sumaPSEMSI = 0;
                        var sumaSMSI = 0;
                        var sumaIFac = 0;
                        var sumaSaldo= 0;
                        var sumaCB = 0;
                        var sumaInc =0;

                        for (i = 0; i < data.length; i++) {

                            sumaRMCI= sumaRMCI + data[i].recibo_mes_actual;
                            sumaRMSI = sumaRMSI + data[i].recibo_mes_actual_siniva;
                            sumaPSMASI = sumaPSMASI + data[i].pendiente_saldar_mes_anteriorl_siniva;
                            sumaPSEMSI = sumaPSEMSI + data[i].pendiente_saldar_mes_actual;
                            sumaSMSI = sumaSMSI + data[i].saldada_mes_actual_siniva;
                            sumaIFac = sumaIFac + data[i].importe_factura;
                            sumaSaldo = sumaSaldo + data[i].saldo;
                            sumaCB = sumaCB + data[i].comision_base;
                            sumaInc = sumaInc + data[i].incobrabilidad;

                            var fechaFact = moment(new Date(data[i].fechaFactura)).format('DD/MM/YYYY');
                            var fechaDue = moment(new Date(data[i].dueDate)).format('DD/MM/YYYY');
                            var fechaSaldada = data[i].fecha_saldada.slice(0, 10);
                            var recibo_mes_actual = data[i].recibo_mes_actual.toLocaleString('es-MX');
                            var recibo_mes_actual_siniva = data[i].recibo_mes_actual_siniva.toLocaleString('es-MX');
                            var pendiente_saldar_mes_anteriorl_siniva = data[i].pendiente_saldar_mes_anteriorl_siniva.toLocaleString('es-MX');
                            var saldada_mes_actual_siniva = data[i].saldada_mes_actual_siniva.toLocaleString('es-MX');
                            var pendiente_saldar_mes_actual = data[i].pendiente_saldar_mes_actual.toLocaleString('es-MX');
                            var importe_factura = data[i].importe_factura.toLocaleString('es-MX');
                            var incobrabilidad = data[i].incobrabilidad.toLocaleString('es-MX');
                            var comisionBase = data[i].comision_base.toLocaleString('es-MX', {maximumFractionDigits: 2});

                            if (data[i].saldo > 0 &&  comisionBase == 0){
                                html += '<tr>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].tranid+ '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  recibo_mes_actual + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  recibo_mes_actual_siniva + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + pendiente_saldar_mes_anteriorl_siniva + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + saldada_mes_actual_siniva + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + pendiente_saldar_mes_actual + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + fechaFact + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + fechaDue + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + fechaSaldada + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].diasDiferencia + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + importe_factura + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].saldo+ '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].diferencias_precio+ '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].descuento_fuera_tiempo+ '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].incobrabilidad+ '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + comisionBase + '</td>' +
                            '</tr>';
                            }else{
                            html += '<tr>' +
                            '<td style="font-weight: bold">' + data[i].tranid+ '</td>' +
                            '<td style="font-weight: bold">' +  recibo_mes_actual + '</td>' +
                            '<td style="font-weight: bold">' +  recibo_mes_actual_siniva + '</td>' +
                            '<td style="font-weight: bold">' + pendiente_saldar_mes_anteriorl_siniva + '</td>' +
                            '<td style="font-weight: bold">' + saldada_mes_actual_siniva + '</td>' +
                            '<td style="font-weight: bold">' + pendiente_saldar_mes_actual + '</td>' +
                            '<td style="font-weight: bold">' + fechaFact + '</td>' +
                            '<td style="font-weight: bold">' + fechaDue + '</td>' +
                            '<td style="font-weight: bold">' + fechaSaldada + '</td>' +
                            '<td style="font-weight: bold">' + data[i].diasDiferencia + '</td>' +
                            '<td style="font-weight: bold">' + importe_factura + '</td>' +
                            '<td style="font-weight: bold">' + data[i].saldo+ '</td>' +
                            '<td style="font-weight: bold">' + data[i].diferencias_precio+ '</td>' +
                            '<td style="font-weight: bold">' + data[i].descuento_fuera_tiempo+ '</td>' +
                            '<td style="font-weight: bold">' + incobrabilidad+ '</td>' +
                            '<td style="font-weight: bold">' + comisionBase + '</td>' +
                            '</tr>';
                            }
                        }

                        if(html !== ''){
                            html +=
                            '<td style="font-weight: bold; background-color:#7fffbf">Total</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaRMCI.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaRMSI.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaPSMASI.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaSMSI.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaPSEMSI.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">NA</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">NA</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">NA</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf"> </td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaIFac.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaSaldo.toLocaleString('es-MX')+'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">0</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">0</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+ sumaInc.toLocaleString('es-MX') +'</td>'+
                            '<td style="font-weight: bold; background-color:#7fffbf">'+sumaCB.toLocaleString('es-MX')+'</td>';
                           $('#llenaDetalle').html(html);
                           //console.log(html);
                           document.getElementById("divClientes").style.display = "none";
                           document.getElementById("divDetalle").style.display = "block";
                           document.getElementById("divFiltroCli").style.display = "none";

                            $('#companyname').text(data[0].companyname);
                           $('#companyid').text(data[0].companyid);
                           document.getElementById("companyname").style.display = "block";
                           document.getElementById("companyid").style.display = "block";
                           //console.log(sumaRMSI);
                           $('#comisionesDetalle').dataTable( {
                                dom : 'Brtip',
                                paging:false,
                                fixedHeader:true,
                                ordering: false,
                                scrollY:320,
                                scrollX: true,
                                scrollCollapse: true,

                                buttons: [
                                    {
                                        extend:    'excel',
                                        text:      'Descargar &nbsp <i class="fas fa-file-excel"></i>',
                                        titleAttr: 'Descargar Excel'
                                    }
                                ],
                                initComplete: function () {
                                var btns = $('.dt-button');
                                btns.addClass('btn btn-success ');
                                btns.removeClass('dt-button');

                                },

                            });
                        }

                    },
                    error: function() {
                        console.log("Error ajax dentro");
                    }
                });

            } );

        },
        error: function() {
            console.log("Error");
            alert('Error, Tiempo de espera agotado');
        }
    });
}
function regresar(){
    $("#comisionesDetalle").dataTable().fnDestroy();
    document.getElementById("divClientes").style.display = "block";
    document.getElementById("divDetalle").style.display = "none";
    document.getElementById("divFiltroCli").style.display = "block";
    document.getElementById("companyname").style.display = "none";
    document.getElementById("companyid").style.display = "none";
}

</script>
@endsection
