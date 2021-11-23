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

    <!-- BRAND LOGO ----------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="brand-logo">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 row-logo">
                <img onclick="navigate('/', false)" class="logo appear-500 loading" onload="removeLoading(this)" src="{{asset('assets/customers/img/png/indar.png')}}" alt="Login image" width="150">
            </div>
            <div class="col-lg-6 col-md-10 col-sm-10 col-xs-8">
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
                                <li><a class="dropdown-item dropdown-item-main" href="#">Abrasivos <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item dropdown-item-2" href="#">Diamantados <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                            <ul class="submenu submenu-2 dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Copas de diamantada</a></li>
                                                <li><a class="dropdown-item" href="#">Discos de diamante</a></li>
                                                <li><a class="dropdown-item" href="#">Lija de carburo</a></li>
                                                <li><a class="dropdown-item" href="#">Lija de diamante</a></li>
                                                <li><a class="dropdown-item" href="#">Pads diamantados</a></li>
                                                <li><a class="dropdown-item" href="#">Rectificadores diamantados</a></li>
                                                <li><a class="dropdown-item" href="#">Rueda de diamante</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item dropdown-item-2" href="#">Fibras <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                            <ul class="submenu submenu-2 dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Almohadillas</a></li>
                                                <li><a class="dropdown-item" href="#">Bandas de lija</a></li>
                                                <li><a class="dropdown-item" href="#">Discos de fibra</a></li>
                                                <li><a class="dropdown-item" href="#">Rodillos</a></li>
                                                <li><a class="dropdown-item" href="#">Ruedas</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item dropdown-item-2" href="#">Metálicos <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                            <ul class="submenu submenu-2 dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Cardas</a></li>
                                                <li><a class="dropdown-item" href="#">Cepillos</a></li>
                                                <li><a class="dropdown-item" href="#">Espirales</a></li>
                                                <li><a class="dropdown-item" href="#">Limas</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item dropdown-item-2" href="#">Paquete <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                            <ul class="submenu submenu-2 dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Paquete</a></li>
                                                <li><a class="dropdown-item" href="#">Paquete</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item dropdown-item-2" href="#">Revestidos <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                            <ul class="submenu submenu-2 dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Bandas de lija</a></li>
                                                <li><a class="dropdown-item" href="#">Cilindros</a></li>
                                                <li><a class="dropdown-item" href="#">Discos de esponja</a></li>
                                                <li><a class="dropdown-item" href="#">Discos de lija</a></li>
                                                <li><a class="dropdown-item" href="#">Lijas en hoja</a></li>
                                                <li><a class="dropdown-item" href="#">Lijas esponja</a></li>
                                                <li><a class="dropdown-item" href="#">Rehilete de lija</a></li>
                                                <li><a class="dropdown-item" href="#">Rollos de lija</a></li>
                                                <li><a class="dropdown-item" href="#">Rueda flap</a></li>
                                                <li><a class="dropdown-item" href="#">Tiras de lija</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item dropdown-item-2" href="#">Sólidos <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                            <ul class="submenu submenu-2 dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Discos de cubo</a></li>
                                                <li><a class="dropdown-item" href="#">Discos tipo 41 para <br> máquinas estacionarias</a></li>
                                                <li><a class="dropdown-item" href="#">Discos tipo 41 para <br> máquinas portatiles</a></li>
                                                <li><a class="dropdown-item" href="#">Limas y piedras abrasivas</a></li>
                                                <li><a class="dropdown-item" href="#">Pastas para pulido</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Adhesivos y selladores <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                    <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Cintas adhesivas <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Adhesivos de montaje</a></li>
                                                    <li><a class="dropdown-item" href="#">Adhesivo epóxico</a></li>
                                                    <li><a class="dropdown-item" href="#">Adhesivos estructural</a></li>
                                                    <li><a class="dropdown-item" href="#">Adhesivos fijador</a></li>
                                                    <li><a class="dropdown-item" href="#">Adhesivos instantáneo</a></li>
                                                    <li><a class="dropdown-item" href="#">Adhesivos de contacto</a></li>
                                                    <li><a class="dropdown-item" href="#">Cemento</a></li>
                                                    <li><a class="dropdown-item" href="#">Pegamento blanco</a></li>
                                                    <li><a class="dropdown-item" href="#">Pegamento universal</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Cintas adhesivas <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Cinta adhesiva reflejante</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta aislante</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta antiderrapante</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta asfáltica</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta decorativa</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta doble cara</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta masking</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta para ducto</a></li>
                                                    <li><a class="dropdown-item" href="#">Cinta para empaque</a></li>
                                                    <li><a class="dropdown-item" href="#">Cintas de acero inoxidable</a></li>
                                                    <li><a class="dropdown-item" href="#">Cintas selladoras</a></li>

                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Impermeabilizantes <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Concreto impermeable</a></li>
                                                    <li><a class="dropdown-item" href="#">Impermeabilizante</a></li>
                                                    <li><a class="dropdown-item" href="#">Morteros y aditivos</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Paquete de solventes <br> y otros químicos <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Paquete de solventes <br> y otros químicos</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Resanadores y reparadores <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Resanadores</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Selladores <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Juntas </a></li>
                                                    <li><a class="dropdown-item" href="#">Pistola calafateadora </a></li>
                                                    <li><a class="dropdown-item" href="#">Sellador de rosca </a></li>
                                                    <li><a class="dropdown-item" href="#">Selladores </a></li>
                                                    <li><a class="dropdown-item" href="#">Silicón </a></li>
                                                </ul>
                                            </li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Automotriz <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                    <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Complementos automotrices <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Anticongelante</a></li>
                                                    <li><a class="dropdown-item" href="#">Inversores y arrancadores</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Limpieza automotriz <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Equipo de limpieza</a></li>
                                                    <li><a class="dropdown-item" href="#">Escobas</a></li>
                                                    <li><a class="dropdown-item" href="#">Limpiadores automotrices</a></li>
                                                    <li><a class="dropdown-item" href="#">Shampoos</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Lubricantes <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Lubricantes en aerosol</a></li>
                                                    <li><a class="dropdown-item" href="#">Lubricantes líquidos</a></li>
                                                    <li><a class="dropdown-item" href="#">Lubricantes sólidos</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Pulido y encerado <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Complementos para pulido y encerado</a></li>
                                                    <li><a class="dropdown-item" href="#">Encerado automotriz</a></li>
                                                    <li><a class="dropdown-item" href="#">Pulimento automotriz</a></li>
                                                </ul>
                                            </li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Cerraduras y herrajes <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                    <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Cajas fuertes <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Caja fuerte</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Candados <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Candado de combinación</a></li>
                                                    <li><a class="dropdown-item" href="#">Candado de llave</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Cerraduras <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Cerradura de embutir</a></li>
                                                    <li><a class="dropdown-item" href="#">Cerradura de sobreponer</a></li>
                                                    <li><a class="dropdown-item" href="#">Cerradura para mueble</a></li>
                                                    <li><a class="dropdown-item" href="#">Pomos, manijas y cerrojos</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Herrajes <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Bisagras</a></li>
                                                    <li><a class="dropdown-item" href="#">Carro de rodamientos</a></li>
                                                    <li><a class="dropdown-item" href="#">Cierrapuertas</a></li>
                                                    <li><a class="dropdown-item" href="#">Correderas</a></li>
                                                    <li><a class="dropdown-item" href="#">Escuadras y mensulas</a></li>
                                                    <li><a class="dropdown-item" href="#">Fijapuerta y topes</a></li>
                                                    <li><a class="dropdown-item" href="#">Gancho y percheros</a></li>
                                                    <li><a class="dropdown-item" href="#">Guardapolvos</a></li>
                                                    <li><a class="dropdown-item" href="#">Jaladeras<a></li>
                                                    <li><a class="dropdown-item" href="#">Ruedas y rodajas</a></li>
                                                    <li><a class="dropdown-item" href="#">Señalamiento de fachada</a></li>
                                                    <li><a class="dropdown-item" href="#">Tubo para closet</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item dropdown-item-2" href="#">Vigilancia <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                <ul class="submenu submenu-2 dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Circuito cerradp de televisión</a></li>
                                                    <li><a class="dropdown-item" href="#">Mirillas</a></li>
                                                    <li><a class="dropdown-item" href="#">Videoportero</a></li>
                                                </ul>
                                            </li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Fijación <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Herramientas <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Herrería y soldadura <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Jardinería <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Material eléctrico <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Mercadeo <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Pintura y accesorios <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Plomería y gas <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                <li><a class="dropdown-item dropdown-item-main" href="#">Seguridad industrial <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item" href="submenuitem1">Submenu item 1 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                        <li><a class="dropdown-item" href="#">Submenu item 2 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                        <li><a class="dropdown-item" href="#">Submenu item 3 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                        <ul class="submenu submenu-2 dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Multi level 1 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                            <li><a class="dropdown-item" href="#">Multi level 2 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                        </ul>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Submenu item 4 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                        <li><a class="dropdown-item" href="#">Submenu item 5 <i class="fas fa-chevron-right fa-xs fa-menu"></i></a></li>
                                    </ul>
                                </li>
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
                            <a class="nav-link" href="#" onclick="navigate('catalogo', true)">Reclutamiento</a>
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