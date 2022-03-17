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
                <h5 class="m-0">Comisiones | Cierre de Mes </h5>
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
                         {{-- <h3 class="card-title">Seleccione una zona</h3> --}}
                      </div>
                   </div>
                   <div  id="divFiltroCli" class="card-body">
                    <div class="col-lg-12">
                        <div class="row ">
                            <div class="col-sm-4">
                                <input type="month" name="fechaCierre" id="fechaCierre" class="form-control" value="<?php echo date('Y-m', strtotime('-1 month'));?>" max = "<?php echo date('Y-m', strtotime('-1 month'));?>">
                            </div>
                            <div class="col-md-4">
                                <div class="spinner-border text-secondary" style="display:none" id="btnSpinner" ></div>
                                <button type="submit" class="btn btn-warning mb-3" style="display: block" onclick="verificar()" id="btnCierre">Cierre de Mes </button>
                            </div>
                         </div>
                     </div>
                    </div>
                    <div id="divClientes" style="display: block" class="card-body">
                        <div class="col-lg-12">
                            <div class="card-body table-responsive p-0">
                               <table id="cierreTable" class="table table-striped table-bordered table-hover" style="width:100% ; font-size:63% ;font-weight: bold ">
                                  <thead style="background-color:#002868; color:white">
                                   <tr>
                                        <th id="headerMes" class="text-center" style="font-size:15px " colspan =16  >  </th>
                                    </tr>
                                     <tr >
                                        <th>Id</th>
                                        <th>Cliente</th>
                                        <th>Ejercicio</th>
                                        <th>Recibida Mes</th>
                                        <th>Recibida Mes sin Iva</th>
                                        <th>Pendiente Saldar</th>
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
<!-- CSS-->
<link rel="stylesheet" href="sweetalert2.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    //Collapse sideBar
    $("body").addClass("sidebar-collapse");
    //Recibe Json

    //console.log(zonas);
    //Llena select zonas
    $('.js-example-basic-single').select2();

    //Llena select Clientes


    //Inicia Ajax
    $(document).ajaxStart(function() {
        document.getElementById("btnSpinner").style.display = "block";
        document.getElementById("btnCierre").style.display = "none";
    });

    //Func Termina Ajax
    $(document).ajaxStop(function() {
        //Esconde y muestra DIVISORES
        document.getElementById("btnSpinner").style.display = "none";
        document.getElementById("btnCierre").style.display = "block";
    } );

});

function verificar(){
    var pfecha = document.getElementById("fechaCierre").value;
    var mes = pfecha.slice(5,7);
    var año = pfecha.slice(0,4);
    var date = mes+'-01-'+año;

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/comisiones/getExistePeriodoEjercicio",
        'type': 'GET',
        'dataType': 'json',
        'data': {fecha : date},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            //var o= JSON.parse(data);
            if (data == true){
                var toast = Swal.mixin({
                    toast: true,
                    icon: 'warning',
                    title: 'General Title',
                    animation: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 6000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                toast.fire({
                  animation: true,
                  title: 'Ya se existe un cierre del Mes Seleccionado, Consultando ...',
                  icon: 'warning'
                });
            consultar();
            }
        },
        error: function() {
            insertar();
            var toast = Swal.mixin({
                    toast: true,
                    icon: 'success',
                    title: 'General Title',
                    animation: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 6000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            toast.fire({
              animation: true,
              title: 'Creando Cierre de Mes',
              icon: 'success'
            });
        }
    });
}

function insertar(){
    var pfecha = document.getElementById("fechaCierre").value;
    var mes = pfecha.slice(5,7);
    var año = pfecha.slice(0,4);
    var date = mes+'-01-'+año;

 $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/comisiones/getCierreMesCobranzaZona",
        'type': 'GET',
        'dataType': 'json',
        'data': {fecha : date},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            //var o= JSON.parse(data);
            alert('Error, al insertar Registros de cierre de mes')
        },
        error: function() {
            consultar();
        }
    });
}


function consultar() {
$("#cierreTable").dataTable().fnDestroy();

var pfecha = document.getElementById("fechaCierre").value;
var mes = pfecha.slice(5,7);
var año = pfecha.slice(0,4);
var date = mes+'-01-'+año;
var dateprueba = new Date(año, mes-1, 01);  // 2009-11-10
var month = dateprueba.toLocaleString('default', { month: 'long' });
document.getElementById("headerMes").innerHTML = month.toUpperCase()+' '+año;
$.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/comisiones/getHistoricoCobranzaZonaList",
        'type': 'GET',
        'dataType': 'json',
        'data': {fecha : date},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            //var o= JSON.parse(data);
            var rawtData = data;
            var groupBy = function (miarray, prop) {
               return miarray.reduce(function(groups, item) {
                   var val = item[prop];
                   groups[val] = groups[val] || {companyId: item.companyId, companyName: item.companyName, ejercicio: item.ejercicio,recibidaMesIva: 0,recbidaMesSinIva: 0,pendienteSaldarMesSinIva: 0, comisionBase: 0};
                   groups[val].recibidaMesIva += item.recibidaMesIva;
                   groups[val].recbidaMesSinIva += item.recbidaMesSinIva;
                   groups[val].pendienteSaldarMesSinIva += item.pendienteSaldarMesSinIva;
                   groups[val].comisionBase += item.comisionBase;

                   return groups;
               }, {});
            }
            //console.log(groupBy(rawtData,'companyname'));
            var resultData = Object.values(groupBy(rawtData,'companyId'));
            console.log(resultData);
            var table = $('#cierreTable').dataTable( {
                dom : 'Brtip',
                paging: false,
                fixedHeader:true,
                scrollY:320,
                scrollX: true,
                scrollCollapse: true,
                responsive: true,
                data : resultData,
                columnDefs: [
                                {
                                  targets: [3,4,5,6,],
                                  render:  $.fn.dataTable.render.number(',', '.', 2)
                                },
                ],
                order: [[1,'asc']],
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

                columns: [  //or different depending on the structure of the object
                { "data": "companyId"},
                { "data": "companyName" },
                { "data": "ejercicio" },
                { "data": "recibidaMesIva" },
                { "data": "recbidaMesSinIva" },
                { "data": "pendienteSaldarMesSinIva" },
                { "data": "comisionBase" },

                ],

            });

        },
        error: function() {
            console.log("Error");
            alert('Error, Tiempo de espera agotado');
        }
    });
}

</script>
@endsection
