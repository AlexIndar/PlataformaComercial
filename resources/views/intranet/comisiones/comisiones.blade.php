@extends('layouts.intranet.main', ['active' =>'Comisiones', 'permissions' => $permissions])

@section('title') Indar | Comisiones @endsection

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
                <h1 class="m-0">Comisiones |[ Vendedor] </h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Comisiones</a></li>
                   <li class="breadcrumb-item active">[Vendedor]</li>
                </ol>
             </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-6">
               <h3 class="m-0">[Nombre del Cliente] | Detalle de la Cobranza</h3>
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
       </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#comisionesTable').DataTable();
        //$('#pagosTable').DataTable();
    } );
</script>
@endsection
