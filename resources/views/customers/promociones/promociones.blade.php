
@extends('layouts.customers.customer')

@section('title') Indar - Promociones @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/promociones/promociones.css')}}">
<script src="{{asset('assets/customers/js/promociones/promociones.js')}}"></script>
@endsection

@section('body')

    <div class="container">
        <br><br>
        <div>
            <button class="btn-blue" onclick="addPromocion()"> <i class="fas fa-file"></i> Nueva</button>
        </div>
        <br><br>

        @foreach($promociones as $promo)
            <div class="promo">
                <div class="promo-header">
                    <h4>[{{$promo->id}}] {{$promo->nombrePromo}}</h4>
                    <div class="actions">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" title="Duplicar"><i class="fas fa-clone"></i></button>
                            <button type="button" class="btn btn-info" title="Editar"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <div class="cuerpo-promo">
                    <h5>Vigencia de <span class="fecha"><i class="fas fa-calendar"></i> {{$promo->fechaInicio}}</span> a <span class="fecha"><i class="fas fa-calendar"></i> {{$promo->fechaFin}}</span> </h5>
                    <h5>Estatus: 0</h5>
                    
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-sm btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">
                                <div class="handle"></div>
                            </button>
                        </div>
                        <br>

                </div>
            </div>

        @endforeach

        <!-- <div class="promo">
            <div class="promo-header">
                <h4>[id] Nombre Promo</h4>
                <div class="actions">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" title="Duplicar"><i class="fas fa-clone"></i></button>
                        <button type="button" class="btn btn-info" title="Editar"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="cuerpo-promo">
                <h5>Vigencia de <span class="fecha"><i class="fas fa-calendar"></i> 01/12/2020 05:30:00</span> a <span class="fecha"><i class="fas fa-calendar"></i> 23/12/2021 05:30:00</span> </h5>
                <h5>Estatus: 0</h5>
                <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
            </div>
        </div> -->

    </div>
    

@endsection
