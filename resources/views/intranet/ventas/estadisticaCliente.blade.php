@extends('layouts.intranet.main', ['active' => 'Intranet', 'permissions' => $permissions])

@section('title') Indar - Estadistica Solicitudes Clientes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <h2>Estadistica Solicitudes Clientes</h2>
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
                    <!-- <button class="btn btn-success"><i class="fas fa-download"></i> Exportar documento</button> -->
                    <button class="btn btn-success" onclick="search('{{$zone}}')"><i class="fab fa-searchengin"></i> Buscar</button>
                </div>
                <div class="col-md-4 text-center">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation">
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
                <div class="col-md-12">
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h3 class="text-center">Tabla de solicitudes</h3>
                    <hr class="hr-indarYellow">
                    <div class="row bg-black">
                        <div class="col-md-6">Tipo</div>
                        <div class="col-md-6">Cantidad</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Solicitud Guardada</div>
                        <div class="col-md-6" id="status1">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Solicitud Enviada</div>
                        <div class="col-md-6" id="status2">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Validación Guardada</div>
                        <div class="col-md-6" id="status3">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Aceptado Contado</div>
                        <div class="col-md-6" id="status4">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Aceptada Contado (pendiente Credito)</div>
                        <div class="col-md-6" id="status5">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Aceptada Credito</div>
                        <div class="col-md-6" id="status6">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Rechazada</div>
                        <div class="col-md-6" id="status7">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Rechazada Credito (Aceptada Contado)</div>
                        <div class="col-md-6" id="status8">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Solicitud Reenviada</div>
                        <div class="col-md-6" id="status9">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Solicitud Cancelada</div>
                        <div class="col-md-6" id="status10">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Revisión Referencias</div>
                        <div class="col-md-6" id="status11">-</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">Proceso Autorización</div>
                        <div class="col-md-6" id="status12">-</div>
                    </div>
                </div>
                <div class="col-md-3"></div>
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
<script src="{{asset('assets/intranet/js/estadisticaCliente.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<script>
    $('#reservation').daterangepicker();
</script>
@endsection