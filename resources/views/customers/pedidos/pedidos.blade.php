@extends('layouts.intranet.main', ['active' => 'Ventas', 'permissions' => $permissions])

@section('title') Ventas - Pedidos @endsection

@section('styles') 
<link rel="stylesheet" href="{{asset('assets/customers/css/promociones/promociones.css')}}">
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<script src="{{asset('assets/customers/js/pedidos/pedidos.js')}}"></script>
@endsection

@section('body')

<div class="content-wrapper p-5">
    <div class="container">
        <br><br>
        <div>
            <button class="bg-promo btn-primary" onclick="addPedido()"> <i class="fas fa-file"></i> Nuevo Pedido</button>
        </div>
        <br><br>

        @foreach($pedidos as $pedido)
            <div class="promo">
                <div class="promo-header">
                    <h4>[#{{$pedido->idCotizacion}} - {{$pedido->companyId}}] {{$pedido->orderC}}</h4>
                    <div class="actions">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" title="Duplicar"><i class="fas fa-clone"></i></button>
                            <button type="button" class="btn btn-info" title="Editar" onclick="editarPedido('{{$pedido->idCotizacion}}', '{{$pedido->companyId}}')"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <div class="cuerpo-promo">
                    <h5>Forma Envío <span class="fecha"><i class="fas fa-truck-loading"></i> {{$pedido->shippingWay}}</span> Fletera <span class="fecha"><i class="fas fa-shipping-fast"></i> {{$pedido->packageDelivery}}</span> </h5>
                    <h5>{{$pedido->addressName}}</h5>
                    <h5>{{$pedido->comments}}</h5>
                    
                </div>
            </div>

        @endforeach

        <form style="display: none" action="/pedido/editar" method="POST" id="form">
            @csrf
            <input type="hidden" id="id" name="id" value=""/>
            <input type="hidden" id="companyId" name="companyId" value=""/>
        </form>

    </div>
    
</div>
@endsection
