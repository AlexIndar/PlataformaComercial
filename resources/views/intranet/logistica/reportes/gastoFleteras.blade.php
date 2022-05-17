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
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                          <h3 class="card-title mt-2 mr-3">Gasto Fleteras</h3>
                          <button type="button" class="btn btn-outline-primary btn-consultar-gasto-fletera" onclick="logisticaController.consultFreightExpense()"><i class="fa-solid fa-cog fa-spin mr-1"></i> Consultando</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" id="card-table" hidden>
                            <div class="table-responsive">
                                <table id="table-gasto-fleteras" class="table table-bordered table-hover table-sm">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th>NUM DOC</th>
                                            <th>VENDOR</th>
                                            <th>NUM FACTURA</th>
                                            <th>IMPORTE FACTURA</th>
                                            <th>CHECK RETENCIÓN</th>
                                            <th>UUID</th>
                                            <th>USUARIO</th>
                                            <th>COMENTARIO</th>
                                            <th>AUTORIZADO</th>
                                            <th>AUTORIZADO USUARIO</th>
                                            <th>NUM GUIA</th>
                                            <th>IMPORTE GUIA</th>
                                            <th>FACTURAS</th>
                                            <th>COMENTARIO GUIA</th>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ env('APP_URL')}}assets/intranet/js/logisticaController.js"></script>
@endsection