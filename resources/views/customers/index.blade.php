@extends('layouts.customers.customer', ['token' => $token])

@section('title') Indar @endsection

@section('assets')
<script src="{{asset('assets/customers/js/items.js')}}"></script>
@endsection

@section('body')
    <!-- HERO --------------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="container-hero" style="width:100%; padding-top:20px">
        <div class="row">
            <div class="col-lg-8">
                <div class="hero">
                    <input type="hidden" name="token" id="token" value="{{$token}}">
                    @if($token == "error")
                        <div class="alert alert-danger alert-dismissible fade in show appear-1000" role="alert" style="width:30%; margin-left:35%; position: absolute; z-index:11000; margin-top: 10px;text-align:center;">
                            Usuario inválido o contraseña incorrecta
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="slider">
                        <div class="carousel slide h-100 w-100" data-bs-ride="carousel">
                            <div class="carousel-inner h-100">
                                <div class="carousel-item active h-100">
                                    <div class="slider-img slider-1 appear-500"></div>
                                    <div class="overlay"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" class="orange"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="yellow"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                                    <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">Tu bodega ferretera. Precio, rapidez y atención.</h1>
                                    <button data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" onclick="conocerMas()" class="slider-btn">COMPRAR AHORA</button>
                                </div>
                                <div class="carousel-item h-100">
                                    <div class="slider-img slider-2"></div>
                                    <div class="overlay"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" class="orange"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="red"></div>
                                    <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                                    <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">Principal mayorista ferretero en la región Centro-Occidente</h1>
                                    <button data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" onclick="conocerMas()" class="slider-btn">COMPRAR AHORA</button>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="row d-flex justify-content-center align-items-center ferreimpulsos-hero" style="width: 100%; height: 165px; background-color: #F5F8F8;">
                        <h2 style="text-align: center; width: 100%;">Ferreimpulsos del mes</h2>
                        <a href="#" style="text-decoration: none; color: #002868; width: 100%; text-align: center; font-weight: 500;">¡DESCÁRGALO AHORA!</a>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="row d-flex justify-content-center align-items-center bienvenido-hero" style="width: 100%; height: 165px; background-color: #F5F8F8; margin-top: 10px;">
                        <h2 style="text-align: center; width: 100%;">Bienvenido a Indar</h2>
                        <h5 style="text-align: center; width: 100%;">Regístrate para dar seguimiento a tu proceso de alta como cliente</h5>
                        <a href="#" style="text-decoration: none; color: #002868; width: 100%; text-align: center; font-weight: 500;">DEJA TUS DATOS AQUÍ</a>
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
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Abrasivos</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Adhesivos y Selladores</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Automotriz</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Cerraduras y Herrajes</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Fijación</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Herramientas</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Herrería y Soldadura</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Jardinería</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Material Eléctrico</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Pintura y Accesorios</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-circle fa-3x" style="color:#002868"></i>
            <p style="font-weight: 500; font-size: 15px; text-align: center;">Plomería y Gas</p>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-4 col-3 d-flex align-items-center flex-column" style="cursor:pointer;">
            <i class="fas fa-trophy fa-3x" style="color:rgb(251, 198, 0);"></i>
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
    <br>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center flex-column">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <img src="{{asset('assets/customers/img/png/flash-sale.png')}}" width="40px" alt="">    
                <h4>¡OFERTA RELÁMPAGO!</h4>
            </div>
            <ul id="countdown">
            <li id="days">
                <div class="number">00</div>
                <div class="label">DÍAS</div>
            </li>
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
    <!-- NEW PRODUCTS -------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <br>
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
                    <div class="swiper-slide swiper-slide-products" onclick="detailsProduct('U1 1212')">
                        <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://http2.mlstatic.com/D_NQ_NP_2X_730841-MLM44000592476_112020-F.webp" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://resources.sears.com.mx/medios-plazavip/fotos/productos_sears1/original/3031928.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://tiendamakita.com/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn.shopify.com/s/files/1/0033/8418/0848/products/73d47fb5-0b87-4bac-841a-de12606994f6_1024x.jpg?v=1630656145" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://www.diprofer.com/catalogo/5153-large_default/cerraduras-sobreponer-clasica-blister.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://www.diprofer.com/catalogo/5163-large_default/cerraduras-sobreponer-puertas-corredizas-clasica.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://tlapalero-16ac7.kxcdn.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/f/a/fan014_4.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRibv4h012POe7NdUlvZtQ553bsEIDDfnBlv1dmQLdNc6LpE9T85iyS7H3Vu4kaGOr-AcY&usqp=CAU" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/1616HD.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://s1.kaercher-media.com/products/11509300/main/1/d0.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn.homedepot.com.mx/productos/140503/140503-d.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M616_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M666_AS01?$zmmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://medios.urrea.com/catalogo/Surtek/hd/CP-NO.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://tauber.com.mx/storage/customer/images/83755_U1_268GHL.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/JC10.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/41ZU61_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn.masterlock.com/product/orig/MLLA_PRODUCT_S1017.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn1.coppel.com/images/catalog/mkp/226/3000/2261100-1.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>

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


    <!-- WEBINAR / CORPORATIVO ---------------------------------------------------------------------------------------------------------------------------------------- -->


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





    <!-- OUTLET ---------------------------------------------------------------------------------------------------------------------------------------------------------->


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
    <div class="outlet-products">
        <div class="outlet-products-title">
            <h3 data-aos="fade-right" data-aos-duration="2000">Outlet y descontinuados <a class="show-more">Ver más</a> </h3>
        </div>
        <div class="carousel-2" data-aos="fade-left" data-aos-duration="2000">
          <!-- Slider main container -->
            <div class="swiper swiper-2">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://http2.mlstatic.com/D_NQ_NP_2X_730841-MLM44000592476_112020-F.webp" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://resources.sears.com.mx/medios-plazavip/fotos/productos_sears1/original/3031928.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://tiendamakita.com/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn.shopify.com/s/files/1/0033/8418/0848/products/73d47fb5-0b87-4bac-841a-de12606994f6_1024x.jpg?v=1630656145" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://www.diprofer.com/catalogo/5153-large_default/cerraduras-sobreponer-clasica-blister.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://www.diprofer.com/catalogo/5163-large_default/cerraduras-sobreponer-puertas-corredizas-clasica.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://tlapalero-16ac7.kxcdn.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/f/a/fan014_4.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRibv4h012POe7NdUlvZtQ553bsEIDDfnBlv1dmQLdNc6LpE9T85iyS7H3Vu4kaGOr-AcY&usqp=CAU" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/1616HD.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://s1.kaercher-media.com/products/11509300/main/1/d0.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn.homedepot.com.mx/productos/140503/140503-d.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M616_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M666_AS01?$zmmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://medios.urrea.com/catalogo/Surtek/hd/CP-NO.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://tauber.com.mx/storage/customer/images/83755_U1_268GHL.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/JC10.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/41ZU61_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn.masterlock.com/product/orig/MLLA_PRODUCT_S1017.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn1.coppel.com/images/catalog/mkp/226/3000/2261100-1.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        @if($token && $token != 'error')
                        <h5> <span class="original-price">$000</span>  <br> <span class="price"></span>$000</h5>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="controls d-flex align-items-center flex-row row">
                <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-indar swiper-button-prev swiper-button-prev-2  swiper-buttons-indar-left"></div>
                <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-indar swiper-button-next swiper-button-next-2  swiper-buttons-indar-right"></div>
                <div class="swiper-pagination swiper-pagination-2"></div>
        </div>

    </div>

@endsection