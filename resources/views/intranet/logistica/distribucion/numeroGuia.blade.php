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
                                    <div class="row justify-content-between">
                                        <div class="col-3 mt-2">
                                            <h3 class="card-title">Numero Guía</h3>
                                        </div>
                                        {{-- <div class="col-2">
                                            <button type="button" class="btn btn-block btn-outline-primary" onclick="logisticaController.showModalLogin()"><i class="fa-solid fa-pen-to-square"></i>Actualizar Importes</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row justify-content-between">
                                            <div class="col-3 p-0">
                                                <strong>1. Ingrese Información</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-2">
                                    <div class="col-12 p-0">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="">Fletera</label>
                                                <select class="form-control" name="fletera" id="fletera">
                                                        <option value="" selected disabled>Seleccione una fletera</option>
                                                    @foreach($freighters as $freighter)
                                                        <option value="{{$freighter->lisT_ID}}"> {{ $freighter->lisT_ITEM_NAME }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-3 p-0">
                                                <label for="">Chofer:</label>
                                                <select class="form-control" name="chofer" id="chofer">
                                                    <option value="" selected disabled>Seleccione un chofer</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{$driver->id}}">{{ $driver->nombre }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="">Num. de Guía</label>
                                                <input class="form-control" type="text" id="NumGuia">
                                            </div>
                                            <div class="col-3">
                                                <label for="">Importe Total</label>
                                                <input class="form-control" type="text" id="importeTotal" value="0.00" disabled>
                                            </div>
                                            <div class="col-1 mt-2">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="logisticaController.addNumGuia()" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa-solid fa-floppy-disk"></i></button>
                                            </div>
                                            {{-- <div style="border: 1px solid black;width: 0%;max-width: 0%;padding: 0px;">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-secondary btn" data-toggle="tooltip" data-placement="top" title="Reiniciar"><i class="fa-solid fa-repeat"></i></button>
                                            </div> --}}
                                            {{-- <div class="col-2">
                                                <label for="">Importe seguro</label>
                                                <input class="form-control" type="text" id="importeSeguro">
                                            </div> --}}
                                        </div>
                                        <hr>
                                        <div class="row justify-content-end">
                                            <div class="col-2">
                                                <label for="">Facturas</label>
                                                <input class="form-control" type="text" id="searchFactura">
                                            </div>
                                            <div class="col-1 mt-2">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="logisticaController.searchBills()" data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2 p-0">
                                        <div class="row justify-content-between">
                                            <div class="col-5">
                                                <div class="row p-1" style="border: 1px solid gray;">
                                                    <div class="col-12">
                                                        <strong>2. Guía Conformada por:</strong>
                                                    </div>
                                                </div>
                                                <div class="row" style="border: 1px solid gray;">
                                                    <div class="col-12">
                                                        <div class="row" id="divrow" style="height: 270px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                            <div class="col-12 table-responsive p-0">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Factura</th>
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
                                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="logisticaController.addTypeRowTable()"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="border: 1px solid gray;">
                                                    <div class="col-8 p-0">
                                                        <button type="button" class="btn btn-block btn-plataform btn" style="border-radius:0px" onclick="logisticaController.CaptureInvoices()"><i class="fa-solid fa-file-arrow-up mr-3"></i>Capturar Facturas</button>
                                                    </div>
                                                    <div class="col-4 mt-1">
                                                        <strong>3 Embarques</strong>
                                                    </div>
                                                </div>
                                                <div class="row" style="border: 1px solid gray;">
                                                    <div class="col-12">
                                                        <div class="row" id="divrow" style="height: 270px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                            <div class="col-12 table-responsive p-0">
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
                                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="logisticaController.addEmbarqueRowTable()"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row" id="divrow" style="border: 1px solid gray;height: 345px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
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
                                                        <div class="row" id="divrow" style="border: 1px solid gray;height: 348px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
                                                            <div class="col-12 table-responsive p-0">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Factura</th>
                                                                            <th>Embarque</th>
                                                                            <th>Autoriza</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="table-content-facturas-selected">
                                                                        
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