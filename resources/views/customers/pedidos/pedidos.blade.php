@extends('layouts.intranet.main', ['active' => 'Ventas', 'permissions' => $permissions])

@section('title')
    Ventas - Pedidos
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/customers/css/promociones/promociones.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/customers/css/pedidos/addPedido.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/intranet/css/misSolicitudes.css') }}">
    <script src="{{ asset('assets/customers/js/pedidos/pedidos.js') }}"></script>
@endsection

@section('body')
    <div class="content-wrapper p-5">
        <div class="container">
            <br><br>
            <div>
                <button class="bg-promo btn-primary" onclick="addPedido()"> <i class="fas fa-file"></i> Nueva
                    Cotización</button>
            </div>
            <br><br>
            {{-- <a href="https://5327814.app.netsuite.com/core/media/media.nl?id=25510597&c=5327814&h=6Svz9s3L_QT_Sdjn6nb1o0W1zgJaIT1UzHNeGh1VQlBOgbBN&mv=l3ug84bc&_xt=.xml"
                download> Descarga XML </a>
            <br><br> --}}
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
                <div class="col-3" id='inputFiltro'>
                    <input type="text" class="inputPedido" id="filterValue" name="filterValue"
                        style="height: 40px !important; background-color: white !important;" disabled>
                </div>
                <div class="col-3 d-none" id='selectZonas'>
                    <select id="zonas" name="zonas" class="form-control selectpicker" data-live-search="true">
                        <option selected value="none">Selecciona una zona</option>
                    </select>
                </div>
                <div class="col-2">
                    <button type="button" id="filtrarPedidos" class="btn btn-info" style="height: 40px !important;"
                        onclick="filtrar()" disabled><i class="fas fa-search"></i> Buscar</button>
                </div>
                <div class="col-1">
                    <div class="spinner-border text-secondary"
                        style="display:none; margin-left: 15px; width: 25px; height: 25px; margin-top: 2px;"
                        id="btnSpinner"></div>
                </div>
            </div>

            <br><br>
            <div id="rowPedidos">
                <!-- AQUÍ SE AGREGAN LAS COTIZACIONES DESDE EL DOM DE JAVASCRIPT -->
            </div>


            <form style="display: none" action="/pedido/editar" method="POST" id="formEditar">
                @csrf
                <input type="hidden" id="id" name="id" value="" />
                <input type="hidden" id="companyId" name="companyId" value="" />
            </form>

            <form style="display: none" action="/pedido/nuevo" method="POST" id="formNuevo">
                @csrf
                <input type="hidden" id="entity" name="entity" value="{{ $entity }}" />
            </form>

            <!-- FORM OCULTO PARA ELIMINAR COTIZACIÓN GUARDADA-->

            <form style="display: none" action="/pedido/eliminar" method="POST" id="formDelete">
                @csrf
                <input type="text" id="idCotizacion" name="idCotizacion" value="" hidden>

            </form>

            <!-- MODAL PARA CONFIRMAR ELIMINAR COTIZACIÓN -->

            <!-- Modal -->
            <div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
