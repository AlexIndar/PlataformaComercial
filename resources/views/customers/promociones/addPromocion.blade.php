@extends('layouts.intranet.main', ['active' => 'Ventas', 'permissions' => $permissions])

@section('title') Ventas - Agregar Promoción @endsection 

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/promociones/addPromocion.css')}}">
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<script src="{{asset('assets/customers/js/promociones/addPromocion.js')}}"></script>
<!-- <script src="{{asset('assets/customers/js/index.js')}}"></script> -->

@endsection

@section('body')

<div class="content-wrapper p-5">
    <div class="container-fluid">
        <br><br>
        <!---------------------------------------------------------------------------------- DATOS GENERALES / ENCABEZADO PROMOCIONES ------------------------------------------------->

        <div class="datos-generales">
            <div class="title bg-indar">
                <h4>Datos generales de la promoción</h4>
            </div>
            <br>
                
            <div class="content-datos-generales">
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Nombre:</h5></div>
                    <div class="col-lg-10 col-md-9 col-sm-12 col-12"><input class="input-promociones" type="text" id="nombrePromo" name="nombrePromo" required></div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Fechas:</h5></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                        <select id="fechas" name="fechas" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div>
                <br><br>
                <div class="row text-center">
                    <div class="col-12">
                        <h5 id="mensaje-fechas" class="mensaje-fechas mensaje green"> <strong>Sólo estas fechas</strong> participan en la promoción</h5>
                    </div>
                </div>

                <br>

                <div class="row text-center">
                    <div class="col-12">
                        <input class="input-promociones" type="text" id="rangoFechas" name="daterange" data-date-container='#datepicker' value=""/>
                    </div>
                </div>

                <br>
                <div class="row text-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="row text-center">
                            <div class="col-12"><h5>Hora de inicio (primer día)</h5></div>
                            <div class="col-12">
                                <input type="time" id="startTime" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="row text-center">
                            <div class="col-12"><h5>Hora de término (último día)</h5></div>
                            <div class="col-12">
                                <input type="time" id="endTime" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
           

        </div>


        <br><br>

        <!------------------------------------------------------------------------------------ REGLAS -------------------------------------------------------------------->
    <div id="rules" id="rules">

        <div class="row">
            <div class="col-12 text-center">
                <h2>Reglas</h2>
            </div>
        </div>

        <br><br>

        <div class="datos-generales">
            <div class="title bg-indar">
                <h4>Descuento promo <span id="percent-disccount">: 1</span>% sobre máximo del cliente</h4>
            </div>
            <br>

            <div class="content-datos-generales">
                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Descuento promo:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="descuento" id="descuento" value="1" step=".01" min="0">
                    </div>

                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Puntos:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="puntos" id="puntos" min="0">
                    </div>
                </div>
                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Plazos:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <select id="plazos" name="plazos" class="form-control selectpicker" data-live-search="true">
                            <option selected value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Descuento Web:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="descuentoweb" id="descuentoweb" step=".01" min="0">
                    </div>
                </div>
                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Regalos:</h5>
                    </div>
                    <div class="col-lg-10 col-md-9 col-12">
                            <select id="regalos" name="regalos[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none">
                            </select>
                            <h5 id="regalosLoading">Cargando regalos ...</h5>
                    </div>
                </div> 

                <br><br>
                <hr>
                <br><br>

                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Monto mínimo:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="preciomin" id="preciomin" value="1" step=".01" min="0">
                    </div>

                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Cantidad mínima:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="cantidadmin" id="cantidadmin" value="1" step="1" min="0">
                    </div>
                </div>

                <br><br>
                <hr>
                <br><br>


                <!-- CATEGORIAS DE CLIENTES -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Categorías de clientes:</h4></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                        <select id="listaCategoriaClientes" name="listaCategoriaClientes" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div>

                <br><br>
                <div class="row text-center">
                    <div class="col-12">
                        <h5 id="mensaje-categorias" class="mensaje-categorias mensaje green"> <strong>Sólo estas categorías de clientes</strong> participan en la promoción</h5>
                    </div>
                </div>

                <br>
                <div class="col-12">
                            <select id="categorias" name="categorias[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>
                            <h5 id="categoriasLoading">Cargando categorías ...</h5>
                </div>
                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="triggerInputFile('categorias')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="categoriasFile" id="categoriasFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Categorias')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Categorias')" data-toggle="modal" data-target="#modalDelete"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                
                <br><br>

                <!-- GIROS DE CLIENTES -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center d-none">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Giros de clientes:</h4></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                        <select id="listaGirosClientes" name="listaGirosClientes" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div>

                <!-- <br><br> -->
                <div class="row text-center d-none">
                    <div class="col-12">
                        <h5 id="mensaje-giros" class="mensaje-giros mensaje green"> <strong>Sólo estos giros de clientes</strong> participan en la promoción</h5>
                    </div>
                </div>

                <!-- <br> -->
                <div class="col-12 d-none">
                            <select id="giros" name="giros[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>
                            <h5 id="girosLoading">Cargando giros ...</h5>
                </div>
                <!-- <br> -->
                <!-- <div class="col-12 d-flex flex-row justify-content-center align-items-center"> -->
                <div class="col-12 d-none">
                    <button class="btn btn-blue" onclick="triggerInputFile('giros')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="girosFile" id="girosFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Giros')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Giros')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                

                <!-- <br><br> -->

                <!-- CLIENTES -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Clientes:</h4></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                        <select id="listaClientes" name="listaClientes" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div>

                <br><br>
                <div class="row text-center">
                    <div class="col-12">
                        <h5 id="mensaje-clientes" class="mensaje-clientes mensaje green"> <strong>Sólo estos clientes</strong> participan en la promoción</h5>
                    </div>
                </div>

                <br>
                <div class="col-12">
                            <select id="clientes" name="clientes[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select> 
                            <h5 id="clientesLoading">Cargando clientes ...</h5>
                </div>
                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="triggerInputFile('clientes')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="clientesFile" id="clientesFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Clientes')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Clientes')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                

                <br><br>

                <!-- PROVEEDORES -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Proveedores:</h4></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                        <select id="listaProveedores" name="listaProveedores" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div>

                <br><br>
                <div class="row text-center">
                    <div class="col-12">
                        <h5 id="mensaje-proveedores" class="mensaje-proveedores mensaje green"> <strong>Sólo estos proveedores</strong> participan en la promoción</h5>
                    </div>
                </div>

                <br>
                <div class="col-12">
                            <select id="proveedores" name="proveedores[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>  
                            <h5 id="proveedoresLoading">Cargando proveedores ...</h5>
                </div>
                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="triggerInputFile('proveedores')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="proveedoresFile" id="proveedoresFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Proveedores')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Proveedores')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                

                <br><br>

                <!-- MARCAS -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Marcas:</h4></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                        <select id="listaMarcas" name="listaMarcas" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div>

                <br><br>
                <div class="row text-center">
                    <div class="col-12">
                        <h5 id="mensaje-marcas" class="mensaje-marcas mensaje green"> <strong>Sólo estas marcas</strong> participan en la promoción</h5>
                    </div>
                </div>

                <br>
                <div class="col-12">
                            <select id="marcas" name="marcas[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>  
                            <h5 id="marcasLoading">Cargando marcas ...</h5>
                </div>
                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="triggerInputFile('marcas')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="marcasFile" id="marcasFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Marcas')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Marcas')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                

                <br><br>

                <!-- ARTÍCULOS -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Artículos:</h4></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Tipo de lista</h5></div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                        <select id="listaArticulos" name="listaArticulos" class="form-control selectpicker" data-live-search="true">
                            <option selected value="blanca">Blanca (inclusiva)</option>
                            <option value="negra">Negra (exclusiva)</option>
                        </select>
                    </div>
                </div> 

                <br><br>
                <div class="row text-center">
                    <div class="col-12">
                        <h5 id="mensaje-articulos" class="mensaje-articulos mensaje green"> <strong>Sólo estos artículos</strong> participan en la promoción</h5>
                    </div>
                </div>

                <br>
                <div class="col-12">
                            <select id="articulos" name="articulos[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>
                            <h5 id="articulosLoading">Cargando artículos ...</h5>
                </div>
                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" id="excelArticulos" onclick="triggerInputFile('articulos')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="articulosFile" id="articulosFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Articulos')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Articulos')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                

                <br><br>

            </div>

        </div>

        <br><br><br><br>
        

        <div class="col">
            <div class="row-12 d-flex justify-content-center align-items-center d-column" id="div-loading">
                <img src="{{asset('assets/customers/gif/loading.gif')}}" id="loading" width="30px">
            </div>
            <br>
            <div class="row-12">
                <button class="btn btn-blue w-100" id="btn-guardar" onclick="guardarPromocion()">Validar</button>
            </div>
        </div>

        <br><br><br><br>
    </div>

</div>

    <!-- DELETE TAGS MODAL -->
    <div class="modal-background" id="deleteModal">
        <div class="modal-indar">
            <div class="modal-header">
                <h4>Limpiar lista</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
            </div>
            <div class="modal-body text-center">
                <h4>¿Seguro que deseas limpiar la lista de <span id="listaDelete"></span>?</h4> <br><br>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="clearSelectionAccept()"><i class="fas fa-check-square"></i> Aceptar</button>
                    <button class="btn btn-danger" onclick="closeModal()"><i class="fas fa-window-close"></i> Cancelar</button>
                </div>

            </div>
        </div>
    </div> 

    <!-- VALIDATE DATA MODAL -->
    <div class="modal-background" id="validateModal">
        <div class="modal-indar">
            <div class="modal-header">
                <h4>Verifica los siguientes datos</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
            </div>
            <div class="modal-body">
                <div id="bodyValidations"></div> <br>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="closeModal()">Cerrar</button>
                </div>

            </div>
        </div>
    </div> 



@endsection
