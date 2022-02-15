
@extends('layouts.customers.customer')

@section('title') Indar - Agregar Pedido @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/addPedido.css')}}">
<script src="{{asset('assets/customers/js/pedidos/addPedido.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
@endsection

@section('body')

  <br><br>


  <div class="container-fluid">
    <div class="title bg-blue">
        <p>Enviar Pedido a Netsuite</p>
    </div>
    <br><br>
    <div class="content">
        <!---------------------------------------------------------------------------------------------------- ENCABEZADO PEDIDO ---------------------------------------------------------------------------------------------->
        <div class="header">
            <div class="row  text-start">
                <div class="col-lg-1 col-md-1 col-12 rowPedido">
                    <h5>Pedido</h5>
                </div>
                <div class="col-lg-5 col-md-5 col-12 rowPedido"><input type="text" class="inputPedido" id="customerID" name="customerID" value=""></div>
            </div>
        </div>

    </div> <!-- Cierre content -->
  </div> <!-- Cierre container-fluid -->

@endsection
