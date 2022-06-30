@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | Pago en Línea @endsection

@section('styles')

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
                            <td><img  src="{{asset('dist/img/pdf.png')}}" alt="Product 1" class="img-size-32 mr-2"></td>
                            <td>Factura</td>
                            <td>{{ $value->tranid }}</td>
                            <td>{{ substr($value->fechaFactura, 0, 10) }}</td>
                            <td>{{ substr($value->dueDate, 0, 10)  }}</td>
                            <td>{{ number_format($value->importe_factura_snDescontar, 2)}}</td>
                            {{-- <td class="text-center">{{ number_format($value->importe_factura, 2)}}</td>
                            <td class="text-center">{{ number_format($value->descuento_aplicado, 2)}}</td>
                            <td class="text-center">{{ number_format($value->porcentaje_Descuento_Aplicado, 2)}}%</td>
                            <td class="text-center">{{ number_format($value->importe_factura_menos_descuento, 2)}}</td> --}}
                            <td> {{ number_format($value->saldo, 2) }}</td>
                            <td>
                                <div class="btn btn-info btn-circle" id="btnDetalleFact" onclick='detalleFactura("{{$value->tranid}}")'>
                                    <i class="far fa-eye"></i>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                     </table>
                     <br>
                     @if($notas === [])
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
                                <td> <img  src="{{asset('dist/img/nota.png')}}" alt="Nota" class="img-size-32 mr-2"></td>
                                <td>Nota de Crédito</td>
                                  <td> <a href="#" class="text-muted">{{ $nota->transaction_id }}</a></td>
                                  <td class="text-center">{{ number_format($nota->amount, 2) }}</td>
                                  <td class="text-center">{{ substr($nota->fecha_nota, 0, 10) }}</td>
                                  <td class="text-center"> NA </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                     </table>
                   </div>
                   <div id="resumenPago" style="display:none"class="col-md-12 table-responsive">
                    <p  class="lead" >Resumen de Pago:</p>
                    <table id="example2" class="table table-hover" style="font-size:90% ;font-weight: bold">
                        <thead style="background-color:#002868; color:white">
                           <tr>
                              <th>No. Factura</th>
                              <th>Vencimiento</th>
                              <th>Imp Con IVA</th>
                              <th>Imp Sin IVA</th>
                              <th>Porciento Descuento</th>
                              <th>Imp Con Iva con Descuento</th>
                              <th>Saldo</th>
                              <th style="background-color:#fa5d48e5">No. NC</th>
                              <th style="background-color:#fa5d48e5">Monto</th>
                              <th style="background-color:#3de65fb5">TOTAL</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                 </div>
                </div>
                <br>
                <div class="row">
                   <div class="col-6">
                      <p class="lead">Metodos de Pago:</p>
                      <img src="{{ asset('dist/img/credit/visa.png') }}" alt="Visa">
                      <img src="{{ asset('dist/img/credit/mastercard.png') }}" alt="Mastercard">
                      <img src="{{ asset('dist/img/credit/american-express.png') }}" alt="American Express">
                      <img src="{{ asset('dist/img/credit/paypal2.png') }}" alt="Paypal">
                      <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                         Nota : solo se puede pagar ......
                      </p>
                   </div>
                   <div class="col-6">
                      <div class="table-responsive">
                         <table class="table">
                            <tbody>
                               <tr>
                                  <th style="width:50%">Subtotal:</th>
                                  <td id="subtotal"></td>
                               </tr>
                               <tr>
                                  <th>Descuentos:  </th>
                                  <td id="descuento"></td>
                               </tr>
                               <tr>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
       <div class="modal-content">
          <div class="modal-header bg-indarBlue">
            <h4 id="headerNC" class="text-center title ml-auto">Modal Detalle Factura</h4>
             <input type="text" id="typeFormInf" value="" hidden>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <i class="fas fa-times"></i>
             </button>
          </div>
          <div class="modal-body text-indarBlue" id="modal2">
             <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center title ml-auto" style="color: rgba(214, 157, 0, 0.815)">DATOS</h6>
                   {{--  <label for="">Selecciona la Factura a Asignar la N.C</label> --}}

                </div>
             </div>
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
            <h4 id="headerNC" class="text-center title ml-auto">Aplicar Nota de Crédito</h4>
             <input type="text" id="typeFormInf" value="" hidden>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <i class="fas fa-times"></i>
             </button>
          </div>
          <div class="modal-body text-indarBlue" id="modal2">
             <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center title ml-auto" style="color: rgba(214, 157, 0, 0.815)">(Asigne a una Factura Su Nota de Crédito)</h6>
                   {{--  <label for="">Selecciona la Factura a Asignar la N.C</label> --}}
                   <select class="form-control" name="" id="selectFact"placeholder="Seleccione una Factura"></select>
                </div>
             </div>
             <br>
             <h6 style="font-weight: bold">Monto de la Nota de Crédito : $ <span id="montoNC" style="font-size: 15px" class="badge badge-success"></span></h6>
          </div>

          <div class="modal-footer">
             <button id="agregarNc" type="submit" class="btn btn-success float-right" data-dismiss="modal">Aplicar N.C</button>
             <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cerrar</button>
          </div>
       </div>
    </div>
 </div>

 </section>
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
        arregloFac=[];
        for(i=0; i< datos.length; i++){
            datos[i][6] = datos[i][6].replace(/,/g, "");
            //datos[i][7] = datos[i][7].replace(/,/g, "");
            arregloFac.push(datos[i]);
            subTotal += parseFloat(datos[i][6]);
            console.log(datos[i][6]);
            //descuento += parseFloat(datos[i][7]);
        }

        $('#subtotal').text('$' + subTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
        //$('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
        if(arregloFac.length == 0){
            document.getElementById("showPaso1").style.display = "none";
        }

    });

    $('#btnMostrarNotas').click(function () {
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

var tableNotas = $('#tableNotas').DataTable({
    dom : 'Brt',
} );

var t = $('#example2').DataTable({
    dom : 'Brt',
    rowCallback: function(row, data, index){
        $('td', row).css('background-color', 'rgba(251, 255, 20, 0.603)');
    }
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


 $('#tableNotas tbody').on('click', 'tr', function () {
   $('#selectFact').empty();
    var facturamayor = 0;
    for (i=0; i< arregloFact.length; i++){
        console.log(arregloFact[i][6]);
        if(parseFloat(arregloFact[i][6]) > facturamayor){
            facturamayor = parseFloat(arregloFact[i][6]);
        }
    }
    console.log(facturamayor);
    //jQuery(this).hide( "blind", {direction: "horizontal"}, 500 );
    var data = tableNotas.row( this ).data();
    var montoNC = data[3].replace(/,/g, "");
    var headerNC = data[2];
    console.log(montoNC, facturamayor);
    if(montoNC < facturamayor ){

    $('#montoNC').text(montoNC);
    $('#headerNC').html('Abonar Nota de Crédito No . '+headerNC);
    $('#notasModal').modal('show');

    for(i=0; i<arregloFact.length; i++){
        montoNC = parseFloat(montoNC);
       if(montoNC < parseFloat(arregloFact[i][6])){
        $('#selectFact').append('<option value='+arregloFact[i][1]+'>Factura No. : '+arregloFact[i][2]+' Monto:  $'+parseFloat(arregloFact[i][6])+'</option>');
        }
    }
    var hide = jQuery(this);
     //Función Agregar NC
    $('#agregarNc').on('click', function(e) {
        document.getElementById("resumenPago").style.display = "block";
        hide.toggle("scale");
        e.preventDefault();
        console.log(data);
        data[6] = data[6].replace(/,/g, "");
        //descuento += parseFloat(data[6]);
        //$('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));


        total = subTotal - descuento;
        $('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
        var monto = parseFloat(data[6]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});
        t.row.add( [
           data[0],
           data[1],
            data[2],
            monto,
            data[4],
            data[5]

        ], ).draw();

    });
    }else{
        Swal.fire({
        position: 'top',
        icon: 'info',
        title: 'Debe de Existir una Factura con Saldo Mayor a la N.C Seleccionada',
        showConfirmButton: false,
        timer: 50000
        })

    }


 } );



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


 } );

});


function mostrarFacturas() {
  $('#labelNC').removeClass('active');
  document.getElementById("notasDiv").style.display = "none";
  document.getElementById("facturasDiv").style.display = "block";
}

function detalleFactura(data) {
    $('#detalleFactModal').modal('show');
    console.log(data);
}

</script>
@endsection
