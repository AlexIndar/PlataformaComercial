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
                        <i class="fas fa-globe"></i> Clientes | Pago en Linea | Nombre del Cliente.
                        <small class="float-right"><?php echo "Fecha :  " . date("d/m/Y") . "<br>"; ?></small>
                    </h4>
                   </div>
                </div>
                <div class="row invoice-info">
                   <div class="col-sm-6 invoice-col">
                      <address>
                        ID.Cliente : ----  <br>
                        Zona : ----- <br>
                      </address>
                   </div>
                   <div class="col-sm-6 invoice-col">
                      <strong>Linea de Crédito</strong><br>
                      Saldo Total: $ 400.00 a Pagar Antes del : 02/04/2022 <br>
                      Disponible: $ 600.00<br>
                      <b> Limite de Crédito:</b> $ 1,000.00  <br>
                   </div>
                </div>
                <hr>
                <div class="row">
                   <div class="col-6 table-responsive">
                    <p class="lead">Seleccione Documento a Pagar:</p>
                    <table id="example" class="table table-striped table-hover" style="width:90% ; font-size:90% ;font-weight: bold ">
                        <thead>
                           <tr>
                            <th>Documento</th>
                            <th>No.</th>
                            <th>Monto</th>
                            <th>Vencimiento</th>
                            <th>Pedido</th>
                           </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="../../dist/img/pdf.png" alt="Product 1" class="img-size-32 mr-2">
                                    Factura
                                 </td>
                                  <td> <a href="#" class="text-muted">98875</a></td>
                                  <td>$877.00</td>
                                  <td>11/07/2022</td>
                                  <td><a href="#" class="text-muted">I-60073</a></td>
                            </tr>
                           <tr>
                            <td>
                                <img src="../../dist/img/pdf.png" alt="Product 1" class="img-size-32 mr-2">
                                Factura
                             </td>
                              <td> <a href="#" class="text-muted">75009</a></td>
                              <td>$1,890.00</td>
                              <td>01/12/2022</td>
                              <td><a href="#" class="text-muted">I-7322</a></td>
                           </tr>
                           <tr>
                            <td>
                                <img src="../../dist/img/pdf.png" alt="Product 1" class="img-size-32 mr-2">
                                Factura
                             </td>
                              <td> <a href="#" class="text-muted">88722</a></td>
                              <td>$303.00</td>
                              <td>08/04/2022</td>
                              <td><a href="#" class="text-muted">I-3821</a></td>
                           </tr>
                        </tbody>
                     </table>
                   </div>
                   <div class="col-6 table-responsive">
                    <p class="lead">Documentos a Pagar:</p>
                    <table id="example2" class="table table-hover" style="font-size:90% ;font-weight: bold ">
                        <thead>
                           <tr>
                              <th>Documento</th>
                              <th>No.</th>
                              <th>Monto</th>
                              <th>Vencimiento</th>
                              <th>Pedido</th>
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
                      <img src="../../dist/img/credit/visa.png" alt="Visa">
                      <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                      <img src="../../dist/img/credit/american-express.png" alt="American Express">
                      <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
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
                                  <td>$250.30</td>
                               </tr>
                               <tr>
                                  <th>Descuentos </th>
                                  <td>$10.00</td>
                               </tr>
                               <tr>
                                  <th>Total:</th>
                                  <td>$240.30</td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                   </div>
                </div>
                <div class="row no-print">
                   <div class="col-12">
                      <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                      <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Generar Ficha de Pago
                      </button>
                      <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-download"></i> Descargar PDF
                      </button>
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
<script>
$(document).ready(function() {

var table = $('#example').DataTable({
        dom : 'Brt',

    } );

var t = $('#example2').DataTable({
    dom : 'Brt',
    rowCallback: function(row, data, index){
                $('td', row).css('background-color', 'rgba(251, 255, 20, 0.603)');
        }
} );

 $('#example tbody').on('click', 'tr', function () {
    jQuery(this).toggle("scale");
     var data = table.row( this ).data();
    console.log(data);
    t.row.add( [
       data[0],
       data[1],
        data[2],
        data[3],
        data[4]

    ] ).draw();
 } );

 $('#example2 tbody').on('click', 'tr', function () {
    jQuery(this).hide( "blind", {direction: "horizontal"}, 500 );
     var data = t.row( this ).data();
    console.log(data);
    table.row.add( [
       data[0],
       data[1],
        data[2],
        data[3],
        data[4]

    ], ).draw();
 } );



});

</script>
@endsection