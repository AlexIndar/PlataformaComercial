<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../assets/customers/img/png/favicon.png">
        <link rel="stylesheet" href="{{asset('assets/customers/css/index.css')}}">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>   
        <script src="{{asset('assets/customers/js/index.js')}}"></script>
        <script src="{{asset('assets/libraries/blazy/blazy.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <title>@yield('title')</title>
        <!-- Custom Styles -->
        @yield('assets')
</head>
<body>

    <!-- LOGIN OPTIONS ---------------------------------------------------------------------------------------------------------------------------------------------------->
    <div class="login-options">
        <h5>Síguenos en </h5>
        <a style="margin-top: -2px !important;" target="blank" href="https://www.facebook.com/FerreteriaINDAR"><i style="color: #002868; margin-left: 10px;" class="fab fa-facebook-square fa-md"></i></a>  
        <a style="margin-top: -2px !important;" target="blank" href="https://www.youtube.com/channel/UCCTX6IiPIZa9wuaU8pMbwmA" class=""><i style="color: #002868; margin-left: 5px;" class="fab fa-youtube-square fa-md"></i> </a> 
        <a style="margin-top: -2px !important;" target="blank" href="https://api.whatsapp.com/send/?phone=5213312359629&text&app_absent=0" class=""><i style="color: #002868; margin-left: 5px;" class="fab fa-whatsapp-square fa-md"></i> </a> 
        <a style="margin-top: -2px !important; margin-right: 10px;" target="blank" href="https://www.linkedin.com/company/indar-tu-bodega-ferretera?trk=company_logo" class=""><i style="color: #002868; margin-left: 5px;" class="fab fa-linkedin fa-md"></i></a> 

        @if($token && $token != 'error')
            <h5 onclick="navigate('logout', false)">Cerrar sesión</h5>
        @else
            <h5 onclick="activeModal(2)">Regístrate  &nbsp;&nbsp;|</h5>
            <h5 onclick="activeModal(1)">Iniciar sesión</h5>
        @endif
        <h5 onclick="navigate('faq', false)">Ayuda</h5>
        <i onclick="navigate('faq', false)" class="fas fa-question-circle question fa-sm"></i> 
    </div>

    <!-- NAVBAR MOBILE ------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <label for="check" class="hamburguer">
      <input type="checkbox" id="check"/> 
      <span></span>
      <span></span>
      <span></span>
    </label>

    <div class="navbar-mobile">
        <div class="container-navbar-mobile">
            <div class="row">
                <div class="col-12">
                    <div class="menu-item" onclick="activeRama1('productos', this)">
                        <h5>Productos</h5>  <i class="fas fa-angle-down submenu-icon"></i> 
                    </div>

                                <div class="rama-1 rama-productos" onclick="activeRama2('abrasivos', this)">
                                    <h5>Abrasivos</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>

                                                        <div class="rama-2 rama-abrasivos" onclick="activeRama3('diamantados', this)">
                                                            <h5>Diamantados</h5>  <i class="fas fa-plus fa-xs submenu-icon"></i>
                                                        </div>

                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Copas de diamantada</h5>
                                                                            </div>
                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Discos de diamante</h5>
                                                                            </div>
                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Lija de carburo</h5>
                                                                            </div>
                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Lima de diamante</h5>
                                                                            </div>
                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Pads diamantados</h5>
                                                                            </div>
                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Rectificadores diamantados</h5>
                                                                            </div>
                                                                            <div class="rama-3 rama-diamantados">
                                                                                <h5>Rueda de diamante</h5>
                                                                            </div>

                                                        <div class="rama-2 rama-abrasivos">
                                                            <h5>Fibras</h5>  <i class="fas fa-plus fa-xs submenu-icon"></i>
                                                        </div>
                                                        <div class="rama-2 rama-abrasivos">
                                                            <h5>Metálicos</h5>  <i class="fas fa-plus fa-xs submenu-icon"></i>
                                                        </div>
                                                        <div class="rama-2 rama-abrasivos">
                                                            <h5>Paquete</h5>  <i class="fas fa-plus fa-xs submenu-icon"></i>
                                                        </div>
                                                        <div class="rama-2 rama-abrasivos">
                                                            <h5>Revestidos</h5>  <i class="fas fa-plus fa-xs submenu-icon"></i>
                                                        </div>
                                                        <div class="rama-2 rama-abrasivos">
                                                            <h5>Sólidos</h5>  <i class="fas fa-plus fa-xs submenu-icon"></i>
                                                        </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Adhesivos y selladores</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Automotriz</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Cerraduras y Herrajes</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Fijación</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Herramientas</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Herrería y soldadura</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Jardinería</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Material eléctrico</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Mercadeo</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Pintura y accesorios</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Plomería y gas</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                                <div class="rama-1 rama-productos">
                                    <h5>Seguridad industrial</h5>  <i class="fas fa-caret-down submenu-icon"></i>
                                </div>
                </div>
                
                <div class="col-12">
                    <div class="menu-item">
                        <h5>Catálogo</h5> 
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="menu-item">
                        <h5>Ferreimpulsos</h5> 
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="menu-item" onclick="activeRama1('empresa', this)">
                        <h5>Empresa</h5> <i class="fas fa-angle-down submenu-icon"></i>
                    </div>
                </div>

                                <div class="rama-1 rama-empresa">
                                    <h5>Nosotros</h5>
                                </div>
                                <div class="rama-1 rama-empresa">
                                    <h5>Centros de cruce</h5>
                                </div>
                                <div class="rama-1 rama-empresa">
                                    <h5>Servicio postventa</h5>
                                </div>
                
                <div class="col-12">
                    <div class="menu-item">
                        <h5>Contacto</h5> 
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="menu-item">
                        @if ($level == ('C')) 
                            <h5>Bolsa de Trabajo</h5> 
                        @else 
                            <h5>Intranet</h5> 
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- BRAND LOGO ----------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="brand-logo">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 row-logo">
                <img onclick="navigate('/', false)" class="logo appear-500" src="{{asset('assets/customers/img/png/indar.png')}}" alt="Login image" width="150">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="input-group mb-3 mt-3">
                    <div class="input-group-prepend">
                        <div class="btn-group">
                            <button class="btn btn-secondary dropdown-toggle input-indar" type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                Filtrar por
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="defaultDropdown" style="transform: translate(0px, 38px) !important; padding: 0 !important;">
                                <li><a class="dropdown-item" href="#">Artículo <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item" href="#">Marca <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item" href="#">Proveedor <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <input type="text" class="form-control input-indar" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-indar" type="button"><i class="fas fa-search fa-lg"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-2">
                <div class="iconos-cuenta mt-3 ml-5">
                    <i class="fas fa-user-circle fa-2x"></i> <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVBAR ------------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="navbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Productos</a>
                            <ul class="dropdown-menu dropdown-menu-main" aria-labelledby="navbarDropdownMenuLink">
                                @for($i = 0; $i < count($rama1); $i ++)
                                    <li><a class="dropdown-item dropdown-item-main" href="#">{{$rama1[$i]}} <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                        @for($x = 0; $x < count($rama2[$i]); $x ++)
                                            @if($x == 0) <ul class="submenu dropdown-menu"> @endif
                                            <li><a class="dropdown-item dropdown-item-2" href="#">{{$rama2[$i][$x]}} <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                @for($y = 0; $y < count($rama3[$i][$x]); $y ++)
                                                    @if($y == 0)<ul class="submenu submenu-2 dropdown-menu"> @endif
                                                    <li><a class="dropdown-item" href="{{$rama3[$i][$x][$y]}}">{{$rama3[$i][$x][$y]}}</a></li>
                                                @endfor
                                                </ul>
                                            </li>
                                        @endfor
                                        </ul>
                                    </li>
                                @endfor
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="navigate('catalogo', true)">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="navigate('catalogo', true)">Ferreimpulsos</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false">
                            Empresa
                        </a>
                        <ul class="dropdown-menu dropdown-menu-empresa dropdown-menu-main" style="height: auto !important;" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="about"><i style="color: #002868; margin-right: 5px;" class="fas fa-caret-right fa-xs"></i> Nosotros </a></li>
                            <li><a class="dropdown-item" href="centros"><i style="color: #002868; margin-right: 5px;" class="fas fa-caret-right fa-xs"></i> Centros de cruce </a></li>
                            <li><a class="dropdown-item" href="postventa"><i style="color: #002868; margin-right: 5px;" class="fas fa-caret-right fa-xs"></i> Servicio postventa </a></li>
                        </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contacto">Contacto</a>
                        </li>
                        <li class="nav-item">
                        @if($level == ('C'))<a class="nav-link" href="#bolsa">Bolsa de Trabajo</a> @else <h5><a class="nav-link" href="Intranet">Intranet</a></h5> @endif
                            
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    

    
    <!-- BODY CONTENT -->


    <div class="body-content">
        @yield('body')
    </div>





     <!-- SUPPLIERS STATIC ---------------------------------------------------------------------------------------------------------------------------------------------------->

    <!-- <div class="suppliers">
        <div class="row suppliers-logos">
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="data:image/webp;base64,UklGRowDAABXRUJQVlA4TIADAAAvmAAJEAfGoG0jSeHPacH1mzsI4z8XCtI2YGG7o8ht2wY+JelgvgG8Bb8Cuc7tvU0x5AhL51LBAxCj70EhP+gtgUUQsVc4ROuFwkKBNrMJRTQiKYl3auZofO8ICGm3bRvPs4Latm3btm3bbvq8tW3btpWc//Y859wbFB8j+j8B8h/2w98rf6+H7AeDNZPax7Mx9ZC+IWL8IXVDROdDxipA6pDxYFlDvUPGYaHmh3yLxzebGvobI/qPEqHzov4qHVoh+hOghZgHG1qLcUmou+Ty701lfdU2SAcg+UWTbqGThq3AMtueAiFyt74n7homA63FuACIvTcMAG7bPhYvFPK0pqd1hhQw0XIEaCT6z3LQWBz7Fgy5lPDT13Ab2Gl5G4MRhjPAIpfthUOmAMMDV0p/19Jl4J5FmsBGwzzgmsureOF4URzWiyuc0qQz5TOmsXDZ0BIaiHOXPFq/quipSQb5mWuYRS8xpyj2XXsBzHFb66366EjLg9GRlroQn/jLssdPK8MeFtoe0F70FHDZ7bE31XKOSAeYZ3nqJ/ZSe8hhm1SeZBgMdUS/qEirPCv1ySAVvVCkSYVXDv1SWroiTNPuL9KW5hknLC0NQfdoYJRhvDiuuqtdAM5rO3tpt/Jth6W7YQnGaobrLtfT2mKontHGlc8o0iDP1lt6Go7PjCwBcF3LYnuYJHoT7mlz8myXpbtBrRha7fToudPrOJzW3sfYpV3Ms6uWVp56OAV7nIqg0m/tGEzUMjXyqmHaUtFTia8u4yY5jYSxoi+G1ppMyqcSZ8X4FE8cdWncxCVTBY4ZHI/nT4VBN8W6x9sMhzfE3jhcgQo/fP2qkCfPP4jjQMvxmZElIpo4HIQDDstglHgf6fLhido0S87Pi1uWYH9qmw0zHTrBIX/7XYytc2sSlm2to6N22jpCO9u7BGW/+ftcqhCci5v0qCGmr0lIfDTtg2GSxf45Uz4Lj6qThUppyxmA46bRsM/wbEDkQUOQIy03TFrXzNe1WmSDK5ZlofmmGpT6bNhL5GDDu2RubJk9a85mP99WlCQ7yyy9Q10sN2CgGKdGVTVIz9xYP/Non/U+Hi+vgeqtqyFdNlT8m2EV7La0jeKOYXNuzJtad/qcwJ5av2BoA6zDA1clmQrUVUQuCfQ2sCHQU0llQqCvpE7gsw4ExvnEhs0ZGuPv9cPfq/yHBQ==" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://cdn.shopify.com/s/files/1/0333/9953/7802/collections/marca-logo-fandeli_Mesa_de_trabajo_1_1024x.png?v=1594413377" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://img.ffx.co.uk/website2/brands/BrandLogos/WD40.png" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://trataconanmeco.com/Ventas/logo_bc_rugo.png" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://cdn.shopify.com/s/files/1/0333/9953/7802/collections/marcas-logos-resistol_Mesa_de_trabajo_1_1024x.png?v=1594413544" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://seeklogo.com/images/P/PFERD-logo-E79ADDAD39-seeklogo.com.png" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://www.makita.es/data/pam/public/Content-Pages/About-Us/About-Makita/makita_white_logo_png.png" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://www.coestan.com/uploads/productos/resized/600_0567ec86e0407dcf50f5bf1f524ce299.png" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://elpro.mx/wp-content/uploads/2018/08/Distintivo-GRUPOELPRO-w-500px-01.png" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://cdn.worldvectorlogo.com/logos/black-decker-3.svg" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="data:image/webp;base64,UklGRowDAABXRUJQVlA4TIADAAAvmAAJEAfGoG0jSeHPacH1mzsI4z8XCtI2YGG7o8ht2wY+JelgvgG8Bb8Cuc7tvU0x5AhL51LBAxCj70EhP+gtgUUQsVc4ROuFwkKBNrMJRTQiKYl3auZofO8ICGm3bRvPs4Latm3btm3bbvq8tW3btpWc//Y859wbFB8j+j8B8h/2w98rf6+H7AeDNZPax7Mx9ZC+IWL8IXVDROdDxipA6pDxYFlDvUPGYaHmh3yLxzebGvobI/qPEqHzov4qHVoh+hOghZgHG1qLcUmou+Ty701lfdU2SAcg+UWTbqGThq3AMtueAiFyt74n7homA63FuACIvTcMAG7bPhYvFPK0pqd1hhQw0XIEaCT6z3LQWBz7Fgy5lPDT13Ab2Gl5G4MRhjPAIpfthUOmAMMDV0p/19Jl4J5FmsBGwzzgmsureOF4URzWiyuc0qQz5TOmsXDZ0BIaiHOXPFq/quipSQb5mWuYRS8xpyj2XXsBzHFb66366EjLg9GRlroQn/jLssdPK8MeFtoe0F70FHDZ7bE31XKOSAeYZ3nqJ/ZSe8hhm1SeZBgMdUS/qEirPCv1ySAVvVCkSYVXDv1SWroiTNPuL9KW5hknLC0NQfdoYJRhvDiuuqtdAM5rO3tpt/Jth6W7YQnGaobrLtfT2mKontHGlc8o0iDP1lt6Go7PjCwBcF3LYnuYJHoT7mlz8myXpbtBrRha7fToudPrOJzW3sfYpV3Ms6uWVp56OAV7nIqg0m/tGEzUMjXyqmHaUtFTia8u4yY5jYSxoi+G1ppMyqcSZ8X4FE8cdWncxCVTBY4ZHI/nT4VBN8W6x9sMhzfE3jhcgQo/fP2qkCfPP4jjQMvxmZElIpo4HIQDDstglHgf6fLhido0S87Pi1uWYH9qmw0zHTrBIX/7XYytc2sSlm2to6N22jpCO9u7BGW/+ftcqhCci5v0qCGmr0lIfDTtg2GSxf45Uz4Lj6qThUppyxmA46bRsM/wbEDkQUOQIy03TFrXzNe1WmSDK5ZlofmmGpT6bNhL5GDDu2RubJk9a85mP99WlCQ7yyy9Q10sN2CgGKdGVTVIz9xYP/Non/U+Hi+vgeqtqyFdNlT8m2EV7La0jeKOYXNuzJtad/qcwJ5av2BoA6zDA1clmQrUVUQuCfQ2sCHQU0llQqCvpE7gsw4ExvnEhs0ZGuPv9cPfq/yHBQ==" alt=""> </div>
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 supplier-logo"> <img  src="https://cdn.shopify.com/s/files/1/0333/9953/7802/collections/marca-logo-fandeli_Mesa_de_trabajo_1_1024x.png?v=1594413377" alt=""> </div>
        </div>
    </div> -->

    
    <!-- FOOTER ---------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="footer">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 contact-footer">
                        <img class="logo-footer appear-500" src="{{asset('assets/customers/img/png/indar.png')}}" alt="Login image" width="250">
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center flex-row">
              <div class="social-media-icons appear-500">
                        <a target="blank" href="https://www.facebook.com/FerreteriaINDAR"><i class="fab fa-facebook-square fa-2x"></i></a>  
                        <a target="blank" href="https://www.youtube.com/channel/UCCTX6IiPIZa9wuaU8pMbwmA" class=""><i class="fab fa-youtube-square fa-2x"></i> </a> 
                        <a target="blank" href="https://api.whatsapp.com/send/?phone=5213312359629&text&app_absent=0" class=""><i class="fab fa-whatsapp-square fa-2x"></i> </a> 
                        <a target="blank" href="https://www.linkedin.com/company/indar-tu-bodega-ferretera?trk=company_logo" class=""><i class="fab fa-linkedin fa-2x"></i></a> 
            </div>
        </div>
        </div>
        <br><br><br>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 footer-links">
                <h4><strong>ACERCA</strong></h4>
                <h5 onclick="navigate('about', false)">¿Quiénes somos?</h5>
                <h5>Centros de Cruce</h5>
                <h5>Catálogo INDAR</h5>
                <h5>Aviso de privacidad</h5>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 footer-links">
                <h4><strong>PROMOCIONES</strong></h4>
                <h5>Ofertas relámpago</h5>
                <h5>Lanzamientos INDAR</h5>
                <h5>Especiales del mes</h5>
                <h5>Eventos</h5>
                <h5>Combos INDAR</h5>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 footer-links">
                <h4><strong>SERVICIO AL CLIENTE</strong></h4>
                <h5>Servicio Postventa</h5>
                <h5>Contacto</h5>
                <h5>Ayuda</h5>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 footer-links">
                <h4><strong>CLIENTE</strong></h4>
                <h5>Quiero ser cliente</h5>
                <h5>Cuenta</h5>
                <h5>Carrito</h5>
            </div>
        </div>
    </div>



    <!-- COPYRIGHT ------------------------------------------------------------------------------------------------------------------------------------------------------------------>

    <div class="copyright">
        <h5>* 1987-2021 <span class="black-strong">Ferretería Indar, S.A. de C.V.</span>  * Dudas o aclaraciones sobre esta página: indarweb@indar.com.mx</h5>
    </div>


    <!-- LOGIN MODAL ----------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div class="modal-background" id="loginModal">
        <div class="modal-indar">
            <div class="modal-header">
                <h4>Iniciar Sesión</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
            </div>
            <div class="modal-body">
                <form action="login" method="post">
                    @csrf
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Usuario">Usuario:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="text" id="email" name="email" placeholder="Correo electrónico" required></div>      
                    </div> <br>
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Password">Contraseña:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="password" id="password" name="password" placeholder="Contraseña" required></div>      
                    </div>
                    <br>
                    <label class="remember-login"><input class="checkbox" type="checkbox" id="remember-me" value="remember_me"> No cerrar sesión</label><br>
                    <div class="login-buttons">
                        <button class="btn login-btn" type="submit" onclick="allowMiddleware()">Iniciar Sesión</button>
                        <!-- <a href="#">Iniciar como empleado*</a> -->
                    </div>
                    <br> <hr class="hr-indar"> <br>
                    <div class="modal-links">
                        <a href="#">Registrar cliente</a> <br>
                        <a href="#">Recuperar usuario y contraseña</a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

     <!-- REGISTER MODAL ----------------------------------------------------------------------------------------------------------------------------------------------------------------->

     <div class="modal-background" id="registerModal">
        <div class="modal-indar">
            <div class="modal-header">
                <h4>Regístrate</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Codigo">Código cliente:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="text" id="codigo" name="codigo" placeholder="Código de cliente" required></div>      
                    </div> <br>
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Usuario">Usuario:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="text" id="email" name="email" placeholder="Correo electrónico" required></div>      
                    </div> <br>
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Password">Contraseña:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="password" id="password" name="password" placeholder="Contraseña" required></div>      
                    </div>
                    <br>
                    <label class="remember-login"><input class="checkbox" type="checkbox" id="remember-me" value="remember_me"> No cerrar sesión</label><br>
                    <div class="login-buttons">
                        <button class="btn login-btn" type="submit">Regístrate</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>


</body>
</html>