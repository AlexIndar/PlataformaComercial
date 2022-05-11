@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | Información General @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection

@section('body')
<div class="content-wrapper" style="min-height: 316px;">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
         </div>
      </div>
   </div>
   <section class="content">
    <div class="container-fluid">
       <div class="row">
          <div class="col-12">
             <div class="invoice p-3 mb-3">
                <div class="row">
                   <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i> Clientes | Información General
                        <small class="float-right"><?php echo "Fecha :  " . date("d/m/Y") . "<br>"; ?></small>
                    </h4>
                   </div>
                </div>
                <br>
                <div class="row invoice-info">
                   <div class="col-sm-4 invoice-col">
                    <strong>Info del Cliente </strong>
                    <input type="text" hidden id="cliente" value="{{ $general->companyid  }}">
                      <address>
                        {{ $general->companyname }} <br>
                        Código : {{ $general->companyid }}  <br>
                        Zona : {{ $general->zona }} <br>
                        Antiguedad : {{ substr($general->antiguedad,-19,10)}} <br>
                        CP : {{ $general->zipCode }}
                      </address>
                   </div>
                   <div class="col-sm-4 invoice-col">
                   <br>
                    RFC : {{ $general->rfc }} <br>
                    Dirección : {{ $general->address }} , {{ $general->estado }} <br>
                    Ciudad : {{ $general->ciudad }}  <br>
                    Telefono : {{ $general->phone }}<br>
                    <b> Categoría :</b> {{ $general->clasificacionActual }} <br>
                 </div>
                </div>
                <hr>
                <div class="row invoice-info">
                    <div class="col-sm-12 invoice-col ">
                        <p class="lead "> <b> Cuentas Por Pagar y Crédito </b></p>
                    </div>
                    <div class="col-sm-7 invoice-col">
                        <strong>Saldo</strong><br>
                        <b>Total de Crédito:</b> <span style="font-size: 15px" class="badge badge-primary">$ {{ number_format($general->creditLimit,2) }}</span>  <b>Días de Crédito : {{ $general->diasCredito }}</b><br>
                        <table id="creditTable" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:73%">
                           <thead style="background-color:#002868; color:white">
                              <tr>
                                 <th>Credito Usado</th>
                                 <th>Vencido 1-30 Días</th>
                                 <th>Vencido 31-60 Días</th>
                                 <th>Vencido 61-90 Días</th>
                                 <th>Vencido Más de 90 Días</th>
                              </tr>
                           </thead>
                           <tbody id="">
                            <tr>
                                <td><span style="font-size: 15px" class="badge badge-warning">$ {{ number_format($general->saldo,2) }}</span></td>
                                <td><span style="font-size: 15px" class="badge badge-warning">$ {{ number_format($general->de0a30,2) }}</span></td>
                                <td><span style="font-size: 15px" class="badge badge-warning">$ {{ number_format($general->de31a60,2) }}</span></td>
                                <td><span style="font-size: 15px" class="badge badge-warning">$ {{ number_format($general->de61a90,2) }}</span></td>
                                <td><span style="font-size: 15px" class="badge badge-warning">$ {{ number_format($general->mayor90,2) }}</span></td>
                            </tr>
                           </tbody>

                        </table>

                       {{--  @if( $general->saldo <= 0)
                        Total : <span style="font-size: 15px" class="badge badge-danger">$ {{   number_format(str_replace("-","",$general->saldo),2) }}</span><br>
                        @else
                        Total : <span style="font-size: 15px" class="badge badge-primary">$ {{  number_format($general->saldo,2) }}</span><br>
                        @endif --}}
                        Total Vencido : <span style="font-size: 15px" class="badge badge-danger">$ {{ number_format($general->saldo,2) }}</span><br>
                        Referencia Bancaria: {{ $general->referenciaBancaria }} <br>

                     </div>
                    <div class="col-sm-5   invoice-col">
                    <strong>Estado de Cuenta </strong><br><br>
                    Seleccione Un Rango de Fechas: <br>
                    <div class="input-group">
                        <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                        </span>
                        <input type="text" class="form-control float-right" id="edoCuenta">
                        <a href="#" target="_blank"><button  class="btn btn-primary"  id="btnConsultar">Estado de Cuenta </button></a>&nbsp;
                        <button  class="btn btn-success"  id="btnPagar">Ir a Pagar </button>
                    </div>
                  </div>
                 </div>
                 <hr>
                <div class="row">
                    <div class="col-sm-12 invoice-col ">
                        <p class="lead "> <b> Contacto INDAR </b></p>
                    </div>
                    <div class="col-md-12 card-body table-responsive p-0">
                        <table id="comisionesDetalle" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:76%">
                           <thead style="background-color:#002868; color:white">
                              <tr>
                                 <th>Área</th>
                                 <th>Nombre</th>
                                 <th>Telefono</th>
                                 <th>E-mail</th>
                              </tr>
                           </thead>
                           <tbody id="">
                            <tr>
                                <td>Representante</td>
                                <td>{{ $general->nombrE_REPRESENTANTE }}</td>
                                <td>{{ $general->telefonO_REPRESENTANTE }}</td>
                                <td>{{ $general->emaiL_REPRESENTANTE }}</td>
                            </tr>
                            <tr>
                                <td>Crédito y Cobranza</td>
                                <td>{{ $general->nombrE_AUXCOBRANZA }}</td>
                                <td>{{ $general->telefonO_AUXCOBRANZA }}</td>
                                <td>{{ $general->emaiL_AUXCOBRANZA }}</td>
                            </tr>
                            <tr>
                                <td>Apoyo de Ventas</td>
                                <td>{{ $general->nombrE_APOYOVENTAS }}</td>
                                <td>{{ $general->telefonO_APOYOVENTAS }}</td>
                                <td>{{ $general->emaiL_APOYOVENTAS }}</td>
                            </tr>
                            <tr>
                                <td>Post Venta</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                           </tbody>

                        </table>
                     </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 invoice-col ">
                        <p class="lead "> <b> Cuentas Bancarias para Depósito </b></p>
                    </div>
                    <div class="card-body col-md-12 table-responsive p-0">
                        <table id="comisionesDetalle" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:76%">
                           <thead style="background-color:#002868; color:white">
                            <tr>
                                <th  style="background-color:#073d92c5; font-size : 17px " class="text-center" colspan="3">
                                    Referencia : {{ $general->referenciaBancaria }}
                                </th>
                            </tr>
                              <tr>
                                 <th>Banco</th>
                                 <th>Cuenta</th>
                                 <th>CLABE</th>
                              </tr>
                           </thead>
                           <tbody id="">
                            <tr>
                                <td>BBVA</td>
                                <td>Convenio CIE: 806161</td>
                                <td>012 320 00133687449 9</td>
                            </tr>
                            <tr>
                                <td>BANORTE</td>
                                <td>Convenio CEP: 51928</td>
                                <td>072 320 00020039981 8</td>
                            </tr>
                            <tr>
                                <td>Santander</td>
                                <td>65-500776517</td>
                                <td>014 320 65500776517 1</td>
                            </tr>
                            <tr>
                                <td>HSBC</td>
                                <td>Cuenta RAP: 2290</td>
                                <td>021 320 04050561075 3</td>
                            </tr>
                            <tr>
                                <td>BANAMEX</td>
                                <td>110-1613905</td>
                                <td>002 320 01101613905 6</td>
                            </tr>
                           </tbody>
                        </table>
                     </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 invoice-col ">
                        <p class="lead "> <b>Estatus de Compras </b></p>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table id="comisionesDetalle" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:73%">
                           <thead style="background-color:#002868; color:white">
                              <tr>
                                 <th>Movimiento</th>
                                 <th>Fecha </th>
                                 <th>Pedidos Pendientes</th>
                                 <th>WMS Ingresado</th>
                                 <th>WMS Surtido</th>
                                 <th>WMS Consolidado</th>
                                 <th>Compras de Hoy </th>
                                 <th>Embarques Por Enviar</th>
                                 <th>Embarques en Transito</th>
                                 <th>Embarques por Confirmar</th>
                              </tr>
                           </thead>
                           <tbody id="">

                           </tbody>

                        </table>
                     </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 invoice-col ">
                        <p class="lead "> <b> Nivel de Servicio </b></p>
                    </div>
                    <div class="col-md-12 card-body table-responsive p-0">
                        <table id="comisionesDetalle" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:76%">
                           <thead style="background-color:#002868; color:white">
                              <tr>
                                 <th>Concepto </th>
                                 <th>Abril 2022</th>
                                 <th>Marzo 2022</th>
                                 <th>Febrero 2022</th>
                                 <th>Enero 2022</th>
                                <th>Diciembre 2021</th>
                                <th>Noviembre 2021</th>
                              </tr>
                           </thead>
                           <tbody id="">
                            <tr>
                                <td>Nivel de Servicio a Primera Factura</td>
                                <td>%</td>
                                <td>%</td>
                                <td>%</td>
                                <td>%</td>
                                <td>%</td>
                                <td>%</td>
                            </tr>
                            <tr>
                                <td>Tiempo de Entrega entre captura y recepción</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                            </tr>
                            <tr>
                                <td>Tiempo de Solución en Folios de Calidad</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                                <td>00</td>
                            </tr>

                           </tbody>

                        </table>
                     </div>

                </div>
                <hr>
                <div class="row">
                    <p class="lead text-center"><b>Histórico de Compras</b></p>
                    <div class="card-body table-responsive p-0">
                        <table id="comisionesDetalle" class="table table-striped table-bordered table-hover comisionesDeta" style="width:100% ; font-size:73%">
                           <thead style="background-color:#002868; color:white">
                            <tr  style="background-color:#002868; color:white">
                            <th style="background-color:#002868; color:white" colspan="6">Ejercicio Anterior 2021</th>
                            <th style="background-color:#002868; color:white" colspan="12">Ejercicio Actual 2022</th>
                            </tr>
                              <tr>
                                 <th>Mes</th>
                                 <th>Trim Feb-Abr </th>
                                 <th>Trim May-Jul</th>
                                 <th>Trim Ago-Oct</th>
                                 <th>Trim Nov-Ene</th>
                                 <th>Total</th>
                                 <th>Trim Feb-Abr </th>
                                 <th>% Crec. </th>
                                 <th>Trim May-Jul</th>
                                 <th>% Crec. </th>
                                 <th>Trim Ago-Oct</th>
                                 <th>% Crec. </th>
                                 <th>Trim Nov-Ene</th>
                                 <th>% Crec. </th>
                                 <th>Acumu lado</th>
                                 <th>% Crec</th>
                              </tr>
                           </thead>
                           <tbody id="">

                           </tbody>

                        </table>
                     </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
</div>
@endsection

@section('js')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

$('#edoCuenta').daterangepicker();
var cliente =  document.getElementById("cliente").value;
$("#btnPagar").click(function(){
   var fechaini =  $('#edoCuenta').data('daterangepicker').startDate.format('MM-DD-YYYY');
   var fechafin =  $('#edoCuenta').data('daterangepicker').endDate.format('MM-DD-YYYY');
window.location.href = "pagoEnLinea/"+cliente+"/"+fechaini+"/"+fechafin;
});


});

</script>
@endsection
