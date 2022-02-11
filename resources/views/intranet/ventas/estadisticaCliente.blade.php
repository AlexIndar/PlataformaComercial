@extends('layouts.intranet.main', ['active' => 'Intranet', 'permissions' => $permissions])

@section('title') Indar - Estadistica Solicitudes Clientes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/estadisticaSolicitudes.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <input type="text" id="userP" value="{{$user}}" hidden>
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
                    <button class="btn btn-success" onclick="search()" disabled id="btnSearch"><i class="fab fa-searchengin"></i> Buscar</button>
                    <!-- <button class="btn btn-info" onclick="ChangeTableG()" id="btnChange"><i class="fa-solid fa-table"></i> Ver Tabla</button> -->
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
            <div class="row mb-2">
                <div class="col-md-4 text-center d-none" id="seeByGroup">
                    <h5>Ver por</h5>
                    <form>
                        <label class="mr-3"><input type="radio" name="seeBy" value="general" onclick="seeBySol()" id="generalRadio">General</label>
                        <label class="mr-3"><input type="radio" name="seeBy" value="gerencia" onclick="seeBySol()" id="gerenciaRadio">Gerencia</label>
                    </form>
                </div>
                <div class="col-md-4 d-none" id="gerenciaGroup">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend bg-indarBlue">
                            <label class="input-group-text" for="gerencias">Gerencias</label>
                        </div>
                        <select class="custom-select" id="gerencias">
                            <option selected>SELECCIONAR</option>
                            <option value="10">Casa</option>
                            <option value="2012">CDMX</option>
                            <option value="8">Centro</option>
                            <option value="7">Centro Norte</option>
                            <option value="5">Guadalajara</option>
                            <option value="6">Jalisco</option>
                            <option value="1012">NorEste</option>
                            <option value="9">Pacifico</option>
                            <option value="4">Telefonico</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 text-center d-none" id="showByGroup">
                    <h5>Mostrar</h5>
                    <form>
                        <label class="mr-3"><input type="radio" name="showBy" value="true" id="showStatusRadio">Por Estatus</label>
                        <label class="mr-3" id="showGerRadioD"><input type="radio" name="showBy" value="false">Por Gerencia</label>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" id="barCharShow">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <div class="col-md-12" id="donutShow">
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="row d-none" id="tabla1Es">
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
            <hr class="hr-indarYellow">
            <div class="row d-none" id="tablaInfo2">
                <table class="table" id="infoSolTab">
                    <thead>
                        <tr class="bg-indarBlue">
                            <th scope="col">Nombre</th>
                            <th scope="col">Total</th>
                            <th scope="col">Solicitud Guardada</th>
                            <th scope="col">Solicitud Enviada</th>
                            <th scope="col">Validación Guardada</th>
                            <th scope="col">Aceptada Contado</th>
                            <th scope="col">Aceptada Contado (Pendiente Credito)</th>
                            <th scope="col">Aceptada Credito</th>
                            <th scope="col">Rechazada</th>
                            <th scope="col">Rechadaza Credito (Aceptada Contado)</th>
                            <th scope="col">Solicitud Reenviada</th>
                            <th scope="col">Solicitud Cancelada</th>
                            <th scope="col">Revisión Referencias</th>
                            <th scope="col">Proceso Autorización</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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