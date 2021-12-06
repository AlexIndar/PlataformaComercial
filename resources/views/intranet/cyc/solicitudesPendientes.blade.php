@extends('layouts.intranet.main')

@section('title') Indar @endsection

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
                    <div class="input-group mb-3">
                        <div class="input-group-prepend bg-indarBlue">
                            <label class="input-group-text" for="inputGroupSelect01">Cobrador</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>SELECCIONAR</option>
                            <option value="2">E1260 | Monica Cecilia Luna</option>
                            <option value="3">E152 | Fernando Mancinas</option>
                            <option value="4">E980 | Michelle Alejandro Martinez</option>
                            <option value="5">E1080 | Cinthya Vanessa Rubio</option>
                            <option value="1">E765 | Bertha Alicia Garibay</option>
                            <option value="6">E1182 | Alberto Octavio Plascencia</option>
                            <option value="7">E1414 | Edgar Leonel Hermosillo</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-8 text-center">
                    <h2>Solicitudes Pendientes</h2>
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
                                <tbody>
                                    <tr>
                                        <td>P028888</td>
                                        <td>MANUEL GOMEZ BARBOZA</td>
                                        <td>13 Hrs 5 min</td>
                                        <td>Z225</td>
                                        <td>
                                            <div class="btn btn-success btn-circle" id="btnInfo" matTooltip="Detalle" data-toggle="modal" data-target="#infoModal">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <div class="btn btn-info btn-circle" data-toggle="modal" data-target="#historialModal">
                                                <i class="far fa-clock"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P028835</td>
                                        <td>FERRETERIA NAVARRETE HERMANOS SA DE CV</td>
                                        <td>141 Hrs 19 min</td>
                                        <td>Z675</td>
                                        <td>
                                            <div class="btn btn-success btn-circle" id="btnInfo" matTooltip="Detalle" data-toggle="modal" data-target="#infoModal">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Aceptar Credito"><i class="fas fa-dollar-sign"></i></div>
                                            <div class="btn btn-info btn-circle" data-toggle="modal" data-target="#historialModal">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-secondary btn-circle" matTooltip="Regresar solicitud"><i class="fas fa-redo-alt"></i></div>
                                            <div class="btn btn-light btn-circle text-green" matTooltip="Descargar contactos"><i class="fas fa-download"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P027744</td>
                                        <td>IZUMI SHIBATA ALEJANDRO</td>
                                        <td>18 Hrs 1 min</td>
                                        <td>Z543</td>
                                        <td>
                                            <div class="btn btn-success btn-circle" id="btnInfo" matTooltip="Detalle" data-toggle="modal" data-target="#validarInfoModal">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Aceptar Credito"><i class="fas fa-dollar-sign"></i></div>
                                            <div class="btn btn-info btn-circle" data-toggle="modal" data-target="#historialModal">
                                                <i class="far fa-clock"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
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
                            <div class="col-sm-4">HURA850521718</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="rfcData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="rfcData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Razon Social</div>
                            <div class="col-sm-4">HURTADO ROMO ADAIR JOSUE</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="razData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="razData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Constancia de Situacion Fiscal</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="constData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="constData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Constancia de Situacion Fiscal (2da Pagina)</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="const2Data" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="const2Data" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Fotografia de Solicitud</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="picSolData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="picSolData" value="Rechazado">Rechazar</label>
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
                            <div class="col-sm-4">rio juchipila</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirCalleData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCalleData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">No. Exteriorl</div>
                            <div class="col-sm-4">1173</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirNoData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirNoData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Ciudad</div>
                            <div class="col-sm-4">Guadalajara</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirCityData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCityData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Estado</div>
                            <div class="col-sm-4">Jalisco</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirEstData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEstData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Colonia</div>
                            <div class="col-sm-4">Quinta Velarde</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirColData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirColData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">CP</div>
                            <div class="col-sm-4">44430</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirCpData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirCpData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Comprobante Domicilio</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirDomData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirDomData" value="Rechazado">Rechazar</label>
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
                            <div class="col-sm-4">carr. al castillo</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">No. Exterior</div>
                            <div class="col-sm-4">37a</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="dirEntNoData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="dirEntNoData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Ciudad</div>
                            <div class="col-sm-4">El salto</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="entCityData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="entCityData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Estado</div>
                            <div class="col-sm-4">Jalisco</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="entEstData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="entEstData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Colonia</div>
                            <div class="col-sm-4">San Jode Del Castillo</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="entColData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="entColData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">C.P.</div>
                            <div class="col-sm-4">45685</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="entCpData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="entCpData" value="Rechazado">Rechazar</label>
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
                            <div class="col-sm-4">Por Definir</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="negPagData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="negPagData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Giro</div>
                            <div class="col-sm-4">Ferreteria y Tlapaleria</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="negiroData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="negiroData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Antiguedad</div>
                            <div class="col-sm-4">31</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="negAntData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="negAntData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Foto Frente</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="negFotData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="negFotData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Foto Izquierda</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="negIzqData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="negIzqData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Foto Derecha</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="negDerData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="negDerData" value="Rechazado">Rechazar</label>
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
                            <div class="col-sm-4">adair josue hurtado romo</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="contNameData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="contNameData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Telefono</div>
                            <div class="col-sm-4">3336881130</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="contTelData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="contTelData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Celular</div>
                            <div class="col-sm-4">3336881130</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="contCelData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="contCelData" value="Rechazado">Rechazar</label>
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
                            <div class="col-sm-4">Propio</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="credLocData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="credLocData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">Tipo Persona</div>
                            <div class="col-sm-4">Fisica</div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="credTypeData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="credTypeData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Aval</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="credIneData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="credIneData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Aval (Reverso)</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="credRevData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRevData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Representante</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="credRepData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRepData" value="Rechazado">Rechazar</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">IFE/INE Representante (Reverso)</div>
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="credRepRevData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="credRepRevData" value="Rechazado">Rechazar</label>
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
                            <div class="col-sm-4"> <button class="btn btn-warning"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-sm-4">
                                <label class="mr-3 text-green"><input type="radio" name="cartResponData" value="Aceptado">Aceptar</label>
                                <label class="mr-3 text-red"><input type="radio" name="cartResponData" value="Rechazado">Rechazar</label>
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
<script src="{{asset('asset/js/misSolicitudes.js')}}"></script>
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
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

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