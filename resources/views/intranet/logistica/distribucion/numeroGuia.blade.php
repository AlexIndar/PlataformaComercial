@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar @endsection

@section('styles')
@endsection
@section('css')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/intranet/css/logistica.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('body')
<div id="cover-spin"><img src="{{asset('assets/intranet/images/loading.gif')}}" alt="loading" style="margin-top: 13%;"></div>
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
                                        <div class="col-12 mt-2">
                                            <h3 class="card-title mt-3 mr-2">Numero Guía</h3>
                                            <a type="button" class="btn btn-outline-primary" href="{{asset('templates/Template_NumeroGuia.xlsx')}}" download="Template_NumeroGuia"><i class="fa-solid fa-file-arrow-down mr-2"></i>Descargar Template</a>
                                            <label type="button" class="btn btn-outline-primary mt-2" for="fileTempleteImport"><i class="fa-solid fa-file-arrow-down mr-2"></i>Importar Template</label>
                                            <button type="button" class="btn btn-outline-primary" onclick="logisticaController.showModalLogin()"><i class="fa-solid fa-pen-to-square mr-2"></i>Actualizar Importes</button>
                                            <form enctype="multipart/form-data">
                                                <input type="file" id="fileTempleteImport" onchange="logisticaController.importDataNumGuia()" hidden>
                                            </form>
                                        </div>
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
                                                <label for="">Fletera:</label>
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
                                                <label for="">Num. de Guía:</label>
                                                <input class="form-control" type="text" id="NumGuia" onchange="logisticaController.searchExistNumGuia()">
                                            </div>
                                            <div class="col-2">
                                                <label for="">Importe Total:</label>
                                                <input class="form-control" type="text" id="importeTotal" value="0.00" disabled>
                                            </div>
                                            <div class="col-1 mt-2" id="crear">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="logisticaController.addNumGuia()" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa-solid fa-floppy-disk"></i></button>
                                            </div>
                                            <div class="col-1 mt-2" id="actualizar" hidden>
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="logisticaController.updateNumGuia()" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa-solid fa-floppy-disk"></i></button>
                                            </div>
                                            <div class="col-1 mt-2">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="location.reload();" data-toggle="tooltip" data-placement="top" title="Reiniciar"><i class="fa-solid fa-arrows-rotate"></i></button>
                                            </div>
                                            <input type="text" id="idNumeroGuiaUpdate" hidden>
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
                                               <!-- Default switch -->
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="isOficinas" onchange="logisticaController.isOficinaFacturaGuia()">
                                                    <label class="custom-control-label" for="isOficinas">Envio a oficinas</label>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <label for="">Facturas:</label>
                                                <input class="form-control" type="text" id="searchFactura" onchange="logisticaController.searchBills()">
                                            </div>
                                            {{-- <div class="col-1 mt-2">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-block btn-plataform btn" onclick="" data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2 p-0">
                                        <div class="row justify-content-between">
                                            <div class="col-6">
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
                                                                            <th>CP</th>
                                                                            <th>Habilitar</th>
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
                                                {{-- <div class="row" style="border: 1px solid gray;">
                                                    <div class="col-8 p-0">
                                                        <button type="button" class="btn btn-block btn-plataform btn" style="border-radius:0px" onclick="logisticaController.CaptureInvoices()"><i class="fa-solid fa-file-arrow-up mr-3"></i>Capturar Facturas</button>
                                                    </div>
                                                    <div class="col-4 mt-1">
                                                        <strong>3 Embarques</strong>
                                                    </div>
                                                </div> --}}
                                                <div class="row" style="border: 1px solid gray;">
                                                    <div class="col-12">
                                                        <div class="row" id="divrow" style="height: 310px; overflow:scroll;overflow-x: hidden;overflow-y: auto;">
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
                                            <div class="col-6">
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
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button> --}}
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
<div class="modal fade" id="modal-importes-fleteras">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Importes Fleteras</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <form enctype="multipart/form-data">
                                <input type="file" id="fileTempleteImportImportesFleteras" onchange="logisticaController.importDataImportsFreighters()" hidden>
                            </form>
                            <form id="formAddGuia">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="fleteraImporteAdd">Fleteras:</label>
                                            <select class="form-control" id="fleteraImporte" name="fleteraImporte">
                                                <option value="" selected>Seleccione una fletera</option>
                                                @foreach($freighters as $freighter)
                                                    <option value="{{$freighter->lisT_ITEM_NAME}}"> {{ $freighter->lisT_ITEM_NAME }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="estadoImporte">Estado:</label>
                                            <select class="form-control" id="estadoImporte" name="estadoImporte">
                                                <option value="" selected>Seleccione un estado</option>
                                                @foreach($states as $state)
                                                <option value="{{ $state->largo }}">{{ $state->largo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group mt-4">
                                            <label for=""></label>
                                            <button class="btn btn-plataform mt-2" onclick="logisticaController.consultFreighterImport(); return false">Consultar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-sm" id="table-importe" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CP</th>
                                            <th>Fletera</th>
                                            <th>Estado</th>
                                            <th>Municipio</th>
                                            <th>Zona</th>
                                            <th>Caja</th>
                                            <th>Atado</th>
                                            <th>Bulto</th>
                                            <th>Cubeta</th>
                                            <th>Tarima</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-content-import">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-editar-importes">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Editar Importes Fletera</h4>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <form id="formAddImport">
                                <div class="row">
                                    <input type="text" id="idImporteFactura" hidden>
                                    <input type="text" id="zonaUpdate" hidden>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="fleteraImporteUpdate">Fleteras:</label>
                                            <select class="form-control" id="fleteraImporteUpdate" name="fleteraImporteUpdate">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="codigoPostalUpdate">Codigo Postal:</label>
                                            <input type="number" class="form-control" id="codigoPostalUpdate" name="codigoPostalUpdate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="cajaUpdate">Caja:</label>
                                            <input type="text" class="form-control" id="cajaUpdate" name="cajaUpdate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="atadoUpdate">Atado:</label>
                                            <input type="text" class="form-control" id="atadoUpdate" name="atadoUpdate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="bultoUpdate">Bulto:</label>
                                            <input type="text" class="form-control" id="bultoUpdate" name="bultoUpdate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="cubetaUpdate">Cubeta:</label>
                                            <input type="text" class="form-control" id="cubetaUpdate" name="cubetaUpdate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="tarimaUpdate">Tarima:</label>
                                            <input type="text" class="form-control" id="tarimaUpdate" name="tarimaUpdate">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="fechaInicioUpdate">Fecha Inicio:</label>
                                            <input type="date" class="form-control" id="fechaInicioUpdate" name="fechaInicioUpdate">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="fechaFinUpdate">Fecha Fin:</label>
                                            <input type="date" class="form-control" id="fechaFinUpdate" name="fechaFinUpdate">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" onclick="logisticaController.exitModalImportUpdate()">Cerrar</button>
                <button type="button" class="btn btn-plataform" onclick="logisticaController.updateImport()">Editar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-agregar-importes">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header title-table">
                <h4 class="modal-title ">Agregar Importes Fletera</h4>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <form id="formAddImport">
                                <div class="row">
                                    <input type="text" id="idImporteFactura" hidden>
                                    <input type="text" id="zonaUpdate" hidden>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="fleteraImporteCreate">Fleteras:</label>
                                            <select class="form-control" name="fleteraImporteCreate" id="fleteraImporteCreate">
                                                <option value="" selected disabled>Seleccione una fletera</option>
                                                @foreach($freighters as $freighter)
                                                    <option value="{{$freighter->lisT_ID}}"> {{ $freighter->lisT_ITEM_NAME }}</option>
                                                @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="codigoPostalCreate">Codigo Postal:</label>
                                            <input type="number" class="form-control" id="codigoPostalCreate" name="codigoPostalCreate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="cajaCreate">Caja:</label>
                                            <input type="text" class="form-control" id="cajaCreate" name="cajaCreate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="atadoCreate">Atado:</label>
                                            <input type="text" class="form-control" id="atadoCreate" name="atadoCreate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="bultoCreate">Bulto:</label>
                                            <input type="text" class="form-control" id="bultoCreate" name="bultoCreate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="cubetaCreate">Cubeta:</label>
                                            <input type="text" class="form-control" id="cubetaCreate" name="cubetaCreate">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="tarimaCreate">Tarima:</label>
                                            <input type="text" class="form-control" id="tarimaCreate" name="tarimaCreate">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="fechaInicioCreate">Fecha Inicio:</label>
                                            <input type="date" class="form-control" id="fechaInicioCreate" name="fechaInicioCreate">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="fechaFinCreate">Fecha Fin:</label>
                                            <input type="date" class="form-control" id="fechaFinCreate" name="fechaFinCreate">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" onclick="logisticaController.exitModalImportCreate()">Cerrar</button>
                <button type="button" class="btn btn-plataform" onclick="logisticaController.createImport()">Agregar</button>
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
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>


<script src="{{ asset('assets/intranet/js/logisticaController.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>  
@endsection