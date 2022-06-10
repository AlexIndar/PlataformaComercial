@extends('layouts.customers.customer')

@section('title')
    Indar - Editar Pedido
@endsection

@section('assets')
    <link rel="stylesheet" href="{{ asset('assets/customers/css/pedidos/addPedido.css') }}">
    <script src="{{ asset('assets/customers/js/pedidos/addPedido.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endsection

@section('body')

    <br><br>


    <div class="container-fluid">
        <div class="title bg-blue">
            <p>Editar pedido</p>
        </div>
        <br><br>


        <div class="content">
            <input type="text" id="entity" value="{{ $entity }}" hidden>
            <input type="text" id="idCotizacion" value="{{ $cotizacion->idCotizacion }}" hidden>
            <!---------------------------------------------------------------------------------------------------- ENCABEZADO PEDIDO ---------------------------------------------------------------------------------------------->
            <div class="header">
                <div class="row  text-start">
                    <div class="col-lg-1 col-md-1 col-12 rowPedido">
                        <div class="skeleton-input"></div>
                        <h5 class="d-none" id="customerIDLabel">Cliente</h5>
                    </div>
                    @if (count($data) == 1)
                        <div class="col-lg-5 col-md-5 col-12 rowPedido"><input type="text" class="inputPedido"
                                id="customerID" name="customerID"
                                value="[{{ strtoupper($data[0]['companyId']) }}] - {{ strtoupper($data[0]['company']) }} ({{ strtoupper($data[0]['zona']) }})"
                                disabled></div>
                    @else
                        <div class="col-lg-5 col-md-5 col-12 rowPedido">
                            <div class="skeleton-input"></div>
                            <select id="customerID" name="customerID" class="form-control selectpicker d-none"
                                data-live-search="true">
                                <option selected value="none">Selecciona un cliente</option>
                                @for ($x = 0; $x < count($data); $x++)
                                    <option class="optionCustomerID" style="height: 30px !important;"
                                        value="{{ $x }}">[{{ strtoupper($data[$x]['companyId']) }}] -
                                        {{ strtoupper($data[$x]['company']) }} ({{ strtoupper($data[$x]['zona']) }})
                                    </option>
                                @endfor
                            </select>
                        </div>
                    @endif
                    <div class="col-lg-2 col-md-3 col-12 rowPedido">
                        <div class="skeleton-input"></div>
                        <h5 class="d-none" id="ordenCompraLabel">Orden de compra</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12 rowPedido">
                        <div class="skeleton-input"></div>
                        <input type="text" class="inputPedido d-none" id="ordenCompra" name="ordenCompra"
                            value="{{ $cotizacion->orderC }}">
                    </div>
                </div>
                <div class="row  text-start">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <h5 class="d-none" id="correoLabel">Correo</h5>
                            </div>
                            @if (count($data) == 1)
                                <div class="col-lg-10 col-md-10 col-12 rowPedido"><input type="text" class="inputPedido"
                                        id="correo" name="correo" value="{{ $cotizacion->email }}"></div>
                            @else
                                <div class="col-lg-10 col-md-10 col-12 rowPedido">
                                    <div class="skeleton-input"></div>
                                    <input type="text" class="inputPedido d-none" id="correo" name="correo">
                                </div>
                            @endif

                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <h5 class="d-none" id="sucursalLabel">Sucursal</h5>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <select id="sucursal" name="sucursal" class="form-control selectpicker d-none"
                                    data-live-search="true">
                                    <option selected value="none">Selecciona una sucursal</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <h5 class="d-none" id="envioLabel">Form. Envío</h5>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12 rowPedido">
                                @if (count($data) == 1)
                                    <input type="text" class="inputPedido" id="envio" name="envio"
                                        value="{{ $data[0]['shippingWayF'] }}" disabled>
                                @else
                                    <div class="skeleton-input"></div>
                                    <input type="text" class="inputPedido d-none" id="envio" name="envio" value="" disabled>
                                @endif
                                <div id="containerSelectEnvio" class="d-none">
                                    <select id="selectEnvio" name="selectEnvio" class="form-control selectpicker"
                                        data-live-search="true">
                                        @if (count($data) == 1)
                                            <option style="height: 30px !important;" value="none">Selecciona una forma de
                                                envío</option>
                                            @for ($x = 0; $x < count($data[0]['shippingWays']); $x++)
                                                <option style="height: 30px !important;" value="{{ $x }}">
                                                    {{ $data[0]['shippingWays'][$x] }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <h5 class="d-none" id="fleteraLabel">Fletera</h5>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <input type="text" class="inputPedido d-none" id="fletera" name="fletera" value=""
                                    autocomplete="off" disabled>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <h5 class="d-none" id="tags-promoLabel">Promo</h5>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <ul class="tags-input d-none" id="tags-promo"></ul>
                            </div>
                        </div>
                        <br>
                        <div class="row d-flex flex-row justify-content-center align-items-center">
                            <div class="col-lg-2 col-md-3 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <h5 class="d-none" id="cuponLabel">Cupón</h5>
                            </div>
                            <div class="col-lg-4 col-md-9 col-12 rowPedido">
                                <div class="skeleton-input"></div>
                                <input type="text" class="inputPedido d-none" id="cupon" name="cupon">
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 rowPedido d-none" id="cliente_recogeLabel">
                                <input type="checkbox" class="checkboxPedido" id="cliente_recoge"> <label
                                    class="cliente_recogeLabel" for="cliente_recoge">Cliente recoge en sucursal</label>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 rowPedido" id="cliente_recogeSkeleton">
                                <div class="skeleton-input"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12 rowPedido d-none" id="separar2000Label">
                                <input type="checkbox" class="checkboxPedido" id="separar2000"> <label
                                    class="separar2000" for="separar2000">Separar 2000</label>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 rowPedido">
                                @if (count($data) == 1)
                                    <label id="categoryCte">Categoría Cliente: {{ $data[0]['category'] }}</label>
                                @else
                                    <label class="d-none" id="categoryCte"></label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!---------------------------------------------------------------------------------------------------- FIN ENCABEZADO PEDIDO ---------------------------------------------------------------------------------------------->

            <br><br>

            <!---------------------------------------------------------------------------------------------------- PEDIDO  ---------------------------------------------------------------------------------------------->

            <div id="loading" class="d-flex flex-row justify-content-center align-items-center"
                style="width: 100%; height: 100px; background-color: #002868; color: white;">
                <h5 id="loading-message">Cargando inventario ...</h5>
            </div>


            <div id="pedido" style="display:none;">

                <div style="display: flex; align-items: flex-start;">
                    <h5>Scroll </h5>
                    <input type="checkbox" id="checkbox1" class='input-switch' />
                    <label for="checkbox1" class="switch" id="label-switch" onmouseup="activeSwitch(1)"></label>
                </div>

                <!-- TABLA ARTICULOS PEDIDO -->

                <div class="cuerpoPedido row">
                    <div class="col-12 overflow-auto">
                        <table class="tablaPedido" id="tablaPedido">
                            <!-- CABECERA DE TABLA -->
                            <tr>
                                <th>
                                    <div class="totalFilas">
                                        <h5># <span class="totalFilasCant" id="totalFilasCant">0</span></h5>
                                    </div>
                                </th>
                                <th>Art</th>
                                <th>Cant</th>
                                <th>Descripción</th>
                                <th>Precio Lista</th>
                                <th>Promo</th>
                                <th>Precio Unitario</th>
                                <th>Importe</th>
                                <th></th>
                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <!-- CUERPO DE TABLA -->

                        </table>
                    </div>

                    <div class="col-12 text-center mt-3 messageAddProducts" id="messageAddProducts">
                        Agrega Productos
                    </div>
                </div>

                <br>

                <!-- CARGAR POR CÓDIGO -->

                <div class="row">
                    <div class="col-lg-4 col-md-5 col-12">
                        <fieldset class="scheduler-border" style="min-height: 140px !important">
                            <legend class="scheduler-border">Cargar por código</legend>

                            <table id="tableCargarPorCodigo" class="tableCargarPorCodigo inactive w-100">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cantidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <button class="btnAgregarPorCodigo mt-3" onclick="addRowCargarPorCodigo()"><i
                                    class="fas fa-plus"></i> Agregar</button>
                            <button id="btnCargarPorCodigo" class="btnCargarPorCodigo mt-3 d-none"
                                onclick="cargarProductosPorCodigo()"><i class="fas fa-arrow-up"></i> Cargar</button>
                        </fieldset>
                    </div>

                    <div class="col-lg-5 col-md-3 col-12">
                        <fieldset class="scheduler-border" style="min-height: 140px !important">
                            <legend class="scheduler-border">Comentarios</legend>
                            <textarea id="comments" name="textarea" cols="40" rows="2" class="form-control" maxlength="400"
                                style="min-height: 50px;">{{ $cotizacion->comments }}</textarea>
                        </fieldset>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <fieldset class="scheduler-border" style="min-height: 140px !important">
                            <legend class="scheduler-border">Detalles Pedido</legend>
                            <h5><strong>SUBTOTAL:</strong> <span style="float: right; text-align: right"
                                    id="subtotalPedido">$0.00</span></h5>
                            <h5><strong>IVA:</strong> <span style="float: right; text-align: right"
                                    id="ivaPedido">$0.00</span></h5>
                            <h5><strong>TOTAL:</strong> <span style="float: right; text-align: right"
                                    id="totalPedido">$0.00</span></h5>
                        </fieldset>

                    </div>

                </div>


                <!---------------------------------------------------------------------------------------------------- PIE PEDIDO ---------------------------------------------------------------------------------------------->

                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" id="mostrarInventario" onclick="cargarInventario()" class="btn btn-group-buttons"
                        data-toggle="modal" data-target=".bd-example-modal-xl"><i class="fab fa-searchengin"></i>
                        Buscar</button>
                    <button type="button" id="downloadPlantilla" class="btn btn-group-buttons"
                        onclick="downloadPlantillaPedido()"><i class="fas fa-file-download"></i> Plantilla</button>
                    <button type="button" id="importarCodigos" class="btn btn-group-buttons"
                        onclick="triggerInputFile()"><i class="fas fa-upload"></i> Importar</button>
                    <input type="file" name="excelCodes" id="excelCodes" accept=".csv, .xls, .xlsx" hidden>
                    <button type="button" id="guardarCotizacion" class="btn btn-group-buttons" onclick="save(2)"><i
                            class="fas fa-save"></i> Guardar</button>
                    <button type="button" id="separarPedido" class="btn btn-group-buttons"
                        onclick="separarPedidosPromo(null,true)"><i class="fas fa-layer-group"></i> Separar Pedido</button>
                    <div class="spinner-border text-secondary"
                        style="display:none; margin-left: 15px; width: 25px; height: 25px; margin-top: 2px;"
                        id="btnSpinner"></div>
                </div>
                <br><br>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" id="nuevaCotizacion" class="btn btn-group-buttons" onclick="nuevaCotizacion()"><i
                            class="fas fa-file"></i> Nueva cotización</button>
                    <button type="button" id="borrarCotizacion" class="btn btn-group-buttons"
                        onclick="activarEliminarModal()"><i class="fas fa-trash"></i> Borrar cotización</button>
                    <button type="button" id="enviarCotizacion" class="btn btn-group-buttons" onclick="sendEmail()"><i
                            class="fas fa-envelope"></i> Enviar cotización</button>
                    <button type="button" id="exportToExcel" class="btn btn-group-buttons"
                        onclick="exportTableToExcel('tablaPedido', 'cotizacion')"><i class="fas fa-download"></i>
                        Descargar
                        cotización</button>
                </div>
                <br><br>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" id="pedidosAnteriores" class="btn btn-group-buttons"
                        onclick="pedidosAnteriores()"><i class="fas fa-history"></i> Pedidos anteriores</button>
                    <button type="button" id="levantarPedido" class="btn btn-group-buttons" onclick="save(4)"><i
                            class="fas fa-check"></i> Levantar pedido</button>
                    <!-- <button type="button" id="pedidosClientes" class="btn btn-group-buttons"><i class="fas fa-user"></i> Pedidos clientes</button>
                                                    <button type="button" id="pedidosPendientes" class="btn btn-group-buttons"><i class="fas fa-clock"></i> Pedidos pendientes</button> -->
                </div>

                <!---------------------------------------------------------------------------------------------------- FIN PIE PEDIDO ---------------------------------------------------------------------------------------------->


                <!---------------------------------------------------------------------------------------------------- INVENTARIO ---------------------------------------------------------------------------------------------->

                <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="modalInventario"
                    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content modal-content-inventario">
                            <input type="text" id="empty" value="yes" hidden>
                            <i class="fa-solid fa-lg fa-xmark" id="closeModalInventario"
                                style="cursor: pointer; margin-top: -8px;" onclick="closeModalInventario()"></i>
                            <div
                                class="checkSoloExistencias row d-flex flex-row justify-content-end align-items-center mb-5">
                                <div class="col-lg-8 col-md-6 col-12 mt-2 mt-sm-5">
                                    <select id="filterInventario" name="filterInventario" class="form-control selectpicker"
                                        data-live-search="true">
                                        <option selected value="none">Ordenar</option>
                                        <option class="optionFilterInventario" style="height: 30px !important;"
                                            value="precioDown">Precio 10 - 1</option>
                                        <option class="optionFilterInventario" style="height: 30px !important;"
                                            value="precioUp">Precio 1 - 10</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 mt-2 mt-sm-5">
                                    <input type="checkbox" class="checkboxPedido" id="mostrar_existencias"
                                        onclick="mostrarSoloExistencias()" style="margin-top: -8px; margin-right: 5px;">
                                    <label class="mostrar_existenciasLabel" id='mostrar_existenciasLabel'
                                        for="mostrar_existencias" style="margin-right: 40px;">Mostrar solo
                                        existencias</label>
                                </div>

                            </div>
                            <table id="tablaInventario" class="table-striped table-bordered table-hover compact display"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="customHeader">Img</th>
                                        <th class="customHeader">Categoría</th>
                                        <th class="customHeader">Fab</th>
                                        <th class="customHeader">Fam</th>
                                        <th class="customHeader">Cod Art</th>
                                        <th class="customHeader">Descripción</th>
                                        <th class="customHeader">Detalles</th>
                                        <th class="customHeader">Descuentos</th>
                                        <th class="customHeader">Promo Vol</th>
                                        <th class="customHeader">Acciones</th>
                                        <th>Precio</th>
                                    </tr>
                                    <tr>
                                        <th>Img</th>
                                        <th>Categoría</th>
                                        <th>Fabricante</th>
                                        <th>Familia</th>
                                        <th>Artículo</th>
                                        <th>Descripción</th>
                                        <th>Detalles</th>
                                        <th>Descuentos</th>
                                        <th>Promo Vol</th>
                                        <th>Acciones</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th class="customHeader">Img</th>
                                        <th class="customHeader">Categoría</th>
                                        <th class="customHeader">Fab</th>
                                        <th class="customHeader">Fam</th>
                                        <th class="customHeader">Cod Art</th>
                                        <th class="customHeader">Descripción</th>
                                        <th class="customHeader">Detalles</th>
                                        <th class="customHeader">Descuentos</th>
                                        <th class="customHeader">Promo Vol</th>
                                        <th class="customHeader">Acciones</th>
                                        <th>Precio</th>
                                    </tr>
                                </tfoot>

                                <tbody class="bodyInventario" style="height: 200px; overflow-y: auto;"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!---------------------------------------------------------------------------------------------------- FIN INVENTARIO ---------------------------------------------------------------------------------------------->

                <!-------------------------------------------------------------------------------------------- MODAL LOADING LEVANTAR PEDIDO NETSUITE ---------------------------------------------------------------------------------------------->

                <div class="modal fade bd-example-modal-xl-ns" tabindex="-1" role="dialog" id="modalNetsuiteLoading"
                    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content modal-content-inventario" id="modal-netsuite-loading">
                            <div class="text-center">
                                <h4>Levantando Pedido</h4>
                            </div>
                            <div id='container-netsuite-loading'></div>
                        </div>
                    </div>
                </div>

            </div> <!-- Cierre Pedido -->
        </div> <!-- Cierre content -->
    </div> <!-- Cierre container-fluid -->


    <!-- FORM OCULTO PARA NUEVA COTIZACIÓN -->

    <form style="display: none" action="/pedido/nuevo" method="POST" id="formNuevo" target="_blank">
        @csrf
        <input type="text" name="entity" id="entity" value="{{ $entity }}" hidden>
    </form>

    <!-- FORM OCULTO PARA ELIMINAR COTIZACIÓN GUARDADA-->

    <form style="display: none" action="/pedido/eliminar" method="POST" id="formDelete">
        @csrf
        <input type="text" id="idCotizacion" name="idCotizacion" value="{{ $cotizacion->idCotizacion }}" hidden>

    </form>

    <!-- MODAL PARA CONFIRMAR ELIMINAR COTIZACIÓN -->

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" onclick="eliminarCotizacion('guardada')">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DIV PARA MOSTRAR IMAGEN DEL PRODUCTO AMPLIADA -->

    <div class="containerImgProduct" id="containerImgProduct">
        <h4 id='codigoArticuloMD'>CÓDIGO ARTICULO</h5>
            <h4 id='descripcionArticuloMD'>DESCRIPCIÓN ARTICULO</h5>
                <div class="magnify">
                    <div class="large" id="zoom"></div>
                    <img src="" alt="" class="imgProductMD small bigImageProduct gallery" id="imgProductMD">
                </div>

                <i class="fa-solid fa-xmark closeImgProductMDIcon" id="closeImgProductMDIcon"
                    onclick="closeImgProductMD()"></i>
    </div>

    <br><br>

@endsection
