@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar | Distribución @endsection

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
<div id="cover-spin"><img src="{{ asset('assets/intranet/images/loading.gif') }}" alt="loading" style="margin-top: 13%;"></div>
<input type="text" id="token" hidden value="{{ $token }}">
<input type="text" id="usuario" hidden value="{{ $username }}">
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                          <h3 class="card-title mt-3 mr-2">Captura Gasto Fletera</h3>
                          <a type="button" class="btn btn-outline-primary" href="{{asset('templates/Template_CapturaGastoFletera.xlsx')}}" download="Template_CapturaGastoFletera"><i class="fa-solid fa-file-arrow-down mr-2"></i>Descargar Template</a>
                          <label type="button" class="btn btn-outline-primary mt-2" for="fileTempleteImport"><i class="fa-solid fa-file-arrow-down mr-2"></i>Importar Template</label>
                          <form enctype="multipart/form-data">
                            <input type="file" id="fileTempleteImport" onchange="logisticaController.ImportTemplateGastoFletera()" hidden>
                          </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3" >
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="acreedor">Acreedor</label>
                                                    <select class="form-control select2" id="acreedor" onchange="logisticaController.showGuias();">
                                                        <option selected disabled>Seleccione un acreedor</option>
                                                        @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->entitY_ID }}" data-paqueteriaid="{{$vendor->paqueteriA_DISTRIBUCION_ID}}" data-esoficina={{$vendor->esOficina}}>{{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="formXML" enctype="multipart/form-data">
                                                    <input type="file" id="cargaXML" onchange="logisticaController.readFileXML()" hidden disabled>
                                                    <label type="button" class="btn btn-secondary btn-block" for="cargaXML" id="btnCargaXML"><i class="fa fa-cloud-upload-alt"></i> Cargar XML</label>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="uuid">UUID:</label>
                                                    <input type="text" class="form-control" id="uuid" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="numFactura">Num. Factura:</label>
                                                    <input type="text" class="form-control" id="numFactura" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="importeSinIva">Importe Sin Iva:</label>
                                                    <input type="text" class="form-control" id="importeSinIva" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" hidden>
                                            <input type="text" class="form-control" id="CantidadXML" disabled>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="importeTotal" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="importeGuias">Importe Guias:</label>
                                                    <input type="text" class="form-control" id="importeGuias" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check" style="padding-left: 0rem !important;">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox"  id="retencionIva" onchange="logisticaController.retentionIVA(this)">
                                                        <label class="form-check-label" for="retencionIva">Retención IVA</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="prontoPago">Pronto Pago:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="prontoPago" onkeyup="logisticaController.pagoPronto()" disabled>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">%</div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-success btn-block" disabled id="btnRegistrarNet" onclick="logisticaController.registerNet()"><i class="fa fa-check-circle"></i> Registrar en Netsuite </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-warning btn-block btn-aut" onclick="logisticaController.registerNet()"><i class="fa fa-user"></i> Solicitar Autorización </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-info btn-block" id="btnAgregarGuia" onclick="logisticaController.showModalAddGuia()" disabled><i class="fa fa-folder-plus"></i> Agregar Guía </button>
                                            </div>
                                        </div>
                                        {{-- <div class="row mt-2">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-danger btn-block btn-orange"><i class="fa fa-folder-plus"></i> Carga Gasto </button>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" style="height: 388px;border: 1px solid black">
                                                    <table id="tableGastoFletera" class="table table-bordered table-hover table-sm">
                                                        <thead class="encabezado-table">
                                                            <tr class="text-center">
                                                                <th><input type="checkbox"></th>
                                                                <th>NumeroGuia</th>
                                                                <th>Importe Total</th>
                                                                <th>Fecha</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dataTableGastoFletera">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="table-responsive" style="height: 366px;border: 1px solid black">
                                                    <table id="tableGastoFletera2" class="table table-bordered table-hover table-sm">
                                                        <thead class="encabezado-table">
                                                            <tr class="text-center">
                                                                <th><input type="checkbox"></th>
                                                                <th>NumeroGuia</th>
                                                                <th>Importe</th>
                                                                <th>Motivo</th>
                                                                <th>Comentario</th>
                                                                <th>Importe Sin IVA</th>
                                                                <th>Retención</th>
                                                                <th>PP</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dataTable2GastoFletera">
        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2" >
                                            <div class="col-12">
                                                <div style="border: 1px solid black">
                                                    <strong id="totalImporte">Total:$</strong>
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
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->departmenT_ID }}">{{ $department->name }}</option>
                                    @endforeach
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
                                    @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->municipio  }}-{{ $municipio->estado }}">{{ $municipio->municipio }}-{{ $municipio->estado }}</option>
                                    @endforeach
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
                                    @foreach ($clasificadores as $clasificador)
                                    <option value="{{ $clasificador }}">{{ $clasificador }}</option>
                                    @endforeach
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