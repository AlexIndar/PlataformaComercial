@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar | Distribución @endsection

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
                            <h3 class="card-title mt-2 mr-3">Reporte SAD</h3>
                            <button type="button" class="btn btn-outline-primary btn-consultar-reporte-sad" disabled onclick="logisticaController.reportSad()"><i class="fa-solid fa-cog fa-spin mr-1"></i> Consultando</button>
                            <button type="button" class="btn btn-outline-primary  btn-excel ml-2" onclick="logisticaController.exportExcelreportSad()" disabled><i class="fa-solid fa-file-excel mr-1"></i>Exportar</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-reporte-sad" class="table table-bordered table-hover table-sm" width="100%">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th data-priority="1">NAME</th>
                                            <th data-priority="2">COMPANY ID</th>
                                            <th data-priority="3">ZONA</th>
                                            <th data-priority="4">PEDIDO</th>
                                            <th data-priority="5">USUARIO</th>
                                            <th data-priority="6">FECHA</th>
                                            <th data-priority="7">EXCEPCION</th>
                                            <th data-priority="8">COMENTARIO</th>
                                            <th data-priority="9">FACTURA</th>
                                            <th data-priority="10">CXC MONTO</th>
                                            <th data-priority="11">CXC AGENTE</th>
                                            <th data-priority="12">CXC FECHA</th>
                                            <th data-priority="13">CXC COMENTARIO</th>
                                            <th data-priority="14">VALIDA AGENTE</th>
                                            <th data-priority="15">VALIDA FECHA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-table-reporte-sad">
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