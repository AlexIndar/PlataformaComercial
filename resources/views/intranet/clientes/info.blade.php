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
                        <i class="fas fa-globe"></i> Clientes | Información General<a href="/clientes/pagoEnLinea" target="_blank">&nbsp;<button  class="btn btn-primary mb-3"  id="btnConsultar">Estado de Cuenta </button></a>
                        <small class="float-right"><?php echo "Fecha :  " . date("d/m/Y") . "<br>"; ?></small>
                    </h4>
                   </div>
                </div>
                <br>
                <div class="row invoice-info">
                   <div class="col-sm-6 invoice-col">
                      Info del Cliente
                      <address>
                         <strong>Nombre De Cliente </strong><br>
                        Gerencia : ----  <br>
                        Sucursal : ----- <br>
                        Tipo de Cliente:-----<br>
                        Antiguedad: 22/12/2019
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
                    <div class="col-sm-12 invoice-col text-center">
                        <p class="lead text-center">Contacto INDAR</p>
                    </div>
                    <div class="col-sm-6 invoice-col text-center">
                        <address>
                           <strong>Nombre del Vendedor </strong><br>
                           Email : indar@indar.com <br>
                           Telefono: (012) 539-1037 <br>
                        </address>
                     </div>
                     <div class="col-sm-6 invoice-col text-center">
                        <address>
                           <strong>Nombre del Gerente </strong><br>
                           Email : indar@indar.com <br>
                           Telefono: (012) 539-1037 <br>
                        </address>
                     </div>
                </div>
                <br>
                <div class="row">

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
