@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | Pago en Línea @endsection

@section('styles')
<style>@media print {
    .modal-dialog {
      max-width: 100%;
      width: 100%;
    }
  }</style>
<link rel="stylesheet" href="{{ asset('assets/customers/css/pagoEnLinea/pagos.css') }}">
<link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


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
                        <i class="fas fa-globe"></i> Clientes | Pago en Linea
                        <small class="float-right"><?php echo "Fecha :  " . date("d/m/Y") . "<br>"; ?></small>
                    </h4>
                   </div>
                </div>
                <div class="row invoice-info">
                   <div class="col-sm-6 invoice-col">
                       @if($data === [])
                      <h1 style="color: red"><u>NO TIENE FACTURAS PENDIENTES DE PAGO!</u></h1>
                       @else
                       @foreach ($data as $value )
                       @endforeach
                       <address>
                        ID.Cliente :{{ $value->companyname }}  <br>
                        Zona : {{ $value->zona }}<br>
                        Código Cte : {{ $value->companyid }}
                      </address>
                      @endif
                   </div>
                </div>
                <div class="row">
                    @if($notas === [])
                    <ul id="progressbar">
                        <li class="active">Seleccionar Factura</li>
                        <li id="laelPago">Crear Intención de Pago</li>
                        <li id="labelFinPago">Finalizar</li>
                    </ul>
                    @else
                    <ul id="progressbar">
                        <li class="active">Seleccionar Factura</li>
                        <li id="labelNC">Agregar Nota de Crédito (Opcional)</li>
                        <li id="labelPago">Crear Intención de Pago</li>
                        <li id="labelFinPago">Finalizar</li>
                    </ul>
                    @endif
                   <div class="col-md-12 table-responsive" id="facturasDiv">
                    <p class="lead"> <strong> Seleccione La Factura a Pagar:</strong></p><br>
                    <table id="example" class="display" style="width:100%">
                        <thead style="background-color:#002868; color:white">
                           <tr>
                            <th></th>
                            <th>Documento</th>
                            <th>No.</th>
                            <th>% de Descuento</th>
                            <th>Fecha Facturación</th>
                            <th>Fecha Vencimiento</th>
                            <th>Imp. Factura con IVA</th>
                            {{-- <th>Imp. Factura sin IVA</th>
                            <th>Desc. Aplicado</th> --}}
                           {{--  <th>Porc. Aplicado</th> --}}
                            {{-- <th>Imp. Fact. con IVA menos Descuento</th> --}}
                            <th>Saldo</th>
                            <th>Acciones</th>
                           </tr>
                        </thead>
                        <tbody>
                        @foreach ( $data as $value )
                        <tr>
                            <td>
                                <div class="spinner-border text-secondary" style="display:none" id="btnSpinnerDownload{{ $value->tranid }}"></div>
                                <div class="btn" style="display:block; width:50px !important " id="btnDownloadFact{{ $value->tranid }}" onclick='downloadFact("{{$value->tranid}}")'>
                                <img  src="{{asset('dist/img/pdf.png')}}" alt="Product 1" class="img-size-32 mr-2">
                             </div>
                            </td>
                            <td>Factura</td>
                            <td>{{ $value->tranid }}</td>
                            <td class="text-center">{{ number_format($value->porcentaje_Descuento_Aplicado, 2)}}%</td>
                            <td>{{ substr($value->fechaFactura, 0, 10) }}</td>
                            <td>{{ substr($value->dueDate, 0, 10)  }}</td>
                            <td>{{ number_format($value->importe_factura, 2)}}</td>
                            {{-- <td class="text-center">{{ number_format($value->importe_factura, 2)}}</td>
                            <td class="text-center">{{ number_format($value->descuento_aplicado, 2)}}</td>
                            <td class="text-center">{{ number_format($value->porcentaje_Descuento_Aplicado, 2)}}%</td>
                            <td class="text-center">{{ number_format($value->importe_factura_menos_descuento, 2)}}</td> --}}
                            <td> {{ number_format($value->saldo, 2) }}</td>
                            <td>
                                <div class="spinner-border text-secondary" style="display:none" id="btnSpinner{{ $value->tranid }}"></div>
                                <div class="btn btn-info " style="display:block; width:50px !important " id="btnDetalleFact{{ $value->tranid }}" onclick='detalleFactura("{{$value->tranid}}")'>
                                    <i class="far fa-eye"></i>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                     </table>
                     <br>
                     @if($notas === [] || $notas[0]->transaction_type=='Payment')
                     <div class="col-md-12 text-center" id="showPaso1" style="display: none">
                        <button class="btn btn-success " id="btnPagar" >Continuar con el Pago &nbsp; <i class="fa fa-arrow-right  "></i></button>
                    </div>
                     @else
                     <div class="col-md-12 text-center" id="showPaso1" style="display: none">
                        <button class="btn btn-info" id="btnMostrarNotas">Agregar Nota de Crédito&nbsp; <i class="fa fa-file-circle-plus"></i></button>
                        &nbsp; ó &nbsp;
                        <button class="btn btn-success " id="btnPagar" >Continuar con el Pago &nbsp; <i class="fa fa-arrow-right  "></i></button>
                    </div>
                     {{-- <button style = "display:none" class="form-control btn-info" id="btnMostrarNotas">Agregar Nota de Crédito&nbsp; <i class="fa fa-file-circle-plus"></i></button>
                     <button style = "display:none" class="form-control btn-success" id="btnPagar">Continuar con el Pago &nbsp; <i class="fa fa-arrow-right  "></i></button> --}}
                     @endif
                   </div>
                   <div class="col-md-12 table-responsive" id="notasDiv" style="display:none">
                    <p class="lead">Seleccione Nota de Crédito a Abonar:</p><br>
                    <div class="col-md-12 text-center">
                        <button class="form-control btn-info" onclick="mostrarFacturas()" id="btnMostrarFacturas"><i class="fa fa-arrow-left"></i> &nbsp; Regresar a Facturas</button><br>
                    </div>
                    <table id="tableNotas" class="display" style="width:100%">
                        <thead style="background-color:#002868; color:white">
                           <tr>
                            <th></th>
                            <th>Documento</th>
                            <th>No.</th>
                            <th>Monto</th>
                            <th>Fecha Facturación</th>
                            <th>Vencimiento</th>
                           </tr>
                        </thead>
                        <tbody>
                        @foreach ( $notas as $nota )
                            @if($nota->status == 'Open')
                            <tr>
                                <td>
                                    <div class="spinner-border text-secondary" style="display:none" id="btnSpinnerDownloadNC{{ $nota->transaction_id }}"></div>
                                    <div class="btn" style="display:block; width:50px !important " id="btnDownloadNC{{ $nota->transaction_id }}" onclick='downloadNC("{{$nota->transaction_id}}")'>
                                    <img  src="{{asset('dist/img/nota.png')}}" alt="Product 1" class="img-size-32 mr-2">
                                 </div>
                                </td>
                                <td>Nota de Crédito</td>
                                  <td>{{ $nota->transaction_id }}</td>
                                  <td class="text-center">{{ number_format($nota->amount, 2) }}</td>
                                  <td class="text-center">{{ substr($nota->fecha_nota, 0, 10) }}</td>
                                  <td class="text-center"> NA </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                     </table>
                     <hr>
                   </div>
                   <div class="col-md-12 table-responsive">
                    <p class="lead">Resumen de Pago:</p>
                   </div>

                   <div id="resumenPago" style="display:none"class="col-md-12 table-responsive">
                 </div>
                </div>
                <br>
                <div class="row">
                   {{-- <div class="col-6">
                      <p class="lead">Metodos de Pago:</p>
                      <img src="{{ asset('dist/img/credit/visa.png') }}" alt="Visa">
                      <img src="{{ asset('dist/img/credit/mastercard.png') }}" alt="Mastercard">
                      <img src="{{ asset('dist/img/credit/american-express.png') }}" alt="American Express">
                      <img src="{{ asset('dist/img/credit/paypal2.png') }}" alt="Paypal">
                      <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                         Nota : solo se puede pagar ......
                      </p>
                   </div> --}}
                   <div class="col-6">
                      <div class="table-responsive">
                         <table class="table">
                            <tbody>
                               <tr>
                                  <th style="width:50%">Subtotal:</th>
                                  <td id="subtotal"></td>
                               </tr>
                               <tr hidden>
                                  <th>Descuentos: </th>
                                  <td id="descuento"></td>
                               </tr>
                               <tr hidden>
                                  <th>Total:</th>
                                  <td id="total"></td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                   </div>
                </div>
                <div class="row no-print">
                   <div class="col-12">
                     {{--  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> --}}
                      <button  type="button" class="btn btn-success float-right" style="display:none" onclick="window.print();"><i class="far fa-credit-card"></i> Generar Intención de Pago
                      </button>
                     {{--  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-download"></i> Descargar PDF
                      </button> --}}
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
<!-- Modal Detalle Factura-->
<div class="modal fade" id="detalleFactModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
       <div class="modal-content">
          <div class="modal-header" style="background-color:#002868; color:whitesmoke">
            <h4 id="headerNC" class="text-center title ml-auto">Detalle de Factura: <u><p id="numeroFact" style="color:#d8ad02"></p></u></h4>

             <input type="text" id="typeFormInf" value="" hidden>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <i class="fas fa-times"></i>
             </button>
          </div>
          <div class="card-body table-responsive p-0">
            <table id="detalleFactTable" class="table table-striped table-bordered table-hover "
                style="width:100% ; font-size:75% ;font-weight: bold ">
                <thead style="background-color:#002868; color:white">
                    <tr>
                        <th>Tipo de Transacción</th>
                        <th>Monto Abonado</th>
                        <th>Fecha de Abono</th>
                        <th>Folio de Abono</th>
                    </tr>
                </thead>
                <tbody id="llenadetalleFactModal">
                </tbody>
            </table>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cerrar</button>
         </div>
       </div>
    </div>
 </div>
<!-- Modal Notas de Crédito-->
<div class="modal fade" id="notasModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
       <div class="modal-content">
          <div class="modal-header bg-indarBlue">
            <h4 id="headerNC" class="text-center title ">Aplicar Nota de Crédito</h4>
             <input type="text" id="typeFormInf" value="" hidden>
             </button>
          </div>
          <div class="modal-body text-indarBlue" id="modal2">
             <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center title ml-auto" style="color: rgba(214, 146, 0, 0.815)"><strong>(De Clic En el Recuadro Para Asignar una Factura Su N.C)</strong>  </h6>
                   {{--  <label for="">Selecciona la Factura a Asignar la N.C</label> --}}
                   <select class="form-control" name="" id="selectFact"placeholder="Seleccione una Factura"></select>
                </div>
             </div>
             <br>
             <h6 style="font-weight: bold">Número de la Nota de Crédito :  <span id="numeroNC" style="font-size: 15px" class="badge badge-info"></span></h6>
             <h6 style="font-weight: bold">Monto de la Nota de Crédito : $ <span id="montoNC" style="font-size: 15px" class="badge badge-success"></span></h6>
          </div>

          <div class="modal-footer">
             <button id="agregarNc" type="submit" class="btn btn-success float-right" data-dismiss="modal">Aplicar N.C</button>
          </div>
       </div>
    </div>
 </div>

 </section>
</div>
<!-- Modal de Intención de Pago-->
<div id="printThis">
    <div id="intencionPagoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Modal Content: begins -->
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-indarBlue">
                    <h4 id="headerNC" class="text-center title ml-auto">Intención de Pago</h4>
                    <input type="text" id="typeFormInf" value="" hidden>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                    </button>
                 </div>
                <!-- Modal Body -->
                <div class="modal-body text-indarBlue" id="modal2">
                    <div class="row">
                       <div class="col-md-12">
                           <h6 class="text-center title ml-auto" style="color: rgba(214, 21, 0, 0.815)"><strong> Favor de  <p id="fechaIntencionPagoHeader" class="lead"></p></strong> </h6>
                               <div id="divresumenPago" style="display:block"class="col-md-12 table-responsive">
                               <p  class="lead" >Resumen de Pago:</p>
                               <table id="resumenPagoFactTable" class="table table-hover" style="font-size:90% ;font-weight: bold">
                                   <thead style="background-color:#002868; color:white">
                                      <tr>
                                         <th>No. Factura</th>
                                         <th>Saldo</th>
                                         <th>% Descuento</th>
                                         <th>Imp. Descuento</th>
                                         <th>Vencimiento</th>
                                         <th>Importe a Cobrar</th>
                                      </tr>
                                   </thead>
                                   <tbody id="llenaResumenPagoFactTable">

                                   </tbody>
                                </table>
                            </div>

                          <div class="col-md-12">
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
                    </div>
                 </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <h3 id="fechaIntencionPago" style="background-color:rgb(199, 23, 4);color:white; font-size:18px "></h3>
                    <h6 style="font-weight: bold">Total a Pagar : $ <span id="impTotal" style="font-size: 15px" class="badge badge-success"></span></h6>
                     <button id="btnPrint" type="submit" class="btn btn-success float-right" data-dismiss="modal">Imprimir</button>
                     <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cerrar</button>
                  </div>
                <style>

                    @media screen {

                        #printSection {

                            display: none;

                        }

                    }

                    @media print {
                        .modal-dialog {
                        max-width: 100%;
                        width: 100%;
                        }
                        body * {

                            visibility: hidden;

                        }

                        #printSection,

                        #printSection * {

                            visibility: visible;

                        }

                        #printSection {

                            position: absolute;

                            left: 0;

                            top: 0;

                        }

                    }

                </style>

            </div>

        </div>

        <!-- Modal Content: ends -->

    </div>

</div>
 </section>
</div>
</div>
@endsection


@section('js')

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--datatables-->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://nightly.datatables.net/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    document.getElementById("btnPrint").onclick = function () {

printElement(document.getElementById("printThis"));

};

function printElement(elem) {

var domClone = elem.cloneNode(true);



var $printSection = document.getElementById("printSection");



if (!$printSection) {

    var $printSection = document.createElement("div");

    $printSection.id = "printSection";

    document.body.appendChild($printSection);

}



$printSection.innerHTML = "";

$printSection.appendChild(domClone);

window.print();

}

//$("body").addClass("sidebar-collapse");
var table = $('#example').DataTable({
    dom : 'Brtip',
    paging:false,
    fixedHeader:true,
    ordering: false,
    scrollY:320,
    scrollX: true,
    bInfo:false,
    scrollCollapse: true
} );


$('#example tbody').on('click', 'tr', function () {
    $(this).toggleClass('selected');
    document.getElementById("showPaso1").style.display = "block";
    var datos = table.rows('.selected').data()
    var subTotal=0;
    var descuento=0;
    htmlResumenNC='';
    arregloFac=[];

    for(i=0; i< datos.length; i++){
        datos[i][6] = datos[i][6].replace(/,/g, "");
        var descFa = parseFloat(datos[i][6])*(parseFloat(datos[i][3])/100);
        var impFa = parseFloat(datos[i][6])-parseFloat(descFa);
        htmlResumenNC += '<table id="example'+i+'" class="table table-hover" style="font-size:90% ;font-weight: bold">'+
                        '<thead style="background-color:#002868; color:white">'+
                           '<tr>'+
                              '<th>Tipo</th>'+
                              '<th>Número</th>'+
                              '<th>Saldo</th>'+
                              '<th>% Descuento</th>'+
                              '<th>Imp Descuento PP</th>'+
                              '<th style="background-color:#e6d53db5">Vencimiento</th>'+
                              '<th style="background-color:#3de65fb5">Importe a Cobrar </th>'+
                           '</tr>'+
                       ' </thead>'+
                        '<tbody>'+
                            '<tr>'+
                              '<td>Factura</td>'+
                              '<td>'+datos[i][2]+'</td>'+
                              '<td>'+parseFloat(datos[i][6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                              '<td> --- </td>'+
                              '<td> --- </td>'+
                              '<td>'+datos[i][5]+'</td>'+
                              '<td id="importeACobrar">'+parseFloat(datos[i][6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'  </td>'+
                           '</tr>'+
                        '</tbody>'+
                        '<tbody id="'+datos[i][2]+'">'+
                        '</tbody>'+
                        '<tfoot id="total'+datos[i][2]+'">'+
                            '<td>Total</td>'+
                              '<td>---</td>'+
                              '<td>---</td>'+
                              '<td>'+ datos[i][3] +'</td>'+
                              '<td> '+ descFa.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) +' </td>'+
                              '<td>---</td>'+
                              '<td id="importeACobrar">'+impFa.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'  </td>'+
                        '</tfoot>';
                     '</table>';
        //datos[i][7] = datos[i][7].replace(/,/g, "");
        arregloFac.push(datos[i]);
        subTotal += parseFloat(datos[i][6]);

    }
    $('#resumenPago').html(htmlResumenNC);
    htmlResumenPagoFact='';
    var impPagar=0;
    var porcDesc=0;
    var impDesc=0;
    var impTotal=0;
    fechaPago = [];

    arregloFac.forEach(element => {
        porcDesc = parseFloat(element[3])/100;
        element[7] = element[7].replace(/,/g, "")
        impPagar = element[7]-(element[7] * porcDesc);
        //impPagar = impPagar.replace(/,/g, "");
        impDesc = parseFloat(element[7]) * porcDesc
        impTotal= impPagar+impTotal;
        htmlResumenPagoFact +='<tr>'+
            '<td>'+element[2]+'</td>'+
            '<td>'+element[7].toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
            '<td>'+element[3]+'</td>'+
            '<td>'+impDesc.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
            '<td>'+ element[5]+'</td>'+
            '<td style="color:green">'+impPagar.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
            '</tr>';
        fechaPago.push(element[5]);
    });
    if(arregloFac.length != 0){
    var  fechaLimPago=fechaPago.sort();
   var añoLimPago = fechaLimPago[0].slice(0,4);
   var mesLimPago = fechaLimPago[0].slice(5,7);
   var diaLimPago = fechaLimPago[0].slice(8,10);
   $('#fechaIntencionPago').text('Realizar Su Pago Antes del:'+diaLimPago+'/'+mesLimPago+'/'+añoLimPago);
   $('#fechaIntencionPagoHeader').text('Realizar Su Pago Antes del:'+diaLimPago+'/'+mesLimPago+'/'+añoLimPago);
    htmlResumenPagoFact +='<tr style="background-color:rgb(255, 187, 0)">'+
            '<td colspan="3"></td>'+
            '<td >TOTAL A PAGAR</td>'+
            '<td>$'+ impTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
            '<td ></td>'+
            '</tr>';

    $('#impTotal').text(impTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#llenaResumenPagoFactTable').html(htmlResumenPagoFact);
    $('#subtotal').text('$' + subTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }


    //$('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    if(arregloFac.length == 0){
        document.getElementById("showPaso1").style.display = "none";
    }

});

$('#btnMostrarNotas').click(function () {
    document.getElementById("resumenPago").style.display = "block";
    $('#labelNC').addClass('active');
    var data = table.rows('.selected').data();
    arregloFact=[];
    for(i=0; i< data.length; i++){
        data[i][6] = data[i][6].replace(/,/g, "");
        arregloFact.push(data[i]);
    }
    document.getElementById("notasDiv").style.display = "block";
    document.getElementById("facturasDiv").style.display = "none";
});

$('#btnPagar').click(function () {
    $('#labelPago').addClass('active');
    $('#labelNC').addClass('active');
    $('#intencionPagoModal').modal('show');
    //document.getElementById("notasDiv").style.display = "block";
    //document.getElementById("facturasDiv").style.display = "none";
});

$("#intencionPagoModal").on("hidden.bs.modal", function () {
    $('#labelNC').removeClass('active');
    $('#labelPago').removeClass('active');

});

var tableNotas = $('#tableNotas').DataTable({
    dom : 'Brt',
} );

var t = $('#example2').DataTable({
    dom : 'Brt',
} );
var subTotal = 0;
var descuento = 0;
var total = 0;
htmlSelectFact='';
montosFac=[];
/*  $('#example tbody').on('click', 'tr', function () {

    jQuery(this).toggle("scale");
     var data = table.row( this ).data();
    // Mostrar Boton de NC
    document.getElementById("btnMostrarNotas").style.display = "block";

if(data[1]=='Factura'){
    data[6] = data[6].replace(/,/g, "");
    subTotal += parseFloat(data[6]);
    $('#subtotal').text('$' + subTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
}
else{
    descuento += parseFloat(data[6]);
    $('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
}

total = subTotal - descuento;
$('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
var monto = parseFloat(data[6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});
if(montosFac.includes(monto)){

}else{
    montosFac.push(parseFloat(data[6]));
}
    t.row.add( [
       data[0],
       data[1],
        data[2],
        monto,
        data[4],
        data[5]

    ] ).draw();

    htmlSelectFact += '<tr>'+
        '<td>' + data[0]+ '</td>'+
        '<td>' + data[1]+ '</td>'+
        '<td>' + data[2]+ '</td>'+
        '<td>$' + monto+ '</td>'+
        '<td><input type="number" class="form-control" placeholder ="Ingrese el Monto a Descontar"></td>'+

        '</tr>';
    $('#selectFacTable').html(htmlSelectFact);
 } ); */
 $('#tableNotas tbody').on('click', 'tr', function (event) {
   $('#selectFact').empty();
    var facturamayor = 0;
    for (i=0; i< arregloFact.length; i++){
        if(parseFloat(arregloFact[i][6]) > facturamayor){
            facturamayor = parseFloat(arregloFact[i][6]);
        }
    }
    var data = tableNotas.row( this ).data();
    var montoNC = data[3].replace(/,/g, "");
    var numeroNC = data[2];
    var headerNC = data[2];
    //console.log(montoNC, facturamayor);
    if(montoNC < facturamayor ){
    $('#montoNC').text(montoNC);
    $('#numeroNC').text(numeroNC);
    $('#headerNC').html('Abonar Nota de Crédito No . '+headerNC);
    //$('#notasModal').modal({backdrop: 'static', keyboard: false});
    $('#notasModal').modal('show');
    for(i=0; i<arregloFact.length; i++){

        montoNC = parseFloat(montoNC);
       if(montoNC < parseFloat(arregloFact[i][6])){
        $('#selectFact').append('<option value='+arregloFact[i][2]+'>Factura No. : '+arregloFact[i][2]+' Monto:  $'+parseFloat(arregloFact[i][6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+' Desc: '+ arregloFact[i][3] +'</option>');
        }
    }
    hide = jQuery(this);
    }else{
        Swal.fire({
        position: 'top',
        icon: 'info',
        title: 'Debe de Existir una Factura con Saldo Mayor a la N.C Seleccionada',
        showConfirmButton: false,
        timer: 5000
        })

    }
 });

 var saldo=0;
 var x = 0;
 var y='nada';

 $('#agregarNc').on('click', function(e) {
    document.getElementById("btnMostrarFacturas").style.display = "none";
    htmlappendTotal='';
    htmlappendNC='';

    var montoNC = $('#montoNC').text();
    var numeroNC = $('#numeroNC').text();
    var numeroFact =document.getElementById("selectFact").value;
    var saldoSelectedFact = $("#selectFact option:selected" ).text();
    saldoSelectedFact = saldoSelectedFact.slice(30);
    saldoSelectedFact=saldoSelectedFact.replace(/,/g, "");
    var selectedFact= $("#selectFact option:selected" ).text();
    selectedFact = selectedFact.slice(14,20);
    var porcSelectedFact= $("#selectFact option:selected" ).text();
    porcSelectedFact =porcSelectedFact.slice(-5,-1);
    var id = selectedFact;
    var saldoTotal = parseFloat(saldoSelectedFact)-parseFloat(montoNC);
    hide.toggle();
    e.preventDefault();
    hide = jQuery(this);
    var descuentoPP = saldoTotal * (parseFloat(porcSelectedFact)/100);
    var saldoFinal = saldoTotal - descuentoPP;
    for (i=0; i< arregloFact.length; i++){
        if(arregloFact[i][2]== selectedFact){
            var lugar = i;
            console.log(i);
        }
    }
    console.log(arregloFact);
    arregloFact[lugar][6]= parseFloat(arregloFact[lugar][6])-parseFloat(montoNC);
    console.log(arregloFact[lugar][6]);
    htmlappendNC +='<tr style="font-size:13px; font-style:italic; background-color:rgba(253, 244, 66, 0.944)">'+
                      '<td><i class="fa-solid fa-right-long"></i>Nota de Credito</td>'+
                      '<td>'+numeroNC+'</td>'+
                      '<td style="color:red">-'+parseFloat(montoNC).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                      '<td> --- </td>'+
                      '<td> --- </td>'+
                      '<td> --- </td>'+
                      '<td id="saldoTotal">  '+ saldoTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) +' </td>'+
                    '</tr>';

    htmlappendTotal +='<tr style="background-color:#3de65fb5">'+
                      '<td >Total</td>'+
                      '<td>---</td>'+
                      '<td>---</td>'+
                      '<td> %'+porcSelectedFact+' </td>'+
                      '<td> '+ descuentoPP.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})  +'</td>'+
                      '<td> --- </td>'+
                      '<td>  '+ saldoFinal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) +' </td>'+
                    '</tr>';

    appendNC = $('#'+selectedFact+'');
    appendTotal = $('#total'+selectedFact+'');
    appendNC.append(htmlappendNC);
    appendTotal.html(htmlappendTotal);
    //agregarNC (data,montoNC);
    });
/*
 $('#example2 tbody').on('click', 'tr', function () {
    jQuery(this).hide( "blind", {direction: "horizontal"}, 500 );
     var data = t.row( this ).data();
    if(data[1]=='Factura'){
        data[6] = data[6] = data[6].replace(/,/g, "");
        subTotal -=  parseFloat(data[6]);
        $('#subtotal').text('$' + subTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }else{
        descuento -= parseFloat(data[6]);
        $('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    total = subTotal - descuento;
    $('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    var monto = parseFloat(data[6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});

    if(data[1]=='Factura'){
        table.row.add( [
       data[0],
       data[1],
        data[2],
        monto,
        data[4],
        data[5]

    ], ).draw();

    }else{
        tableNotas.row.add( [
        data[0],
        data[1],
        data[2],
        monto,
        data[4],
        data[5]

    ], ).draw();
    }


 } ); */

});

function agregarNC(data,montoNC){
    console.log( document.getElementById("selectFact").value);
    /* var sumaFinal=0;
    document.getElementById("btnMostrarFacturas").style.display = "none";
    var htmlappendNC='';

        arregloAgregarNC = [];
        var saldoSelectedFact = $("#selectFact option:selected" ).text();
        saldoSelectedFact = saldoSelectedFact.slice(30);
        var selectedFact= $("#selectFact option:selected" ).text();
        selectedFact = selectedFact.slice(14,20);
        var porcSelectedFact= $("#selectFact option:selected" ).text();
        porcSelectedFact =porcSelectedFact.slice(-5,-1);
        var id = selectedFact;
        var saldoNC = data[3].replace(/,/g, "");
        var saldoTotal = parseFloat(saldoSelectedFact)-parseFloat(saldoNC);
        var descuentoPP = saldoTotal * (parseFloat(porcSelectedFact)/100);
        var saldoFinal = saldoTotal - descuentoPP;
        arregloAgregarNC.push({factura: selectedFact, nc: data[2], saldo: saldoNC });

        htmlappendNC +='<tr style="font-size:13px; font-style:italic; background-color:rgba(253, 244, 66, 0.944)">'+
                        '<td><i class="fa-solid fa-right-long"></i>Nota de Credito</td>'+
                        '<td>'+data[2]+'</td>'+
                        '<td style="color:red">-'+saldoNC.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                        '<td> --- </td>'+
                        '<td> --- </td>'+
                        '<td> --- </td>'+
                        '<td>  '+ saldoTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) +' </td>'+
                      '</tr>'+
                      '<tr style="background-color:#3de65fb5">'+
                        '<td >Total</td>'+
                        '<td>---</td>'+
                        '<td>---</td>'+
                        '<td> %'+porcSelectedFact+' </td>'+
                        '<td> '+ descuentoPP.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})  +'</td>'+
                        '<td> --- </td>'+
                        '<td>  '+ saldoFinal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) +' </td>'+
                      '</tr>';

        appendNC = $('#'+selectedFact+'');
        appendNC.html(htmlappendNC);
        */
        //console.log('NC:'+saldoNC,'FactSelect:'+selectedFact,'SaldoFact:'+saldoSelectedFact,'Total:'+saldoTotal);

        //data[6] = data[6].replace(/,/g, "");
        //descuento += parseFloat(data[6]);
        //$('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
        /* total = subTotal - descuento;
        $('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
        var monto = parseFloat(data[6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});
        t.row.add( [
           data[0],
           data[1],
            data[2],
            monto,
            data[4],
            data[5]

        ], ).draw(); */

}


function mostrarFacturas() {
  //$("#comisionesTable").dataTable().fnDestroy();
  document.getElementById("resumenPago").style.display = "none";
  $('#labelNC').removeClass('active');
  document.getElementById("notasDiv").style.display = "none";
  document.getElementById("facturasDiv").style.display = "block";
}

function detalleFactura(folio) {
    document.getElementById('btnSpinner'+folio).style.display = "block";
    document.getElementById("btnDetalleFact"+folio).style.display = "none";

    const cte = {!! json_encode($value->companyid) !!}
    //console.log(folio, cte);
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/clientes/getDetalleFactura",
        'type': 'GET',
        'dataType': 'json',
        'data': {folio: folio, cte : cte},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
         //console.log(data);
         if(data.length == 0){
            Swal.fire({
                position: 'top',
                icon: 'info',
                title: 'Factura Sin Abonos',
                showConfirmButton: false,
                timer: 10000
                });
         }
         else{
         var detalleFactModal ='';

         var tipoAbonado;
         var fechaAbono;
         for(var i=0; i< data.length; i++){
            if (data[i].transaction_type == 'Payment'){
                tipoAbonado = 'Pago';
            }
            if(data[i].transaction_type == 'Credit Memo'){
                tipoAbonado='Nota de Crédito';
             }
            fechaAbono = data[i].fecha.slice(0, 10);
            detalleFactModal+= '<tr>' +
                '<td>'+ tipoAbonado +'</td>' +
                '<td style="color:green"> '+ data[i].amount.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                '<td>' + fechaAbono +'</td>' +
                '<td>' + data[i].number +'</td>' +
                '</tr>';
         }


         $('#numeroFact').text(folio);
         $('#llenadetalleFactModal').html(detalleFactModal);
         $('#detalleFactModal').modal('show');
         }
         document.getElementById("btnSpinner"+folio).style.display = "none";
         document.getElementById("btnDetalleFact"+folio).style.display = "block";
        }
        ,
        error: function() {
            console.log("Error");
            alert('Error, Tiempo de espera agotado');
        }
    });

}

function downloadFact (folio){
document.getElementById('btnSpinnerDownload'+folio).style.display = "block";
document.getElementById("btnDownloadFact"+folio).style.display = "none";
var type = 'CustInvc';
var formato = 'PDF';
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/clientes/getDocumentCFDI",
        'type': 'GET',
        'data': {folio: folio, type: type, formato: formato},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            //console.log(data);
            document.getElementById('btnSpinnerDownload'+folio).style.display = "none";
            document.getElementById("btnDownloadFact"+folio).style.display = "block";
            if(data == 'NOK'){
                Swal.fire({
                position: 'top',
                icon: 'info',
                title: 'Vista previa del Archivo No disponible',
                showConfirmButton: false,
                timer: 50000
                });
            }
            window.open(data, '_blank');
         }
        ,
        error: function() {
            alert('Error, Intente nuevamente');
        }

    });

}
function downloadNC (folio){

document.getElementById('btnSpinnerDownloadNC'+folio).style.display = "block";
document.getElementById("btnDownloadNC"+folio).style.display = "none";
var type = 'CustCred';
var formato = 'PDF';
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/clientes/getDocumentCFDI",
        'type': 'GET',
        'data': {folio: folio, type: type, formato: formato},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            document.getElementById('btnSpinnerDownloadNC'+folio).style.display = "none";
            document.getElementById("btnDownloadNC"+folio).style.display = "block";
            if(data=='NOK'){
                //console.log(data);
                Swal.fire({
                position: 'top',
                icon: 'info',
                title: 'Vista Previa No disponible',
                showConfirmButton: false,
                timer: 5000
                })
            }else{
                window.open(data, '_blank');
            }


         }
        ,
        error: function() {
            alert('Error, Intente nuevamente');
        }

    });

}

</script>
@endsection
