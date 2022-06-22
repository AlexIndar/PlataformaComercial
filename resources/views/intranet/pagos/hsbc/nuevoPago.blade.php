
@extends('layouts.intranet.main', ['active' => 'Pagos', 'permissions' => $permissions])

@section('title') HSBC - Nuevo Pago @endsection 

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/promociones/addPromocion.css')}}">
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/pagos/hsbc/js/addPago.js') }}"></script>

@endsection

@section('body')

<div class="content-wrapper p-5">
    <div class="container-fluid">
        <br><br>

        <!---------------------------------------------------------------------------------- DATOS GENERALES / ENCABEZADO PAGO ------------------------------------------------->

        <div class="datos-generales">
            <div class="title bg-indar">
                <h4>Datos Ordenante</h4>
            </div>
            <br>
                
            <div class="content-datos-generales">
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Razón Social:</h5></div>
                    <div class="col-lg-10 col-md-9 col-sm-12 col-12"><input class="input-promociones" type="text" id="ord_nombre" name="ord_nombre" maxlength="40" value="FERRETERIA INDAR, S.A. DE C.V." required readonly></div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>No. Cuenta:</h5></div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-12"><input class="input-promociones" type="text" id="ord_num_cta" name="ord_num_cta" maxlength="20" value="4050561075" required readonly></div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>RFC:</h5></div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-12"><input class="input-promociones" type="text" id="ord_curp_rfc" name="ord_curp_rfc" maxlength="18" value="FIN870710Q40" required readonly></div>
                </div>
            </div>
        </div>


        <br><br>

        <!-------------------------------------------------------------------------------- DETALLE PAGO -------------------------------------------------------------------->
    <div id="rules" id="rules">

        <div class="datos-generales">
            <div class="title bg-indar">
                <h4>Datos Beneficiario</h4>
            </div>
            <br>

            <div class="content-datos-generales">
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>Razón Social:</h5></div>
                    <div class="col-lg-10 col-md-9 col-sm-12 col-12"><input class="input-promociones" type="text" id="ben_nombre" name="ben_nombre" maxlength="40" required></div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12"><h5>No. Cuenta:</h5></div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-12"><input class="input-promociones" type="text" id="ben_num_cta" name="ben_num_cta" maxlength="20" required></div>
                    {{-- Códigos bancarios según el catálogo de bancos del SAT --}}
                    <div class="col-lg-2 col-md-3 col-12 text-center mt-2">
                        <h5>Banco:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <select id="cve_bco_ben" name="cve_bco_ben" class="form-control selectpicker" data-live-search="true">
                            <option selected value="021">HSBC</option>
                            <option value="012">BBVA</option>
                            <option value="002">BANAMEX</option>
                        </select> 
                    </div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-lg-2 col-md-3 col-12 text-center mt-2">
                        <h5>Tipo Cuenta:</h5>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <select id="ben_tpo_cta" name="ben_tpo_cta" class="form-control selectpicker" data-live-search="true">
                            <option selected value="40">Clabe</option>
                            <option value="01">Cheques</option>
                            <option value="03">TDB</option>
                            <option value="04">Vostro</option>
                            <option value="05">CValores</option>
                        </select> 
                    </div>
                </div>
                <br>

                <div id="pagos">

                </div>

                <br><br>
                <div class="row-12">
                    <button class="btn btn-blue btnActions w-100" id="btn-add" onclick="addRowNewPago()">Agregar Pago</button>
                    <button class="btn btn-blue w-100 mt-3" id="btn-download" onclick="generateFile()" disabled>Generar archivo</button> 
                </div>

            </div>
        </div>
    </div>
</div>

<!-- VALIDATE DATA MODAL -->
<div class="modal-background" id="validateModal">
    <div class="modal-indar">
        <div class="modal-header">
            <h4>Verifica los siguientes datos</h4>
            <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
        </div>
        <div class="modal-body">
            <div id="bodyValidations"></div> <br>
            <div class="d-flex flex-row justify-content-center align-items-center">
                <button class="btn btn-blue" onclick="closeModal()">Cerrar</button>
            </div>

        </div>
    </div>
</div> 

@endsection
