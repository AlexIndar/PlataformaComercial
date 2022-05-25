@extends('layouts.intranet.main', ['active' => 'Intranet', 'permissions' => $permissions])

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
                <div class="col-md-4">
                    @if($user['permissions'] != "CYC")
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Cobrador</label>
                        </div>
                        <select id="inputGroupSelect01" name="inputGroupSelect01" class="form-control selectpicker" data-size="7" data-live-search="true">
                        </select>
                    </div>
                    @endif
                </div>
                <div class="col-md-8 text-center">
                    <h2>Solicitudes Pendientes</h2>
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
                            <h3 class="card-title text-indarBlue">Solicitudes Pendientes</h3>
                            <button onclick="envioMail()"></button>
                            <button onclick="ocultar()"></button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableCyc" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Prospecto</th>
                                        <th>Tiempo en cola</th>
                                        <th>Zona</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Prospecto</th>
                                        <th>Tiempo en cola</th>
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
                <div class="row" id="datosGeneralesSection" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos Generales</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">RFC</div>
                            <div class="col-md-6"><input type="text" name="rfcEdit" id="rfcEdit" class="form-control" disabled onfocusout="changeFlag(2)" maxlength="13"></div>
                            <div class="col-md-2">
                                <label class="mr-3 text-green"><input type="radio" name="rfcData" value="Aceptado" id="rfcData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="rfcData" value="Rechazado" id="rfcData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Razon Social</div>
                            <div class="col-md-6"><input type="text" name="rzEdit" id="rzEdit" class="form-control" disabled onfocusout="changeFlag(2)" maxlength="99"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="razData" value="Aceptado" id="razData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="razData" value="Rechazado" id="razData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Nombre Comercial</div>
                            <div class="col-md-6"><input type="text" name="nomComEdit" id="nomComEdit" disabled class="form-control" onfocusout="changeFlag(1)" maxlength="99"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="nomComData" value="Aceptado" id="nomComData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="nomComData" value="Rechazado" id="nomComData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Email Facturacion</div>
                            <div class="col-md-6"><input type="text" name="emailFactE" id="emailFactE" disabled class="form-control"></div>
                            <div class="col-md-2">
                                <!-- <label class="mr-3 text-green"><input type="radio" name="emailFData" value="Aceptado" id="emailFData">SI</label> -->
                                <!-- <label class="mr-3 text-red"><input type="radio" name="emailFData" value="Rechazado" id="emailFData2">NO</label> -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Constancia de Situacion Fiscal</div>
                            <div class="col-md-6" id="imgCSFButton"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="constData" value="Aceptado" id="constData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="constData" value="Rechazado" id="constData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Constancia de Situacion Fiscal (2da Pagina)</div>
                            <div class="col-md-6" id="imgCSF2Button"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="const2Data" value="Aceptado" id="const2Data">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="const2Data" value="Rechazado" id="const2Data2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Fotografia de Solicitud</div>
                            <div class="col-md-6" id="imgFSButton"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="picSolData" value="Aceptado" id="picSolData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="picSolData" value="Rechazado" id="picSolData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="obsDatGen" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="direccionFiscalSection">
                    <div class="col-md-12">
                        <h3 class="text-center">Dirección Fiscal</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Calle</div>
                            <div class="col-md-6"><input type="text" name="calleFEdit" id="calleFEdit" disabled class="form-control" onfocusout="changeFlag(3)" maxlength="99"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirCalleData" value="Aceptado" id="dirCalleData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCalleData" value="Rechazado" id="dirCalleData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Exterior</div>
                            <div class="col-md-6"><input type="text" name="noFEdit" id="noFEdit" disabled class="form-control" onfocusout="changeFlag(3)" maxlength="20"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirNoData" value="Aceptado" id="dirNoData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirNoData" value="Rechazado" id="dirNoData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Interior</div>
                            <div class="col-md-6"><input type="text" name="noIntFEdit" id="noIntFEdit" disabled class="form-control" onfocusout="changeFlag(3)" maxlength="20"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirNoIntData" value="Aceptado" id="dirNoIntData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirNoIntData" value="Rechazado" id="dirNoIntData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Ciudad</div>
                            <div class="col-md-6"><input type="text" name="cityFEdit" id="cityFEdit" disabled class="form-control" onfocusout="changeFlag(3)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirCityData" value="Aceptado" id="dirCityData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCityData" value="Rechazado" id="dirCityData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Estado</div>
                            <div class="col-md-6"><input type="text" name="estadoFEdit" id="estadoFEdit" disabled class="form-control" onfocusout="changeFlag(3)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEstData" value="Aceptado" id="dirEstData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEstData" value="Rechazado" id="dirEstData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Colonia</div>
                            <div class="col-md-6" id="col1E"><input type="text" name="coloniaFEdit" id="coloniaFEdit" disabled class="form-control" onfocusout="changeFlag(3)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirColData" value="Aceptado" id="dirColData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirColData" value="Rechazado" id="dirColData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">CP</div>
                            <div class="col-md-6"><input type="text" name="cpFEdit" id="cpFEdit" disabled class="form-control" onfocusout="validaCPEdit()" maxlength="5"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirCpData" value="Aceptado" id="dirCpData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCpData" value="Rechazado" id="dirCpData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3" id="datFisCD">
                            <div class="col-md-4">Comprobante Domicilio</div>
                            <div class="col-md-4" id="imgCDButton"><button class="btn btn-danger"><i class="fas fa-exclamation"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirDomData" value="Aceptado" id="dirDomData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirDomData" value="Rechazado" id="dirDomData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsFiscal" id="obsFiscal" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="direccionEntregaSection">
                    <div class="col-md-12">
                        <h3 class="text-center">Dirección de entrega</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Calle</div>
                            <div class="col-md-6"><input type="text" name="calleEEdit" id="calleEEdit" disabled class="form-control" onfocusout="changeFlag(4)" maxlength="99"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntData" value="Aceptado" id="dirEntData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntData" value="Rechazado" id="dirEntData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Exterior</div>
                            <div class="col-md-6"><input type="text" name="noEEdit" id="noEEdit" disabled class="form-control" onfocusout="changeFlag(4)" maxlength="20"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntNoData" value="Aceptado" id="dirEntNoData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntNoData" value="Rechazado" id="dirEntNoData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">No. Interior</div>
                            <div class="col-md-6"><input type="text" name="noIntEEdit" id="noIntEEdit" disabled class="form-control" onfocusout="changeFlag(4)" maxlength="20"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntNoIntData" value="Aceptado" id="dirEntNoIntData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntNoIntData" value="Rechazado" id="dirEntNoIntData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Ciudad</div>
                            <div class="col-md-6"><input type="text" name="cityEEdit" id="cityEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entCityData" value="Aceptado" id="entCityData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entCityData" value="Rechazado" id="entCityData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Estado</div>
                            <div class="col-md-6"><input type="text" name="estadoEEdit" id="estadoEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entEstData" value="Aceptado" id="entEstData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entEstData" value="Rechazado" id="entEstData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Colonia</div>
                            <div class="col-md-6"><input type="text" name="coloniaEEdit" id="coloniaEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entColData" value="Aceptado" id="entColData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entColData" value="Rechazado" id="entColData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">C.P.</div>
                            <div class="col-md-6"><input type="text" name="cpEEdit" id="cpEEdit" disabled class="form-control" onfocusout="changeFlag(4)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entCpData" value="Aceptado" id="entCpData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entCpData" value="Rechazado" id="entCpData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsEntrea" id="obsEntrea" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Begin Title -->
                <div class="row" id="NegocioSection">
                    <div class="col-md-12">
                        <h3 class="text-center">Negocio</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Metodo de pago</div>
                            <div class="col-md-6"><input type="text" name="metPagoEdit" id="metPagoEdit" disabled class="form-control"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negPagData" value="Aceptado" id="negPagData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negPagData" value="Rechazado" id="negPagData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Giro</div>
                            <div class="col-md-6"><input type="text" name="giroEdit" id="giroEdit" class="form-control" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negiroData" value="Aceptado" id="negiroData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negiroData" value="Rechazado" id="negiroData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Antiguedad</div>
                            <div class="col-md-6"><input type="text" name="antiguedadEdit" id="antiguedadEdit" disabled class="form-control" onfocusout="changeFlag(1)"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negAntData" value="Aceptado" id="negAntData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negAntData" value="Rechazado" id="negAntData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Foto Frente</div>
                            <div class="col-md-4" id="imgFFN"><button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negFotData" value="Aceptado" id="negFotData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negFotData" value="Rechazado" id="negFotData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Foto Izquierda</div>
                            <div class="col-md-4" id="imgFIN"><button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negIzqData" value="Aceptado" id="negIzqData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negIzqData" value="Rechazado" id="negIzqData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Foto Derecha</div>
                            <div class="col-md-4" id="imgFDN"><button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negDerData" value="Aceptado" id="negDerData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negDerData" value="Rechazado" id="negDerData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsNegocio" id="obsNegocio" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="ContactoSection">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos de Contacto</h3>
                        <hr class="hr-indarYellow">
                        <div class="contactos" id="datContactos">
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsContacto" id="obsContacto" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
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
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credLocData" value="Aceptado" id="credLocData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credLocData" value="Rechazado" id="credLocData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Tipo Persona</div>
                            <div class="col-md-4"><input type="text" name="typePEdit" id="typePEdit" disabled class="form-control"></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credTypeData" value="Aceptado" id="credTypeData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credTypeData" value="Rechazado" id="credTypeData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3" id="pagareSection" style="display: none;">
                            <div class="col-md-4">Pagare</div>
                            <div class="col-md-4" id="imgPagA"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credPagData" value="Aceptado" id="credPagData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credPagData" value="Rechazado" id="credPagData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">IFE/INE Representante</div>
                            <div class="col-md-4" id="imgIfeR"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credRepData" value="Aceptado" id="credRepData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRepData" value="Rechazado" id="credRepData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">IFE/INE Representante (Reverso)</div>
                            <div class="col-md-4" id="imgIfeRR"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credRepRevData" value="Aceptado" id="credRepRevData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRepRevData" value="Rechazado" id="credRepRevData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3" id="ifeASection" style="display:  none;">
                            <div class="col-md-4">IFE/INE Aval</div>
                            <div class="col-md-4" id="imgIfeA"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credIneData" value="Aceptado" id="credIneData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credIneData" value="Rechazado" id="credIneData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3" id="ifeARSection" style="display: none;">
                            <div class="col-md-4">IFE/INE Aval (Reverso)</div>
                            <div class="col-md-4" id="imgIfeAR"> <button class="btn btn-warning"><i class="far fa-eye"></i>SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credRevData" value="Aceptado" id="credRevData">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRevData" value="Rechazado" id="credRevData2">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3" id="showIneValidationSection" style="display: none;">
                            <div class="col-md-4">Ine Validation</div>
                            <div class="col-md-4" id="imgIneVal"><button class="btn btn-warning"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsCredito" id="obsCredito" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
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
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsActaConst" id="obsActaConst" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cartaRespRef" style="display: none;">
                    <div class="col-md-12">
                        <h3 class="text-center">Carta Responsiva</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-md-4">Carta Responsiva</div>
                            <div class="col-md-4" id="imgCRRef"> <button class="btn btn-warning"><i class="far fa-eye"></i> No hay archivo</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="picCRRef" value="Aceptado" id="picCRRef">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="picCRRef" value="Rechazado" id="picCRRef2">NO</label>
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
                            <div class="col-md-4" id="imgCaraRef"><button class="btn btn-warning"><i class="far fa-eye"></i> No hay archivo</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="picCaratulaRef" value="Aceptado" id="picCaratulaRef">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="picCaratulaRef" value="Rechazado" id="picCaratulaRef2">NO</label>
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
                <div class="row" id="observRef" style="display: none;">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsReferencias" id="obsReferencias" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-outline-success float-right"  onclick="acceptCredit(true)">Aceptar</button> -->
                <button type="button" class="btn btn-outline-success float-right" onclick="saveValidation(true)" id="acceptOne" style="display: none;">Aceptar</button>
                <button type="button" class="btn btn-outline-success float-right" onclick="initialQuestionTrue(true)" id="acceptTwo" style="display: none;">Aceptar</button>
                <button type="button" class="btn btn-outline-danger float-right" onclick="saveValidation(false)">Rechazar</button>
                <button type="button" class="btn btn-outline-info float-right" onclick="saveValidation(null)">Guardar</button>
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
                            <input type="file" class="custom-file-input" id="inputGroupFile19" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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

<!--MODAL ACCEPT FOR CREDIT-->
<div class="modal fade" id="acceptForCreditModal" tabindex="-1" aria-labelledby="acceptForCreditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title">Acceptar Solicitud</h3>
                <h3 class="text-center title ml-auto">Folio <span id="folAcceptCredit">2654</span></h3>
                <h3 class="text-center title ml-auto" id="typeSolAcceptCredit">CreditoAB</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
                <br>
                <div class="row mb-6">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="shippingWaySelectCredit">Forma de Envio</label>
                            </div>
                            <select id="shippingWaySelectCredit" name="shippingWaySelectCredit" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-indarYellow">$</span>
                            <input type="text" class="form-control" placeholder="Limite de Saldo" id="limitCredit">
                            <span class="input-group-text bg-indarYellow">.00</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="" id="maxDayOfCredit" placeholder="Días Máximos" class="form-control">
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row mb-6">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="commercialPaySelectCredit">Condicion de Pago</label>
                            </div>
                            <select id="commercialPaySelectCredit" name="commercialPaySelectCredit" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="priceListSelectCredit">Lista de Precio</label>
                            </div>
                            <select id="priceListSelectCredit" name="priceListSelectCredit" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- <input type="text" name="" id="" placeholder="Usuario Intelisis" class="form-control"> -->
                    </div>
                </div>
                <br>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success float-right" onclick="acceptCredit()">Aceptar</button>
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ACCEPT FOR CASH-->
<div class="modal fade" id="acceptForCashModal" tabindex="-1" aria-labelledby="acceptForCashLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title">Acceptar Solicitud</h3>
                <h3 class="text-center title ml-auto">Folio <span id="folAcceptCash">2654</span></h3>
                <h3 class="text-center title ml-auto" id="typeSolAccept">CreditoAB</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
            <input type="text" id="sameDir" value="" hidden>
            <input type="text" id="typeSolCash" value="" hidden>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="saleRoutesSelect">Ruta de Venta</label>
                            </div>
                            <select id="saleRoutesSelect" name="saleRoutesSelect" class="form-control selectpicker" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-indarYellow">$</span>
                            <input type="text" class="form-control" placeholder="Limite de Saldo" id="limitCash">
                            <span class="input-group-text bg-indarYellow">.00</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="" id="maxDayCash" placeholder="Días Máximos" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="commercialTermsSelect">Condicion Comercial</label>
                            </div>
                            <select id="commercialTermsSelect" name="commercialTermsSelect" class="form-control selectpicker" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="priceListSelect">Lista de Precio</label>
                            </div>
                            <select id="priceListSelect" name="priceListSelect" class="form-control selectpicker" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="" id="userCash" placeholder="Usuario Intelisis" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">Pagare Nuevo</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="" id="montoPagare" placeholder="Monto Pagare" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="defaultCheck2">
                            <label class="form-check-label" for="defaultCheck2">Bono Cliente Nuevo</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2" id="addresFiscal1">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="shippingWaySelect">Forma de Envio</label>
                            </div>
                            <select id="shippingWaySelect" name="shippingWaySelect" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="routeSelect">Ruta</label>
                            </div>
                            <select id="routeSelect" name="routeSelect" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p id="dirF1">AV GUADALUPE #150 - #C 204, Santa Cruz de las Huertas, TONALA, JALISCO, C.P. 45402</p>
                    </div>
                </div>
                <div class="row mb-2" id="addresFiscal2">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="shippingWaySelect2">Forma de Envio</label>
                            </div>
                            <select id="shippingWaySelect2" name="shippingWaySelect2" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="paqueteriaSelect">Paqueteria</label>
                            </div>
                            <select id="paqueteriaSelect" name="paqueteriaSelect" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p id="dirF2">AV GUADALUPE #150 - #C 204, Santa Cruz de las Huertas, TONALA, JALISCO, C.P. 45402</p>
                    </div>
                </div>
                <div class="row mb-2" id="addresEntrega" style="display: none;">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="shippingWaySelect3">Forma de Envio</label>
                            </div>
                            <select id="shippingWaySelect3" name="shippingWaySelect3" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="paqueteriaSelect2">Paqueteria</label>
                            </div>
                            <select id="paqueteriaSelect2" name="paqueteriaSelect2" class="form-control selectpicker" data-size="5" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p id="dirE">AV GUADALUPE #150 - #C 204, Santa Cruz de las Huertas, TONALA, JALISCO, C.P. 45402</p>
                    </div>
                </div>
                <div class="row mb-2" id="ineValidationSection" style="display: none;">
                    <div class="col-md-12 text-center">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="titlePictureEdit">Validación INE</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="ineValidationFile" accept="image/x-png,image/gif,image/jpeg">
                                <label class="custom-file-label" for="ineValidationFile" id="label-ineValidationFile">Ingresar archivo ...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success float-right" onclick="acceptContado()">Aceptar contado</button>
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REFERENCIA -->
<div class="modal" tabindex="-1" id="setReferenceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="titleModalRef"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Agrega la referencia<i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <input type="text" id="referenceValue" placeholder="Referencia" class="form-control">
                    </div>
                </div>
                <input type="text" id="codCustomer" value="" hidden>
                <input type="text" id="folRef" value="" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success float-right" onclick="setReference()">Enviar Referencia</button>
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REACTIVACION -->
<div class="modal" tabindex="-1" id="reactiveClieModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="titleModalReact">Solicitud No.<span id="folReact"></span>, RFC: <span id="rfcReact"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <input type="text" id="reactiveClieValue" placeholder="No. Cliente" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success float-right" onclick="setReactCli()">Reactivar</button>
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cerrar</button>
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
<script src="{{asset('assets/intranet/js/solicitudesPendientes.js')}}"></script>
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


    function mensaje() {
        let info = $('input[name="rfcData"]:checked').val();
        alert(info);
    }
</script>
@endsection