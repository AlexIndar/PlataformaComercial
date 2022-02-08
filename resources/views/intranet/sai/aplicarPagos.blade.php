@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | Aplicar Pagos @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection

@section('body')

<div class="content-wrapper" style="min-height: 2128.12px;">
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h1 class="m-0">Aplicar Pagos</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">CxC</a></li>
                   <li class="breadcrumb-item active">Aplicar Pagos</li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <div class="content">
       <div class="container-fluid">
          <div class="row">
             <div class="col-lg-4">
                <div class="card">
                   <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                         <h3 class="card-title">Controles</h3>
                      </div>
                   </div>
                   <div class="card-body">
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Zona: </label>
                            <select class="form-control selectpicker" id="select-zona" data-live-search="true">
                                <option data-tokens="0">Seleccione Opción</option>
                                <option data-tokens="1">Opcion2</option>
                                <option data-tokens="2">Opcion3</option>
                             </select>
                        </div>
                      <div class="form-check form-check-inline">
                         <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioZona" value="option1">
                         <label class="form-check-label" for="inlineRadio1">Zona</label>
                      </div>
                      <div class="form-check form-check-inline">
                         <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioCliente" value="option2">
                         <label class="form-check-label" for="inlineRadio2">Cliente</label>
                      </div>
                      <div class="form-group row">
                         <div class="col-sm-12">
                            <select class="form-control selectpicker" id="select-zona" data-live-search="true">
                               <option data-tokens="0">Seleccione Opción</option>
                               <option data-tokens="1">Opcion2</option>
                               <option data-tokens="2">Opcion3</option>
                            </select>
                         </div>
                      </div>
                   <div class="col-auto text-center">
                      <button type="submit" class="btn btn-primary mb-3">Consultar</button>
                   </div>
                   <hr>
                   <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Pagos</h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <table id="pagosTable" class="table table-striped table-bordered" style=" width:100%">
                            <thead>
                               <tr>
                                  <th>Pago</th>
                                  <th>SaldoPendiente</th>
                                  <th>Cliente</th>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                  <td>Ejemplo</td>
                                  <td>Ejemplo</td>
                                  <td>Ejemplo</td>
                               </tr>
                            </tbody>
                         </table>
                         <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Cliente: </label>
                            <input class="form-control form-control-sm" type="text" placeholder="Ingrese Nombre de Cliente" name="cliente"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Cob: </label>
                            <input class="form-control form-control-sm" type="text"  name="cob"/>
                            <label class="form-control-sm">Ven: </label>
                            <input class="form-control form-control-sm" type="text" name="ven"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Zona: </label>
                            <input class="form-control form-control-sm" type="text"name="zona"/>
                            <label class="form-control-sm">Limite: </label>
                            <input class="form-control form-control-sm" type="text" name="limite"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Pago: </label>
                            <input class="form-control form-control-sm" type="text"name="pago"/>
                            <label class="form-control-sm">Actual: </label>
                            <input class="form-control form-control-sm" type="text" name="actual"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">SAT: </label>
                            <select class="form-control selectpicker" id="select-sat" data-live-search="true">
                                <option data-tokens="0">Seleccione Opción</option>
                                <option data-tokens="1">Opcion2</option>
                                <option data-tokens="2">Opcion3</option>
                             </select>
                        </div>
                        <div class="col-auto text-center">
                            <button type="btn" class="btn btn-success mb-3">Excel</button>
                            <button type="btn" class="btn btn-secondary mb-3">Netsuite</button>
                         </div>
                    </div>
                </div>
             </div>
             </div>
             <div class="col-lg-8">
                <div class="card-body table-responsive p-0">
                   <table id="aplicarPagos" class="table table-striped table-bordered" style="width:100% ; font-size:90%">
                      <thead>
                         <tr>
                            <th>NumDoc</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                            <th>FechaRecibo</th>
                            <th>Terminos</th>
                            <th>Vencimiento</th>
                            <th>DescuentoFact</th>
                            <th>ImporteBruto</th>
                            <th>SaldoPendiente</th>
                            <th>Porcentaje</th>
                            <th>DescuentoTotal</th>
                            <th>APagar</th>
                            <th>DIFFECHA</th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                         </tr>
                      </tbody>
                   </table>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#aplicarPagos').DataTable();
        //$('#pagosTable').DataTable();

        $(function() {
        $('.selectpicker').selectpicker();
        });

    } );
</script>
@endsection
