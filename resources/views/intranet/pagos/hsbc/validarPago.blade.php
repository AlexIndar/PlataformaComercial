@extends('layouts.intranet.main', ['active' => 'Ventas', 'permissions' => $permissions])

@section('title')
    HSBC - Validar Pagos
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/customers/css/promociones/addPromocion.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/intranet/css/misSolicitudes.css') }}">
    <script src="{{ asset('assets/pagos/hsbc/js/validarPagos.js') }}"></script>
    <!-- <script src="{{ asset('assets/customers/js/index.js') }}"></script> -->
@endsection

@section('body')
    <div class="content-wrapper p-5">
        <div class="container-fluid">
            <br><br>
            <!---------------------------------------------------------------------------------- DATOS GENERALES / ENCABEZADO PROMOCIONES ------------------------------------------------->

            <div class="datos-generales">
                <div class="title bg-indar">
                    <h4>Validar Pagos</h4>
                </div>
                <br>

                <div class="content-datos-generales">
                    <div class="row text-center">
                        <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                            <button class="btn btn-blue" onclick="triggerInputFile('respuesta')"><i
                                    class="fas fa-file-upload"></i> Cargar Archivos</button>
                            <input multiple type="file" name="respuestaFile" id="respuestaFile" accept=".txt" hidden>
                        </div>
                    </div>
                </div>

                <div id="respuesta">

                </div>

            </div>
        </div>
    </div>
@endsection
