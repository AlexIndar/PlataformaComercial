@extends('layouts.intranet.main', ['active' =>'Comisiones', 'permissions' => $permissions])
@section('title') Indar | Comisiones | Resumen @endsection
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
               <h6 class="m-0">Comisiones | Resumen</h6>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Comisiones</a></li>
                  <li class="breadcrumb-item"><a href="#">Resumen</a></li>
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
                  <div  id="divFiltroCli" class="card-body">
                     <div class="col-lg-12">
                        <div class="row ">
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
                  <div  class="card-body" id="tablaDiv">
                     <div  class="col-lg-12">
                        <div class="card-body table-responsive p-0">
                           <table id="resumenComisionesTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                              <thead style="background-color:#002868; color:white">
                                 <tr >
                                    <th>No. Emp</th>
                                    <th>Nombre</th>
                                    <th>Zona</th>
                                    <th>Grupo</th>
                                    <th>Comisión Base</th>
                                    <th>Prestaciones</th>
                                    <th>Comisión Integrada</th>
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
<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

</script>
@endsection
