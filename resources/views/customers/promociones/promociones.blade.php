@extends('layouts.intranet.main', ['active' => 'Ventas'])

@section('title') Ventas - Promociones @endsection

@section('styles') 
    <link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/customers/css/promociones/promociones.css')}}">
    <script src="{{asset('assets/customers/js/promociones/promociones.js')}}"></script>
@endsection

@section('body')

<div class="content-wrapper p-5">
    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-lg-6 col-12 mt-3">
                <button type="button" id="nuevaPromo" class="btn btn-group-buttons btn-default" onclick="addPromocion()"><i class="fas fa-file"></i> Nueva Promoción</button>
            </div>
            <div class="col-lg-6 col-12 mt-3">
                <button type="button" id="nuevoPaquete" class="btn btn-group-buttons btn-default" onclick="addPaquete()"><i class="fas fa-object-group"></i> Nuevo Paquete</button>
            </div>
        </div>
       
        <div>
        </div>
        <br><br>

        

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-promociones-tab" data-toggle="tab" href="#nav-promociones" role="tab" aria-controls="nav-promociones" aria-selected="true">Promociones</a>
                <a class="nav-link" id="nav-paquetes-tab" data-toggle="tab" href="#nav-paquetes" role="tab" aria-controls="nav-paquetes" aria-selected="false">Paquetes</a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-promociones" role="tabpanel" aria-labelledby="nav-promociones-tab">
                @foreach($promociones as $promo)
                    @if(!$promo->paquete && ($promo->idPaquete == 0 || $promo->idPaquete == null))
                        <div class="promo">
                            <div class="promo-header">
                                <h4>[{{$promo->id}}] {{$promo->nombrePromo}}</h4>
                                <div class="actions">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary" title="Duplicar" onclick="activarDuplicarModal('{{$promo->id}}', 'promo')"><i class="fas fa-clone"></i></button>
                                        <button type="button" class="btn btn-info" title="Editar" onclick="editarPromo('{{$promo->id}}')"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger" title="Eliminar" onclick="activarEliminarModal('{{$promo->id}}', 'promo')"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div> 
                            </div> 
                            <div class="cuerpo-promo">
                                <h5>Vigencia de <span class="fecha"><i class="fas fa-calendar"></i> {{$promo->fechaInicio}}</span> a <span class="fecha"><i class="fas fa-calendar"></i> {{$promo->fechaFin}}</span> </h5>
                                <h5>Estatus: 0</h5>
                                
                                    <div class="col-sm-5">
                                        <button type="button" class="btn btn-sm btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">
                                            <div class="handle"></div>
                                        </button>
                                    </div>
                                    <br>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="tab-pane fade" id="nav-paquetes" role="tabpanel" aria-labelledby="nav-paquetes-tab">
                @foreach($promociones as $promo)
                    @if($promo->paquete)
                        <div class="promo">
                            <div class="promo-header">
                                <h4>[{{$promo->id}}] {{$promo->nombrePromo}}</h4>
                                <div class="actions">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary" title="Duplicar" onclick="activarDuplicarModal('{{$promo->id}}', 'paquete')"><i class="fas fa-clone"></i></button>
                                        <button type="button" class="btn btn-info" title="Editar" onclick="editarPromo('{{$promo->id}}')"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger" title="Eliminar" onclick="activarEliminarModal('{{$promo->id}}', 'paquete')"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div> 
                            </div> 
                            <div class="cuerpo-promo">
                                <h5>Vigencia de <span class="fecha"><i class="fas fa-calendar"></i> {{$promo->fechaInicio}}</span> a <span class="fecha"><i class="fas fa-calendar"></i> {{$promo->fechaFin}}</span> </h5>
                                <h5>Estatus: 0</h5>
                                
                                    <div class="col-sm-5">
                                        <button type="button" class="btn btn-sm btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">
                                            <div class="handle"></div>
                                        </button>
                                    </div>
                                    <br>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- FORM PARA EDITAR -->
    <form style="display: none" action="/promociones/editar" method="POST" id="form">
            @csrf
            <input type="hidden" id="id" name="id" value=""/>
    </form>

    <!-- FORM PARA DUPLICAR -->
    <form style="display: none" action="/promociones/duplicar" method="POST" id="form">
            @csrf
            <input type="hidden" id="idDuplicar" name="idDuplicar" value=""/>
            <input type="hidden" id="tipoDuplicar" name="tipoDuplicar" value=""/>
    </form>

    <!-- FORM OCULTO PARA ELIMINAR COTIZACIÓN GUARDADA-->
  
    <form style="display: none" action="/promociones/eliminar" method="POST" id="formDelete">
                @csrf
                <input type="text" id="idPromo" name="idPromo" value="" hidden>
    </form>

         <!-- MODAL PARA CONFIRMAR ELIMINAR PROMOCION -->

        <!-- Modal -->
        <div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 id="h4-modalEliminar">Eliminar Promoción</h4>
                    <i style="cursor:pointer;" class="fas fa-times" onclick="closeModalDelete()"></i>
                </div>
                <div class="modal-body">
                    <h5 id="h5-modalEliminar">¿Desea eliminar esta promoción?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalDelete()">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarPromo()">Eliminar</button>
                </div>
                </div>
            </div>
        </div>

        <!-- MODAL PARA DAR NOMBRE A PROMOCION DUPLICADA -->

        <!-- Modal -->
        <div class="modal fade" id="confirmDuplicarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 id="h4-modalDuplicar">Duplicar Promoción</h4>
                    <i style="cursor:pointer;" class="fas fa-times" onclick="closeModalDuplicar()"></i>
                </div>
                <div class="modal-body">
                    <h5 id="h5-modalDuplicar">Indique un nombre para la nueva promoción</h5>
                    <input type="text" id="nombrePromoDuplicar" name="nombrePromoDuplicar" class="input-promociones" style="border: 1px solid black !important;">
                </div>
                <div class="modal-footer">
                    <div class="spinner-border text-secondary" style="display:none; margin-right: 15px; width: 25px; height: 25px; margin-top: 2px;" id="btnSpinner" ></div>
                    <button type="button" class="btn btn-secondary" onclick="closeModalDuplicar()">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="duplicarPromo(false)">Duplicar</button>
                    <button type="button" class="btn btn-info" onclick="duplicarPromo(true)">Duplicar y Editar</button>
                </div>
                </div>
            </div>
        </div>
    
</div>
@endsection
