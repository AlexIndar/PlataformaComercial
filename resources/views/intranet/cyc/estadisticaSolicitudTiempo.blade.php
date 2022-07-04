@extends('layouts.intranet.main', ['active' => 'CyC', 'permissions' => $permissions])

@section('title') Indar - Estadistica Solicitudes Clientes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <input type="text" id="userP" value="{{$username}}" hidden>
    <input type="text" id="userR" value="{{$userRol}}" hidden>
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <h2>Estadistica Solicitudes Tiempo</h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend bg-indarBlue">
                            <label class="input-group-text" for="typeForms">Tipo de Solicitud</label>
                        </div>
                        <select class="custom-select" id="typeForms">
                            <option selected>SELECCIONAR</option>
                            <option value="4">Todas</option>
                            <option value="0">Contado</option>
                            <option value="1">Credito</option>
                            <option value="2">Credito AB</option>
                            <option value="3">Carta Responsiva</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline-success" id="exportFileBtn" onclick="getEstadisticaTiempo()"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                    <button class="btn btn-outline-success" id="exportFileBtn2" onclick="exportTableToExcel()"><i class="fa-solid fa-magnifying-glass"></i> Exporta</button>
                    <!-- <button class="btn btn-outline-success" id="exportFileBtn" onclick="getEstadisticaTiempo()"><i class="fas fa-download"></i> Exportar documento</button> -->
                </div>
                <div class="col-md-4 text-center">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation" name="daterange">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-indarYellow">
                            <h3 class="card-title text-indarBlue">Estadistica Tiempo de Solicitudes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableCyc" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Razon Social</th>
                                        <th>Zona</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>CYC</th>
                                        @if($userRol != "GERENTEVENTA")
                                        <th>Revisión</th>
                                        <th>Referencias</th>
                                        <th>Autorización</th>
                                        <th>Fecha de Registro</th>
                                        @else
                                        <th>Alta NetSuite</th>
                                        <th>1ra Compra</ht>
                                        <th>Importe</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Razon Social</th>
                                        <th>Zona</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>CYC</th>
                                        @if($userRol != "GERENTEVENTA")
                                        <th>Revisión</th>
                                        <th>Referencias</th>
                                        <th>Autorización</th>
                                        <th>Fecha de Registro</th>
                                        @else
                                        <th>Alta NetSuite</th>
                                        <th>1ra Compra</ht>
                                        <th>Importe</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>
</div>

<div class="modal" tabindex="-1" id="infoReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalInfoReport">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="infoModalR">No se encontraron resultados</p>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- MODAL HISTORIAL DE SOLICITUD-->
<div class="modal fade" id="infoClienteModal" tabindex="-1" aria-labelledby="infoClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto">INFO CLIENTE</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue">
                <div class="row">
                    <div class="col-md-12">
                        <div id="infoClienteList"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- CARGA MODAL -->
<div class="modal" tabindex="-1" id="cargaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="titleCargaModal"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Enviando información <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="bodyCargaModal"><i class="fa fa-spinner" aria-hidden="true"></i></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/intranet/js/estadisticaSolicitudTiempo.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- BS-Stepper -->
<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>

<!-- <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script> -->
<script>
    $('#reservation').daterangepicker();
</script>
@endsection