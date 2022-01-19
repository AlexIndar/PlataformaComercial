
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
                        <select id="customerID" name="customerID" class="form-control selectpicker" data-live-search="true">
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
                <div class="col-lg-3 col-md-3 col-12 rowPedido"><input type="text" class="inputPedido" id="ordenCompra" name="ordenCompra"></div>
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
                                    <option style="height: 30px !important;" value="none">Selecciona una sucursal</option>
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
                                <li class="tags">1PREMIABM<i class="fa fa-times"></i></li>
                                <li class="tags last">1PREMIAF4<i class="fa fa-times"></i></li>
                                <!-- <li class="tags-new">
                                    <input type="text" placeholder="Buscar"> 
                                </li> -->
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

    <!---------------------------------------------------------------------------------------------------- PEDIDO  ---------------------------------------------------------------------------------------------->

    <div id="loading" class="d-flex flex-row justify-content-center align-items-center" style="width: 100%; height: 100px; background-color: #002868; color: white;">
        <h5 id="loading-message">Cargando inventario ...</h5>
    </div>


    <div id="pedido" style="display:none;">

        <!-- TABLA ARTICULOS PEDIDO -->

        <div class="cuerpoPedido row">
            <div class="col-12 overflow-auto">
                <table class="tablaPedido" id="tablaPedido">
                    <!-- CABECERA DE TABLA -->
                    <tr>
                        <th>#</th>
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
                <fieldset class="scheduler-border">
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

                    <button class="btnAgregarPorCodigo mt-3" onclick="addRowCargarPorCodigo()"><i class="fas fa-plus"></i> Agregar</button>
                    <button id="btnCargarPorCodigo" class="btnCargarPorCodigo mt-3 d-none" onclick="cargarProductosPorCodigo()"><i class="fas fa-arrow-up"></i> Cargar</button>
                </fieldset>
            </div>

            <div class="col-lg-8 col-md-7 col-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Comentarios</legend>
                    <textarea id="comments" name="textarea" cols="40" rows="2" class="form-control" maxlength="400" style="min-height: 50px;"></textarea>
                </fieldset>
            </div>
        </div>

        <!-- INVENTARIO -->

        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <button type="button" id="mostrarInventario" onclick="cargarInventario()" class="btn btn-group-buttons" data-toggle="modal" data-target=".bd-example-modal-xl"><i class="fab fa-searchengin"></i> Buscar</button>
            <button type="button" id="downloadPlantilla" class="btn btn-group-buttons" onclick="downloadPlantillaPedido()"><i class="fas fa-file-download"></i> Plantilla</button>
            <button type="button" id="importarCodigos" class="btn btn-group-buttons" onclick="triggerInputFile()"><i class="fas fa-file-excel"></i> Importar</button>
            <input type="file" name="excelCodes" id="excelCodes" accept=".csv, .xls, .xlsx" hidden>
            <button type="button" id="guardarCotizacion" class="btn btn-group-buttons" onclick="save()"><i class="fas fa-save"></i> Guardar</button>
        </div>
        <br><br>
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <button type="button" id="nuevaCotizacion" class="btn btn-group-buttons"><i class="fas fa-file"></i> Nueva cotización</button>
            <button type="button" id="borrarCotizacion" class="btn btn-group-buttons"><i class="fas fa-trash"></i> Borrar cotización</button>
            <button type="button" id="enviarCotizacion" class="btn btn-group-buttons"><i class="fas fa-share-square"></i> Enviar cotización</button>
        </div>
        <br><br>
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <button type="button" id="pedidosAnteriores" class="btn btn-group-buttons" onclick="pedidosAnteriores()"><i class="fas fa-history"></i> Pedidos anteriores</button>
            <button type="button" id="levantarPedido" class="btn btn-group-buttons"><i class="fas fa-check"></i> Levantar pedido</button>
            <button type="button" id="pedidosClientes" class="btn btn-group-buttons"><i class="fas fa-user"></i> Pedidos clientes</button>
            <button type="button" id="pedidosPendientes" class="btn btn-group-buttons"><i class="fas fa-clock"></i> Pedidos pendientes</button>
        </div>

        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="modalInventario" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                                <input type="text" id="empty" value="yes" hidden>
                                <table id="tablaInventario" class="table-striped table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="customHeader">Img</th>
                                            <th class="customHeader">Categoría</th>
                                            <th class="customHeader">Fab</th>
                                            <th class="customHeader">Fam</th>
                                            <th class="customHeader">Grupo</th>
                                            <th class="customHeader">Tipo</th>
                                            <th class="customHeader">ID</th>
                                            <th class="customHeader">Cod Art</th>
                                            <th class="customHeader">Descripción</th>
                                            <th class="customHeader">Multiplo</th>
                                            <th class="customHeader">Cantidad</th>
                                            <th class="customHeader">Precio</th>
                                            <th class="customHeader">Unidad</th>
                                            <th class="customHeader">Promo</th>
                                            <th class="customHeader">Existencia</th>
                                            <th class="customHeader">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
            </div>
        </div>
        </div>

    </div>
    
    <!---------------------------------------------------------------------------------------------------- PIE PEDIDO ---------------------------------------------------------------------------------------------->


    <!---------------------------------------------------------------------------------------------------- FIN PIE PEDIDO ---------------------------------------------------------------------------------------------->


    </div>
  </div>
  

  <br><br>

@endsection
