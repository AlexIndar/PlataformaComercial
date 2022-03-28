@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | DEMO @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection

@section('body')
<div class="content-wrapper" style="min-height: 316px;">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0">Demo </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Demo</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
                  <div class="card-body table-responsive p-0">
                     <table id="example" class="table table-hover" style="width:90% ; font-size:90% ;font-weight: bold ">
                        <thead>
                           <tr>
                              <th>Documento</th>
                              <th>Price</th>
                              <th>Sales</th>
                              <th>More</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                            <td>
                                <img src="dist/img/pdf.png" alt="Product 1" class="img-size-32 mr-2">
                                Factura
                             </td>
                              <td>$1,230 USD</td>
                              <td>

                                 198
                              </td>
                              <td>
                                 <a href="#" class="text-muted">
                                 <i class="fas fa-search"></i>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                            <td>
                                <img src="dist/img/pdf.png" alt="Product 1" class="img-size-32 mr-2">
                                Factura
                             </td>
                              <td>$199 USD</td>
                              <td>

                                 87
                              </td>
                              <td>
                                 <a href="#" class="text-muted">
                                 <i class="fas fa-search"></i>
                                 </a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>

            </div>
            <div class="col-lg-6">
                    <div  class="card-body table-responsive p-0">
                       <table id="example2" class="table table-hover" style="width:90% ; font-size:90% ;font-weight: bold ">
                          <thead>
                             <tr>
                                <th>Documento</th>
                                <th>Price</th>
                                <th>Sales</th>
                                <th>More</th>
                             </tr>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>TOTAL</th>
                                  <th>0</th>
                                  <th>0</th>
                                  <th>0</th>
                              </tr>
                          </tfoot>
                       </table>
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
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>


$(document).ready(function() {

    var table = $('#example').DataTable({
            dom : 'Brt',

        } );

    var t = $('#example2').DataTable({
        dom : 'Brt',
    } );

     $('#example tbody').on('click', 'tr', function () {
        jQuery(this).toggle("scale");
         var data = table.row( this ).data();
        console.log(data);
        t.row.add( [
           data[0],
           data[1],
            data[2],
            data[3]

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
            data[3]

        ], ).draw();
     } );



});

function consultar() {
//var x = document.getElementById("zonas").value;
$("#example").dataTable().fnDestroy();
var response = [];
var selectedRadio = $('input[name=radiobtn]:checked', '#myForm').val();
var id = '';
if(selectedRadio === 'zona'){
    id = document.getElementById("zonas").value;
    console.log(id);
}else{
    var idCliente = document.getElementById("cli").value;
    id = 'C'+idCliente;

}

$.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/AplicarPagos/getRegresaPrimerosDatos",
        'type': 'GET',
        'dataType': 'json',
        'data': {Id:id},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            var html = '';
            var tablePagos = '';
            var i;
            for (i = 0; i < data.length; i++) {
                var apagar = (data[i].saldoPendiente)-(data[i].descuentoTotal);
                if(data[i].documento !== "CustPymt"){


              html += '<tr>' +
                '<td></td>' +
                '<td>' + data[i].numDoc + '</td>' +
                '<td>' + data[i].nota + '</td>' +
                '<td>' + data[i].fecha + '</td>' +
                '<td>' + data[i].fechaRecibo + '</td>' +
                '<td>' + data[i].terminos + '</td>' +
                '<td>' + data[i].vencimiento + '</td>' +
                '<td>' + data[i].descuentoCliente + '</td>' +
                '<td>$' + data[i].importeBruto + '</td>' +
                '<td>$' + data[i].saldoPendiente + '</td>' +
                '<td>' + data[i].porcentaje + '</td>' +
                '<td>$' + data[i].descuentoTotal.toFixed(2) + '</td>' +
                '<td>$' +   apagar.toFixed(2)+ '</td>' +
                '<td>?</td>' +
                '</tr>';
                }else{
                    tablePagos += '<tr>' +
                    '<td>' + data[i].numDoc + '</td>' +
                    '<td>' + data[i].saldoPendiente + '</td>' +
                    '<td>' + data[i].cliente + '</td>' +
                    '</tr>';
                }
            }
            $('#DataResult').html(html);
            $('#tablePagos').html(tablePagos);

        },
        error: function() {
            console.log("Error");
            alert('Tiempo de espera agotado');
        }
    });



}



</script>
@endsection
