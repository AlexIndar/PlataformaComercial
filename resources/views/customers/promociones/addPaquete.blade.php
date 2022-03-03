@extends('layouts.intranet.main', ['active' => 'Ventas', 'permissions' => $permissions])

@section('title') Ventas - Agregar Paquete @endsection 

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/promociones/addPromocion.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/addPedido.css')}}">
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css">
@endsection

@section('body')

<div class="content-wrapper p-5">
    <div class="container-fluid">
        <br><br>
        <!---------------------------------------------------------------------------------- DATOS GENERALES / ENCABEZADO PROMOCIONES ------------------------------------------------->

        <div class="datos-generales">
            <div class="title bg-indar">
                <h4>Datos generales del paquete</h4>
            </div>
            <br>
                
            <div class="content-datos-generales">
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Cupón:</h5></div>
                    <div class="col-lg-10 col-md-9 col-sm-12 col-12"><input class="input-promociones" type="text" id="nombrePromo" name="nombrePromo" required></div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Fechas:</h5></div>
                    <div class="col-lg-10 col-md-9 col-sm-12 col-12">
                        <input class="input-promociones" type="text" id="rangoFechas" name="daterange" data-date-container='#datepicker' value=""/>
                    </div>
                </div>
                <br>

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

        <!-- <div class="row">
            <div class="col-12 text-center">
                <h2>Reglas</h2>
            </div>
        </div>

        <br><br> -->

        <div class="datos-generales">
            <!-- <div class="title bg-indar">
                <h4>Descuento paquete <span id="percent-disccount">: 1</span>% adicional sobre categoría del cliente</h4>
            </div> -->
            <div class="title bg-indar">
                <h4>Reglas</h4>
            </div>
            <br>

            <div class="content-datos-generales">
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
                        <h5>Puntos:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="puntos" id="puntos" min="0">
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
                    <div class="col-lg-2 col-md-2 col-12 text-center">
                        <h5>Cuota paquete:</h5>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <select id="tipoCuota" name="tipoCuota" class="form-control selectpicker" data-live-search="true">
                            <option selected value="General">General</option>
                            <option value="Personalizada">Personalizada</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <input class="input-promociones" type="number" name="preciomin" id="preciomin" value="1" step=".01" min="1">
                    </div>

                    <div class="col-lg-2 col-md-2 col-12 text-center">
                        <h5>Cantidad mínima:</h5>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <input class="input-promociones" type="number" name="cantidadmin" id="cantidadmin" value="1" step="1" min="1">
                    </div>
                </div>

                <br><br>
                <hr>
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

                <div class="row text-center d-none">
                    <div class="col-12">
                        <h5 id="mensaje-giros" class="mensaje-giros mensaje green"> <strong>Sólo estos giros de clientes</strong> participan en la promoción</h5>
                    </div>
                </div>

                <div class="col-12 d-none">
                            <select id="giros" name="giros[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>
                            <h5 id="girosLoading">Cargando giros ...</h5>
                </div>

                <div class="col-12 d-none">
                    <button class="btn btn-blue" onclick="triggerInputFile('giros')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="girosFile" id="girosFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Giros')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Giros')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                
                <!-- CLIENTES -------------------------------------------------------------------------------------------------------------------------->
                <div class="clientesGeneral">
                    <div class="row reglas-row text-center">
                        <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Clientes:</h4></div>
                        <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                                <select id="clientes" name="clientes[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                                </select> 
                                <h5 id="clientesLoading">Cargando clientes ...</h5>
                        </div>
                    </div>
                    <br>
                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                        <button class="btn btn-blue" onclick="triggerInputFile('clientes')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                        <input type="file" name="clientesFile" id="clientesFile" accept=".csv, .xls, .xlsx" hidden>
                        <button class="btn btn-blue" onclick="downloadTemplate('Clientes')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                        <button class="btn btn-danger" onclick="clearSelection('Clientes')"><i class="fas fa-trash"></i> Eliminar todos</button>
                    </div>

                </div>
               
                <!-- CLIENTES CON CUOTAS (EN CASO DE QUE SELECCIONES CUOTA MINIMA PERSONALIZADA) -->

                <div class="clientesCuotas" style="display: none;">
                    <div class="row reglas-row text-center">
                        <div class="col-12"><h4>Clientes con cuotas:</h4></div>
                        <div class="col-12">
                            <button class="btn btn-blue" onclick="triggerInputFile('clientesCuotas')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                            <input type="file" name="clientesCuotasFile" id="clientesCuotasFile" accept=".csv, .xls, .xlsx" hidden>
                            <button class="btn btn-blue" onclick="downloadTemplate('ClientesCuotas')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                            <button class="btn btn-danger d-none confirmCuotas" onclick="clearSelectionCuotas()"><i class="fas fa-trash"></i> Eliminar cuotas</button>
                        </div>
                        <br><br>
                        <div class="col-12 mt-3 confirmCuotas d-none"><h5 class="mensaje-fechas mensaje green">¡Cuotas cargadas con éxito!</h5></div>
                        <div class="col-12 confirmCuotas d-none">
                            <button type="button" id="mostrarCuotas" class="btn btn-group-buttons" data-toggle="modal" data-target=".bd-example-modal-xl"><i class="fas fa-eye"></i> Ver cuotas</button>
                        </div>
                    </div>
                    <br><br><br>
                </div>

                <br><br>
                
                <!-- CATEGORIAS DE CLIENTES -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Categorías de clientes:</h4></div>
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                            <select id="categorias" name="categorias[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>
                            <h5 id="categoriasLoading">Cargando categorías ...</h5>
                    </div>
                </div>
                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="triggerInputFile('categorias')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="categoriasFile" id="categoriasFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Categorias')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Categorias')" data-toggle="modal" data-target="#modalDelete"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                
                <br><br>
                <br><br>

            </div>

        </div>

        <br><br><br><br>

        <div class="row d-none" id='subreglasTitle'>
            <div class="col-12 text-center">
                <h2>Subreglas</h2>
            </div>
        </div>

        <!-- TABLA SUBREGLAS -->

        <div class="cuerpoPedido row d-none" id='subreglasTable'>
            <div class="col-12 overflow-auto">
                <table class="tablaPedido" id="tablaPedido">
                    <!-- CABECERA DE TABLA -->
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descuento</th>
                        <th>Descuento Web</th>
                        <th>Monto mínimo</th>
                        <th>Cantidad mínima</th>
                        <th>Acciones</th>
                    </tr>

                    <tr>
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
        </div>

        <br><br><br><br>
        
        <div class="col">
            <div class="row-12 d-flex justify-content-center align-items-center d-column" id="div-loading">
                <img src="{{asset('assets/customers/gif/loading.gif')}}" id="loading" width="30px">
            </div>
            <br>
            <div class="row-12">
                <button class="btn btn-blue w-100" id="btn-validar" onclick="validarPaquete()">Validar Paquete</button>
                <button class="btn btn-blue w-100 d-none" id="btn-add-sub" onclick="validarPaquete()"><i class="fas fa-plus"></i> Agregar subregla</button>
                <button class="btn btn-blue w-100 mt-3 d-none" id="btn-guardar" onclick="storePaquete()"><i class="fas fa-save"></i> Guardar Paquete</button>
            </div>
        </div>



        <br><br><br><br>




    </div>

</div>

    <!-- MODAL REGLAS PAQUETE -->

    <div class="modal-background" id="reglasModal">
        <div class="modal-indar-reglas">
            <div class="modal-header">
                <h4>Agregar subregla</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModalSubreglas()"></i>
            </div>
            <div class="modal-body text-center">
                <input type="text" class="d-none" id="indexSubregla">
                <br><br>
                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-6 text-center">
                        <h5>Nombre subregla:</h5>
                    </div>
                    <div class="col-lg-10 col-md-9 col-6">
                        <input class="input-promociones" type="text" name="nombreSubregla" id="nombreSubregla">
                    </div>
                </div>

                <br>

                <div class="row reglas-row" id="descuentosPorCategoria">
                    <div class="col-lg-3 col-md-3 col-12">
                        <select id="categoriaCliente1" name="categoriaCliente1" class="form-control" data-live-search="true">
                            <option selected value="master">MASTER</option>
                            <option value="d">CLIENTE D</option>
                            <option value="a">CLIENTE A</option>
                            <option value="a light">CLIENTE A LIGHT</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 text-center">
                        <h5>Descuento subregla:</h5>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <input class="input-promociones" type="number" name="descuentoSubregla1" id="descuentoSubregla1" value="1" step=".01" min="0">
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 text-center">
                        <h5>Descuento web:</h5>
                    </div>
                    <div class="col-lg-2 col-md-2 col-11">
                        <input class="input-promociones" type="number" name="descuentoWebSubregla1" id="descuentoWebSubregla1" value="1" step=".01" min="0">
                    </div>
                    <div class='col-1'><i class='fas fa-plus-square btn-add-product fa-2x' id="iconoAgregarCategoriaDescuento1" onclick="addRowCategoriaDescuento(1)"></i></div>
                </div>

                <br>

                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Cuota mínima:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="preciominSub" id="preciominSub" value="1" step=".01" min="1">
                    </div>

                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Cantidad mínima:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <input class="input-promociones" type="number" name="cantidadminSub" id="cantidadminSub" value="1" step="1" min="1">
                    </div>
                </div>

                <br>

                <div class="row reglas-row">
                    <div class="col-lg-2 col-md-3 col-12 text-center">
                        <h5>Regalos:</h5>
                    </div>
                    <div class="col-lg-10 col-md-9 col-12">
                            <select id="regalosSub" name="regalosSub[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none">
                            </select>
                            <h5 id="regalosSubLoading">Cargando regalos ...</h5>
                    </div>
                </div> 

                <br><br>
                <hr>
                <br><br>

                <!-- PROVEEDORES -------------------------------------------------------------------------------------------------------------------------->

                <div class="row reglas-row text-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 col-12"><h4>Proveedores:</h4></div>
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                            <select id="proveedores" name="proveedores[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>  
                            <h5 id="proveedoresLoading">Cargando proveedores ...</h5>
                    </div>
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
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                            <select id="marcas" name="marcas[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>  
                            <h5 id="marcasLoading">Cargando marcas ...</h5>
                    </div>
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
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                            <select id="articulos" name="articulos[]" class="form-control chosen" data-placeholder="Buscar" multiple style="display:none;">
                            </select>
                            <h5 id="articulosLoading">Cargando artículos ...</h5>
                    </div>  
                </div> 

                <br>
                <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" id="excelArticulos" onclick="triggerInputFile('articulos')"><i class="fas fa-file-upload"></i> Desde archivo</button>
                    <input type="file" name="articulosFile" id="articulosFile" accept=".csv, .xls, .xlsx" hidden>
                    <button class="btn btn-blue" onclick="downloadTemplate('Articulos')"><i class="fas fa-file-download"></i> Descargar Plantilla</button>
                    <button class="btn btn-danger" onclick="clearSelection('Articulos')"><i class="fas fa-trash"></i> Eliminar todos</button>
                </div>
                <br><br>

                <div class="col">
                    <div class="row-12 d-flex justify-content-center align-items-center d-column" id="div-loading">
                        <img src="{{asset('assets/customers/gif/loading.gif')}}" id="loading" width="30px">
                    </div>
                    <br>
                    <div class="row-12">
                        <button class="btn btn-blue w-100" id="btn-guardarSub" onclick="addRule()"><i class="fas fa-plus"></i> Agregar</button>
                    </div>
                </div>

                <br><br><br>

            </div>
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

      <!-- DELETE TAGS MODAL CUOTAS -->
    <div class="modal-background" id="deleteModalCuotas">
        <div class="modal-indar">
            <div class="modal-header">
                <h4>Limpiar lista</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
            </div>
            <div class="modal-body text-center">
                <h4>¿Seguro que deseas limpiar la lista de <span id="listaDeleteCuotas"></span>?</h4> <br><br>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <button class="btn btn-blue" onclick="clearCuotas()"><i class="fas fa-check-square"></i> Aceptar</button>
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


     <!---------------------------------------------------------------------------------------------------- CUOTAS PERSONALIZADAS ---------------------------------------------------------------------------------------------->

     <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="modalInventario" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content modal-content-inventario">
                                <input type="text" id="empty" value="yes" hidden>
                                <table id="tablaPreviewCuotas" class="table-striped table-bordered table-hover compact display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="customHeader">Cliente</th>
                                            <th class="customHeader">Cuota</th>
                                            <th class="customHeader">Plazo 1</th>
                                            <th class="customHeader">Plazo 2</th>
                                            <th class="customHeader">Plazo 3</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bodyPreviewCuotas" style="height: 200px; overflow-y: auto;"></tbody>
                                    <tfoot>
                                    <tr>
                                            <th class="customHeader">Cliente</th>
                                            <th class="customHeader">Cuota</th>
                                            <th class="customHeader">Plazo 1</th>
                                            <th class="customHeader">Plazo 2</th>
                                            <th class="customHeader">Plazo 3</th>
                                        </tr>
                                    </tfoot>
                                </table>
            </div>
        </div>
        </div>


@endsection

@section('js')
<script src="{{asset('assets/customers/js/promociones/addPromocion.js')}}"></script>
<script src="{{asset('assets/customers/js/promociones/addPaquete.js')}}"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
@endsection