@extends('layouts.intranet.main',['active' => 'Logistica','permissions' => $permissions])

@section('title') Indar | Reportes @endsection

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
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                          <h3 class="card-title mt-2 mr-3">Gasto Fleteras</h3>
                          <button type="button" class="btn btn-outline-primary btn-consultar-gasto-fletera" onclick="logisticaController.consultFreightExpense()"><i class="fa-solid fa-cog fa-spin mr-1"></i> Consultando</button>
                          <button type="button" class="btn btn-outline-primary  btn-excel ml-2" onclick="logisticaController.exportExcelFreightExpense()" disabled><i class="fa-solid fa-file-excel mr-1"></i>Exportar</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-gasto-fleteras" class="table table-bordered table-hover table-sm">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th data-priority="1">NUM DOC</th>
                                            <th data-priority="2">VENDOR</th>
                                            <th data-priority="3">NUM FACTURA</th>
                                            <th data-priority="4">IMPORTE FACTURA</th>
                                            <th data-priority="5">CHECK RETENCIÓN</th>
                                            <th data-priority="6">UUID</th>
                                            <th data-priority="7">USUARIO</th>
                                            <th data-priority="8">COMENTARIO</th>
                                            <th data-priority="9">AUTORIZADO</th>
                                            <th data-priority="10">AUTORIZADO USUARIO</th>
                                            <th data-priority="11">NUM GUIA</th>
                                            <th data-priority="12">IMPORTE GUIA</th>
                                            <th data-priority="13">FACTURAS</th>
                                            <th data-priority="14">COMENTARIO GUIA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-table-gasto-fleteras">
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