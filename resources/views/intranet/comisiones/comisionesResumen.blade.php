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
                                                onclick="consultar()" id="btnConsultar">Cargar Resumen </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="card-body" id="resumenTable">
                                <div  class="col-lg-12">
                                   <div class="card-body table-responsive p-0">
                                      <table id="resumenComisionesTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                                         <thead style="background-color:#002868; color:white">
                                            <tr >
                                               <th>Zona</th>
                                               <th>No.Empleado</th>
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


   });
   function consultar() {
      // $.fn.dataTable.ext.errMode = 'none';

   var pfecha = document.getElementById("fechaCliente").value;
   var mes = pfecha.slice(5,7);
   var año = pfecha.slice(0,4);
   var date = mes+'-01-'+año;
   var dateprueba = new Date(año, mes-1, 01);
   var month = dateprueba.toLocaleString('default', { month: 'long' });
   // AJAX Principal
   var loopZonas = {!! json_encode($zonas) !!};
   //console.log(loopZonas);
   var loopZonas = JSON.parse({!! json_encode($zonas) !!});
       //Llena select zonas
    var suma = 0;
    for (var i=0 ; i<loopZonas.length ; i++){
        var tamanio = loopZonas.length;
        var  idzona = loopZonas[i].zona;
$.ajax({
'headers': {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  'url': "/comisiones/getResumen",
  'type': 'GET',
  'dataType': 'json',
  'data': {zona:idzona, fecha : date, suma: suma,tamanio : tamanio },
  'enctype': 'multipart/form-data',
  'timeout': 4 * 60 * 60 * 1000,
  success: function array(data){

    suma = suma + 1;
      if(suma < tamanio){

        console.log('contador',suma);
          console.log('tamanio',tamanio);

      }else{
        $('#resumenComisionesTable').dataTable( {
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
        Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Se cargaron Correctamente Los importes de Comisiónes',
                showConfirmButton: false,
                timer: 5000
                })
        console.log('terminaste');
        document.getElementById("btnSpinner").style.display = "none";
        document.getElementById("btnConsultar").style.display = "block";
        }
        var sumaRMCI = 0;
        var sumaRMSI = 0;
        var sumaPSMASI = 0;
        var sumaPSEMSI = 0;
        var sumaSMSI = 0;
        var sumaIFac = 0;
        var sumaSaldo= 0;
        var sumaCB = 0;

        var sumaMN30 = 0;
        var sumaMN60 = 0;
        var sumaMN90 = 0;
        var sumaMN90mas = 0;
        var sumaMNtotal = 0;
        var sumaMNCB= 0;

        var sumaMB30 = 0;
        var sumaMB60 = 0;
        var sumaMB90 = 0;
        var sumaMB90mas = 0;
        var sumaMBtotal = 0;
        var sumaMBCB= 0;

        var sumaDescneg = 0;
        var sumaDesFT = 0;
        var sumaIncob = 0;
        var sumaImpD= 0;
        var sumaImpF = 0;
        var sumaImpI = 0;

        var sumaImporTotal= 0;
        var sumaTotal30= 0;
        var sumaTotal60= 0;
        var sumaTotal90 = 0;
        var sumaTotal90mas = 0;
        var sumaTotalImporte = 0;


        for (i = 0; i < data[4].length; i++) {

            sumaRMCI= sumaRMCI + data[4][i].recibo_mes_actual;
            sumaRMSI = sumaRMSI + data[4][i].recibo_mes_actual_siniva;
            sumaPSMASI = sumaPSMASI + data[4][i].pendiente_saldar_mes_anteriorl_siniva;
            sumaPSEMSI = sumaPSEMSI + data[4][i].pendiente_saldar_mes_actual;
            sumaSMSI = sumaSMSI + data[4][i].saldada_mes_actual_siniva;

            sumaDescneg += data[4][i].descneg;
            sumaDesFT += data[4][i].descuento_fuera_tiempo;
            sumaIncob += data[4][i].incobrabilidad;

            sumaImpD += data[4][i].desNegSinCalcular;
            sumaImpF += data[4][i].descFueraTiempoSinCalcular;
            sumaImpI += data[4][i].incobrabilidadSinCalcular;

            if( data[4][i].margen== "MN"){
                sumaMN30 += data[4][i].de0a30;
                sumaMN60 += data[4][i].de31a60;
                sumaMN90 += data[4][i].de61a90;
                sumaMN90mas += data[4][i].de91oMayor;
                sumaMNCB += data[4][i].comision_base;


            }else{
                sumaMB30 += data[4][i].de0a30;
                sumaMB60 += data[4][i].de31a60;
                sumaMB90 += data[4][i].de61a90;
                sumaMB90mas += data[4][i].de91oMayor;
                sumaMBCB += data[4][i].comision_base;

            }
        }
        sumaDescneg = sumaDescneg ;

        sumaMNtotal = sumaMN30 + sumaMN60 + sumaMN90 + sumaMN90mas;
        sumaMBtotal = sumaMB30 + sumaMB60 + sumaMB90 + sumaMB90mas;
        sumaTotal30= sumaMN30 + sumaMB30;
        sumaTotal60= sumaMN60 + sumaMB60;
        sumaTotal90= sumaMN90 + sumaMB90;
        sumaTotal90mas = sumaMN90mas + sumaMB90mas;
        sumaTotalImporte = sumaMBtotal + sumaMNtotal;
        var sumaCBtotal = sumaMNCB+sumaMBCB;
        totalComision = sumaCBtotal;
        var despensa = sumaCBtotal * 0.10 ;



var comisionTot = sumaCBtotal;

   var importePunt = (comisionTot * data[0].porcAlcanzado)/100;
   //console.log( comisionTot );
var vendedornombre;
var nempleado;
nempleado = data[0].numEmpVend;
//console.log(data[0]);
   if( data[0].vendedor == null){
       var vendedor = " ";
       var vendedornombre="Sin Vendedor Asignado";
   }else{
       vendedor = data[0].vendedor + ' | ' + data[0].zona;
       vendedornombre = data[0].vendedor;

   }
   var dataDetalle = data[0].detalle;
   var bonoDetalle = data[1].ctesNuevoMesDetalle;
   var i ;
   var bonosPorc;
   var rawtData = data[0].detalle;//agrupar Clientes Visitados
   var rawtDataNoActivos = data[0].detalleVisitadosNoAct;//agrupar Clientes Visitados No Activos
   //Agrupar Clientes Visitados
   var groupBy = function (miarray, prop) {
      return miarray.reduce(function(groups, item) {
         var val = item[prop];
         groups[val] = groups[val] || {companyname: item.companyName, codigo: item.codigo,fecha: item.fecha, numVisitas: 0};
         groups[val].numVisitas += item.numVisitas;
         return groups;
      }, {});
   }
   var resultData = Object.values(groupBy(rawtData,'codigo'));
   //Agrupar Clientes Visitados No Activos
   var groupNoAct = function (miarray, prop) {
      return miarray.reduce(function(groups, item) {
         var val = item[prop];
         groups[val] = groups[val] || {companyname: item.companyName, codigo: item.codigo,fecha: item.fecha, numVisitas: 0};
         groups[val].numVisitas += item.numVisitas;
         return groups;
      }, {});
   }
   var resultNoAct = Object.values(groupNoAct(rawtDataNoActivos,'codigo'));

   var ctesNoVisitados = data[0].detallePorVisitar;

   var show ;
   var porClientesVisitados;
   porClientesVisitados = data[0].totalClientes * .9;

   //console.log(porClientesVisitados);
   //console.log(data[0] );
   if ( data[0].totalClientesVisitados <= porClientesVisitados ){
      importePunt = 0.00;
      data[0].porcAlcanzado=0.00;
   }

   var comisionInt = parseFloat(comisionTot) + parseFloat(importePunt) + parseFloat(comisionTot*0.10);
   var importdiasNoLaborados;
   var comisionXdia = comisionTot / 30;
   importdiasNoLaborados = data[0].diasNoLAborados * comisionXdia;
   if(importePunt < importdiasNoLaborados){
                importdiasNoLaborados=0
            }
    comisionInt = comisionInt - importdiasNoLaborados;
   //console.log(importdiasNoLaborados, comisionInt);



   bonosPorc = (data[1].cumplimientoIndicador)*10;
   //console.log(data[1].cumplimientoIndicador);
   if(bonosPorc >= 10){
       bonosPorc = 10;
   }

   bonoImp =( bonosPorc * comisionTot /100);
   var ctesnvos ;
   var le = data[1].le;
   //var le = data[1].real -  data[1].nuevosMesActualRoTP;
   if(data[1].nuevosMesActualRoTP == 0){
       ctesnvos = '<td style="font-weight: bold"><u>' + data[1].nuevosMesActualRoTP+ '</u></td>';
   } else ctesnvos =  '<td style="font-weight: bold; cursor: pointer" data-toggle="modal" data-target="#nvosclientesModal" ><u>' + data[1].nuevosMesActualRoTP+ '</u></td>';

   var voCtesNvos = 2;
   var porCtesNvos;
   var importCtesNvos;
   if(data[1].nuevosMesActualRoTP >= voCtesNvos){
       porCtesNvos = 5;
   }else{
       porCtesNvos = 0;
   }
   importCtesNvos = ( comisionTot * porCtesNvos)/100;

   var vtasPorc = data[2].alcance/10;
   var vtasImporte = (vtasPorc/100) * comisionTot;
   var totalBonos = vtasImporte + importCtesNvos + comisionInt + bonoImp;

   if(data[2].hasOwnProperty('status')){

       Swal.fire({
       position: 'top',
       icon: 'warning',
       title: 'Error Al cargar Total de Ventas',
       showConfirmButton: false,
       timer: 5000
       })
   }else{

   }
   //Agrupar Especiales por cons
   var rawtDataEspeciales = data[3];

   var groupEspeciales = function (miarray, prop) {
      return miarray.reduce(function(groups, item) {
         var val = item[prop];
         groups[val] = groups[val] || {conse: item.conse, total: item.total, cuota: item.cuota, especialesDelMes: item.especialesDelMes, avance: item.avance};

         return groups;
      }, {});
   }
   var resultDataEspeciales = Object.values(groupEspeciales(rawtDataEspeciales,'conse'));

   var avanceEspeciales=0 ;
   var sumaRealEspeciales=0;
   for(var i=0; i < resultDataEspeciales.length-2; i++){

       if(resultDataEspeciales[i].avance >= 100){
           avanceEspeciales = 100;
       }
       else{
           avanceEspeciales = resultDataEspeciales[i].avance;
       }
       if(resultDataEspeciales[i].conse == 1 && resultDataEspeciales[20].cuota != 0){
           var avance1 ;
           if(resultDataEspeciales[20].cuota > 4 ){
               avance1 = 0;
           }else{
               avance1 = 100;
           }

            avanceEspeciales = avanceEspeciales + avance1;
       }else{
           if(resultDataEspeciales[i].conse == 2 && resultDataEspeciales[21].cuota != 0){
               var avance2 ;
           if(resultDataEspeciales[21].cuota > 4 ){
               avance2 = 0;
           }else{
               avance2 = 100;
           }

            avanceEspeciales = avanceEspeciales + avance2;
       }else{

       }
       }


            sumaRealEspeciales =sumaRealEspeciales + avanceEspeciales;
            //console.log(resultDataEspeciales[20].conse);
   }
   sumaRealEspeciales=sumaRealEspeciales/200;
   sumaRealEspeciales = sumaRealEspeciales*10;
   var alcanceEspeciales = (sumaRealEspeciales - 25)/50;
   alcanceEspeciales = alcanceEspeciales * 100;
   var porcImporteEspeciales;
   var importeEspeciales;
   var comisionTotal;
   porcImporteEspeciales = 15 * alcanceEspeciales;
   porcImporteEspeciales = porcImporteEspeciales/10000;
   importeEspeciales = porcImporteEspeciales * parseFloat(comisionTot);
   if(importeEspeciales < 0){
      importeEspeciales = 0;
  }



    var vendedorzona=data[4][0].zona;


    var prestaciones;
    var descuentosComisiones;
    var bonos;
    bonos = bonoImp + importCtesNvos+ vtasImporte + importeEspeciales;
    descuentosComisiones = sumaDescneg + sumaDesFT + sumaIncob;
    prestaciones = despensa + importePunt - importdiasNoLaborados -descuentosComisiones;
    comisionTotal = comisionTot + prestaciones + bonos - descuentosComisiones;
    var bonoEspecificos = bonoImp  + importeEspeciales;
    $('#llenaResumen').append('<tr>'+
        '<td>'+vendedorzona+'</td>'+
        '<td>'+nempleado+'</td>'+
        '<td>'+vendedornombre+'</td>'+
        '<td>'+comisionTot.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td style="color:red">'+sumaDescneg.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td style="color:red">'+sumaDesFT.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td style="color:red">'+sumaIncob.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+prestaciones.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+comisionInt.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+importCtesNvos.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+vtasImporte.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+bonoEspecificos.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '<td>'+comisionTotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+'</td>'+
        '</tr>');
        myCallback(vendedorzona,vendedornombre,comisionTot,prestaciones,comisionInt,sumaDescneg,sumaDesFT,sumaIncob,
        importCtesNvos,vtasImporte,bonoEspecificos,año,mes, comisionTotal);
  },
  error: function() {
      console.log("Error");
      alert('Error, Tiempo de espera agotado');
  }
});
}
}

function myCallback(zona,nombre,comisionBase,prestaciones,comisionInt,desneg,desft,incobrabilidad,bonoClientesNuevos,
bonoVentas,bonoEspecificos,ejercicio,periodo, comisionTotal){

    var jsonResumen = [];
    jsonResumen.push({ zona: zona, nombre: nombre, comisionBase: comisionBase, prestaciones: prestaciones,
        comisionIntegrada: comisionInt, ejercicio: ejercicio, periodo: periodo, diferenciaPrecio: desneg,
        incobrabilidad: incobrabilidad, descuFueraTiempo: desft,bonoVentas:bonoVentas, bonoEspecificos: bonoEspecificos,
        bonoClientesNuevos: bonoClientesNuevos, comisionTotal: comisionTotal });

    jsonResumen = JSON.stringify(jsonResumen);
    jsonResumen = jsonResumen.slice(1,-1);
    console.log(jsonResumen);
    $.ajax({
           'headers': {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           'url': "/comisiones/postComisionesResumenRH",
           'type': 'POST',
           'dataType': 'json',
           'data': {ResumenModel : jsonResumen},
           'enctype': 'multipart/form-data',
           'timeout': 4 * 60 * 60 * 1000,
           success: function (data){
            console.log(data);
           /*  Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Se cargó el Resumen Correctamente',
            showConfirmButton: false,
            timer: 5000
          }) */

        },
        error: function() {
            console.log(data);
            Swal.fire({
            position: 'top',
            icon: 'warning',
            title: 'Error Vuelva a cargar la página',
            showConfirmButton: false,
            timer: 5000
          })
        }
    });
}

    </script>
@endsection
