@extends('layouts.intranet.main', ['active' => 'Ventas', 'permissions' => $permissions])

@section('title') Ventas - Pedidos @endsection

@section('styles') 
<link rel="stylesheet" href="{{asset('assets/customers/css/promociones/promociones.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/addPedido.css')}}">
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
        <div class="row">
            <div class="col-6">
                <select id="filterKey" name="filterKey" class="form-control selectpicker" data-live-search="true">
                            <option selected value="none">Filtrar por:</option>             
                            <option value="idCotizacion">ID Cotización</option>             
                            <option value="companyId">Código Cliente</option>             
                            <option value="orderC">Orden Compra</option>             
                            <option value="email">Email</option>             
                </select>
            </div>
            <div class="col-3">
                <input type="text" class="inputPedido" id="filterValue" name="filterValue" style="height: 40px !important; background-color: white !important;">
            </div>
            <div class="col-2">
                    <button type="button" id="filtrarPedidos" class="btn btn-info" style="height: 40px !important;" onclick="filtrar()"><i class="fas fa-search"></i> Buscar</button>
            </div>
            <div class="col-1">
                <div class="spinner-border text-secondary" style="display:none; margin-left: 15px; width: 25px; height: 25px; margin-top: 2px;" id="btnSpinner" ></div>
            </div>
        </div>
      
        <br><br>
        <div id="rowPedidos">
            @foreach($pedidos as $pedido)
                <div class="promo">
                    <div class="promo-header">
                        <h4>[#{{$pedido->idCotizacion}} - {{strtoupper($pedido->companyId)}}] {{$pedido->orderC}}</h4>
                        <div class="actions">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" title="Editar" onclick="editarPedido('{{$pedido->idCotizacion}}', '{{$pedido->companyId}}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar" onclick="activarEliminarModal('{{$pedido->idCotizacion}}')"><i class="fas fa-trash"></i></button>
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
        </div>
       

        <form style="display: none" action="/pedido/editar" method="POST" id="formEditar">
            @csrf
            <input type="hidden" id="id" name="id" value=""/>
            <input type="hidden" id="companyId" name="companyId" value=""/>
        </form>

        <form style="display: none" action="/pedido/nuevo" method="POST" id="formNuevo">
            @csrf
            <input type="hidden" id="entity" name="entity" value="ALL"/>
        </form>

        <!-- FORM OCULTO PARA ELIMINAR COTIZACIÓN GUARDADA-->
  
        <form style="display: none" action="/pedido/eliminar" method="POST" id="formDelete">
                @csrf
                <input type="text" id="idCotizacion" name="idCotizacion" value="" hidden>

        </form>

         <!-- MODAL PARA CONFIRMAR ELIMINAR COTIZACIÓN -->

        <!-- Modal -->
        <div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Eliminar Cotización</h4>
                    <i style="cursor:pointer;" class="fas fa-times" onclick="closeModalDelete()"></i>
                </div>
                <div class="modal-body">
                    <h5>¿Desea eliminar esta cotización?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalDelete()">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarCotizacion()">Eliminar</button>
                </div>
                </div>
            </div>
        </div>

    </div>
    
</div>
@endsection
