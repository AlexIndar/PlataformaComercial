@extends('layouts.intranet.main',['active' => 'Logistica','permissions' => $permissions])

@section('title') Indar | Reportes @endsection

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
                            <div class="row">
                                <h3 class="card-title mt-2 mr-3">Interfaz facturación</h3>
                            </div>
                            <div class="row">
                                <div class="col-3 p-0">
                                    <label for="">Fechas:</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" id="fechas"/>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 mt-1">
                                    <label for=""></label>
                                    <button type="button" class="btn btn-block btn-outline-primary btn-lg  btn-consultar-interfaz-facturacion" onclick="logisticaController.consultBillingInterface()" ><i class="fa-solid fa-cog mr-1"></i>Consultar</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="table-interfaz-facturacion" class="table table-bordered table-hover">
                                            <thead class="encabezado-table">
                                                <tr>
                                                    <th>MOVMOVID</th>
                                                    <th>WMSCLAVE</th>
                                                    <th>FECHANS</th>
                                                    <th>FECHAWMS</th>
                                                    <th>CLIENTE</th>
                                                    <th>ARTICULO</th>
                                                    <th>CANTIDADWMS</th>
                                                    <th>CANTIDADWMS</th>
                                                    <th>CANTIDADNS</th>
                                                </tr>
                                            </thead>
                                            <tbody id="content-table-interfaz-facturacion">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
<!-- date-range-picker -->
<script src="{{ env('APP_URL')}}plugins/daterangepicker/daterangepicker.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ env('APP_URL')}}assets/intranet/js/logisticaController.js"></script>
@endsection