@extends('layouts.intranet.main', ['active' => 'Comisiones', 'permissions' => $permissions])
@section('title')
    Indar | Comisiones Resumen
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/intranet/css/') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('body')
    <div id="hidde" class="content-wrapper" style="min-height: 2128.12px;">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0">Comisiones | Resumen </h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Comisiones</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <h6 id="companyname" class="m-0"></h6>
                        <h6 id="companyid" class="m-0"></h6>
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
                                </div>
                            </div>
                            <div id="divFiltroCli" class="card-body">
                                <div class="col-lg-12">
                                    <div class="row ">
                                        <div class="col-sm-2">
                                            <input type="month" name="fechaCliente" id="fechaCliente" class="form-control"
                                                value="<?php echo date('Y-m'); ?>" max="<?php echo date('Y-m'); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="spinner-border text-secondary" style="display:none" id="btnSpinner">
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-3"
                                                style="background-color:#002868" style="display: block"
                                                onclick="consultar()" id="btnConsultar">Consultar </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="card-body" id="resumenTable">
                                <div  class="col-lg-12">
                                   <div class="card-body table-responsive p-0">
                                      <table id="comisionesConsultarResumenTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:65% ;font-weight: bold">
                                         <thead style="background-color:#002868; color:white">
                                            <tr >
                                               <th>Zona</th>
                                               <th>Nombre  </th>
                                               <th>Comisión Base</th>
                                               <th>DES - NEG</th>
                                               <th>DES - FT</th>
                                               <th>DES - INCOB</th>
                                               <th>Prestaciones</th>
                                               <th>Comisión Integrada</th>
                                               <th>Bono Clientes Nuevos</th>
                                               <th>Bono Ventas</th>
                                               <th>Bono Especiales / Ctes act</th>
                                               <th>Comisión Total</th>
                                            </tr>
                                         </thead>
                                         <tbody id="llenaResumen">
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
<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
 $(document).ready(function() {
    //Collapse sideBar
    $("body").addClass("sidebar-collapse");



    //Inicia Ajax
    $(document).ajaxStart(function() {
        document.getElementById("btnSpinner").style.display = "block";
        document.getElementById("btnConsultar").style.display = "none";
    });
    //Func Termina Ajax
    $(document).ajaxStop(function() {
        $('#comisionesConsultarResumenTable').dataTable( {
            dom : 'Brtip',
            paging:false,
            fixedHeader:true,
            ordering: false,
            scrollY:320,
            scrollX: true,
            scrollCollapse: true,
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
        });


        document.getElementById("btnSpinner").style.display = "none";
        document.getElementById("btnConsultar").style.display = "block";
    });

   });
function consultar() {
    $("#comisionesConsultarResumenTable").dataTable().fnDestroy();
    var tipo;
    var zonasarr = {!! json_encode($zonasarr) !!};
    if(zonasarr == 'todo'){
        tipo='ADMIN';
        var zonas = {!! json_encode($zonas) !!};
        zonas = JSON.parse(zonas);
        arrzonas= [];
        for(i=0; i< zonas.length ;i++){
            arrzonas.push(zonas[i].zona);
        }

    }else if(Array.isArray(zonasarr)){
        tipo='GTE';
        var arrzonas = zonasarr

    }else{
        window.location.href = '/';
    }
    // $.fn.dataTable.ext.errMode = 'none';

   var pfecha = document.getElementById("fechaCliente").value;
   var mes = pfecha.slice(5,7);
   var año = pfecha.slice(0,4);
   var date = mes+'-01-'+año;
$.ajax({
'headers': {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  'url': "/comisiones/getConsultaComisionesResumenRH",
  'type': 'GET',
  'dataType': 'json',
  'data': {fecha : date },
  'enctype': 'multipart/form-data',
  'timeout': 4 * 60 * 60 * 1000,
  success: function array(data){
    Swal.fire({
        position: 'top',
        icon: 'success',
        title: 'Se Cargó Correctamente el Resumen De Comisiones',
        showConfirmButton: false,
        timer: 100000
    })
    var htmlllenaResumen='';
    console.log(date, arrzonas, tipo);
    console.log(data);
    if(tipo == 'ADMIN'){
        for(i=0; i<data.length; i++){
            htmlllenaResumen += '<tr>'+
        '<td>'+data[i].zona+'</td>'+
        '<td>'+data[i].nombre+'</td>'+
        '<td>'+data[i].comisionBase.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td style="color:red">'+data[i].diferenciaPrecio.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td style="color:red">'+data[i].descuFueraTiempo.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td style="color:red">'+data[i].incobrabilidad.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+data[i].prestaciones.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+data[i].comisionIntegrada.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+data[i].bonoClientesNuevos.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+data[i].bonoVentas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+data[i].bonoEspecificos.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+data[i].comisionTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '</tr>'
        }
    $('#llenaResumen').html(htmlllenaResumen);
    }else{
        for(i=0; i<data.length; i++){
            if(arrzonas.includes(data[i].zona)){
                htmlllenaResumen += '<tr>'+
                '<td>'+data[i].zona+'</td>'+
                '<td>'+data[i].nombre+'</td>'+
                '<td>'+data[i].comisionBase.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td style="color:red">'+data[i].diferenciaPrecio.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td style="color:red">'+data[i].descuFueraTiempo.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td style="color:red">'+data[i].incobrabilidad.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td>'+data[i].prestaciones.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td>'+data[i].comisionIntegrada.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td>'+data[i].bonoClientesNuevos.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td>'+data[i].bonoVentas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td>'+data[i].bonoEspecificos.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '<td>'+data[i].comisionTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
                '</tr>'
            }
    }
    $('#llenaResumen').html(htmlllenaResumen);
  }
},
  error: function() {
      console.log("Error Resumen");
      Swal.fire({
        position: 'top',
        icon: 'warning',
        title: 'Error al Cargar el Resumen De Comisiones',
        showConfirmButton: false,
        timer: 50000
    })
  }
});

}


    </script>
@endsection
