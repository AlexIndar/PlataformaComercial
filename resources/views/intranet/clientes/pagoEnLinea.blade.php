@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | Pago en Línea @endsection

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
                <hr>
                <div class="row">
                   <div class="col-md-12 table-responsive" id="facturasDiv">
                    <p class="lead">Seleccione La Factura a Pagar:</p>
                    <table id="example" class="display" style="width:100%">
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
                            @foreach ( $data as $value )
                            <tr>
                                <td><img  src="{{asset('dist/img/pdf.png')}}" alt="Product 1" class="img-size-32 mr-2"></td>
                                <td>Factura</td>
                                <td> <a href="#" class="text-muted">{{ $value->tranid }}</a></td>
                                <td class="text-center">{{ number_format($value->saldo, 2) }}</td>
                                <td class="text-center">{{ substr($value->fechaFactura, 0, 10) }}</td>
                                <td class="text-center">{{ substr($value->dueDate, 0, 10)  }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                     </table>
                     <br>
                     <button style = "display:none" class="form-control btn-success" id="btnMostrarNotas">Continuar con el Pago &nbsp; <i class="fa fa-arrow-right  "></i></button>
                   </div>
                   <div class="col-md-12 table-responsive" id="notasDiv" style="display:none">
                    <p class="lead">Seleccione Nota de Crédito a Abonar:</p><button class="form-control btn-primary" onclick="mostrarFacturas()" id="btnMostrarFacturas"><i class="fa fa-arrow-left"></i> &nbsp; Regresar a Facturas</button>
                    <table id="tableNotas" class="table table-striped table-hover" style="width:90% ; font-size:90% ;font-weight: bold ">
                        <thead>
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
                            <tr>
                                <td> <img  src="{{asset('dist/img/nota.png')}}" alt="Nota" class="img-size-32 mr-2"></td>
                                <td>Nota de Crédito</td>
                                  <td> <a href="#" class="text-muted">{{ $nota->transaction_id }}</a></td>
                                  <td class="text-center">{{ number_format($nota->amount, 2) }}</td>
                                  <td class="text-center">{{ substr($nota->fecha_nota, 0, 10) }}</td>
                                  <td class="text-center"> NA </td>
                            </tr>
                        @endforeach
                        </tbody>
                     </table>
                   </div>
                   <div class="col-md-12 table-responsive">
                    <p class="lead">Documentos a Pagar:</p>
                    <table id="example2" class="table table-hover" style="font-size:90% ;font-weight: bold ">
                        <thead>
                           <tr>
                              <th></th>
                              <th>Documento</th>
                              <th>No.</th>
                              <th>Monto</th>
                              <th>Fecha Fact</th>
                              <th>Fecha Venc</th>
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
                                  <th>Descuentos </th>
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
<!-- Modal Notas de Crédito-->
<div class="modal fade" id="notasModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
       <div class="modal-content">
          <div class="modal-header bg-indarBlue">
            <h4 id="headerNC" class="text-center title ml-auto">Agregar Nota de Crédito</h4>
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
             <button id="agregarNc" type="submit" class="btn btn-success float-right" data-dismiss="modal">Agregar N.C</button>
             <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cerrar</button>
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
<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

$("body").addClass("sidebar-collapse");

var table = $('#example').DataTable({
    dom : 'Brt',
} );

    $('#example tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
        document.getElementById("btnMostrarNotas").style.display = "block";

    });

    $('#btnMostrarNotas').click(function () {
        var data = table.rows('.selected').data();
        arregloFact=[];
        for(i=0; i< data.length; i++){
            data[i][3] = data[i][3].replace(/,/g, "");
            arregloFact.push(data[i]);
        }
        console.log(arregloFact);

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
    data[3] = data[3].replace(/,/g, "");
    subTotal += parseFloat(data[3]);
    $('#subtotal').text('$' + subTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
}
else{
    descuento += parseFloat(data[3]);
    $('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
}

total = subTotal - descuento;
$('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
var monto = parseFloat(data[3]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});
if(montosFac.includes(monto)){

}else{
    montosFac.push(parseFloat(data[3]));
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
        console.log(arregloFact[i][3]);
        if(parseFloat(arregloFact[i][3]) > facturamayor){
            facturamayor = parseFloat(arregloFact[i][3]);
        }
    }
    console.log(facturamayor);
    //jQuery(this).hide( "blind", {direction: "horizontal"}, 500 );
    var data = tableNotas.row( this ).data();
    var montoNC = data[3].replace(/,/g, "");
    var headerNC = data[2];
    if(montoNC < facturamayor ){

    $('#montoNC').text(montoNC);
    $('#headerNC').html('Abonar Nota de Crédito No . '+headerNC);
    $('#notasModal').modal('show');

    for(i=0; i<arregloFact.length; i++){
        montoNC = parseFloat(montoNC);
       if(montoNC < parseFloat(arregloFact[i][3])){
        $('#selectFact').append('<option value='+arregloFact[i][1]+'>Factura No. : '+arregloFact[i][2]+' Monto:  $'+parseFloat(arregloFact[i][3])+'</option>');
        }
    }
    var hide = jQuery(this);
     //Función Agregar NC
    $('#agregarNc').on('click', function(e) {

        hide.toggle("scale");
        e.preventDefault();
        console.log(data);
        data[3] = data[3].replace(/,/g, "");
        descuento += parseFloat(data[3]);
        $('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));


        total = subTotal - descuento;
        $('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
        var monto = parseFloat(data[3]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});
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
        title: 'Debe de Existir una Factura Mayor a la N.C Seleccionada',
        showConfirmButton: false,
        timer: 50000
        })

    }


 } );



 $('#example2 tbody').on('click', 'tr', function () {
    jQuery(this).hide( "blind", {direction: "horizontal"}, 500 );
     var data = t.row( this ).data();
    if(data[1]=='Factura'){
        data[3] = data[3] = data[3].replace(/,/g, "");
        subTotal -=  parseFloat(data[3]);
        $('#subtotal').text('$' + subTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }else{
        descuento -= parseFloat(data[3]);
        $('#descuento').text('$' + descuento.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    total = subTotal - descuento;
    $('#total').text('$' + total.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
    var monto = parseFloat(data[3]).toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2});

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
  document.getElementById("notasDiv").style.display = "none";
  document.getElementById("facturasDiv").style.display = "block";
}

</script>
@endsection
