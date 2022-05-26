@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar @endsection

@section('styles')
@endsection
@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}assets/intranet/css/logistica.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/toastr/toastr.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('body')
<input type="text" id="token" hidden value="{{ $token }}">
<input type="text" id="usuario" hidden value="{{ $username }}">
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">Numero Guía</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <strong>1. Ingrese Información</strong>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-1 p-0">
                                        <label for="">Fletera</label>
                                        <select class="form-control" name="" id="">
                                            @foreach($freighters as $freighter)
                                                <option value="{{$freighter->lisT_ID}}">{{$freighter->lisT_ID}} | {{ $freighter->lisT_ITEM_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="">Num. de Guía</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="col-2">
                                        <label for="">Importe Total</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="col-1 mt-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-block btn-secondary btn" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa-solid fa-floppy-disk"></i></button>
                                    </div>
                                    <div class="col-1 mt-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-block btn-secondary btn" data-toggle="tooltip" data-placement="top" title="Reiniciar"><i class="fa-solid fa-repeat"></i></button>
                                    </div>
                                    <div class="col-2">
                                        <label for="">Importe seguro</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="col-2">
                                        <label for="">Facturas</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="col-1 mt-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-block btn-secondary btn" data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row justify-content-between">
                                        <div class="col-5">
                                            <div class="row p-1" style="border: 1px solid gray;">
                                                <div class="col-12">
                                                    <strong>2. Guía Conformada por:</strong>
                                                </div>
                                            </div>
                                            <div class="row" style="border:1px solid gray;">
                                                <div class="col-12 p-0">
                                                    <div class="row" style="height: 270px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                        <div class="col-12 table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tipo</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Importe</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="table-content-guia-type">
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end">
                                                        <div class="col-3">
                                                            <button type="button" class="btn btn-block btn-primary btn" onclick="logisticaController.addTypeRowTable()"><i class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="border: 1px solid gray;">
                                                <div class="col-8 p-0">
                                                    <button type="button" class="btn btn-block btn-primary btn" style="border-radius:0px" onclick="logisticaController.CaptureInvoices()"><i class="fa-solid fa-file-arrow-up mr-3"></i>Capturar Facturas</button>
                                                </div>
                                                <div class="col-4 mt-1">
                                                    <strong>3 Embarques</strong>
                                                </div>
                                            </div>
                                            <div class="row" style="border: 1px solid gray;">
                                                <div class="col-12 p-0">
                                                    <div class="row" style="height: 270px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                        <div class="col-12 table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Embarque</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="table-content-embarque">
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end">
                                                        <div class="col-3">
                                                            <button type="button" class="btn btn-block btn-primary btn" onclick="logisticaController.addEmbarqueRowTable()"><i class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row" style="border: 1px solid gray;height: 345px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                        <div class="col-12 table-responsive p-0">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Factura</th>
                                                                        <th>Cliente</th>
                                                                        <th>Embarque</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="table-content-embarque-factura">
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row" style="border: 1px solid gray;height: 348px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                        <div class="col-12 table-responsive p-0">
                                                            <table class="table table-bordered" style="height: 200px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Factura</th>
                                                                        <th>Autorizado</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="">
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-autorizacion">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header title-table">
            <h4 class="modal-title ">Autorización</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="usuarioSAI">Usuario SAI:</label>
                        <input type="text" class="form-control" id="usuarioSAI">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="contrasenaSAI">Contraseña:</label>
                        <input type="password" class="form-control" id="contrasenaSAI">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" hidden id="divMessage"></div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-plataform" onclick="logisticaController.formAutho()">Autorizar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-agregar-guia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Agregar Guía</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddGuia">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agregarGuiaAcreedor">Acreedor:</label>
                                <select class="form-control" id="agregarGuiaAcreedor" name="agregarGuiaAcreedor" disabled>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agregarGuiaDepartamento">Departamento:</label>
                                <select class="form-control" id="agregarGuiaDepartamento" name="agregarGuiaDepartamento">
                                    <option value="" selected disabled>Seleccione un departamento</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agregarGuiaNumeroGuia">Número de Guía:</label>
                                <input type="text" class="form-control" id="agregarGuiaNumeroGuia" name="agregarGuiaNumeroGuia">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agregarGuiaMunicipio">Municipio:</label>
                                <select class="form-control" id="agregarGuiaMunicipio" name="agregarGuiaMunicipio">
                                    <option value="" selected disabled>Seleccione un municipio</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agregarGuiaImporte">Importe:</label>
                                <input type="text" class="form-control" id="agregarGuiaImporte" name="agregarGuiaImporte" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="agregarGuiaClasificador">Clasificador:</label>
                                <select class="form-control" id="agregarGuiaClasificador" name="agregarGuiaClasificador">
                                    <option value="" selected disabled>Seleccione un clasificador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row" id="divMessageFormAddGuia" hidden></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-plataform" onclick="logisticaController.validateFormAddGuia();">Agregar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('js')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<!-- SweetAlert2 -->
{{-- <script src="{{ env('APP_URL')}}plugins/sweetalert2/sweetalert2.min.js"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr -->
<script src="{{ env('APP_URL')}}plugins/toastr/toastr.min.js"></script>
<!-- Select2 -->
<script src="{{ env('APP_URL')}}plugins/select2/js/select2.full.min.js"></script>
<script src="{{ env('APP_URL')}}assets/intranet/js/logisticaController.js"></script>
<!-- jquery-validation -->
<script src="{{ env('APP_URL')}}plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/jquery-validation/additional-methods.min.js"></script>
@endsection