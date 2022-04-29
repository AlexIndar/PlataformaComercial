
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
        <!---------------------------------------------------------------------------------------------------- ENCABEZADO ---------------------------------------------------------------------------------------------->
        <div class="header">
            <div class="row d-flex justify-content-center">
                <div class="col-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">ID PEDIDO</span>
                        <input type="text" class="form-control" id="idCotizacion" placeholder="4147-1/17">
                        <button type="button" class="btn btn-group-buttons" onclick="enviar()">ENVIAR</button> 
                        <div class="spinner-border text-secondary" style="display:none; margin-left: 15px; width: 25px; height: 25px; margin-top: 5px;" id="btnSpinner" ></div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------------------------------------------------------------------------- RESPUESTA ---------------------------------------------------------------------------------------------->
        <div class="row d-none" id="respuesta">
            <div class="col-12">
                <fieldset class="scheduler-border" style="min-height: 140px !important">
                    <legend class="scheduler-border">Respuesta</legend>
                    <h5 style="display: inline-block;">Internal ID:</h5>
                    <p style="display: inline-block;" id="internalId"></p><br>
                    <h5>JSON PETICIÓN:</h5>
                    <p style="display: inline-block;" id="jsonPeticion"></p><br>
                    <h5>JSON RESPUESTA:</h5>
                    <p style="display: inline-block;" id="jsonRespuesta"></p><br>
                    <h5>Mensaje:</h5>
                    <p style="display: inline-block;" id="message"></p><br>
                    <h5 style="display: inline-block;">Status:</h5>
                    <p style="display: inline-block;" id="status"></p><br>
                    <h5 style="display: inline-block;">Tran ID:</h5>
                    <p style="display: inline-block;" id="tranId"></p><br>
                </fieldset>
            </div>
        </div>


    </div> <!-- Cierre content -->
  </div> <!-- Cierre container-fluid -->
  <br><br><br><br> 

@endsection
