@extends('layouts.customers.customer', ['token' => $token, 'bestSellers' => $bestSellers, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'status' => $status])

@section('title') Indar @endsection

@section('assets')
<script src="{{asset('assets/customers/js/items.js')}}"></script>
@endsection

@section('body')
    <!-- HERO --------------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="container-hero" style="width:100%;">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero">
                    <input type="hidden" name="token" id="token" value="{{$token}}">
                    <div class="slider">
                        <div class="carousel slide carousel-fade h-100 w-100" id="carouselIndar" data-ride="carousel">
                            <div class="carousel-inner h-100">
                                <div id="first-carousel-item" class="carousel-item h-100">
                                    <img loading="lazy" src="{{asset('assets/customers/img/jpg/hero-1.jpg')}}" alt="">
                                </div>
                                <div class="carousel-item h-100">
                                    <img loading="lazy" src="{{asset('assets/customers/img/jpg/hero-2.jpg')}}" alt="">
                                </div>
                                <div class="carousel-item h-100">
                                    <img loading="lazy" src="{{asset('assets/customers/img/jpg/hero-3.jpg')}}" alt="">
                                </div>
                                <button class="carousel-control-prev" type="button" data-target="#carouselIndar" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-target="#carouselIndar" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </div>
    </div>

    <!-- PRODUCTS  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
     
    <br>
    <div class="row">
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/abrasivos.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Abrasivos</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/adhesivos_y_selladores.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Adhesivos y Selladores</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/automotriz.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Automotriz</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/cerraduras_y_herrajes.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Cerraduras y Herrajes</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/fijacion.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Fijación</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/herramientas.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Herramientas</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/herreria_y_soldadura.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Herrería y Soldadura</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/jardineria.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Jardinería</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/material_electrico.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Material Eléctrico</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/pintura_y_accesorios.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Pintura y Accesorios</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/plomeria_y_gas.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Plomería y Gas</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img loading="lazy" width="60px" src="{{asset('assets/customers/img/png/Iconos Productos/mas_vendidos.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Los Más Vendidos</p>
        </div>
    </div>
    

    <!-- SUPPLIERS CAROUSEL  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div class="swiper swiper-suppliers">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper swiper-wrapper-suppliers">
                                <!-- Slides -->
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/austromex.svg')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/black-decker.svg')}}" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/bosch.png')}}" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/de-walt.webp')}}" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/dremel.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/fandeli.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/garlock.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/grupo-elpro.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/klein-tools.svg')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/makita.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/pferd.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/resistol.webp')}}" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/rugo.png')}}" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/skil.png')}}" alt="">
                                </div>                                 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img loading="lazy"  src="{{asset('assets/customers/img/png/proveedores/wd40.png')}}" alt="">
                                </div> 
                                
                                
                            </div>
    </div>
    


    <!-- RELAMPAGO ----------------------------------------------------------------------------------------------------------------------------------------------------- -->
    @if($token && $token != 'error')
    <br>
    <div class="container-fluid" style="width: 90% !important; margin-left: 5% !important;">
        <div class="row mt-5">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 d-flex justify-content-center align-items-center flex-column">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <img loading="lazy" src="{{asset('assets/mercadotecnia/Ofertas Relampago/logo.png')}}" style="margin-left: 5%;" width="90%" alt="Logo Ofertas Relámpago INDAR">    
                </div>
                <ul id="countdown">
                    <!-- <li id="days">
                        <div class="number">00</div>
                        <div class="label">DÍAS</div>
                    </li> -->
                    <li id="hours">
                        <div class="number">00</div>
                        <div class="label">HORAS</div>
                    </li>
                    <li id="minutes">
                        <div class="number">00</div>
                        <div class="label">MINUTOS</div>
                    </li>
                    <li id="seconds">
                        <div class="number">00</div>
                        <div class="label">SEGUNDOS</div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-12 supplier-relampago">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Ofertas Relampago/banner.jpg')}}" height="auto" alt="Banner Ofertas Relámpago INDAR"></div>
            </div>
        </div>
        <br><br>
    
        <!-- ESPECIALES DEL MES --------------------------------------------------------------------------- -->
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Eventos/1.jpg')}}" alt="Especiales del Mes INDAR"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Eventos/2.jpg')}}" alt="Lanzamientos INDAR"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Eventos/3.jpg')}}" alt="Combos INDAR"></div>
            </div>
        </div>
    
        {{-- SUPER OFERTAS --}}
    
        <div class="row">
            <div class="new-products-title" style='border: none !important;'>
                <h3>Super Ofertas</h3>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Super Ofertas/1.jpg')}}" alt="Ofertas Únicas INDAR"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Super Ofertas/2.jpg')}}" alt="Ofertas de Oportunidad INDAR"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Super Ofertas/3.jpg')}}" alt="Outlet INDAR"></div>
            </div>
        </div>
        <br><br>

         <!-- NEW PRODUCTS / TOP SELLERS  -------------------------------------------------------------------------------------------------------------------------------------------------- -->

        <div class="new-products">
            <div class="new-products-title">
                <h3>Los básicos para tu negocio</h3>
            </div>
            <div class="carousel">
            <!-- Slider main container -->
                <div class="swiper swiper-1">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @for ($x = 0; $x < 20; $x++)
                        <div class="swiper-slide swiper-slide-products" onclick="detailsProduct('{{$bestSellers[$x]->itemid}}')">
                            <img loading="lazy" src="http://192.168.70.108:8080/public/assets/articulos/img/01_JPG_CH/{{$bestSellers[$x]->itemid}}_CH.jpg" onerror="this.onerror=null; this.src ='/assets/customers/img/jpg/imagen_no_disponible.jpg'" alt="">
                            <h5>{{$bestSellers[$x]->purchasedescription}}</h5>
                            @if($status == 'active')
                                <h5> <span class="original-price">${{$bestSellers[$x]->priceList}}</span>  <br> <span class="price"></span>${{$bestSellers[$x]->nsoIndrSalesMinPrice}}</h5>
                            @endif
                        </div>
                        @endFor
                    </div>
                </div>
            </div>
                <div class="controls d-flex align-items-center flex-row row">
                    <div class="swiper-button-indar swiper-button-prev swiper-button-prev-1  swiper-buttons-indar-left"></div>
                    <div class="swiper-button-indar swiper-button-next swiper-button-next-1  swiper-buttons-indar-right"></div>
                    <div class="swiper-pagination swiper-pagination-1"></div>
                </div>
        </div>

        <br><br><br>

        {{-- CONTENIDOS DIGITALES --}}
    
        <div class="row">
            <div class="new-products-title" style='border: none !important;'>
                <h3>Sigue nuestros contenidos digitales</h3>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Contenidos Digitales/1.jpg')}}" alt="Video Corporativo INDAR"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Contenidos Digitales/2.jpg')}}" alt="Proximos Eventos INDAR"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Contenidos Digitales/3.jpg')}}" alt="Webindar"></div>
            </div>
        </div>


        {{-- FORMA PARTE DE INDAR --}}
        <br><br>
        <div class="row">
            <div class="new-products-title" style='border: none !important;'>
                <h3>Forma parte de INDAR</h3>
            </div>
            <br><br>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Forma parte de INDAR/1.jpg')}}" alt="Forma parte de INDAR Cliente"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Forma parte de INDAR/2.jpg')}}" alt="Forma parte de INDAR Empleado"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 p-3 supplier-relampago d-flex flex-column align-items-center justify-content-center">
                    <div class="zoom"><img loading="lazy" src="{{asset('assets/mercadotecnia/Forma parte de INDAR/3.jpg')}}" alt="Forma parte de INDAR Proveedor"></div>
            </div>
        </div>


    </div>
    @endif
@endsection