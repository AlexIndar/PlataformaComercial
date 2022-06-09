@extends('layouts.intranet.main', ['active' => 'Intranet', 'permissions' => $permissions])

@section('title') Indar - HeatMap @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/heatmap.css')}}">
<script src="{{asset('assets/intranet/js/heatMap.js')}}"></script>
@endsection

@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <h2>HeatMap Clientes</h2>
                </div>
            </div>
            <hr class="hr-indarYellow ">
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 text-center">
                    <div class="containerMap">
                        <div id="floating-panel" style="display: none;">
                            <button id="toggle-heatmap">Alternar Mapa de Calor</button>
                            <button id="change-gradient">Alternar Tonalidad</button>
                            <button id="change-radius">Alternar Radio</button>
                            <button id="change-opacity">Alternar Opacidad</button>
                        </div>
                        <div id="map"></div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">INICIO</div>
                            <div class="col-md-6">FIN</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="date" min="1960-01-01" class="form-control float-right" id="periodIni" onchange="getCustomerList()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="date" min="1960-01-01" class="form-control float-right" id="periodEnd" onchange="getCustomerList()">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert" id="alertDate" style="display: none;">
                                    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupGerencia">GERENCIA</label>
                                </div>
                                <select id="inputGroupGerencia" name="inputGroupGerencia" class="form-control selectpicker" data-size="7" data-live-search="true" onchange="changeGerencia()">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupZonas">ZONAS</label>
                                </div>
                                <select id="inputGroupZonas" name="inputGroupZonas" class="form-control selectpicker" data-size="7" data-live-search="true" onchange="getCustomerList()">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupEnvio">ENVIO</label>
                                </div>
                                <select id="inputGroupEnvio" name="inputGroupEnvio" class="form-control selectpicker" data-size="7" data-live-search="true" onchange="getCustomerList()">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <button class="btn btn-outline-info" onclick="getCustomerList()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal" tabindex="-1" id="infoReport">
    <div class="modal-dialog text-center">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalInfoReport"><i class="fa-solid fa-triangle-exclamation"></i> Aviso <i class="fa-solid fa-triangle-exclamation"></i></h5>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCW4Yp_Swrw_1NfMh5udHnQ_g1GVgp_WTA&libraries=visualization&v=weekly" async></script>
@endsection