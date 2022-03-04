
@extends('layouts.customers.customer')

@section('title') Indar - Forzar Pedido @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/addPedido.css')}}">
<script src="{{asset('assets/customers/js/pedidos/forzarPedido.js')}}"></script>
@endsection

@section('body')

  <br><br>


  <div class="container-fluid">
    <div class="title bg-blue">
        <p>Enviar Pedido a Netsuite</p>
    </div>
    <br><br><br><br>
    <div class="content">
        <!---------------------------------------------------------------------------------------------------- ENCABEZADO PEDIDO ---------------------------------------------------------------------------------------------->
        <div class="header">
            <div class="row d-flex justify-content-center">
                <div class="col-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">ID PEDIDO</span>
                        <input type="text" class="form-control" id="idCotizacion" value="4055-2/4">
                        <button type="button" class="btn btn-group-buttons" onclick="enviar()">ENVIAR</button>
                    </div>
                </div>
            </div>
          
        </div>

    </div> <!-- Cierre content -->
  </div> <!-- Cierre container-fluid -->
  <br><br><br><br>

@endsection
