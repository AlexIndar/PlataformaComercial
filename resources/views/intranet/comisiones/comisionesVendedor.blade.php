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
                           <div class="col-md-2">
                              <select name="zonas"  class="form-control js-example-basic-single" id="zonas"></select>
                           </div>
                           <div class="col-sm-2">
                              <input type="month" name="fechaCliente" id="fechaCliente" class="form-control" value="<?php echo date("Y-m");?>" max = "<?php echo date("Y-m");?>">
                           </div>
                           <div class="col-md-4">
                              <div class="spinner-border text-secondary" style="display:none" id="btnSpinner" ></div>
                              <button type="submit" class="btn btn-primary mb-3" style="background-color:#002868" style="display: block" onclick="consultar()" id="btnConsultar">Consultar </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div  class="card-body" id="tablaDiv" style="display: none">
                     <div  class="col-lg-12">
                        <div class="card-body table-responsive p-0">
                           <table id="comisionesTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                              <thead style="background-color:#002868; color:white">
                                 <tr>
                                    <th id="headerMes" class="text-center" style="font-size:15px " colspan =12>  </th>
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
                                 <th  class="text-center" style="background-color:#002868; color:white; font-size:15px " colspan =8  > DIAS DE ATRASO EN LA COBRANZA PARA COMISIONES</th>
                              </tr>
                              <tr style="background-color:#002868; color:white" >
                                 <th colspan="2">Concepto</th>
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
                                 <th colspan="2">Factor MN</th>
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
                                 <th colspan="2">Factor MB</th>
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
                                 <th  class="text-center" style="background-color:#002868; color:white; font-size:15px " colspan =8  > DESCUENTOS A COMISIONES</th>
                              </tr>
                              <tr style="background-color:#002868; color:white" >
                                 <th colspan="4">Concepto</th>
                                 <th>Importe</th>
                                 <th>% de Descuento </th>
                                 <th>Total </th>
                                 <th>Neto a Descontar</th>
                              </tr>
                              <tbody id="llenadesComi">
                              </tbody>
                              <tr>
                                 <th  class="text-center" style="background-color:#002868; color:white; font-size:15px " colspan =8  > PRESTACIONES</th>
                              </tr>
                              <tr style="background-color:#002868; color:white" >
                                 <th colspan="4">Concepto</th>
                                 <th colspan="2"> % </th>
                                 <th colspan="2">Importe </th>
                              </tr>
                              <tbody id="llenaDespensa">
                              </tbody>
                              <tr style="background-color:#002868; color:white" >
                                 <th >Bono de Puntualidad (8.7%)</th>
                                 <th > % Bono </th>
                                 <th>clientes Visitados</th>
                                 <th>Total de Clientes</th>
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
                     <div   class="col-lg-12">
                        <div class="card-body table-responsive p-0">
                           <table id="bonosTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                              <thead style="background-color:#002868; color:white">
                                 <tr>
                                    <th id="headerMes" class="text-center" style="font-size:15px " colspan =7  > BONOS </th>
                                 </tr>
                                 <tr >
                                    <th style="width:320px">Clientes Nuevos</th>
                                    <th>Parametro Nvos Ctes</th>
                                    <th>Clientes Activos</th>
                                    <th>Valor Objetivo</th>
                                    <th>%  de Alcance</th>
                                    <th>Importe</th>
                                 </tr>
                              </thead>
                              <tbody id="llenaBonos">
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div   class="col-lg-12">
                        <div class="card-body table-responsive p-0">
                           <table id="bonosTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                              <thead style="background-color:#002868; color:white">
                                 <tr>
                                    <th id="headerMes" class="text-center" style="font-size:15px " colspan =7  >ESPECIALES</th>
                                 </tr>
                                 <tr >
                                    <th style="width:420px" >Especiales del Mes (15%)</th>
                                    <th >Cuota</th>
                                    <th>Real</th>
                                    <th>Avance</th>
                                 </tr>
                              </thead>
                              <tbody id="llenaEspeciales">
                                <tr>
                                  <td>E01</td>
                                  <td >cuota</td>
                                  <td>Real</td>
                                  <td>Avance</td>
                                </tr>
                                <tr>
                                    <td>E02</td>
                                    <td >cuota</td>
                                    <td>Real</td>
                                    <td>Avance</td>
                                </tr>
                                <tr>
                                    <td>E03</td>
                                    <td>cuota</td>
                                    <td>Real</td>
                                    <td>Avance</td>
                                </tr>
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
<!-- Modal Detalle Dias laborados -->
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
<!-- Modal Detalle Dias NO laborados -->
<div class="modal fade" id="diasNoLaboradosModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
       <div class="modal-content">
          <div class="modal-header bg-indarBlue">
             <h3 class="text-center title ml-auto">Detalle Días No Laborados</h3>
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
                     <div id='calendar'></div>
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
         <div class="modal-header bg-indarBlue">
            Descuentos</h3>
            <h6 id ="vendedordes" class="text-center title ml-auto"></h6>
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
                              <th>Id Documento</th>
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
<!-- Modal Clientes Nuevos-->
<div class="modal fade" id="nvosclientesModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-indarBlue">
            <h3 class="text-center title ml-auto">Detalle de Clientes Nuevos</h3>
            <h6 id ="vendedorbon" class="text-center title ml-auto"></h6>
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
                              <th>Código cliente</th>
                              <th style="width:320px">Nombre</th>
                              <th>Zona</th>
                              <th>Fecha</th>
                           </tr>
                        </thead>
                        <tbody id="clientesNvosModal">
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
<!-- Modal Editar VO-->
<div class="modal fade" id="editarVo" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-indarBlue">
            <h3 class="text-center title ml-auto">Editar Parametro Nuevos Clientes</h3>
            <h6 id ="zonareferencia" class="text-center title ml-auto"></h6>
            <input type="text" id="typeFormInf" value="" hidden>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
            </button>
         </div>
         <div class="modal-body text-indarBlue" id="modal2">
            <div class="row">
               <div class="col-md-12">
                  <div class="card-body table-responsive p-0">
                     <label for="">Nuevo Parametro  :</label>
                     <input class="form-control" type="number" name="parametro" id="parametro" placeholder="Ingrese nuevo Parametro">
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button id="submitParametro" type="submit" class="btn btn-success float-right" data-dismiss="modal">Guardar</button>
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
<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- FULLCALENDAR-->
<link href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' rel='stylesheet' />
<script src='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js'></script>




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
           document.getElementById("tablaDiv").style.display = "block";

       } );

   });
   function consultar() {
      // $.fn.dataTable.ext.errMode = 'none';

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
                   '<td style="font-weight: bold" > Cobranza </td>' +
                   '<td style="font-weight: bold">' + sumaRMCI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaRMSI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaPSMASI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaPSEMSI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaRMSI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlmn += '<tr>' +
                   '<td style="font-weight: bold" colspan="2"> Importe Cobrado productos MN </td>' +
                   '<td style="font-weight: bold">' +sumaMN30.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMN60.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMN90.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMN90mas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMNtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMNCB.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlmb += '<tr>' +
                   '<td style="font-weight: bold" colspan="2"> Importe Cobrado productos MB </td>' +
                   '<td style="font-weight: bold">' +sumaMB30.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMB60.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMB90.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaMB90mas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaMBtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">'  +sumaMBCB.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlsubtotal += '<tr style ="background-color: rgba(231, 235, 11, 0.705)">' +
                   '<td style="font-weight: bold" colspan="2"> Cobrado </td>' +
                   '<td style="font-weight: bold">' +sumaTotal30.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaTotal60.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaTotal90.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' +sumaTotal90mas.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaTotalImporte.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td id ="totalComision" style="font-weight: bold">' + sumaCBtotal.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';
                var desneg;
                var desft;
                var desinc;

                 if(sumaDescneg == 0){
                    desneg = '<tr>';
                 }else{
                    desneg = '<tr onClick="detalleDesc(1);" style="cursor: pointer" data-toggle="modal" data-target="#descModal">';
                 }
                 if(sumaDesFT == 0){
                     desft = '<tr>';
                 }else{
                     desft = '<tr  onClick="detalleDesc(2);" style="cursor: pointer"  data-toggle="modal" data-target="#descModal">';
                 }
                 if(sumaIncob == 0){
                     desinc = '<tr>';
                 }else{
                    desinc = '<tr  onClick="detalleDesc(3);" style="cursor: pointer"  data-toggle="modal" data-target="#descModal">';
                 }
                   htmldescComi += desneg +
                   '<td style="font-weight: bold" colspan="4"> DESNEG </td>' +
                   '<td style="font-weight: bold">' + sumaImpD.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">21.49 %</td>' +
                   '<td style="font-weight: bold">' + sumaDescneg.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaDescneg.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>'+
                   desft +
                   '<td style="font-weight: bold" colspan="4"> Descuento Fuera de Tiempo </td>' +
                   '<td style="font-weight: bold">' + sumaImpF.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">21.49 %</td>' +
                   '<td style="font-weight: bold">' + sumaDesFT.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaDesFT.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>'+
                   desinc +
                   '<td style="font-weight: bold" colspan="4" > Incobrabilidad </td>' +
                   '<td style="font-weight: bold">' + sumaImpI.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">21.49 %</td>' +
                   '<td style="font-weight: bold">' + sumaIncob.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '<td style="font-weight: bold">' + sumaIncob.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   htmlDespensa += '<tr>' +
                   '<td style="font-weight: bold" colspan="4"> Despensa </td>' +
                   '<td style="font-weight: bold" colspan="2"> 10.00 % </td>' +
                   '<td style="font-weight: bold" colspan="2">' + despensa.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td>' +
                   '</tr>';

                   $('#llenaTable').html(html);
                   $('#llenaMN').html(htmlmn);
                   $('#llenaMB').html(htmlmb);
                   $('#llenaSubtotal').html(htmlsubtotal);
                   $('#llenadesComi').html(htmldescComi);
                   $('#llenaDespensa').html(htmlDespensa);
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
           success: function array(data){

            var events = []; //The array
            var fechaCalendar;
            var inicioCalendar;
            console.log(data[0].detalle);
            if(data[0].detalle.length === 0 ){
                var añoCalendar = data[0].fechaFinPeriodo.slice(0,4);
                var mesCalendar = data[0].fechaFinPeriodo.slice(5,7);

                inicioCalendar = añoCalendar + '-' + mesCalendar+'-01';
                // Alerta de que no existen días Reportados
                var toast = Swal.mixin({
                    toast: true,
                    icon: 'danger',
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
                  title: 'No Existe Registro de Días trabajados!',
                  icon: 'danger'
                });

            }else{

                var añoCalendar = data[0].detalle[0].fecha.slice(6,10);
                var mesCalendar = data[0].detalle[0].fecha.slice(3,5);
                var diaCalendar = data[0].detalle[0].fecha.slice(0,2);
                inicioCalendar = añoCalendar + '-' + mesCalendar+'-'+diaCalendar;


            }


            events.push({title :'Inicio del Periodo' , start: data[0].fechaInicioPeriodo, backgroundColor: 'green'});
            events.push({title :'Fin del Periodo' , start: data[0].fechaFinPeriodo, backgroundColor: 'red'});

            for(var i =0; i < data[0].detalle.length; i++)
            {

                añoCalendar = data[0].detalle[i].fecha.slice(6,10);
                mesCalendar = data[0].detalle[i].fecha.slice(3,5);
                diaCalendar = data[0].detalle[i].fecha.slice(0,2);
                fechaCalendar = añoCalendar + '-' + mesCalendar+'-'+diaCalendar;

                events.push( {title: data[0].detalle[i].codigo , start: fechaCalendar})
            }



            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: [ 'dayGrid' ],
              defaultView: 'dayGridMonth',
              header: {
                center: 'addEventButton'
              },
              defaultDate: inicioCalendar,

              events: events

            });

            calendar.render();
            //console.log(data[0]);
           // console.log(data.porcAlcanzado);
            var htmlPuntualidad = '';
            var htmlModal = '';
            var htmlBonos = '';
            var htmlModalnc = '';

            var importePunt = (comisionTot * data[0].porcAlcanzado)/100;
            //console.log( comisionTot );
            var comisionInt = parseFloat(comisionTot) + parseFloat(importePunt) + parseFloat(comisionTot*0.10);
            if( data[0].vendedor == null){
                var vendedor = " ";
            }else{
                vendedor = data[0].vendedor + ' | ' + data[0].zona;
            }

            var dataDetalle = data[0].detalle;
            var bonoDetalle = data[1].ctesNuevoMesDetalle;
            var i ;
            var bonosPorc;
            var rawtData = data[0].detalle;
                var groupBy = function (miarray, prop) {
                return miarray.reduce(function(groups, item) {
                   var val = item[prop];
                   groups[val] = groups[val] || {formulario: item.formulario, codigo: item.codigo,fecha: item.fecha, numVisitas: 0};
                   groups[val].numVisitas += item.numVisitas;



                   return groups;
               }, {});
            }
            //console.log(groupBy(rawtData,'companyname'));
            var resultData = Object.values(groupBy(rawtData,'codigo'));
            //console.log(resultData);
            for (i = 0; i < resultData.length; i++) {

                //console.log(dataDetalle[i].formulario);
                htmlModal += '<tr>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + resultData[i].formulario + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  resultData[i].numVisitas + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  resultData[i].codigo + '</td>' +
                            '</tr>';
            }

            for (i = 0; i < bonoDetalle.length; i++) {

                htmlModalnc += '<tr>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  bonoDetalle[i].companyid + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  bonoDetalle[i].companyname + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  bonoDetalle[i].zona + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  bonoDetalle[i].date_first_order.split("T", 1);+ '</td>' +
                            '</tr>';
                }


            var show ;
            if(data[0].diasLaborados == 0){
                show =   '<td style="font-weight: bold">';
            }else show = '<td style="cursor: pointer"  data-toggle="modal" data-target="#diasModal">';

            htmlPuntualidad +=  '<tr>' +
                   '<td style="font-weight: bold" > Días No Reportados </td>' +
                   '<td style="font-weight: bold"> 8.7  % </td>' +
                   show + '<u>'+ data[0].totalClientesVisitados +'</u></td>' +
                   '<td style="font-weight: bold">'+ data[0].totalClientes +'</td>' +
                   show +'<u>'+ data[0].diasLaborados +'</u></td>' +
                   '<td style="cursor: pointer"  data-toggle="modal" data-target="#diasNoLaboradosModal"><u>'+ data[0].diasNoLAborados +'</u></td>' +
                   '<td style="font-weight: bold">'+ data[0].porcAlcanzado +'%</td>' +
                   '<td style="font-weight: bold">'+ importePunt.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})  +'</td>' +
                   '</td>'+
                   '<tr>' +
                   '<td style="font-weight: bold" colspan="7"> Comision Integrada </td>' +
                   '<td style="font-weight: bold">'+ comisionInt.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})  +'</td>' +
                   '</tr>';


            bonosPorc = parseInt(data[1].cumplimientoIndicador)*10;
            if(bonosPorc >= 10){
                bonosPorc = 10;
            }
            bonoImp =( bonosPorc * comisionTot /100);
            var ctesnvos ;
            if(data[1].nuevosMesActual == 0){
                ctesnvos = '<td style="font-weight: bold"><u>' + data[1].nuevosMesActual+ '</u></td>';
            } else ctesnvos =  '<td style="font-weight: bold; cursor: pointer" data-toggle="modal" data-target="#nvosclientesModal" ><u>' + data[1].nuevosMesActual+ '</u></td>';
            htmlBonos += '<tr>' +
                    ctesnvos
                     +
                     '<td style="font-weight: bold;cursor: pointer" data-toggle="modal" data-target="#editarVo"><u>' +  data[1].parametroCtes + '</u></td>' +
                     '<td style="font-weight: bold" >' +  data[1].real + '</td>' +
                     '<td style="font-weight: bold">' +  data[1].vo + '</td>' +
                     '<td style="font-weight: bold" >' + bonosPorc + ' % </td>' +
                     '<td style="font-weight: bold" >' +  bonoImp.toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2})+ '</td>' +
                     '</tr>';

            $('#llenaPuntualidad').html(htmlPuntualidad);
            $('#llenaModal').html(htmlModal);
            $('#vendedordes').text(vendedor);
            $('#vendedorbon').text(vendedor);
            $('#vendedor').text(vendedor);
            $('#llenaBonos').html(htmlBonos);
            $('#clientesNvosModal').html(htmlModalnc);
            $('#zonareferencia').text(data[0].zona);


           },
           error: function() {
               console.log("Error");
               alert('Error, Tiempo de espera agotado');
           }
       });
        }

   }

   $('#diasNoLaboradosModal').on('hidden.bs.modal', function () {
        // remove the bs.modal data attribute from it

        // and empty the modal-content element
       console.log('aquiiii');
    });

   //Función POST Parametro
   $('#submitParametro').on('click', function(e) {
    var parametro = document.getElementById('parametro').value;
    var ref = document.getElementById('zonareferencia').textContent;

    e.preventDefault();
    $.ajax({
           'headers': {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           'url': "/comisiones/postParametroCtesZona",
           'type': 'POST',
           'dataType': 'json',
           'data': {referencia : ref , parametroCte : parametro},
           'enctype': 'multipart/form-data',
           'timeout': 4 * 60 * 60 * 1000,
           success: function (data){
            console.log(data);
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
              title: 'Se Editó El parametro , En el ID:'+data,
              icon: 'success'
            });
        },
        error: function() {
            var toast = Swal.mixin({
                    toast: true,
                    icon: 'danger',
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
                  title: 'Error Vuelva a intentar Editar el Parametro!',
                  icon: 'danger'
                });
        }
    });

   });

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
            console.log(data);
            for (i = 0; i < data.length; i++) {

                //console.log(data[i].companyname);
                htmlModalDesc += '<tr>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' + data[i].companyid + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].companyname + '</td>' +
                            '<td style="font-weight: bold; background-color:#f9ea45">' +  data[i].tranid + '</td>' +
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
