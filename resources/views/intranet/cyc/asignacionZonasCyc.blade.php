@extends('layouts.intranet.main', ['active' => 'Operaciones', 'permissions' => $permissions])

@section('title') Indar - Asignación de Zonas @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-md-10 text-center">
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-outline-info" onclick="getTemplate()"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</button>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Asignación de Zonas</h2>
                <div class="row text">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">.xlsx</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputZonasFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <label class="custom-file-label" for="inputZonasFile" id="label-inputZonasFile">Ingresar archivo ...</label>
                        </div>
                    </div>
                </div>
                <p>Las zonas en el archivo deben contener los tres agentes aunque solo cambie uno.</p>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row text-center" id="btnSuccesFile" style="display: none;">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="button" class="btn btn-outline-success" onclick="updateZonesCyc()"><i class="fas fa-upload"></i> Reasignar Zonas</button>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('assets/intranet/js/asignacionZonas.js')}}"></script>
@endsection