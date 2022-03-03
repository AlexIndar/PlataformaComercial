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
                         <h3 class="card-title">Seleccione una zona</h3>
                      </div>
                   </div>
                   <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row ">
                            <div class="col-sm-4">
                                <select name="zonas"  class="form-control js-example-basic-single" id="zonas"></select>
                            </div>
                            <div class="col-sm-4">
                                <input type="month" name="fecha" id="fecha" class="form-control" value="2022-02">
                            </div>
                            <div class="col-md-4">
                                    <div class="spinner-border text-success" style="display:none" id="btnSpinner" ></div>
                                    <button type="submit" class="btn btn-success mb-3"  style="display: block" onclick="consultar()" id="btnConsultar">Consultar </button>
                            </div>
                         </div>
                     </div>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="card-body table-responsive p-0">
                               <table id="comisionesTable" class="table table-striped table-bordered" style="width:100% ; font-size:70%">
                                  <thead style="background-color:#002868; color:white">
                                   <tr>
                                        <th class="text-center" style="font-size:15px " colspan =16  > FEBRERO </th>
                                    </tr>
                                     <tr>
                                        <th>Cliente</th>
                                        <th>Recibida en el mes con IVA</th>
                                        <th>Recibida en el mes sin IVA</th>
                                        <th>Pendiente Saldar mes anterior sin IVA</th>
                                        <th>Pendiente de saldar este mes sin IVA</th>
                                        <th>Saldada en el mes sin IVA</th>
                                        <th>Cobranza de 0 a 30 dias</th>
                                        <th>Cobranza de 31 a 60 dias</th>
                                        <th>Cobranza de 61 a 90 dias</th>
                                        <th>Cobranza a + de 90 dias</th>
                                        <th>Diferencia en Precio (Neto a Des contar)</th>
                                        <th>Desc. Fuera de Tiempo (Neto a Des contar)</th>
                                        <th>Incobr abilidad (Neto a Des contar)</th>
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
    var zonas = JSON.parse({!! json_encode($zonas) !!});
    console.log(zonas);
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
$("#comisionesTable").dataTable().fnDestroy();
var id = document.getElementById("zonas").value;
var date = '02-02-2022';
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
            //var o= JSON.parse(data);
            var rawtData = data;
            var groupBy = function (miarray, prop) {
               return miarray.reduce(function(groups, item) {
                   var val = item[prop];
                   groups[val] = groups[val] || {companyid: item.companyid, companyname: item.companyname,recibo_mes_actual: 0,recibo_mes_actual_siniva: 0,pendiente_saldar_mes_anteriorl_siniva: 0,pendiente_saldar_mes_actual: 0,saldada_mes_actual_siniva: 0,de0a30: 0,de31a60: 0,de61a90: 0,de91oMayor: 0,diferencias_precio: 0,descuento_fuera_tiempo: 0,incobrabilidad: 0,comision_base: 0};
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
                   groups[val].incobrabilidad += item.incobrabilidad;
                   groups[val].comision_base +=  Math.round(item.comision_base);


                   return groups;
               }, {});
            }
            console.log(groupBy(rawtData,'companyname'));
            var resultData = Object.values(groupBy(rawtData,'companyid'));
            console.log(resultData);
            var table = $('#comisionesTable').dataTable( {
                fixedHeader:true,
                scrollY:320,
                data : resultData,
                columns: [  //or different depending on the structure of the object
                { "data": "companyname" },
                { "data": "recibo_mes_actual" },
                { "data": "recibo_mes_actual_siniva" },
                { "data": "pendiente_saldar_mes_anteriorl_siniva" },
                { "data": "pendiente_saldar_mes_actual" },
                { "data": "saldada_mes_actual_siniva" },
                { "data": "de0a30" },
                { "data": "de31a60" },
                { "data": "de61a90" },
                { "data": "de91oMayor" },
                { "data": "diferencias_precio" },
                { "data": "descuento_fuera_tiempo" },
                { "data": "incobrabilidad" },
                { "data": "comision_base" }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
            });

            $('#comisionesTable tbody').on('click', 'tr', function () {
                $(this).toggleClass('select');
                var row = table.api().row(this).data();
               console.log(row['companyid']);
            } );

        },
        error: function() {
            console.log("Error");
            alert('Error, Tiempo de espera agotado');
        }
    });
}
</script>
@endsection
