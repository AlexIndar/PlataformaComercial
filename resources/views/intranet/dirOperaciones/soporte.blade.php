@extends('layouts.intranet.main', ['active' => 'Operaciones', 'permissions' => $permissions])

@section('title') Indar - HeatMap @endsection

@section('styles')
<!-- <link rel="stylesheet" href="{{asset('assets/intranet/css/heatmap.css')}}"> -->
<script src="{{asset('assets/intranet/js/soporte.js')}}"></script>
@endsection
<style type="text/css">
    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <h2>SOPORTE INDARNET</h2>
                </div>
            </div>
            <hr class="hr-indarYellow ">
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 text-center">
                    <p>REPARAR REFERENCIAS DE UNA SOLICITUD</p>
                    <input type="text" name="refRepSol" id="refRepSol" class="form-control" maxlength="8" placeholder="Folio">
                    <br>
                    <button class="btn btn-success" onclick="repairReferences()">Aceptar</button>
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
                <p id="infoModalR">El campo está vacio</p>
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

@endsection