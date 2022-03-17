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
                               <table id="comisionesTable" class="table table-striped table-bordered table-hover" style="width:100% ; font-size:63% ;font-weight: bold ">
                                  <thead style="background-color:#002868; color:white">
                                   <tr>
                                        <th id="headerMes" class="text-center" style="font-size:15px " colspan =16  >  </th>
                                    </tr>
                                     <tr >
                                        <th>Concepto</th>
                                        <th>Reci bida en el Mes con IVA</th>
                                        <th>Pagada en el Mes sin IVA</th>
                                        <th>Pendiente Saldar Mes Anterior sin IVA</th>
                                        <th>Pendiente Saldar Este Mes sin IVA</th>
                                        <th>Saldada en el Mes sin IVA</th>
                                     </tr>
                                  </thead>
                                  <tbody id="llenaTable">
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
document.getElementById("headerMes").innerHTML = ' COBRANZA '+month.toUpperCase()+' '+año;
$.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/comisiones/getInfoCobranzaZonaWeb",
        'type': 'GET',
        'dataType': 'json',
        'data': {referencia:id, fecha : date},
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

                        for (i = 0; i < data.length; i++) {

                            sumaRMCI= sumaRMCI + data[i].recibo_mes_actual;
                            sumaRMSI = sumaRMSI + data[i].recibo_mes_actual_siniva;
                            sumaPSMASI = sumaPSMASI + data[i].pendiente_saldar_mes_anteriorl_siniva;
                            sumaPSEMSI = sumaPSEMSI + data[i].pendiente_saldar_mes_actual;
                            sumaSMSI = sumaSMSI + data[i].saldada_mes_actual_siniva;

                        }

                        if(html == ''){
                            html += '<tr>' +
                            '<td style="font-weight: bold"> Cobranza </td>' +
                            '<td style="font-weight: bold">' +  sumaRMCI.toLocaleString('es-MX') + '</td>' +
                            '<td style="font-weight: bold">' +  sumaRMSI.toLocaleString('es-MX') + '</td>' +
                            '<td style="font-weight: bold">' +  sumaPSMASI.toLocaleString('es-MX') + '</td>' +
                            '<td style="font-weight: bold">' + sumaPSEMSI.toLocaleString('es-MX') + '</td>' +
                            '<td style="font-weight: bold">' + sumaRMSI.toLocaleString('es-MX') + '</td>' +
                            '</tr>';
                           $('#llenaTable').html(html);
                           //console.log(html);
                        /*    document.getElementById("divClientes").style.display = "none";
                           document.getElementById("divDetalle").style.display = "block";
                           document.getElementById("divFiltroCli").style.display = "none"; */

                            /* $('#companyname').text(data[0].companyname);
                           $('#companyid').text(data[0].companyid);
                           document.getElementById("companyname").style.display = "block";
                           document.getElementById("companyid").style.display = "block"; */
                           //console.log(sumaRMSI);
                           $('#comisionesTable').dataTable( {
                                dom : 'Brt',
                                ordering: false,
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
            console.log("Error");
            alert('Error, Tiempo de espera agotado');
        }
    });
}


</script>
@endsection
