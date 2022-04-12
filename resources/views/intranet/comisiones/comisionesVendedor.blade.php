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
                        {{--
                        <h3 class="card-title">Seleccione una zona</h3>
                        --}}
                     </div>
                  </div>
                  <div  id="divFiltroCli" class="card-body">
                     <div class="col-lg-12">
                        <div class="row ">
                           <div class="col-sm-4">
                              <select name="zonas"  class="form-control js-example-basic-single" id="zonas"></select>
                           </div>
                           <div class="col-sm-4">
                              <input type="month" name="fechaCliente" id="fechaCliente" class="form-control" value="<?php echo date("Y-m");?>" max = "<?php echo date("Y-m");?>">
                           </div>
                           <div class="col-md-4">
                              <div class="spinner-border text-secondary" style="display:none" id="btnSpinner" ></div>
                              <button type="submit" class="btn btn-primary mb-3" style="background-color:#002868" style="display: block" onclick="consultar()" id="btnConsultar">Consultar </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div  class="card-body">
                     <div   class="col-lg-12">
                        <div class="card-body table-responsive p-0">
                           <table id="comisionesTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                              <thead style="background-color:#002868; color:white">
                                 <tr>
                                    <th id="headerMes" class="text-center" style="font-size:15px " colspan =7  >  </th>
                                 </tr>
                                 <tr >
                                    <th style="width:320px">Concepto</th>
                                    <th>Recibida en el Mes con IVA</th>
                                    <th>Cobrado en el Mes sin IVA</th>
                                    <th>Pendiente Saldar Mes Anterior sin IVA</th>
                                    <th>Pendiente Saldar Este Mes sin IVA</th>
                                    <th>Saldada en el Mes sin IVA</th>
                                 </tr>
                              </thead>
                              <tbody id="llenaTable">
                              </tbody>
                              <tr>
                                 <th  class="text-center" style="background-color:#002868; color:white; font-size:15px " colspan =7  > DIAS DE ATRASO EN LA COBRANZA PARA COMISIONES</th>
                              </tr>
                              <tr style="background-color:#002868; color:white" >
                                 <th>Concepto</th>
                                 <th>De 0 a 30 Días</th>
                                 <th>De 31 a 60 Días </th>
                                 <th>De 61 a 90 Días </th>
                                 <th>Más de 90 Días</th>
                                 <th>Total</th>
                                 <th>Total Comisiones</th>
                              </tr>
                              <tbody id="llenaMN">
                              </tbody>
                              <tr style="background-color:#0744a7d2 ; color:white">
                                 <th>Factor MN</th>
                                 <th>1.805 %</th>
                                 <th>1.264 % </th>
                                 <th>0.722 % </th>
                                 <th>0.000 %</th>
                                 <th>NA</th>
                                 <th>NA</th>
                              </tr>
                              <tbody id="llenaMB">
                              </tbody>
                              <tr style="background-color:#0744a7d2 ; color:white">
                                 <th>Factor MB</th>
                                 <th>0.903 %</th>
                                 <th>0.632 %</th>
                                 <th>0.361 %</th>
                                 <th>0.000 %</th>
                                 <th>NA</th>
                                 <th>NA</th>
                              </tr>
                              <tbody id="llenaSubtotal">
                              </tbody>
                              <tr>
                                 <th  class="text-center" style="background-color:#002868; color:white; font-size:15px " colspan =7  > DESCUENTOS A COMISIONES</th>
                              </tr>
                              <tr style="background-color:#002868; color:white" >
                                 <th colspan="3">Concepto</th>
                                 <th>Importe</th>
                                 <th>% de Descuento </th>
                                 <th>Total </th>
                                 <th>Neto a Descontar</th>
                              </tr>
                              <tbody id="llenadesComi">
                              </tbody>
                              <tr>
                                 <th  class="text-center" style="background-color:#002868; color:white; font-size:15px " colspan =7  > PRESTACIONES</th>
                              </tr>
                              <tr style="background-color:#002868; color:white" >
                                 <th colspan="3">Concepto</th>
                                 <th colspan="2"> % </th>
                                 <th colspan="2">Importe </th>
                              </tr>
                              <tbody id="llenaDespensa">
                              </tbody>
                              <tr style="background-color:#002868; color:white" >
                                 <th colspan="2">Bono de Puntualidad (8.7 %)</th>
                                 <th > % Bono </th>
                                 <th >Días Laborados </th>
                                 <th >Días no Reportados </th>
                                 <th >% de Alcance </th>
                                 <th >Importe </th>
                              </tr>
                              <tbody id="llenaPuntualidad">
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

  <!-- Modal Detalle Dias no laborados -->
  <div class="modal fade" id="diasModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto">Detalle de Visitas y Días Laborados</h3>
                <h6 id ="vendedor" class="text-center title ml-auto"></h6>
                <input type="text" id="typeFormInf" value="" hidden>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body table-responsive p-0">
                            <table id="modalTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold ">
                               <thead style="background-color:#002868; color:white">
                                  <tr >
                                     <th style="width:320px">Formulario</th>
                                     <th>Número de Visitas</th>
                                     <th>Código</th>
                                     <th>Fecha</th>
                                  </tr>
                               </thead>
                               <tbody id="llenaModal">
                               </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

  <!-- Modal Detalle Descuentos -->
  <div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">Descuentos</h3>
                <h6 id ="vendedor" class="text-center title ml-auto"></h6>
                <input type="text" id="typeFormInf" value="" hidden>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body table-responsive p-0">
                            <table id="modalTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:70% ;font-weight: bold ">
                               <thead style="background-color:#002868; color:white">
                                <tr >
                                    <th>Id</th>
                                    <th>Cliente</th>
                                    <th>Recibida en el mes con IVA</th>
                                    <th>Cobrado en el mes sin IVA</th>
                                    <th>Pendiente Saldar mes anterior sin IVA</th>
                                    <th>Pendiente de saldar este mes sin IVA</th>
                                    <th>Sal dada en el mes sin IVA</th>
                                    <th>Desc Neg</th>
                                    <th>Desc. Fuera de Tiempo </th>
                                    <th>Nota de Credito por Incobra bilidad</th>
                                    <th>Incobra bilidad </th>
                                    <th>Comisión Base</th>
                                 </tr>
                               </thead>
                               <tbody id="llenaDescModal">
                               </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cerrar</button>
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
<script>
   $(document).ready(function() {
       //Collapse sideBar
       $("body").addClass("sidebar-collapse");
       //Recibe Json
       var zonas = JSON.parse({!! json_encode($zonas) !!});
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
           //Esconde y muestra DIV
           document.getElementById("btnSpinner").style.display = "none";
           document.getElementById("btnConsultar").style.display = "block";
       } );

   });
   function consultar() {
      // $.fn.dataTable.ext.errMode = 'none';
   $("#comisionesTable").dataTable().fnDestroy();
   $("#comisionesDetalle").dataTable().fnDestroy();

   var id = document.getElementById("zonas").value;
   var pfecha = document.getElementById("fechaCliente").value;
   var mes = pfecha.slice(5,7);
   var año = pfecha.slice(0,4);
   var date = mes+'-01-'+año;
   var dateprueba = new Date(año, mes-1, 01);
   var month = dateprueba.toLocaleString('default', { month: 'long' });
   document.getElementById("headerMes").innerHTML = ' COBRANZA '+month.toUpperCase()+' '+año;
// AJAX Principal

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

               var html = '';
               var htmlmn = '';
               var htmlmb = '';
               var htmlsubtotal ='';
               var htmldescComi='';
               var htmlDespensa='';

               var i;
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


               for (i = 0; i < data.length; i++) {

                   sumaRMCI= sumaRMCI + data[i].recibo_mes_actual;
                   sumaRMSI = sumaRMSI + data[i].recibo_mes_actual_siniva;
                   sumaPSMASI = sumaPSMASI + data[i].pendiente_saldar_mes_anteriorl_siniva;
                   sumaPSEMSI = sumaPSEMSI + data[i].pendiente_saldar_mes_actual;
                   sumaSMSI = sumaSMSI + data[i].saldada_mes_actual_siniva;

                   sumaDescneg += data[i].descneg;
                   sumaDesFT += data[i].descuento_fuera_tiempo;
                   sumaIncob += data[i].incobrabilidad;

                   sumaImpD += data[i].desNegSinCalcular;
                   sumaImpF += data[i].descFueraTiempoSinCalcular;
                   sumaImpI += data[i].incobrabilidadSinCalcular;

                   if( data[i].margen== "MN"){
                       sumaMN30 += data[i].de0a30;
                       sumaMN60 += data[i].de31a60;
                       sumaMN90 += data[i].de61a90;
                       sumaMN90mas += data[i].de91oMayor;
                       sumaMNCB += data[i].comision_base;


                   }else{
                       sumaMB30 += data[i].de0a30;
                       sumaMB60 += data[i].de31a60;
                       sumaMB90 += data[i].de61a90;
                       sumaMB90mas += data[i].de91oMayor;
                       sumaMBCB += data[i].comision_base;

                   }
               }
               sumaDescneg = sumaDescneg*(-1) ;

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


               if(html == ''){
                   html += '<tr>' +
                   '<td style="font-weight: bold"> Cobranza </td>' +
                   '<td style="font-weight: bold">' + sumaRMCI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaRMSI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaPSMASI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaPSEMSI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaRMSI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlmn += '<tr>' +
                   '<td style="font-weight: bold"> Importe Cobrado productos MN </td>' +
                   '<td style="font-weight: bold">' +sumaMN30.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMN60.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMN90.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMN90mas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMNtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMNCB.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlmb += '<tr>' +
                   '<td style="font-weight: bold"> Importe Cobrado productos MB </td>' +
                   '<td style="font-weight: bold">' +sumaMB30.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMB60.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMB90.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMB90mas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaMBtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">'  +sumaMBCB.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlsubtotal += '<tr style ="background-color: rgba(231, 235, 11, 0.705)">' +
                   '<td style="font-weight: bold"> Cobrado </td>' +
                   '<td style="font-weight: bold">' +sumaTotal30.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaTotal60.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaTotal90.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaTotal90mas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaTotalImporte.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td id ="totalComision" style="font-weight: bold">' + sumaCBtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmldescComi += '<tr onClick="detalleDesc(1);" style="cursor: pointer" data-toggle="modal" data-target="#descModal">' +
                   '<td style="font-weight: bold" colspan="3"> DESNEG </td>' +
                   '<td style="font-weight: bold">' + sumaImpD.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">21.49 %</td>' +
                   '<td style="font-weight: bold">' + sumaDescneg.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaDescneg.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>'+
                   '<tr  onClick="detalleDesc(2);" style="cursor: pointer"  data-toggle="modal" data-target="#descModal">' +
                   '<td style="font-weight: bold" colspan="3"> Descuento Fuera de Tiempo </td>' +
                   '<td style="font-weight: bold">' + sumaImpF.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">21.49 %</td>' +
                   '<td style="font-weight: bold">' + sumaDesFT.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaDesFT.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>'+
                   '<tr  onClick="detalleDesc(3);" style="cursor: pointer"  data-toggle="modal" data-target="#descModal">' +
                   '<td style="font-weight: bold" colspan="3" > Incobrabilidad </td>' +
                   '<td style="font-weight: bold">' + sumaImpI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">21.49 %</td>' +
                   '<td style="font-weight: bold">' + sumaIncob.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaIncob.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>'/* +
                   '<tr style ="background-color: rgba(231, 235, 11, 0.705)">' +
                   '<td style="font-weight: bold" colspan="5"> Comision Base </td>' +
                   '<td style="font-weight: bold; text-center"  colspan="2">' + sumaCBtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>' */;

                   htmlDespensa += '<tr>' +
                   '<td style="font-weight: bold" colspan="3"> Despensa </td>' +
                   '<td style="font-weight: bold" colspan="2"> 10.00 % </td>' +
                   '<td style="font-weight: bold" colspan="2">' + despensa.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   $('#llenaTable').html(html);
                   $('#llenaMN').html(htmlmn);
                   $('#llenaMB').html(htmlmb);
                   $('#llenaSubtotal').html(htmlsubtotal);
                   $('#llenadesComi').html(htmldescComi);
                   $('#llenaDespensa').html(htmlDespensa);

                   $('#comisionesTable').dataTable( {
                        dom : 'Brt',
                        ordering: false,
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
                }
                myCallback(sumaCBtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
           },
           error: function() {
               console.log("Error");
               alert('Error, Tiempo de espera agotado');
           }
        });
//

        function myCallback(response) {


         var comisionTot = response.replace(',','');

          //AJAX Detalle Días
          $.ajax({
           'headers': {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           'url': "/comisiones/getDiasNoHabiles",
           'type': 'GET',
           'dataType': 'json',
           'data': {zona:id, fecha : date},
           'enctype': 'multipart/form-data',
           'timeout': 4 * 60 * 60 * 1000,
           success: function(data){
            //console.log(data.diasLaborados);
           // console.log(data.porcAlcanzado);
            var htmlPuntualidad = '';
            var htmlModal = '';
            var importePunt = (comisionTot * data.porcAlcanzado)/100;
            console.log( comisionTot );
            var comisionInt = parseFloat(comisionTot) + parseFloat(importePunt) + parseFloat(comisionTot*0.10);
            var vendedor = data.vendedor + ' | ' + data.zona;
            var dataDetalle = data.detalle;
            var i ;

            for (i = 0; i < dataDetalle.length; i++) {

                //console.log(dataDetalle[i].formulario);
                htmlModal += '<tr>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + dataDetalle[i].formulario + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  dataDetalle[i].numVisitas + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  dataDetalle[i].codigo + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  dataDetalle[i].fecha + '</td>' +
                            '</tr>';
            }

            htmlPuntualidad += '<tr style="cursor: pointer"  data-toggle="modal" data-target="#diasModal">' +
                   '<td style="font-weight: bold" colspan="2"> Días No Reportados </td>' +
                   '<td style="font-weight: bold"> 8.7  % </td>' +
                   '<td style="font-weight: bold" ><u>'+ data.diasLaborados +'</u></td>' +
                   '<td style="font-weight: bold" ><u>'+ data.diasNoLAborados +'</u></td>' +
                   '<td style="font-weight: bold">'+ data.porcAlcanzado +'%</td>' +
                   '<td style="font-weight: bold">'+ importePunt.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})  +'</td>' +
                   '</tr>'+
                   '<tr>' +
                   '<td style="font-weight: bold" colspan="6"> Comision Integrada </td>' +
                   '<td style="font-weight: bold">'+ comisionInt.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})  +'</td>' +
                   '</tr>';

            $('#llenaPuntualidad').html(htmlPuntualidad);
            $('#llenaModal').html(htmlModal);
            $('#vendedor').text(vendedor);
           },
           error: function() {
               console.log("Error");
               alert('Error, Tiempo de espera agotado');
           }
       });

          // Do whatever you need with result variable
        }

   }

   function detalleDesc(numero) {
    var id = document.getElementById("zonas").value;
    var pfecha = document.getElementById("fechaCliente").value;
    var mes = pfecha.slice(5,7);
    var año = pfecha.slice(0,4);
    var date = mes+'-01-'+año;
    if(numero == 1){
        id= 'D'+id;
    }else if(numero == 2){
        id = 'F'+id;
    }else{
        id= 'I'+id
    }
    //console.log(id);
        // AJAX Detalle Descuentos
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
            htmlModalDesc = '';
            for (i = 0; i < data.length; i++) {

                //console.log(data[i].companyname);
                htmlModalDesc += '<tr>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].companyid.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].companyname.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].recibo_mes_actual.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].recibo_mes_actual_siniva.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].pendiente_saldar_mes_anteriorl_siniva.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].pendiente_saldar_mes_anteriorl_siniva.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].recibo_mes_actual_siniva.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].descneg.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].descuento_fuera_tiempo.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].incobrabilidadADescontar.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].incobrabilidad.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].comision_base.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                            '</tr>';
            }
            $('#llenaDescModal').html(htmlModalDesc);




         /*    $('#llenaPuntualidad').html(htmlPuntualidad);
            $('#llenaModal').html(htmlModal);
            $('#vendedor').text(vendedor); */
           },
           error: function() {
               console.log("Error");
               alert('Error, Recargar Página');
           }
       });
    }


</script>
@endsection
