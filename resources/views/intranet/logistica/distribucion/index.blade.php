@extends('layouts.intranet.main', ['active' => 'Logistica']) 

@section('title') Indar | Distribución @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/main.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
      <div class="container">
            <div class="row">
                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-people-carry-box fa-2x"></i><br>
                        <h6>Embarque Masivo</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.numeroGuia'); }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-arrow-up-1-9 fa-2x"></i><br>
                        <h6>Numero Guia</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-truck-ramp-box fa-2x"></i><br>
                        <h6>Desembarcar</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-clipboard-check fa-2x"></i><br>
                        <h6>Confirmar</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.validarSad') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-list-check fa-2x"></i><br>
                        <h6>Validar SAD</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.reporteSad') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-newspaper fa-2x"></i><br>
                        <h6>Reporte SAD</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.reporteEmbarque') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-file-lines fa-2x"></i><br>
                        <h6>Reporte Embarque</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-file-pen fa-2x"></i><br>
                        <h6>Editar Num. Guia</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.capturaGastoFletera') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-book-open-reader fa-2x"></i><br>
                        <h6>Captura Gasto Fletera</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-arrow-up-1-9 fa-2x"></i><br>
                        <h6>Num. Guia Postventa</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-swatchbook fa-2x"></i><br>
                        <h6>Catálogo Proveedores</h6>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-award fa-2x"></i><br>
                        <h6>Servicio PostVenta</h6>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.autorizarGastosFleteras') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-check-to-slot fa-2x"></i><br>
                        <h6>Gastos Fleteras Por Autorizar</h6>
                      </div>
                    </a>
                  </div>
            </div>
            <br><br><br><br>
      </div>
  </div>

@endsection