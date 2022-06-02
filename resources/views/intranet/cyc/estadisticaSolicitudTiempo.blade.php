@extends('layouts.intranet.main', ['active' => 'Intranet', 'permissions' => $permissions])

@section('title') Indar - Estadistica Solicitudes Clientes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <input type="text" id="userP" value="{{$user}}" hidden>
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
                    <button class="btn btn-outline-success" id="exportFileBtn" disabled><i class="fas fa-download"></i> Exportar documento</button>
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
@endsection

@section('js')
<script src="{{asset('assets/intranet/js/estadisticaSolicitudTiempo.js')}}"></script>
<!-- ChartJS -->
<!-- <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script> -->
<script>
    $('#reservation').daterangepicker();
</script>
@endsection