<!DOCTYPE html>
<html lang="en">

<head>
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-SGWQQRQ15Y"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="Somos el principal mayorista ferretero en la región Centro-Occidente de la República Mexicana.">
    <meta property="og:url" content="http://indarweb.dyndns.org:8080">
    <meta property="og:title" content="Indar - Mayorista Ferretero">
    <meta property="og:discription" content="Somos el principal mayorista ferretero en la región Centro-Occidente de la República Mexicana.">
    <meta property="og:site_name" content="Indar">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://indarweb.dyndns.org:8080/assets/customers/img/jpg/hero-1.jpg">
    <link rel="canonical" href="http://indarweb.dyndns.org:8080">

    <link rel="icon" type="image/png" href="/assets/customers/img/png/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/customers/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/customers/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/customers/css/buscador/buscador.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.8.5/jquery-ui.min.js" integrity="sha256-fOse6WapxTrUSJOJICXXYwHRJOPa6C1OUQXi7C9Ddy8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.js"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/customers/js/index.js') }}"></script>
    <script src="{{ asset('assets/customers/js/portal/buscador.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blazy/1.8.2/blazy.min.js" integrity="sha512-Yrd3VqXNBUzyCQWVBlL65mTdE1snypc9E3XnGJba0zJmxweyJAqDNp6XSARxxAO6hWdwMpKQOIGE5uvGdG0+Yw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DATEPICKER -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- CHOSEN SELECT -->
    <script type="text/javascript" src="{{ asset('plugins/chosen/chosen.jquery.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.min.css') }}" />

    <!-- xlsx reader  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.8/xlsx.full.min.js"></script>

    
    <!-- Custom Styles -->
    @yield('assets')
</head>

<body>
    <div class="overlayBusqueda" id="overlayBusqueda"></div>
    <div class="overlayDropdown" id="overlayDropdown"></div>


    <!-- LOGIN OPTIONS ---------------------------------------------------------------------------------------------------------------------------------------------------->
    <div class="login-options">
        <h5>Síguenos en </h5>
        <a style="margin-top: -2px !important;" target="blank" href="https://www.facebook.com/FerreteriaINDAR"><i style="color: var(--indar-primary); margin-left: 10px;" class="fab fa-facebook-square fa-md"></i></a>
        <a style="margin-top: -2px !important;" target="blank" href="https://www.youtube.com/channel/UCCTX6IiPIZa9wuaU8pMbwmA" class=""><i style="color: var(--indar-primary); margin-left: 5px;" class="fab fa-youtube-square fa-md"></i> </a>
        <a style="margin-top: -2px !important;" target="blank" href="https://api.whatsapp.com/send/?phone=5213312359629&text&app_absent=0" class=""><i style="color: var(--indar-primary); margin-left: 5px;" class="fab fa-whatsapp-square fa-md"></i> </a>
        <a style="margin-top: -2px !important; margin-right: 10px;" target="blank" href="https://www.linkedin.com/company/indar-tu-bodega-ferretera?trk=company_logo" class=""><i style="color: var(--indar-primary); margin-left: 5px;" class="fab fa-linkedin fa-md"></i></a>

        @if ($token && $token != 'error' && $token != 'expired')
            <h5 onclick="navigate('/logout', false)">Cerrar sesión</h5>
        @else
            <h5 onclick="activeModal(2)">Regístrate &nbsp;&nbsp;|</h5>
            <h5 onclick="activeModal(1)">Iniciar sesion</h5>
        @endif
        <h5 onclick="navigate('/faq', false)">Ayuda</h5>
        <i onclick="navigate('/faq', false)" class="fas fa-question-circle question fa-sm"></i>
    </div>

    <!-- NAVBAR MOBILE ------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <label for="check" class="hamburguer">
        <input type="checkbox" class="checkboxHamburguer" id="check" />
        <span></span>
        <span></span>
        <span></span>
    </label>

    <div class="navbar-mobile" id="navmobile">
        <div class="container-navbar-mobile">
            <div class="row">
                <div class="col-12">
                    <div class="menu-item" onclick="activeRama1('cuenta', this)">
                        <h5>Cuenta</h5> <i class="fas fa-angle-down submenu-icon"></i>
                    </div>
                    @if ($token && $token != 'error' && $token != 'expired')
                        <div class="rama-1 rama-cuenta">
                            <h5 onclick="navigate('/logout', false)">Cerrar Sesión</h5>
                        </div>
                    @else
                        <div class="rama-1 rama-cuenta">
                            <h5 onclick="activeModal(2)">Regístrate</h5>
                        </div>
                        <div class="rama-1 rama-cuenta">
                            <h5 onclick="activeModal(1)">Iniciar sesión</h5>
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <div class="menu-item" onclick="activeRama1('productos', this)">
                        <h5>Productos</h5> <i class="fas fa-angle-down submenu-icon"></i>
                    </div>
                    @for ($i = 0; $i < count($rama1); $i++)
                        <div class="rama-1 rama-productos" onclick="activeRama2('{{ $rama1[$i] }}', this)">
                            <h5>{{ $rama1[$i] }}</h5> <i class="fas fa-caret-down submenu-icon"></i>
                        </div>
                        @for ($x = 0; $x < count($rama2[$i]); $x++)
                            <div class="rama-2 rama-{{ $rama1[$i] }}"
                                onclick="activeRama3('{{ $rama2[$i][$x] }}', this)">
                                <h5>{{ $rama2[$i][$x] }}</h5> <i class="fas fa-plus fa-xs submenu-icon"></i>
                            </div>
                            @for ($y = 0; $y < count($rama3[$i][$x]); $y++)
                                <div class="rama-3 rama-{{ $rama2[$i][$x] }}">
                                    <h5>{{ $rama3[$i][$x][$y] }}</h5>
                                </div>
                            @endfor
                        @endfor
                    @endfor
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
                    <div class="rama-1 rama-empresa">
                        <h5>Nosotros</h5>
                    </div>
                    <div class="rama-1 rama-empresa">
                        <h5>Centros de cruce</h5>
                    </div>
                    <div class="rama-1 rama-empresa">
                        <h5>Servicio postventa</h5>
                    </div>
                </div>

                <div class="col-12">
                    <div class="menu-item">
                        <h5>Contacto</h5>
                    </div>
                </div>

                <div class="col-12">
                    <div class="menu-item">
                        @if ($level == 'E')
                            <h5><a href="/Intranet" style="color: var(--indar-primary);">Intranet</a></h5>
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
                <img onclick="navigate('/', false)" class="logo appear-500" src="{{ asset('assets/customers/img/png/indar.png') }}" alt="Login image" width="150">
            </div>
            <div class="offset-lg-0 col-lg-6 offset-md-1 col-md-10 offset-sm-1 col-sm-10 offset-xs-1 col-xs-10 col-10 offset-1 p-0">
                <div class="mb-3 mt-3 d-flex justify-space-between flex-row w-100">
                    <input type="text" class="form-control input-indar" id="buscador" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-indar" onclick='buscarFiltro("")' type="button">
                            <i id="btnBuscar" class="fas fa-search fa-lg"></i>
                            <div class="spinner-border" style="display:none; width: 20px; height: 20px;" id="btnSpinner"></div>
                        </button>
                    </div>
                </div>
                <div class="resultadoBusqueda" id="resultado-busqueda">
                    <div class="cuadrante cuadrante1">
                        <div class="tituloCuadrante">
                            <h5>Sugerencia por Artículo - <span class="cantidadRecomendaciones" id="cantidadRecomendacionesArticulo"></span></h5>
                        </div>
                        <div class="listSugerencias" id="listSugerenciasArticulo">
                            {{-- <div class="lineSugerencia sugerenciaArticulo">
                                <h5 class="h5Sugerencia"> <span id="sugerenciaArticuloDescripcion-1">ESMERILADORA ANGULAR 1/2" 600 W 1100 RPM </span> <span id="sugerenciaArticuloCodigo-1">[U1 EA404D]</span></h5> <br>
                                <img class="imgSugerencia" id="sugerenciaArticuloImg-1" src="http://www.indar.com.mx/imagenes/LOGOTIPOS/SURTEK.jpg" alt="">
                                <div class="Stars" style="--rating: 5;"></div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="cuadrante cuadrante2">
                        <div class="tituloCuadrante">
                            <h5>Sugerencia por Proveedor - <span class="cantidadRecomendaciones" id="cantidadRecomendacionesProveedor"></span></h5>
                        </div>
                        <div class="listSugerencias" id="listSugerenciasProveedor">
                            {{-- <div class="lineSugerencia sugerenciaProveedor">
                                <h5 class="h5Sugerencia"> <span id="sugerenciaProveedorCodigo-1">A4 </span> <span id="sugerenciaProveedorNombre-1">[AUSTROMEX]</span></h5> <br>
                                <img class="imgSugerencia" id="sugerenciaProveedorImg-1-1" src="http://www.indar.com.mx/imagenes/LOGOTIPOS/AUSTRODIAM.jpg" alt="">
                                <img class="imgSugerencia" id="sugerenciaProveedorImg-1-2" src="http://www.indar.com.mx/imagenes/LOGOTIPOS/AUSTROMEX.jpg" alt="">
                                <img class="imgSugerencia" id="sugerenciaProveedorImg-1-3" src="http://www.indar.com.mx/imagenes/LOGOTIPOS/TENAZIT.jpg" alt="">
                            </div> --}}
                        </div>
                    </div>
                    <div class="cuadrante cuadrante3">
                        <div class="tituloCuadrante">
                            <h5>Sugerencia por Marca - <span class="cantidadRecomendaciones" id="cantidadRecomendacionesMarca"></span></h5>
                        </div>
                        <div class="listSugerencias" id="listSugerenciasMarca">
                            {{-- <div class="lineSugerencia sugerenciaMarca">
                                <h5 class="h5Sugerencia"><span id="sugerenciaMarcaNombre-1">AUSTRODIAM</span></h5>
                                <img class="imgSugerencia" id="sugerenciaMarcaImg-1" src="http://www.indar.com.mx/imagenes/LOGOTIPOS/AUSTRODIAM.jpg" alt="">
                            </div> --}}
                        </div>
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
                        @for ($i = 0; $i < count($rama1); $i++)
                                    <li><a class="dropdown-item dropdown-item-main" href="#">{{ $rama1[$i] }} <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                    @for ($x = 0; $x < count($rama2[$i]); $x++)
                                            @if ($x == 0)
                                                <ul class="submenu dropdown-menu">
                                            @endif
                                                    <li><a class="dropdown-item dropdown-item-2" href="#">{{ $rama2[$i][$x] }} <i class="fas fa-chevron-right fa-xs fa-menu"></i></a>
                                                    @for ($y = 0; $y < count($rama3[$i][$x]); $y++)
                                                        @if ($y == 0)
                                                            <ul class="submenu submenu-2 dropdown-menu">
                                                        @endif
                                                                <li><a class="dropdown-item" href="{{ $rama3[$i][$x][$y] }}">{{ $rama3[$i][$x][$y] }}</a></li>
                                                    @endfor
                                                </ul>
                                    </li>
                                    @endfor
                        </ul>
                        </li>
                        @endfor
                    </ul>
                    </li>
                    <li class="nav-item notDropdown">
                        <a class="nav-link" href="#" onclick="navigate('/catalogo', true)">Catálogo</a>
                    </li>
                    <li class="nav-item notDropdown">
                        <a class="nav-link" href="#" onclick="navigate('/catalogo', true)">Ferreimpulsos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Empresa
                        </a>
                        <ul class="dropdown-menu dropdown-menu-empresa dropdown-menu-main" style="height: auto !important;" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="about"><i style="color: var(--indar-primary); margin-right: 5px;" class="fas fa-caret-right fa-xs"></i> Nosotros </a></li>
                            <li><a class="dropdown-item" href="centros"><i style="color: var(--indar-primary); margin-right: 5px;" class="fas fa-caret-right fa-xs"></i> Centros de cruce </a></li>
                            <li><a class="dropdown-item" href="postventa"><i style="color: var(--indar-primary); margin-right: 5px;" class="fas fa-caret-right fa-xs"></i> Servicio postventa </a></li>
                        </ul>
                    </li>
                    <li class="nav-item notDropdown">
                        <a class="nav-link" href="contacto">Contacto</a>
                    </li>
                    <li class="nav-item notDropdown">
                        @if ($level == 'E')
                            <h5><a class="nav-link" href="/Intranet">Intranet</a></h5>
                        @endif
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

    <!-- FOOTER ---------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="footer">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 contact-footer">
                <img class="logo-footer appear-500" src="{{ asset('assets/customers/img/png/indar.png') }}" alt="Indar Logo" width="250">
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
                <h5 onclick="navigate('/about', false)">¿Quiénes somos?</h5>
                <h5>Centros de Cruce</h5>
                <h5>Catálogo INDAR</h5>
                <h5>Aviso de privacidad</h5>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 footer-links">
                <h4><strong>PROMOCIONES</strong></h4>
                <h5>Ofertas relámpago</h5>
                <h5>Lanzamientos INDAR</h5>
                <h5> del mes</h5>
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
        <h5>* 1987-2022 <span class="black-strong">Ferretería Indar, S.A. de C.V.</span> * Dudas o aclaraciones sobre esta página: indarweb@indar.com.mx</h5>
    </div>


    <!-- LOGIN MODAL ----------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div class="modal-background" id="loginModal">
        <div class="modal-indar">
            <div class="modal-header">
                <h4>Iniciar Sesión</h4>
                <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal()"></i>
            </div>
            <div class="modal-body">
                <form action="login" method="get">
                    @csrf
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Usuario">Usuario:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="text" id="email" name="email" placeholder="Usuario o Correo electrónico" required></div>
                    </div> <br>
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Password">Contraseña:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="password" id="password" name="password" placeholder="Contraseña" required></div>
                    </div>
                    <br>
                    <label class="remember-login"><input class="checkbox" type="checkbox" id="remember-me" value="remember_me"> Recordar credenciales</label><br>
                    <div class="login-buttons">
                        <button class="btn login-btn" type="submit" value="Login">Iniciar Sesión</button>
                    </div>
                    <br>
                    <hr class="hr-indar"> <br>
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
                        <div class="col-lg-9 col-md-12"><input type="text" id="codigoRegister" name="codigoRegister" placeholder="Código de cliente" required></div>
                    </div> <br>
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Usuario">Usuario:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="text" id="emailRegister" name="emailRegister" placeholder="Correo electrónico" required></div>
                    </div> <br>
                    <div class="modal-inputs row">
                        <div class="col-lg-3 col-md-12"><label for="Password">Contraseña:</label></div>
                        <div class="col-lg-9 col-md-12"><input type="password" id="passwordRegister" name="passwordRegister" placeholder="Contraseña" required></div>
                    </div>
                    <br>
                    <label class="remember-login"><input class="checkbox" type="checkbox" id="remember-me-register" value="remember_me"> No cerrar sesión</label><br>
                    <div class="login-buttons">
                        <button class="btn login-btn" type="submit">Regístrate</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


</body>

</html>
