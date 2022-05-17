@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar @endsection

@section('styles')
{{-- <link rel="stylesheet" href="{{asset('assets/intranet/css/')}}"> --}}
@endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}assets/intranet/css/logistica.css">
@endsection
@section('body')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 scroll">
                    <div class="card mt-3">
                        <div class="card-body card-logistica">
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Fechas:</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" id="fechas"/>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for=""></label>
                                    <button type="button" class="btn btn-block btn-outline-primary btn-lg btn-consultar-factura" onclick="logisticaController.consultBillsXShipments()" ><i class="fa-solid fa-cog mr-1"></i>Consultar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2 card-table-facturas-embarcar" hidden>
                        <div class="card-header title-table">
                            <h3 class="card-title mt-2 mr-3">Facturas por embarcar</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div id="alert-message" hidden></div>
                            <div class="table-responsive">
                                <table id="table-facturas-embarque" class="table table-bordered table-hover table-sm display nowrap">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th>PEDIDO</th>
                                            <th>COTIZACIÓN</th>
                                            <th>CONSOLIDADO</th>
                                            <th>MOVIMIENTO</th>
                                            <th>FECHA INGRESO</th>
                                            <th>FACTURA</th>
                                            <th>ENVIA A</th>
                                            <th>FECHA FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>ZONA</th>
                                            <th>NOTA</th>
                                            <th>CONDICIÓN PAGO</th>
                                            <th>IMPORTE</th>
                                            <th>FORMA ENVIO</th>
                                            <th>FLETERA</th>
                                            <th>TOTAL EMBARQUES</th>
                                            <th>EMBARQUE</th>
                                            <th>FECHA EMBARQUE</th>
                                            <th>ESTADO EMBARQUE</th>
                                            <th>COMENTARIO EMBARQUE</th>
                                            <th>ESTADO FACTURA</th>
                                            <th>COMENTARIO FACTURA</th>
                                            <th>FECHA FLETE X CONFIRMAR</th>
                                            <th>FECHA ENTREGA</th>
                                            <th>USUARIO</th>
                                            <th>CHOFER</th>
                                            <th>DIAS</th>
                                            <th>RESPONSABLE</th>
                                            <th>DIAS PERMITIDOS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-table-facturas-embarque">
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
<!-- DataTables  & Plugins -->
<script src="{{ env('APP_URL')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/jszip/jszip.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- date-range-picker -->
<script src="{{ env('APP_URL')}}plugins/daterangepicker/daterangepicker.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ env('APP_URL')}}assets/intranet/js/logisticaController.js"></script>
@endsection