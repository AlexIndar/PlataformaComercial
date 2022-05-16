@extends('layouts.intranet.main', ['active' => 'Dashboard', 'permissions' => $permissions]) 

@section('title') Indar @endsection

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
                        <i class="nav-icon fas fa-users fa-2x"></i><br>
                        <i class="nav-icon fas fa-solid fa-people-carry-box"></i>
                        <h6>Embarque Masivo</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-map-marker-alt fa-2x"></i><br>
                        <h6>Numero Guia</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-search-dollar fa-2x"></i><br>
                        <h6>Desembarcar</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book fa-2x"></i><br>
                        <h6>Confirmar</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-hammer fa-2x"></i><br>
                        <h6>Validar SAD</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Reporte SAD</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Reporte Embarque</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Editar Num. Guia</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.distribucion.capturaGastoFletera') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Captura Gasto Fletera</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Num. Guia Postventa</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="3" class="card-link">
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
            </div>
            <br><br><br><br>
      </div>
  </div>

@endsection