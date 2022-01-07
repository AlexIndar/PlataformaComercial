@extends('layouts.intranet.main', ['active' => 'Dashboard'])

@section('title') Indar @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/main.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
      <div class="container">

            <div class="row">
                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="about" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-users fa-2x"></i><br>
                        <h6>Quiénes somos</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="centros" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-map-marker-alt fa-2x"></i><br>
                        <h6>Dónde Comprar</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="http://www.indar.com.mx/ProductosNuevos.php" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-search-dollar fa-2x"></i><br>
                        <h6>Especiales del mes</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="http://www.indar.com.mx/FerreImpulsos.php" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book fa-2x"></i><br>
                        <h6>Ferre Impulsos</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-hammer fa-2x"></i><br>
                        <h6>Productos</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12">
                    <a href="catalogo" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Catálogo Indar</h6>
                      </div>
                    </a>
                  </div>
            </div>

            <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="catalogo" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-swatchbook fa-2x"></i><br>
                        <h6>Catálogo proveedores</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="postventa" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-award fa-2x"></i><br>
                        <h6>Servicio PostVenta</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="contacto" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-headset fa-2x"></i><br>
                        <h6>Contáctanos</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="http://www.indar.com.mx/Director/TuCuentaDirector.php" class="card-link">
                      <div class="dashboard-cards">
                          <i class="nav-icon fas fa-user-circle fa-2x"></i><br>
                          <h6>Mi Cuenta</h6>
                      </div>
                    </a>
                  </div>
            </div>

            <br><br><br><br>

      </div>
  </div>

@endsection