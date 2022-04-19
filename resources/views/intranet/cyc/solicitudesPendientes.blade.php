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
                        <select id="inputGroupSelect01" name="inputGroupSelect01" class="form-control selectpicker" data-live-search="true">
                        </select>
                    </div>
                    @endif
                </div>
                <div class="col-md-8 text-center">
                    <h2>Solicitudes Pendientes</h2>
                    <button onclick="getSolicitudesPendientes()">asd</button>
                    <input type="text" id="userName" value="{{$user['typeUser']}}">
                    <input type="text" id="userP" value="{{$user['permissions']}}">
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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
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


<div class="modal fade" id="validarInfoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto">Validar Solicitud</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h4>Tipo de Solicitud: Contado</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>Zona: Z225</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos Generales</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-sm-4">RFC</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="rfcInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="rfcData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="rfcData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Razon Social</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="rzInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="razData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="razData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Constancia de Situacion Fiscal</div>
                            <div class="col-sm-6" id="imgCSFInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="constData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="constData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Constancia de Situacion Fiscal (2da Pagina)</div>
                            <div class="col-sm-6" id="imgCSFRInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="const2Data" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="const2Data" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Fotografia de Solicitud</div>
                            <div class="col-sm-6" id="imgSolInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="picSolData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="picSolData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Dirección Fiscal</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-sm-4">Calle</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="calleFInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirCalleData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCalleData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">No. Exterior</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="noEFInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirNoData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirNoData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Ciudad</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="cityFInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirCityData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCityData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Estado</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="estadoFInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEstData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEstData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Colonia</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="colFIndo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirColData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirColData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">CP</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="cpFInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirCpData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCpData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Comprobante Domicilio</div>
                            <div class="col-sm-6" id="imgCdInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirDomData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirDomData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Dirección de entrega</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-sm-4">Calle</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="calleEInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">No. Exterior</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="noExtEInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntNoData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntNoData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Ciudad</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="cityEInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entCityData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entCityData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Estado</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="estadoEInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entEstData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entEstData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Colonia</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="colEInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entColData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entColData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">C.P.</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="cpEInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="entCpData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="entCpData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
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
                            <div class="col-sm-4">Metodo de pago</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="mpInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negPagData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negPagData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Giro</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="giroInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negiroData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negiroData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Antiguedad</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="antiguedadInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negAntData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negAntData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Foto Frente</div>
                            <div class="col-sm-6" id="imgFFInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negFotData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negFotData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Foto Izquierda</div>
                            <div class="col-sm-6" id="imgFIInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negIzqData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negIzqData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Foto Derecha</div>
                            <div class="col-sm-6" id="imgFDInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="negDerData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="negDerData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Datos de Contacto</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-sm-6 text-bold">Tipo Contacto</div>
                            <div class="col-sm-6 text-bold">Principal</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Nombre</div>
                            <div class="col-sm-6"><input type="text" class="form-control" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="contNameData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="contNameData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Telefono</div>
                            <div class="col-sm-6"><input type="text" class="form-control" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="contTelData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="contTelData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Celular</div>
                            <div class="col-sm-6"><input type="text" class="form-control" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="contCelData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="contCelData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Credito</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-sm-4">Tipo Local</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="tlInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credLocData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credLocData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Tipo Persona</div>
                            <div class="col-sm-6"><input type="text" class="form-control" id="tpInfo" disabled></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credTypeData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credTypeData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Aval</div>
                            <div class="col-sm-6" id="imgIneAInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credIneData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credIneData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Aval (Reverso)</div>
                            <div class="col-sm-6" id="imgIneARInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credRevData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRevData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Representante</div>
                            <div class="col-sm-6" id="imgIneRInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credRepData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRepData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Representante (Reverso)</div>
                            <div class="col-sm-6" id="imgIneRRInfo"><button class="btn btn-danger"><i class="far fa-eye"></i> SIN ARCHIVO</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="credRepRevData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRepRevData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Carta Responsiva</h3>
                        <hr class="hr-indarYellow">
                        <div class="row mb-3">
                            <div class="col-sm-4">Carta Responsiva</div>
                            <div class="col-sm-6"><button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-2">
                                <label class="mr-3 text-green"><input type="radio" name="cartResponData" value="Aceptado">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="cartResponData" value="Rechazado">NO</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-center">
                                <h4>Observaciones</h4>
                                <textarea name="obsDatGen" id="" cols="30" rows="4" style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center title ml-auto">Historial de transacciones de la solicitud 18606</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3 bg-dark">
                            <div class="col-sm-6">Fecha</div>
                            <div class="col-sm-6">Tipo de Transacción</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 text-bold">19/May/2021 05:24:05 pm</div>
                            <div class="col-sm-6">Solicitud Enviada</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 text-bold">20/May/2021 11:23:20 am</div>
                            <div class="col-sm-6">Validacion Guardada</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 text-bold">20/May/2021 11:23:25 am</div>
                            <div class="col-sm-6">Rechazada</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
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