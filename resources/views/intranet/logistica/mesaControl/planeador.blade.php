@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar @endsection

@section('styles')
{{-- <link rel="stylesheet" href="{{asset('assets/intranet/css/')}}"> --}}
@endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/intranet/css/logistica.css') }}">
@endsection
@section('body')
<div id="cover-spin"><img src="{{asset('assets/intranet/images/loading.gif')}}" alt="loading" style="margin-top: 13%;"></div>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                          <h3 class="card-title mt-2 mr-3">Planeador</h3>
                          <button type="button" class="btn btn-outline-primary mr-2" onclick="logisticaController.reloadTable()"><i class="fa-solid fa-cog fa-spin mr-1"></i> Actualizar</button>
                          <label for="" id="date"><script> var dateAndTime = document.getElementById('date');

                            var currentTime = new Date();
                      
                            dateAndTime.innerHTML = 'Ultima Actualización: '+currentTime.toLocaleTimeString();</script></label>
                          <button type="button" class="btn btn-outline-primary float-right" onclick="logisticaController.slopesBoxes()"><i class="fas fa-solid fa-dolly"></i> Cajas Pendientes</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover table-sm">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th>PRIORIDAD</th>
                                            <th>FORMA ENVIO</th>
                                            <th>CLIENTE</th>
                                            <th>NUM. PEDIDO</th>
                                            <th>SECTOR 1</th>
                                            <th>SECTOR 2</th>
                                            <th>SECTOR 3</th>
                                            <th>SECTOR 4</th>
                                            <th>SECTOR 5</th>
                                            <th>VALIDANDO</th>
                                            <th>Z_BULK1</th>
                                            <th>Z_BULK2</th>
                                            <th>Z_BULKIN1</th>
                                            <th>Z_INF 1</th>
                                            <th>Z_VOL 1</th>
                                            <th>Z_VOL 2</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-table-planeador">
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-planeador-detail">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Planeador Detalle</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="table-planeador-detail" class="table table-bordered table-hover table-sm">
                        <thead class="encabezado-table">
                            <tr>
                                <th>MOV</th>
                                <th>NUM PEDIDO</th>
                                <th>PRIORIDAD</th>
                                <th>FORMA ENVIO</th>
                                <th>CLIENTE</th>
                                <th>CLAVE</th>
                                <th>NOMBRE</th>
                                <th>AREA</th>
                                <th>POR SURTIR</th>
                                <th>SURTIDO</th>
                            </tr>
                        </thead>
                        <tbody id="content-planeador-detail">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-cajas-pendientes">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Cajas Pendientes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="table-cajas-pendientes" class="table table-bordered table-hover table-sm">
                        <thead class="encabezado-table">
                            <tr>
                                <th>PEDIDO CONSOLIDADO</th>
                                <th>FORMA ENVIO</th>
                                <th>PRIORIDAD</th>
                                <th>CAJA</th>
                                <th>ARTICULO</th>
                                <th>CANTIDAD</th>
                                <th>UBICACIÓN ORIGEN</th>
                                <th>USUARIO</th>
                                <th>NOMBRE</th>
                                <th>FECHA SURTIDO</th>
                                <th>TIEMPO ESPERA</th>
                            </tr>
                        </thead>
                        <tbody id="content-cajas-pendientes">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/intranet/js/logisticaController.js') }}"></script>
@endsection