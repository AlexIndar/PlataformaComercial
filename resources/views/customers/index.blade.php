@extends('layouts.customers.customer', ['token' => $token])

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
                    @if($token == "error")
                        <div class="alert alert-danger alert-dismissible fade in show appear-1000" role="alert" style="width:30%; margin-left:35%; position: absolute; z-index:11000; margin-top: 10px;text-align:center;">
                            Usuario inválido o contraseña incorrecta
                            <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="deleteTokenCookie()" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="slider">
                        <div class="carousel slide h-100 w-100" id="carouselIndar" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselIndar" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselIndar" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselIndar" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                            <div class="carousel-inner h-100">
                                <div class="carousel-item active h-100">
                                    <div class="slider-img slider-1 appear-500"></div>
                                    <div class="overlay"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" class="orange"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="yellow"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                                    <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">BIENVENIDO A INDAR. Regístrate para dar seguimiento a tu proceso de alta como cliente</h1>
                                    <button data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" onclick="conocerMas()" class="slider-btn">REGÍSTRATE AHORA</button>
                                </div>
                                <div class="carousel-item h-100">
                                    <div class="slider-img slider-2"></div>
                                    <div class="overlay"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" class="orange"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="red"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                                    <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">Ferreimpulsos del mes <br>Noviembre 2021</h1>
                                    <button data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" onclick="conocerMas()" class="slider-btn">DESCÁRGALO AHORA</button>
                                </div>
                                <div class="carousel-item h-100">
                                    <div class="slider-img slider-3"></div>
                                    <div class="overlay"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" class="blue"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="black"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                                    <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">¡Ofertas relámpago! Aprovecha las mejores ofertas por tiempo limitado</h1>
                                    <button data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" onclick="conocerMas()" class="slider-btn">COMPRAR AHORA</button>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndar" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselIndar" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
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
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/abrasivos.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Abrasivos</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/adhesivos_y_selladores.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Adhesivos y Selladores</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/automotriz.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Automotriz</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/cerraduras_y_herrajes.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Cerraduras y Herrajes</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/fijacion.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Fijación</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/herramientas.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Herramientas</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/herreria_y_soldadura.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Herrería y Soldadura</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/jardineria.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Jardinería</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/material_electrico.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Material Eléctrico</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/pintura_y_accesorios.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Pintura y Accesorios</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/plomeria_y_gas.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Plomería y Gas</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <img width="60px" class="loading load-product-category" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/Iconos Productos/mas_vendidos.png')}}" alt="">
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Los Más Vendidos</p>
        </div>
    </div>
    

    <!-- SUPPLIERS CAROUSEL  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div class="swiper swiper-suppliers">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper swiper-wrapper-suppliers">
                                <!-- Slides -->
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://cdn.worldvectorlogo.com/logos/austromex.svg" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://cdn.worldvectorlogo.com/logos/black-decker-3.svg" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://logodownload.org/wp-content/uploads/2014/12/bosch-logo.png" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="data:image/webp;base64,UklGRowDAABXRUJQVlA4TIADAAAvmAAJEAfGoG0jSeHPacH1mzsI4z8XCtI2YGG7o8ht2wY+JelgvgG8Bb8Cuc7tvU0x5AhL51LBAxCj70EhP+gtgUUQsVc4ROuFwkKBNrMJRTQiKYl3auZofO8ICGm3bRvPs4Latm3btm3bbvq8tW3btpWc//Y859wbFB8j+j8B8h/2w98rf6+H7AeDNZPax7Mx9ZC+IWL8IXVDROdDxipA6pDxYFlDvUPGYaHmh3yLxzebGvobI/qPEqHzov4qHVoh+hOghZgHG1qLcUmou+Ty701lfdU2SAcg+UWTbqGThq3AMtueAiFyt74n7homA63FuACIvTcMAG7bPhYvFPK0pqd1hhQw0XIEaCT6z3LQWBz7Fgy5lPDT13Ab2Gl5G4MRhjPAIpfthUOmAMMDV0p/19Jl4J5FmsBGwzzgmsureOF4URzWiyuc0qQz5TOmsXDZ0BIaiHOXPFq/quipSQb5mWuYRS8xpyj2XXsBzHFb66366EjLg9GRlroQn/jLssdPK8MeFtoe0F70FHDZ7bE31XKOSAeYZ3nqJ/ZSe8hhm1SeZBgMdUS/qEirPCv1ySAVvVCkSYVXDv1SWroiTNPuL9KW5hknLC0NQfdoYJRhvDiuuqtdAM5rO3tpt/Jth6W7YQnGaobrLtfT2mKontHGlc8o0iDP1lt6Go7PjCwBcF3LYnuYJHoT7mlz8myXpbtBrRha7fToudPrOJzW3sfYpV3Ms6uWVp56OAV7nIqg0m/tGEzUMjXyqmHaUtFTia8u4yY5jYSxoi+G1ppMyqcSZ8X4FE8cdWncxCVTBY4ZHI/nT4VBN8W6x9sMhzfE3jhcgQo/fP2qkCfPP4jjQMvxmZElIpo4HIQDDstglHgf6fLhido0S87Pi1uWYH9qmw0zHTrBIX/7XYytc2sSlm2to6N22jpCO9u7BGW/+ftcqhCci5v0qCGmr0lIfDTtg2GSxf45Uz4Lj6qThUppyxmA46bRsM/wbEDkQUOQIy03TFrXzNe1WmSDK5ZlofmmGpT6bNhL5GDDu2RubJk9a85mP99WlCQ7yyy9Q10sN2CgGKdGVTVIz9xYP/Non/U+Hi+vgeqtqyFdNlT8m2EV7La0jeKOYXNuzJtad/qcwJ5av2BoA6zDA1clmQrUVUQuCfQ2sCHQU0llQqCvpE7gsw4ExvnEhs0ZGuPv9cPfq/yHBQ==" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://1000marcas.net/wp-content/uploads/2021/05/Dremel-logo.png" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://cdn.shopify.com/s/files/1/0333/9953/7802/collections/marca-logo-fandeli_Mesa_de_trabajo_1_1024x.png?v=1594413377" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://www.coestan.com/uploads/productos/resized/600_0567ec86e0407dcf50f5bf1f524ce299.png" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://elpro.mx/wp-content/uploads/2018/08/Distintivo-GRUPOELPRO-w-500px-01.png" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://cdn.worldvectorlogo.com/logos/klein-tools.svg" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://www.makita.es/data/pam/public/Content-Pages/About-Us/About-Makita/makita_white_logo_png.png" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://seeklogo.com/images/P/PFERD-logo-E79ADDAD39-seeklogo.com.png" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://cdn.shopify.com/s/files/1/0333/9953/7802/collections/marcas-logos-resistol_Mesa_de_trabajo_1_1024x.png?v=1594413544" alt="">
                                </div>
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://trataconanmeco.com/Ventas/logo_bc_rugo.png" alt="">
                                </div> 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Skil_logo.svg/1280px-Skil_logo.svg.png" alt="">
                                </div>                                 
                                <div class="swiper-slide swiper-slide-suppliers">
                                    <img  src="https://img.ffx.co.uk/website2/brands/BrandLogos/WD40.png" alt="">
                                </div> 
                                
                                
                            </div>
    </div>
    


    <!-- RELAMPAGO ----------------------------------------------------------------------------------------------------------------------------------------------------- -->
    @if($token && $token != 'error')
    <br>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center flex-column">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <img src="{{asset('assets/customers/img/png/flash-sale.png')}}" width="40px" alt="">    
                <h4>¡OFERTA RELÁMPAGO!</h4>
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
    </div>

    <br><br>

    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>Proveedor 1</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>Proveedor 2</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>Proveedor 3</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>Proveedor 4</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>Proveedor 5</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
            <a href="#" class="a-yellow"  text-align:center;">HAS TU PEDIDO AQUÍ</a>
            </div>
        </div>
    </div>
    
    <br><br>
    @endif
    <!-- NEW PRODUCTS / TOP SELLERS  -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="new-products">
        <div class="new-products-title">
            <h3>Los más vendidos</h3>
        </div>
        <div class="carousel appear-1000">
          <!-- Slider main container -->
            <div class="swiper swiper-1">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @for ($x = 0; $x < 20; $x++)
                    <div class="swiper-slide swiper-slide-products" onclick="detailsProduct('{{$bestSellers[$x]->itemid}}')">
                        <img src="http://www.iindar.com.mx/imagenes/articulos/02_JPG_MD/{{$bestSellers[$x]->itemid}}_MD.jpg" onerror="showLoadImg(this)" alt="">
                        <h5>{{$bestSellers[$x]->purchasedescription}}</h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">${{$bestSellers[$x]->priceList}}</span>  <br> <span class="price"></span>${{$bestSellers[$x]->nsoIndrSalesMinPrice}}</h5>
                        @endif
                    </div>
                    @endFor
                </div>
            </div>
        </div>
            <div class="controls d-flex align-items-center flex-row row">
                <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-indar swiper-button-prev swiper-button-prev-1  swiper-buttons-indar-left"></div>
                <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-indar swiper-button-next swiper-button-next-1  swiper-buttons-indar-right"></div>
                <div class="swiper-pagination swiper-pagination-1"></div>
            </div>
        </div>
    </div>


    <!-- ESPECIALES DEL MES --------------------------------------------------------------------------- -->
    @if($token && $token != 'error')
    <br><br>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: red; color: white;">
                <h5>LANZAMIENTOS</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: red; color: white;">
                <h5>ESPECIALES DEL MES</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: red; color: white;">
                <h5>DEMOSHOW (PROMO)</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: red; color: white;">
                <h5>COMBOS INDAR</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
    </div>
    
    <br><br>
    @endif


    <!-- WEBINAR / CORPORATIVO ---------------------------------------------------------------------------------------------------------------------------------------- -->

    @if($token && $token != 'error')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>CORPORATIVO</h5>
                <a href="#" class="a-yellow" >VERLO AHORA</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>PREVENTIVO PROX. EVENTO</h5>
                <a href="#" class="a-yellow" >VERLO AHORA</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>WEBINAR</h5>
                <a href="#" class="a-yellow" >VERLOS AHORA</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: #002868; color: white;">
                <h5>ASISTE A WEBINAR</h5>
                <a href="#" class="a-yellow" >REGÍSTRATE AQUÍ</a>
            </div>
        </div>
    </div>
    
    <br><br>




    <!-- OUTLET / OFERTAS DE OPORTUNIDAD ---------------------------------------------------------------------------------------------------------------------------------------------------------->


    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: red; color: white;">
                <h5>OFERTAS DE OPORTUNIDAD CON SUPER DESCUENTOS</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 p-3">
            <div class="supplier-relampago d-flex flex-column align-items-center justify-content-center" style="height: 200px; width: 100%; background-color: red; color: white;">
                <h5>ZONA OUTLET GRANDES REBAJAS</h5>
                <a href="#" class="a-yellow" >COMPRAR AHORA</a>
            </div>
        </div>
    </div>

    <br>
    @endif

    <!---------------------------------------------------------------------------- SLIDER OUTLET ------------------------------------------------------------------------>



    <div class="outlet-products">
        <div class="outlet-products-title">
            <h3 data-aos="fade-right" data-aos-duration="2000">Outlet y descontinuados  @if($token && $token != 'error') <a class="show-more">Ver más</a> @endif </h3>
        </div>
        <div class="carousel-2" data-aos="fade-left" data-aos-duration="2000">
          <!-- Slider main container -->
            <div class="swiper swiper-2">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @for ($x = 0; $x < 20; $x++)
                    <div class="swiper-slide swiper-slide-products" onclick="detailsProduct('{{$bestSellers[$x]->itemid}}')">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img class="b-lazy" src="http://www.iindar.com.mx/imagenes/articulos/02_JPG_MD/{{$bestSellers[$x]->itemid}}_MD.jpg"  onerror="showLoadImg(this)" alt="">
                        <h5>{{$bestSellers[$x]->purchasedescription}}</h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">${{$bestSellers[$x]->priceList}}</span>  <br> <span class="price"></span>${{$bestSellers[$x]->nsoIndrSalesMinPrice}}</h5>
                        @endif
                    </div>
                    @endFor
                </div>
            </div>
        </div>

        <div class="controls d-flex align-items-center flex-row row">
                <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-indar swiper-button-prev swiper-button-prev-2  swiper-buttons-indar-left"></div>
                <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-indar swiper-button-next swiper-button-next-2  swiper-buttons-indar-right"></div>
                <div class="swiper-pagination swiper-pagination-2"></div>
        </div>

    </div>



    <!-- BOLSA DE TRABAJO / RECLUTAMIENTO -->

    <div class="reclutamiento">
        <div class="overlay"></div>
        <div class="row" style="height: 100%;">
            <div class="col-12 d-flex justify-content-center align-items-center flex-column" style="height: 100%">
                <h3>Forma parte de INDAR</h3>
                <p>Somos una importante empresa del giro ferretero con más de 34 años de trayectoria y presencia en toda la República Mexicana</p>
                <button data-aos="fade-up" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" class="btn-reclutamiento">POSTULARME</button>
            </div>
        </div>

    </div>




@endsection