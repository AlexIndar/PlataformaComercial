@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar @endsection

@section('styles')
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
                            <h3 class="card-title mt-2 mr-3">Validar SAD</h3>
                            <button type="button" class="btn btn-outline-primary btn-consultar-validar-sad" disabled onclick="logisticaController.consultValidateSAD()"><i class="fa-solid fa-cog fa-spin mr-1"></i> Consultando</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-validar-sad" class="table table-bordered table-hover table-sm">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th data-priority="1">PEDIDO</th>
                                            <th data-priority="2">IMPORTE PEDIDO</th>
                                            <th data-priority="3">CLIENTE</th>
                                            <th data-priority="4">NOMBRE</th>
                                            <th data-priority="5">FECHA FACTURA</th>
                                            <th data-priority="6">FACTURA</th>
                                            <th data-priority="7">IMPORTE FACTURA</th>
                                            <th data-priority="8">DESCUENTO TOTAL PP</th>
                                            <th data-priority="9">IMPORTE PP</th>
                                            <th data-priority="10">EXCEPCION</th>
                                            <th data-priority="11">COMENTARIO</th>
                                            <th data-priority="12">CXC COMENTARIO</th>
                                            <th data-priority="13">MONTO</th>
                                            <th data-priority="14"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-table-validar-sad">
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
@endsection
@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/intranet/js/logisticaController.js') }}"></script>
@endsection