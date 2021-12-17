
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
    </div>

@endsection
