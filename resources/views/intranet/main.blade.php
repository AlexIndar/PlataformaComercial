@extends('layouts.main')

@section('title') Indar @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
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
                    <a href="#" class="card-link">
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
                    <a href="http://www.indar.com.mx/CatalogoIndarPag.php?wg=1-20&wi=1&wp=1" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-book-open fa-2x"></i><br>
                        <h6>Catálogo Indar</h6>
                      </div>
                    </a>
                  </div>
            </div>

            <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="#" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-swatchbook fa-2x"></i><br>
                        <h6>Catálogo proveedores</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="http://www.indar.com.mx/PoliticaGarantias.php" class="card-link">
                      <div class="dashboard-cards">
                        <i class="nav-icon fas fa-award fa-2x"></i><br>
                        <h6>Servicio PostVenta</h6>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="http://www.indar.com.mx/Contactanos.php" class="card-link">
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

            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="http://www.indar.com.mx/ProductosPortada.php?ref=1&wpage=1&word=DESCRIPCION1&wfil=4&vis=Imagen&btnClick=1">
                  <img class="img-dashboard" src="http://www.indar.com.mx/imagenes/Articulos/Portada_centro/1" width="100%" style="margin-top:20px;" alt="">
                </a>
              </div>

              <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="http://www.indar.com.mx/ProductosPortada.php?ref=2&wpage=1&word=DESCRIPCION1&wfil=4&vis=Imagen&btnClick=1">
                  <img class="img-dashboard" src="http://www.indar.com.mx/imagenes/Articulos/Portada_centro/2" width="100%" style="margin-top:20px;" alt="">              
                </a>
              </div>

              <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="http://www.indar.com.mx/ProductosPortada.php?ref=3&wpage=1&word=DESCRIPCION1&wfil=4&vis=Imagen&btnClick=1">
                  <img class="img-dashboard" src="http://www.indar.com.mx/imagenes/Articulos/Portada_centro/3" width="100%" style="margin-top:20px;" alt="">
                </a>
              </div>  
            </div>


            <div class="row">
              <div class="col-lg-9">
                <a href="http://webindar.mx/registro/">
                  <img class="img-dashboard-large" id="img-dashboard-large" src="https://scontent.fgdl10-1.fna.fbcdn.net/v/t1.6435-9/243937895_3100923426896194_5845392087450481642_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=e3f864&_nc_ohc=zH_BBwRPG9YAX-VAfpo&_nc_ht=scontent.fgdl10-1.fna&oh=eee16d624b471fdccbf182517fc668be&oe=6195594F" alt="">
                </a>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="http://www.indar.com.mx/ProductosPortada.php?ref=4&wpage=1&word=DESCRIPCION1&wfil=4&vis=Imagen&btnClick=1">
                  <img class="img-dashboard" src="http://www.indar.com.mx/imagenes/Articulos/Portada_centro/4" width="100%" style="margin-top:20px;" alt="">
                </a>
              </div>

              <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="http://www.indar.com.mx/ProductosPortada.php?ref=5&wpage=1&word=DESCRIPCION1&wfil=4&vis=Imagen&btnClick=1">
                  <img class="img-dashboard" src="http://www.indar.com.mx/imagenes/Articulos/Portada_centro/5" width="100%" style="margin-top:20px;" alt="">              
                </a>
              </div>

              <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="http://www.indar.com.mx/ProductosPortada.php?ref=6&wpage=1&word=DESCRIPCION1&wfil=4&vis=Imagen&btnClick=1">
                  <img class="img-dashboard" src="http://www.indar.com.mx/imagenes/Articulos/Portada_centro/6" width="100%" style="margin-top:20px;" alt="">
                </a>
              </div>  
            </div>

            <br><br><br><br>

      </div>
  </div>

@endsection