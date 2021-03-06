@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar | Distribución @endsection

@section('styles')
@endsection
@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/intranet/css/logistica.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('body')
<div id="cover-spin"><img src="{{ asset('assets/intranet/images/loading.gif') }}" alt="loading" style="margin-top: 13%;"></div>
<input type="text" id="token" hidden value="{{ $token }}">
<input type="text" id="usuario" hidden value="{{ $username }}">
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                          <h3 class="card-title mt-3 mr-2">Autorizar Gastos Fleteras</h3>
                          <a type="button" class="btn btn-outline-primary" onclick="logisticaController.getFoliosAuthorize()"><i class="fa-solid fa-book mr-2"></i>Folios Autorizados</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="tableFolios" class="table table-bordered table-hover table-sm">
                                                <thead class="encabezado-table">
                                                    <tr class="text-center">
                                                        <th>Folio</th>
                                                        <th>Acreedor</th>
                                                        <th>Estado</th>
                                                        <th>Fecha</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
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
<div class="modal fade" id="modal-folio-autorizados">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title">Folios Autorizados</h4>
                <button type="button" class="btn btn-outline-primary  btn-excel ml-2" onclick="logisticaController.exportFoliosAuthorizeExcel()"><i class="fa-solid fa-file-excel mr-1"></i>Exportar</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="table-responsive">
                            <table id="tableFoliosAutorizados" class="table table-bordered table-hover table-sm">
                                <thead class="encabezado-table">
                                    <tr class="text-center">
                                        <th>Folio</th>
                                        <th>Acreedor</th>
                                        <th>Estado</th>
                                        <th>Numero Factura</th>
                                        <th>importe Factura</th>
                                        <th>Fecha</th>
                                        <th>¿Quien autorizo?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-folio-detail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Detalle Folio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="idgastofletera" hidden>
                <input type="text" id="folio" hidden>
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><Strong>Acreedor</Strong></span>
                            <span class="info-box-number text-center text-muted mb-0" id="text-acreedor"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><Strong>Folio</Strong></span>
                            <span class="info-box-number text-center text-muted mb-0" id="text-folio"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><Strong>Importe Sin IVA</Strong></span>
                            <span class="info-box-number text-center text-muted mb-0" id="text-importesinIva"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><Strong>Importe</Strong></span>
                            <span class="info-box-number text-center text-muted mb-0" id="text-importeIva"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><Strong>Estatus</Strong></span>
                            <span class="info-box-number text-center text-muted mb-2" id="text-estado"></span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-12 col-sm-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><Strong>Comentario</Strong></span>
                            <span class="info-box-number text-center text-muted mb-2" id="text-comentario"></span>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <hr>
                <div class="row">
                   <div class="col-12">
                        <h4 class="timeline-header">Detalles de guias</h3>
                        <div id="accordion"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" onclick="logisticaController.CancelFolio()">Cancelar Folio</button>
                <button type="submit" class="btn btn-plataform" onclick="logisticaController.AutoriceFolio();">Autorizar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('js')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<!-- SweetAlert2 -->
{{-- <script src="{{ env('APP_URL')}}plugins/sweetalert2/sweetalert2.min.js"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>


<script src="{{ asset('assets/intranet/js/logisticaController.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>  
@endsection