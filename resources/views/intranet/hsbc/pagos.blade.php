@extends('layouts.intranet.main', ['active' => 'HSBC'])

@section('title')
    HSBC - Pagos
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/customers/css/promociones/promociones.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/intranet/css/misSolicitudes.css') }}">
    <script src="{{ asset('assets/hsbc/js/pagos/pagos.js') }}"></script>
@endsection

@section('body')
    <div class="content-wrapper p-5">
        <div class="container">
            <br><br>
            <div class="row">
                <div class="col-lg-6 col-12 mt-3">
                    <button type="button" id="nuevaPromo" class="btn btn-group-buttons btn-default" onclick="nuevoPago()"><i
                            class="fas fa-file"></i> Nuevo Pago</button>
                </div>
                <div class="col-lg-6 col-12 mt-3">
                    <button type="button" id="nuevoPaquete" class="btn btn-group-buttons btn-default"
                        onclick="validarPago()"><i class="fas fa-check"></i> Validar Pago</button>
                </div>
            </div>

            <div>
            </div>
            <br><br>
        </div>
    </div>
@endsection
