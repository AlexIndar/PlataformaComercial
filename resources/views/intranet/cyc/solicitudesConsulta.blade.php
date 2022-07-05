@extends('layouts.intranet.main', ['active' => 'CyC', 'permissions' => $permissions])

@section('title') Indar - Solicitudes Pendientes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <h2>Consulta de Solicitudes</h2>
                    <input type="text" id="userName" value="{{$user['typeUser']}}" hidden>
                    <input type="text" id="userP" value="{{$user['permissions']}}" hidden>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-indarYellow">
                            <!-- <h3 class="card-title text-indarBlue">Solicitudes</h3> -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableCyc" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Prospecto</th>
                                        <th>Fecha de registro</th>
                                        <th>Status</th>
                                        <th>Zona</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Prospecto</th>
                                        <th>Fecha de registro</th>
                                        <th>Status</th>
                                        <th>Zona</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>


<!--MODAL INFO -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto">Detalle de Solicitud No. <span id="folioInf"></span></h3>
                <input type="text" id="typeFormInf" value="" hidden>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3>Tipo de Solicitud</h3>
                        <h4 style="color: gray;" id="typeSol"></h4>
                    </div>
                    <div class="col-md-4">
                        <h3>Zona</h3>
                        <h4 style="color: gray;" id="zonaSol"></h4>
                    </div>
                    <div class="col-md-4">
                        <h3 id="moneySolT">Credito Solicitado</h3>
                        <h4 style="color: gray;" id="moneySol"></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos Generales</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">RFC</div>
                            <div class="col-md-6"><input type="text" name="rfcEdit" id="rfcEdit" class="form-control" disabled onfocusout="changeFlag(2)" maxlength="13"></div>
                            <div class="col-md-2" id="rfcButtons"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Razon Social</div>
                            <div class="col-md-6"><input type="text" name="rzEdit" id="rzEdit" class="form-control" disabled onfocusout="changeFlag(2)" maxlength="99"></div>
                            <div class="col-md-2" id="rzButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Nombre Comercial</div>
                            <div class="col-md-6"><input type="text" name="nomComEdit" id="nomComEdit" disabled class="form-control" onfocusout="changeFlag(1)" maxlength="99"></div>
                            <div class="col-md-2" id="nomComButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Email Facturacion</div>
                            <div class="col-md-6"><input type="text" name="emailFactE" id="emailFactE" disabled class="form-control"></div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Constancia de Situacion Fiscal</div>
                            <div class="col-md-6" id="imgCSFButton"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-2" id="csfButtons1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Constancia de Situacion Fiscal (2da Pagina)</div>
                            <div class="col-md-6" id="imgCSF2Button"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-2" id="csfButtons2">

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Fotografia de Solicitud</div>
                            <div class="col-md-6" id="imgFSButton"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-2" id="picSolButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertDG">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Dirección Fiscal</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Calle</div>
                            <div class="col-md-6"><input type="text" name="calleFEdit" id="calleFEdit" disabled class="form-control" onfocusout="changeFlag(3)" maxlength="99"></div>
                            <div class="col-md-2" id="callFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Exterior</div>
                            <div class="col-md-6"><input type="text" name="noFEdit" id="noFEdit" disabled class="form-control" onfocusout="changeFlag(3)" maxlength="20"></div>
                            <div class="col-md-2" id="noFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Interior</div>
                            <div class="col-md-6"><input type="text" name="noIntFEdit" id="noIntFEdit" disabled class="form-control" onfocusout="changeFlag(3)" maxlength="20"></div>
                            <div class="col-md-2" id="noIntFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Ciudad</div>
                            <div class="col-md-6"><input type="text" name="cityFEdit" id="cityFEdit" disabled class="form-control" onfocusout="changeFlag(3)"></div>
                            <div class="col-md-2" id="cityFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Estado</div>
                            <div class="col-md-6"><input type="text" name="estadoFEdit" id="estadoFEdit" disabled class="form-control" onfocusout="changeFlag(3)"></div>
                            <div class="col-md-2" id="estadoFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Colonia</div>
                            <div class="col-md-6" id="col1E"><input type="text" name="coloniaFEdit" id="coloniaFEdit" disabled class="form-control" onfocusout="changeFlag(3)"></div>
                            <div class="col-md-2" id="coloniaFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">CP</div>
                            <div class="col-md-6"><input type="text" name="cpFEdit" id="cpFEdit" disabled class="form-control" onfocusout="validaCPEdit()" maxlength="5"></div>
                            <div class="col-md-2" id="cpFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3" id="datFisCD">
                            <div class="col-md-4">Comprobante Domicilio</div>
                            <div class="col-md-4" id="imgCDButton"><button class="btn btn-danger"><i class="fas fa-exclamation"></i> SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="comDFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertDF">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Dirección de entrega</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Calle</div>
                            <div class="col-md-6"><input type="text" name="calleEEdit" id="calleEEdit" disabled class="form-control" onfocusout="changeFlag(4)" maxlength="99"></div>
                            <div class="col-md-2" id="calleEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Exterior</div>
                            <div class="col-md-6"><input type="text" name="noEEdit" id="noEEdit" disabled class="form-control" onfocusout="changeFlag(4)" maxlength="20"></div>
                            <div class="col-md-2" id="noEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Interior</div>
                            <div class="col-md-6"><input type="text" name="noIntEEdit" id="noIntEEdit" disabled class="form-control" onfocusout="changeFlag(4)" maxlength="20"></div>
                            <div class="col-md-2" id="noIntEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Ciudad</div>
                            <div class="col-md-6"><input type="text" name="cityEEdit" id="cityEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-md-2" id="cityEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Estado</div>
                            <div class="col-md-6"><input type="text" name="estadoEEdit" id="estadoEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-md-2" id="estadoEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Colonia</div>
                            <div class="col-md-6"><input type="text" name="coloniaEEdit" id="coloniaEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-md-2" id="coloniaEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">C.P.</div>
                            <div class="col-md-6"><input type="text" name="cpEEdit" id="cpEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-md-2" id="cpEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertDE">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Begin Title -->
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Negocio</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Metodo de pago</div>
                            <div class="col-md-6"><input type="text" name="metPagoEdit" id="metPagoEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="metPagoButtons">
                            </div>
                        </div>
                        <div class="row mb-3" id="giroEdit1">
                            <div class="col-md-4">Giro</div>
                            <div class="col-md-6">
                                <input type="text" name="giroEditV" id="giroEditV" disabled class="form-control" disabled>
                                <!-- <select id="giroEdit" name="giroEdit" class="form-control selectpicker" data-live-search="true"></select> -->
                            </div>
                            <div class="col-md-2" id="giroButtons">
                            </div>
                        </div>
                        <div class="row mb-3 d-none" id="giroEdit2">
                            <div class="col-md-4">Giro</div>
                            <div class="col-md-6">
                                <select id="giroEdit" name="giroEdit" class="form-control selectpicker" data-live-search="true"></select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-circle" onclick="alert('Ya está disponible la edición')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-circle float-right"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Antiguedad</div>
                            <div class="col-md-6"><input type="text" name="antiguedadEdit" id="antiguedadEdit" disabled class="form-control" onfocusout="changeFlag(1)"></div>
                            <div class="col-md-2" id="antiguedadButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Foto Frente</div>
                            <div class="col-md-4" id="imgFFN"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="picNegFButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Foto Izquierda</div>
                            <div class="col-md-4" id="imgFIN"><button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-md-4" id="picNegIButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Foto Derecha</div>
                            <div class="col-md-4" id="imgFDN"><button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-md-4" id="picNegDButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertNegocio">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos de Contacto</h3>
                        <hr class="hr-indarYellow">
                        <div class="contactos" id="datContactos">
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertCont">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="crediSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Credito</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Tipo Local</div>
                            <div class="col-md-4"><input type="text" name="typeLEdit" id="typeLEdit" disabled class="form-control"></div>
                            <div class="col-md-4" id="typeLButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Tipo Persona</div>
                            <div class="col-md-4"><input type="text" name="typePEdit" id="typePEdit" disabled class="form-control"></div>
                            <div class="col-md-4" id="typePButtons">
                            </div>
                        </div>
                        <div class="row mb-3" id="pagareSection" style="display: none;">
                            <div class="col-md-4">Pagare</div>
                            <div class="col-md-4" id="imgPagA"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="picPagAButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">IFE/INE Representante</div>
                            <div class="col-md-4" id="imgIfeR"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="picIFERButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">IFE/INE Representante (Reverso)</div>
                            <div class="col-md-4" id="imgIfeRR"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="picIFERRButtons">
                            </div>
                        </div>
                        <div class="row mb-3" id="ifeASection" style="display:  none;">
                            <div class="col-md-4">IFE/INE Aval</div>
                            <div class="col-md-4" id="imgIfeA"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="picIFEAButtons">
                            </div>
                        </div>
                        <div class="row mb-3" id="ifeARSection" style="display: none;">
                            <div class="col-md-4">IFE/INE Aval (Reverso)</div>
                            <div class="col-md-4" id="imgIfeAR"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-md-4" id="picIFERAButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertCredit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="aCSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Acta Constitutiva <button class="btn btn-warning float-right" onclick="editActaConst()"><i class="fas fa-pencil-alt"></i>Editar Acta Constitutiva</button></h3>
                        <hr class="hr-indarYellow">
                        <div class="acRow" id="acRow">

                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertAC">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cRSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Carta Responsiva</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Carta Responsiva</div>
                            <div class="col-md-4" id="imgCR"> <button class="btn btn-warning"><i class="far fa-eye"></i> No hay archivo</button></div>
                            <div class="col-md-4" id="cartRButtons">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cartSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Caratula <button class="btn btn-warning float-right" onclick="editReferences()"><i class="fas fa-pencil-alt"></i>Editar Caratula</button></h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Caratula</div>
                            <div class="col-md-4" id="imgCara"> <button class="btn btn-warning"><i class="far fa-eye"></i> No hay archivo</button></div>
                            <div class="col-md-4" id="caraButtons">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="refSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Referencias <button class="btn btn-warning float-right" onclick="editReferences()"><i class="fas fa-pencil-alt"></i>Editar Referencias</button></h3>
                        <hr class="hr-indarYellow">
                        <div class="acRow" id="refList">
                        </div>
                    </div>
                </div>
                <div class="row" id="factSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Facturas <button class="btn btn-warning float-right" onclick="editReferences()"><i class="fas fa-pencil-alt"></i>Editar Facturas</button></h3>
                        <hr class="hr-indarYellow">
                        <div class="acRow" id="factList">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr class="hr-indarYellow">
                        <div class="acRow">
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center" id="alertRef">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HISTORIAL DE SOLICITUD-->
<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto" id="titleHistory"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3 bg-dark">
                            <div class="col-md-6">Fecha</div>
                            <div class="col-md-6">Tipo de Transacción</div>
                        </div>
                        <div id="historyList"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!--Edit Image-->
<div class="modal" tabindex="-1" id="editImageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalEdit">Editar Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodyEditImageModal" style="text-align: center;">
                <div class="row">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="titlePictureEdit">Editar imagen</span>
                        </div>
                        <div class="custom-file">
                            <!-- <input type="file" class="custom-file-input" id="inputGroupFile19" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> -->
                            <input type="file" class="custom-file-input" id="inputGroupFile19">
                            <label class="custom-file-label" for="inputGroupFile19" id="label-inputGroupFile19">Ingrese Archivo ...</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="editConfirButtons"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CONFIRMACIÓN -->
<div class="modal" tabindex="-1" id="confirModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalConfirm">¿Es seguro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodyModalConfirm" style="text-align: center;">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE MOSTRAR IMAGEN-->
<div class="modal" tabindex="-1" id="showIMGModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalR">Visualización de Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="showIMGBody">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- CARGA MODAL -->
<div class="modal" tabindex="-1" id="cargaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="titleCargaModal"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Enviando información <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="bodyCargaModal"><i class="fa fa-spinner" aria-hidden="true"></i></div>
        </div>
    </div>
</div>

<!-- MODAL ALERT -->
<div class="modal" tabindex="-1" id="alertModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="titleModalR"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta del formulario <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="alertInfoModal">
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('assets/intranet/js/solicitudesConsulta.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- BS-Stepper -->
<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>


<!-- Page specific script -->

<script>
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    });
</script>
@endsection