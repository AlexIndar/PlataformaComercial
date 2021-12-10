
@extends('layouts.customers.customer')

@section('title') Indar - Agregar Pedido @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/addPedido.css')}}">
<script src="{{asset('assets/customers/js/pedidos/addPedido.js')}}"></script>
@endsection

@section('body')

  <br><br>

  <div class="container-fluid">
    <div class="title bg-blue">
        <p>Cotizar y levantar pedido a clientes</p>
    </div>
    <br><br>


    <div class="content">
        <input type="text" id="entity" value="{{$entity}}" hidden>
        <!---------------------------------------------------------------------------------------------------- ENCABEZADO PEDIDO ---------------------------------------------------------------------------------------------->
        <div class="header">
            <div class="row  text-start">
                <div class="col-lg-1 col-md-1 col-12 rowPedido">
                    <h5>Cliente</h5>
                </div>
                @if(count($data)==1)
                    <div class="col-lg-5 col-md-5 col-12 rowPedido"><input type="text" class="inputPedido" id="customerID" name="customerID" value="[{{$data[0]['companyId']}}] - {{$data[0]['company']}}" disabled></div>
                @else
                    <div class="col-lg-5 col-md-5 col-12 rowPedido">
                        <select id="customerID" name="customerID" class="form-control selectpicker" data-live-search="true" >
                            <option selected value="none">Selecciona un cliente</option>
                            @for($x=0; $x < (count($data)); $x++)
                                <option class="optionCustomerID" style="height: 30px !important;" value="{{$x}}">[{{$data[$x]['companyId']}}] - {{$data[$x]['company']}}</option>
                            @endfor
                        </select>
                    </div>
                @endif
                <div class="col-lg-3 col-md-3 col-12 rowPedido">
                    <h5>Orden de compra</h5>
                </div>
                <div class="col-lg-3 col-md-3 col-12 rowPedido"><input type="text" class="inputPedido" id="ordenCompra" name="ordenCompra" value="657191" disabled></div>
            </div>
            <div class="row  text-start">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-12 rowPedido">
                            <h5>Correo</h5>
                        </div>
                        @if(count($data)==1)
                            <div class="col-lg-10 col-md-10 col-12 rowPedido"><input type="text" class="inputPedido" id="correo" name="correo" value="{{$data[0]['email']}}"></div>
                        @else
                            <div class="col-lg-10 col-md-10 col-12 rowPedido"><input type="text" class="inputPedido" id="correo" name="correo"></div>
                        @endif
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-12 rowPedido">
                            <h5>Sucursal</h5>
                        </div>
                        <div class="col-lg-10 col-md-10 col-12 rowPedido">
                            <select id="sucursal" name="sucursal" class="form-control selectpicker" data-live-search="true">
                                @if(count($data)==1)
                                    @for($x=0; $x < (count($data[0]['addresses'])); $x++)
                                        <option style="height: 30px !important;" value="{{$x}}">{{$data[0]['addresses'][$x]['address']}}</option>
                                    @endfor
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 rowPedido">
                            <input type="checkbox" class="checkboxPedido" id="cliente_recoge"> <label for="cliente_recoge">Cliente recoge en sucursal</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-12 rowPedido">
                            <h5>Promo</h5>
                        </div>
                        <div class="col-lg-10 col-md-10 col-12 rowPedido">
                            <ul class="tags-input">
                                <li class="tags last">1PREMIABM<i class="fa fa-times"></i></li>
                                <li class="tags last">1PREMIAF4<i class="fa fa-times"></i></li>
                                <li class="tags-new">
                                    <input type="text" placeholder="Buscar"> 
                                </li>
                            </ul>  
                        </div>
                    </div>
                    <div class="col-12 rowPedido">
                            <input type="checkbox" class="checkboxPedido" id="dividir"> <label for="dividir">Dividir 2000</label>
                    </div>
                </div>
            </div>
            <div class="row text-start">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12 rowPedido">
                            <h5>Form. Envío</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12 rowPedido">
                                @if(count($data)==1)
                                    <input type="text" class="inputPedido" id="envio" name="envio" value="{{$data[0]['shippingWayF']}}" disabled>
                                @else
                                    <input type="text" class="inputPedido" id="envio" name="envio" value="" disabled>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-12 rowPedido">
                            <h5>Fletera</h5>
                        </div>
                        <div class="col-lg-10 col-md-10 col-12 rowPedido">
                                @if(count($data)==1)
                                    <input type="text" class="inputPedido" id="fletera" name="fletera" value="{{$data[0]['packgeDeliveryF']}}" disabled>
                                @else
                                    <input type="text" class="inputPedido" id="fletera" name="fletera" value="" disabled>
                                @endif
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    <!---------------------------------------------------------------------------------------------------- FIN ENCABEZADO PEDIDO ---------------------------------------------------------------------------------------------->
        
    <br><br>

    <!---------------------------------------------------------------------------------------------------- ARTICULOS PEDIDO ---------------------------------------------------------------------------------------------->

    <table class="tablaPedido">
        <tr>
            <th></th>
            <th>Art</th>
            <th>Cant</th>
            <th>Unidad</th>
            <th>Descripción</th>
            <th>Precio Lista</th>
            <th>Promo</th>
            <th>Precio Unitario</th>
            <th>Importe</th>
        </tr>
    </table>
    
    <!---------------------------------------------------------------------------------------------------- FIN ARTICULOS PEDIDO ---------------------------------------------------------------------------------------------->


    <!---------------------------------------------------------------------------------------------------- PIE PEDIDO ---------------------------------------------------------------------------------------------->


    <!---------------------------------------------------------------------------------------------------- FIN PIE PEDIDO ---------------------------------------------------------------------------------------------->


    </div>
  </div>
  

  <br><br>

@endsection
