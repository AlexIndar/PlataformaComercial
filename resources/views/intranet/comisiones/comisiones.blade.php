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
                <h5 class="m-0">Comisiones </h5>
                <h6 class="m-0">Detalle de Cobranza </h6>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Comisiones</a></li>
                </ol>
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
                         <h3 class="card-title">Seleccione un cliente</h3>
                      </div>
                   </div>
                   <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row ">
                            <div class="col-sm-6">
                                <select name="cli"  class="form-control js-example-basic-single" id="cli"></select>
                            </div>
                            <div class="col-md-4">
                                    <div class="spinner-border text-success" style="display:none" id="btnSpinner" ></div>
                                    <button type="submit" class="btn btn-success mb-3"  style="display: block" onclick="consultar()" id="btnConsultar">Consultar </button>
                            </div>
                         </div>
                     </div>
                    </div>
                </div>
             </div>

          </div>
       </div>
    </div>
</div>
<div id = "show" class="content-wrapper" style="min-height: 2128.12px; display:none">
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h3 class="m-0">Comisiones | Detalle de Cobranza </h3>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Comisiones</a></li>
                </ol>
             </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-6">
               <h5 id="companyname" class="m-0"></h5>
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
                         <h3 class="card-title">Detalle de la Cobranza</h3>
                      </div>
                   </div>
                   <div class="card-body">
                    <div class="col-lg-12">
                        <div class="card-body table-responsive p-0">
                           <table id="comisionesTable" class="table table-striped table-bordered" style="width:100% ; font-size:90%">
                              <thead>
                                 <tr>
                                    <th>Documento</th>
                                    <th>Recibida en el Mes con IVA</th>
                                    <th>Recibida en el Mes sin IVA</th>
                                    <th>Pendiente Saldar Mes Anterior sin IVA</th>
                                    <th>Pendiente Saldar Este Mes sin IVA</th>
                                    <th>Saldada en el Mes sin IVA</th>
                                    <th>Fecha Factura</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Fecha Saldada</th>
                                    <th>Días</th>
                                    <th>Importe Factura</th>
                                    <th>Saldo</th>
                                    <th>Diferencia en Precio</th>
                                    <th>Desc. Fuera de Tiempo</th>
                                    <th>Incobrabilidad</th>
                                    <th>Comisión Base</th>
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
<script>
$(document).ready(function() {


    //Recibe Json
    var clientes = JSON.parse({!! json_encode($clientes) !!});
    console.log(clientes);
    //Llena select zonas
    $('.js-example-basic-single').select2();

    //Llena select Clientes
    var $selectClientes = $('#cli');
    $.each(clientes, function(id, name) {
        $selectClientes.append('<option value=' + name.companyId + '>'+  name.companyId+'</option>');
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
        document.getElementById("hidde").style.display = "none";
        document.getElementById("show").style.display = "block";
        $('#comisionesTable').DataTable();

    });

} );

function consultar() {
var id = document.getElementById("cli").value;

$.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/comisiones/getInfoCobranzaZonaWeb",
        'type': 'GET',
        'dataType': 'json',
        'data': {referencia:id},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                var fechaFact = new Date(data[i].fechaFactura).toDateString();
                var fechaDue = new Date( data[i].dueDate).toDateString();
                var recibo_mes_actual = data[i].recibo_mes_actual.toLocaleString('es-MX');
                var recibo_mes_actual_siniva = data[i].recibo_mes_actual_siniva.toLocaleString('es-MX');
                var pendiente_saldar_mes_anteriorl_siniva = data[i].pendiente_saldar_mes_anteriorl_siniva.toLocaleString('es-MX');
                var saldada_mes_actual_siniva = data[i].saldada_mes_actual_siniva.toLocaleString('es-MX');
                var pendiente_saldar_mes_actual = data[i].pendiente_saldar_mes_actual.toLocaleString('es-MX');

              html += '<tr>' +
                '<td>' + data[i].tranid+ '</td>' +
                '<td>' +  recibo_mes_actual + '</td>' +
                '<td>' +  recibo_mes_actual_siniva + '</td>' +
                '<td>' + pendiente_saldar_mes_anteriorl_siniva + '</td>' +
                '<td>' + saldada_mes_actual_siniva + '</td>' +
                '<td>' + pendiente_saldar_mes_actual + '</td>' +
                '<td>' + fechaFact + '</td>' +
                '<td>' + fechaDue + '</td>' +
                '<td>' + data[i].fecha_saldada + '</td>' +
                '<td>' + data[i].diasDiferencia + '</td>' +
                '<td>' + data[i].importe_factura + '</td>' +
                '<td>' + data[i].saldo+ '</td>' +
                '<td>' + data[i].diferencias_precio+ '</td>' +
                '<td>' + data[i].descuento_fuera_tiempo+ '</td>' +
                '<td>' + data[i].incobrabilidad+ '</td>' +
                '<td>' + data[i].comision_base+ '</td>' +
                '</tr>';
            }
            $('#llenaTable').html(html);
            $('#companyname').text(data[0].companyname);


        },
        error: function() {
            console.log("Error");
            alert('Tiempo de espera agotado');
        }
    });



}
</script>
@endsection
