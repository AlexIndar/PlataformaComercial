@extends('layouts.intranet.main', ['active' => 'Intranet', 'permissions' => $permissions])

@section('title') IndarNet - Mis Solicitudes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Mis Solicitudes</h1>
                    <input type="text" id="zoneP" value="{{$zone['description']}}" hidden>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <!-- <input class="form-check-input" type="checkbox" id="defaultCheck1" onclick="refresh()">
                        <label class="form-check-label" for="defaultCheck1">Ver solo pendientes</label> -->
                        <button type="button" class="btn btn-success float-right" onclick="startForm()">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
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
                            <h3 class="card-title text-indarBlue">Mis solicitudes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Razon Social</th>
                                        <th>Fecha de envio solicitud</th>
                                        <th>Situación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listSol as $item)
                                    <tr>
                                        <td>{{$item->claveP}}</td>
                                        <td>{{$item->razonSocial}}</td>
                                        <td>{{$item->fechaAlta}}</td>
                                        <td>{{getStatus($item->status)}}</td>
                                        <td>
                                            @if($item->status != 1)
                                            <div class="btn btn-info btn-circle" id="btnInfo" onclick='detalleSol("{{$item->folio}}")'>
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            @endif
                                            @if($item->status == 7 || $item->status == 8)
                                            <div class="btn btn-primary btn-circle" onclick='reSendFol("{{$item->folio}}")'><i class="fas fa-paper-plane"></i></div>
                                            @endif
                                            <div class="btn btn-info btn-circle" onclick='getTransactionHistory("{{$item->folio}}")'>
                                                <i class="far fa-clock"></i>
                                            </div>
                                            @if($item->status == 1)
                                            <div class="btn btn-warning btn-circle" onclick='continueForm("{{$item->folio}}")'><i class="fas fa-pencil-alt"></i></div>
                                            @endif

                                            <!--<div class="btn btn-danger btn-circle"  *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>-->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Razon Social</th>
                                        <th>Fecha de envio solicitud</th>
                                        <th>Situación</th>
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

<!--MODAL ALTA SOLICITUD -->
<div class="modal fade" id="solicitudModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue" id="headerUNO">
                <input type="text" id="folioR" value="" hidden>
                <h3 class="text-center oswald title ml-auto">Solicitud para Alta de Cliente</h3>
                <h4 class="ml-auto oswald">ZONA: {{$zone['description']}}</h4>
                <button type="button" class="close text-warning" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h5>TIPO DE SOLICITUD</h5>
                                        <button type="submit" class="btn btn-warning float-right" onclick="saveForm('{{$zone}}')">Guardar</button>
                                        <form>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="credit" onclick="valiteTypeForm()" id="creditRadio">Credito</label>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="creditAB" onclick="valiteTypeForm()" id="creditABRadio">AB</label>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="cash" onclick="valiteTypeForm()" id="cashRadio">Contado</label>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="changeRS" onclick="valiteTypeForm()" id="changeRSRadio">Carta Responsiva</label>
                                        </form>
                                    </div>
                                </div>
                                <div class="row" id="amountSol">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-indarYellow">$</span>
                                            <input type="text" class="form-control" id="creditoInput">
                                            <span class="input-group-text bg-indarYellow">.00</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="bs-stepper">
                                    <div class="bs-stepper-header" role="tablist">
                                        <!-- your steps here -->
                                        <div class="step" data-target="#datosGenerales" onclick="stepper.to(1)" id="datosGe">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-user-shield"></i></span>
                                                <span class="bs-stepper-label">Datos Generales</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#direccionFiscal" onclick="stepper.to(2)" id="dirFisc">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-map-marker-alt"></i></span>
                                                <span class="bs-stepper-label">Dirección Fiscal</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#negocio" onclick="stepper.to(3)" id="negoSol">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-store"></i></span>
                                                <span class="bs-stepper-label">Negocio</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#datosContacto" onclick="stepper.to(4)" id="datConSol">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-address-book"></i></span>
                                                <span class="bs-stepper-label">Datos Contacto</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#credito" onclick="stepper.to(5)" id="credSol">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-credit-card"></i></span>
                                                <span class="bs-stepper-label">Credito</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#actaConstitutiva" onclick="stepper.to(6)" id="actaConst">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-file-invoice"></i></span>
                                                <span class="bs-stepper-label">Acta constitutiva</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#referencias" onclick="stepper.to(7)" id="referenciaSol">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-users"></i></span>
                                                <span class="bs-stepper-label">Referencias</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#final" onclick="stepper.to(8)" id="enviarSol">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-flag-checkered"></i></span>
                                                <span class="bs-stepper-label">Enviar</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="datosGenerales" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>DATOS GENERALES</h3>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">

                                                    <input type="text" name="RFC" id="rfcInput" placeholder="RFC" class="form-control" onfocusout="validaRFC()" maxlength="13">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="RazonSocial" id="rzInput" placeholder="Nombre o razon social" class="form-control" onfocusout="validaRZI()" maxlength="99">
                                                    <span>Apellido Paterno - Materno - Nombres(s)</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="nombreComercial" id="nameComeInput" placeholder="Nombre Comercial" class="form-control" onfocusout="validaNameC()" maxlength="99">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="numeroProspecto" id="prospecto" placeholder="Número de prospecto" class="form-control" onfocusout="validaProsP()" maxlength="10">
                                                    <span>Capturar número de prospecto de la página web</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm">
                                                    <div class="dropdown">
                                                        <i class="fas fa-question"></i>
                                                        <div class="dropdown-content">
                                                            <img src="{{asset('assets/intranet/images/situacionFiscal.jpg')}}" alt="Situación Fiscal" width="147" height="225">
                                                            <div class="desc">Situación Fiscal</div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Constancia de Situacion Fiscal</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" accept="image/x-png,image/gif,image/jpeg" lang="es">
                                                        <label class="custom-file-label" for="inputGroupFile01" id="label-inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                                <small class="form-text ml-4 mb-1 text-indarBlue">Formato R1*</small>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Constancia de Situacion Fiscal (2da Pagina)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile02" accept="image/x-png,image/gif,image/jpeg">
                                                        <label class="custom-file-label" for="inputGroupFile02" id="label-inputGroupFile02">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Fotografia de Solicitud</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile03" accept="image/x-png,image/gif,image/jpeg">
                                                        <label class="custom-file-label" for="inputGroupFile03" id="label-inputGroupFile03">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<button class="btn bg-warning" onclick="stepper.next()">Siguiente</button>-->
                                            <!-- <button class="btn bg-warning" onclick="verificarDatosGenerales() ? stepper.next() : alert('Llena los campos')">Siguiente</button> -->
                                        </div>
                                        <div id="direccionFiscal" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>DIRECCIÓN FISCAL</h3>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="calle" id="calleInput" placeholder="Calle" class="form-control" onfocusout="validaCalle()" maxlength="99">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="noExt" id="noExtInput" placeholder="No. Ext" class="form-control" onfocusout="validaNoEx()" maxlength="10">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="noInt" id="noIntInput" placeholder="No. Int" class="form-control" onfocusout="validaNoIn()" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="codPos" id="cpInput" placeholder="C.P." class="form-control" onfocusout="updateGeolocation()" maxlength="5">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="email" name="emailFacturacion" id="emailFac" placeholder="Correo@exmample.com" class="form-control" onfocusout="validaEmailF()" maxlength="49">
                                                    <span>Correo donde se enviará la factura</span>
                                                </div>
                                                <!-- <div class="col-md-4">
                                                    <button onclick="updateGeolocation()" class="btn btn-info">Actualizar Geolocalización</button>
                                                </div> -->
                                            </div>
                                            <div class="row mb-3" id="rowInputsGeo">
                                                <div class="col-md-4" id="colDFRow1">
                                                    <span>Colonia</span>
                                                    <select id="colDF" name="colDF" class="form-control selectpicker" data-live-search="true">
                                                    </select>
                                                </div>
                                                <div class="col-md-4 d-none" id="colDFRow2">
                                                    <span>Colonia</span>
                                                    <input type="text" name="auxColDF" id="auxColDF" placeholder="Colonia" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <span>Ciudad</span>
                                                    <input type="text" name="CiudadDF" id="ciudadDF" placeholder="Ciudad" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <span>Estado</span>
                                                    <input type="text" name="estadoDF" id="estadoDF" placeholder="Estado" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3 d-none" id="rowOtraColonia">
                                                <div class="col-md-4">
                                                    <span>Ingresa el nombre de la colonia</span>
                                                    <input type="text" name="otraCol" id="otraCol" placeholder="Colonia" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row" id="compDom1">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Comprobante de Domicilio</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile04" (change)="onFileChange($event, ConstFileTitle);" accept="image/x-png,image/gif,image/jpeg" formControlName="RFCFileCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile04" id="label-inputGroupFile04">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="compDom2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Comprobante de Domicilio (Reverso)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile05" (change)="onFileChange($event, ConstFileTitleReverso);" accept="image/x-png,image/gif,image/jpeg" formControlName="RFCFileReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile05" id="label-inputGroupFile05">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted ml-4 mb-1">CFE, Teléfono, Agua (No mayor a 90 días)</small>
                                            </div>

                                            <div class="row mb-3 form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="addAddress()" id="checkAddAddress">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    ¿Desea usar una dirección diferente para la entrega?
                                                </label>
                                            </div>

                                            <div class="shippingAddress" id="shippingAddress" style="display: none">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <input type="text" name="calle" id="calleInputShipping" placeholder="Calle" class="form-control" onfocusout="validaCalleS()" maxlength="99">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="noExt" id="noExtInputShipping" placeholder="No. Ext" class="form-control" onfocusout="validaNoExS()" maxlength="10">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="noInt" id="noIntInputShipping" placeholder="No. Int" class="form-control" onfocusout="validaNoInS()" maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <input type="text" name="codPos" id="cpInputShipping" placeholder="C.P." class="form-control" onfocusout="validarCPS()" maxlength="5">
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                        <input type="text" name="colDF" id="colDFShipping" placeholder="Colonia" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="CiudadDF" id="ciudadDFShipping" placeholder="Ciudad" class="form-control">
                                                    </div> -->
                                                </div>
                                                <!-- <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <input type="text" name="estadoDF" id="estadoDFShipping" placeholder="Estado" class="form-control">
                                                    </div>
                                                </div> -->
                                                <div class="row mb-3">
                                                    <div class="col-md-4" id="colDFRow3">
                                                        <span>Colonia</span>
                                                        <select id="colDFShipping" name="colDFShipping" class="form-control selectpicker" data-live-search="true">
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 d-none" id="colDFRow4">
                                                        <span>Colonia</span>
                                                        <input type="text" name="auxColDFShipping" id="auxColDFShipping" placeholder="Ciudad" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span>Ciudad</span>
                                                        <input type="text" name="ciudadDFShipping" id="ciudadDFShipping" placeholder="Ciudad" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span>Estado</span>
                                                        <input type="text" name="estadoDFShipping" id="estadoDFShipping" placeholder="Estado" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button> -->
                                        </div>
                                        <div id="negocio" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>NEGOCIO</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Giro del negocio</label>
                                                        </div>
                                                        <select id="inputGroupSelect01" name="inputGroupSelect01" class="form-control selectpicker" data-live-search="true">
                                                        </select>                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" name="antiguedad" id="antiguedad" placeholder="Antigüedad" class="form-control" onfocusout="validaAnti()" maxlength="4">
                                                </div>
                                            </div>
                                            <!-- <div class="row mb-3 d-none" id="rowOtroGiro">
                                                <div class="col-md-4">
                                                    <span>Ingresa el giro del negocio</span>
                                                    <input type="text" name="otroGiro" id="otroGiro" placeholder="Giro" class="form-control">
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">FOTO FRENTE</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile06" (change)="onFileChange($event, FotoFFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="BusinessPic1Ctrl">
                                                        <label class="custom-file-label" for="inputGroupFile06" id="label-inputGroupFile06">FotoFrente</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">FOTO PERFIL IZQ.</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile07" (change)="onFileChange($event, FotoIzqFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="BusinessPic2Ctrl">
                                                        <label class="custom-file-label" for="inputGroupFile07" id="label-inputGroupFile07">FotoperfilIZq</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">FOTO PERFIL DER.</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile08" (change)="onFileChange($event, FotoDerFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="BusinessPic3Ctrl">
                                                        <label class="custom-file-label" for="inputGroupFile08" id="label-inputGroupFile08">fotoPerfilDerecho</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button> -->
                                        </div>
                                        <div id="datosContacto" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>DATOS DE CONTACTO</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Tipo de contacto</label>
                                                        </div>
                                                        <select class="custom-select" id="tipoContacto">
                                                            <option selected>SELECCIONAR</option>
                                                            <option value="1">PRINCIPAL</option>
                                                            <option value="2">PAGOS</option>
                                                            <option value="3">COMPRAS</option>
                                                            <option value="4">ADMON</option>
                                                            <option value="5">EMERGENCIA</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="nombreContacto" id="nombreContacto" placeholder="Nombre" class="form-control" onfocusout="validateNameC()" maxlength="49">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="telefonoContacto" id="telefonoContacto" placeholder="Telefono" class="form-control" maxlength="10">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="celularContacto" id="celularContacto" placeholder="Celular" class="form-control" maxlength="10">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="email" name="emailContacto" id="emailContacto" placeholder="Correo" class="form-control" maxlength="49">
                                                    </div>
                                                    <div class="input-group mb-3 checkForm">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                            ¿Desea recibir publicidad sobre nuestras promociones en este correo?
                                                        </label>
                                                    </div>
                                                    <div class="col-12 text-center" id="alertContacto">

                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info" onclick="addContactData()">Agregar Contacto</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-7">
                                                    <table class="table" id="contactData">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Celular</th>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- <tr>
                                                                <th scope="row">Francisco</th>
                                                                <td>332255889966</td>
                                                                <td>Principal</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sanchez</th>
                                                                <td>3355778855</td>
                                                                <td>Pagos</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr> -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button> -->
                                        </div>
                                        <div id="credito" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>CREDITO</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <p>Local:</p>
                                                    </div>
                                                    <div class="row">
                                                        <form>
                                                            <label class="mr-3"><input type="radio" name="localSoli" value="propio" onclick="changeTipoLocal('Propio')" id="typePropio">Propio</label>
                                                            <label class="mr-3"><input type="radio" name="localSoli" value="rentado" onclick="changeTipoLocal('Rentado')" id="typeRentado">Rentado</label>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Tipo de persona</p>
                                                    <form>
                                                        <label class="mr-3"><input type="radio" name="typePeople" value="fisica" onclick="changeTipoPersona('Fisica')" id="typeFisica">Fisica</label>
                                                        <label class="mr-3"><input type="radio" name="typePeople" value="moral" onclick="changeTipoPersona('Moral')" id="typeMoral">Moral</label>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row" id="pagare" *ngIf="fifthFormGroup.controls.AntiquityCtrl.value<=1">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">PAGARE</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile09" (change)="onFileChange($event, PagareFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="PagareCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile09" id="label-inputGroupFile09">Pagare</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE REPRESENTANTE</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile10" (change)="onFileChange($event, IFERepFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFECtrl">
                                                        <label class="custom-file-label" for="inputGroupFile10" id="label-inputGroupFile10">IFE</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE REPRESENTANTE (Reverso)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile11" (change)="onFileChange($event, IFERepFileTitleReverso)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFEReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile11" id="label-inputGroupFile11">IFER</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="ineAval" *ngIf="fifthFormGroup.controls.AntiquityCtrl.value<=1 || this.TypeRequestCtrl == 'changeRS'">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE AVAL</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile12" (change)="onFileChange($event, IFEAvalFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFEAvalCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile12" id="label-inputGroupFile12">IFEA</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="ineAvalBack" *ngIf="fifthFormGroup.controls.AntiquityCtrl.value<=1 || this.TypeRequestCtrl == 'changeRS'">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE AVAL (Reverso)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile13" accept="image/x-png,image/gif,image/jpeg" formControlName="IFEAvalReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile13" id="label-inputGroupFile13">IFEAR</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button> -->
                                        </div>
                                        <div id="actaConstitutiva" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>ACTA CONSTITUTIVA</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect14">Tipo Archivo</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect14">
                                                            <option value="-1" selected>SELECCIONAR</option>
                                                            <option value="2">FECHA DE CONSTITUCION</option>
                                                            <option value="1">RAZON SOCIAL</option>
                                                            <option value="3">GIRO DE LA EMPRESA</option>
                                                            <option value="4">TRANSITORIOS</option>
                                                            <option value="5">ACCIONISTAS</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="dropdown">
                                                            <i class="fas fa-question"></i>
                                                            <div class="dropdown-content">
                                                                <img src="{{asset('assets/intranet/images/fechaConstitucion.jpg')}}" alt="Acta constitutiva" width="147" height="225">
                                                                <div class="desc">Acta constitutiva</div>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ACTA CONSTITUTIVA</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile14" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile14" id="label-inputGroupFile14">Acta</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info" onclick="addActaConstData()">Agregar Documento</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-6">
                                                    <table class="table" id="actaConsData">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Documento</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- <tr>
                                                                <th scope="row">Razon Social</th>
                                                                <td>Razondocial.jpg</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Giro empresa</th>
                                                                <td>GiroEmpresa.jpg</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr> -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button> -->
                                        </div>
                                        <div id="referencias" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>REFERENCIAS</h3>
                                                </div>
                                            </div>
                                            <div class="row" id="referenciasOptions">
                                                <div class="col-md-12 text-center">
                                                    <form>
                                                        <label class="mr-3"><input type="radio" name="refSoli" id="refSoliDatos" value="datos" onclick="changeRef()">Datos</label>
                                                        <label class="mr-3"><input type="radio" name="refSoli" id="refSoliCaratula" value="caratula" onclick="changeRef()">Caratula</label>
                                                        <label class="mr-3"><input type="radio" name="refSoli" id="refSoliFactura" value="facturas" onclick="changeRef()">Facturas</label>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row d-none" id="referenciasCarta">
                                                <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Carta Responsiva</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile18" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="CartaResponsiva">
                                                        <label class="custom-file-label" for="inputGroupFile18" id="label-inputGroupFile18">Archivo ...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" id="refGroup" style="display: none;">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="razonSocialRef" id="razonSocialRef" placeholder="Razón Social" class="form-control" maxlength="49">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="contactoRef" id="contactoRef" placeholder="Contacto" class="form-control" maxlength="20">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="ciudadRef" id="ciudadRef" placeholder="Ciudad" class="form-control" maxlength="49">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="telefonoRef" id="telefonoRef" placeholder="Telefono" class="form-control" maxlength="10">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info" onclick="addRefData()">Agregar Referencias</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-7">
                                                    <table class="table" id="refData">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Razon Social</th>
                                                                <th scope="col">Contacto</th>
                                                                <th scope="col">Ciudad</th>
                                                                <th scope="col">Telefono</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <!-- <tbody>
                                                            <tr>
                                                                <td scope="row">Sierraz Sanchez</td>
                                                                <td>Contacto</td>
                                                                <td>Guadalajara</td>
                                                                <td>3322558899</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Ferre todo</td>
                                                                <td>Contacto</td>
                                                                <td>Tlaquepaque</td>
                                                                <td>3355778855</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                        </tbody> -->
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row" id="cartGroup" style="display: none;">
                                                <div class="col-md-12 text-center">
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Caratula</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile15" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile15" id="label-inputGroupFile15">Archivo ...</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="factGroup" style="display: none;">
                                                <div class="col-md-5">
                                                    <p>Las facturas deben ser de la competencia, no mayores a 30 dias y la suma del importe de estas deben ser igual o mayor al doble del credito solicitado*</p>
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Datos de Factura</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile16" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile16" id="label-inputGroupFile16">Factura</label>
                                                        </div>
                                                        <span>Ésta página debe mostrar RFC del interesado y de su proveedor*</span>
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Importe de factura</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile17" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile17" id="label-inputGroupFile17">Factura</label>
                                                        </div>
                                                        <span>Ésta página debe mostrar el importe total de la factura*</span>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span>Importe</span>
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control" id="importFactura" style="text-align:right;">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info" onclick="addFacturaData()">Agregar Factura</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-6">
                                                    <table class="table" id="facturaData">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Datos Factura</th>
                                                                <th scope="col">Importe Factura</th>
                                                                <th scope="col">Importe</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- <tr>
                                                                <th scope="row">1</th>
                                                                <td>DatosFactura.jpg</td>
                                                                <td>ImporteFactura.jpg</td>
                                                                <td>$$$</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>DatosFactura.jpg</td>
                                                                <td>ImporteFactura.jpg</td>
                                                                <td>$$$</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr> -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button> -->

                                        </div>
                                        <div id="final" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>SOLICITUD TERMINADA</h3>
                                                    <button type="submit" class="btn btn-success" onclick="SendForm('{{$zone}}')">Enviar</button>
                                                    <button type="submit" class="btn btn-warning" onclick="saveForm('{{$zone}}')">Guardar</button>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>-->
        </div>
    </div>
</div>


<!--MODAL INFO -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto">Detalle de Solicitud No. <span id="folioInf"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal2">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos Generales</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">RFC</div>
                            <div class="col-md-6"><input type="text" name="rfcEdit" id="rfcEdit" class="form-control" disabled></div>
                            <div class="col-md-2" id="rfcButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Razon Social</div>
                            <div class="col-md-6"><input type="text" name="rzEdit" id="rzEdit" class="form-control" disabled></div>
                            <div class="col-md-2" id="rzButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Nombre Comercial</div>
                            <div class="col-md-6"><input type="text" name="nomComEdit" id="nomComEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="nomComButtons">
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
                            <div class="col-md-6"><input type="text" name="calleFEdit" id="calleFEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="callFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Exteriorl</div>
                            <div class="col-md-6"><input type="text" name="noFEdit" id="noFEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="noFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Ciudad</div>
                            <div class="col-md-6"><input type="text" name="cityFEdit" id="cityFEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="cityFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Estado</div>
                            <div class="col-md-6"><input type="text" name="estadoFEdit" id="estadoFEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="estadoFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Colonia</div>
                            <div class="col-md-6"><input type="text" name="coloniaFEdit" id="coloniaFEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="coloniaFEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">CP</div>
                            <div class="col-md-6"><input type="text" name="cpFEdit" id="cpFEdit" disabled class="form-control"></div>
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
                            <div class="col-md-6"><input type="text" name="calleEEdit" id="calleEEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="calleEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Exterior</div>
                            <div class="col-md-6"><input type="text" name="noEEdit" id="noEEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="noEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Ciudad</div>
                            <div class="col-md-6"><input type="text" name="cityEEdit" id="cityEEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="cityEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Estado</div>
                            <div class="col-md-6"><input type="text" name="estadoEEdit" id="estadoEEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="estadoEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Colonia</div>
                            <div class="col-md-6"><input type="text" name="coloniaEEdit" id="coloniaEEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="coloniaEEButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">C.P.</div>
                            <div class="col-md-6"><input type="text" name="cpEEdit" id="cpEEdit" disabled class="form-control"></div>
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
                        <div class="row mb-3">
                            <div class="col-md-4">Giro</div>
                            <div class="col-md-6"><input type="text" name="giroEdit" id="giroEdit" disabled class="form-control"></div>
                            <div class="col-md-2" id="giroButtons">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Antiguedad</div>
                            <div class="col-md-6"><input type="text" name="antiguedadEdit" id="antiguedadEdit" disabled class="form-control"></div>
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
                        <h3 class="text-center">Acta Constitutiva</h3>
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
                        <h3 class="text-center">Caratula</h3>
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
                        <h3 class="text-center">Referencias</h3>
                        <hr class="hr-indarYellow">
                        <div class="acRow" id="refList">

                        </div>
                    </div>
                </div>
                <div class="row" id="factSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Facturas</h3>
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
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning float-right" onclick="saveEdit()">Guardar</button>
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

<div class="modal" tabindex="-1" id="respuestaForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalR">Respuesta Formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="infoModalR">Enviado correctamente</p>
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
                            <input type="file" class="custom-file-input" id="inputGroupFile19" accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label" for="inputGroupFile19" id="label-inputGroupFile19">Fotografia a editar</label>
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
<!-- VALIDATE DATA MODAL -->
<!-- <div class="modal-background" id="validateModal">
    <div class="modal-header bg-indarBlue">
        <h4>Verifica los siguientes datos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </div>
    <div class="modal-body">
        <div id="bodyValidations"></div> <br>
    </div>
</div> -->


@endsection

@section('js')
<script src="{{asset('assets/intranet/js/misSolicitudes.js')}}"></script>
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
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    });
</script>
@endsection