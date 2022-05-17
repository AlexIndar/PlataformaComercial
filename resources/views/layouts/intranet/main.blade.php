<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title')</title>
  <link rel="icon" type="image/png" href="../assets/customers/img/png/favicon.png">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> -->



  <!-- Custom Styles -->
  @yield('styles')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <!-- SELECT -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <!-- DATATABLES -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css"> -->
  @yield('css')

</head>

<body id='body' class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="logo" id="logo" src="{{asset('assets/customers/img/png/indar.png')}}" alt="Login image" width="250">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-indarBlue">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link icon-indar" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Inicio</a>
      </li> -->
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link icon-indar" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link icon-indar" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Mi Cuenta</span>
            <div class="dropdown-divider"></div>
            @if(isset($username))
            <a href="/logout" class="dropdown-item">
              {{$username}}@indar.com.mx</i>
            </a>
            <div class="dropdown-divider"></div>
            @endif
            <a href="/logout" class="dropdown-item">
              Cerrar sesión <i class="fas fa-sign-out-alt mr-2 mt-1 float-right"></i>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link icon-indar" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="Intranet" class="brand-link">
        <img class="logo" src="{{asset('assets/customers/img/png/indar.png')}}" alt="Login image" width="200" style="padding:10px; margin-left: 10px;">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('assets/customers/img/png/profile.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              @if(isset($userRol))
                {{$userRol}}
              @else
                Vendedor
              @endif
            </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              @if($active == 'Dashboard')
              <a href="/Intranet" class="nav-link active">
              @else
              <a href="/Intranet" class="nav-link">
              @endif
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            </li>
            
            @if(in_array('MisSolicitudes', $permissions) || in_array('Estadistica Cliente', $permissions))
            <li class="nav-item">
              @if($active == 'Intranet')
              <a href="#" class="nav-link active">
              @else
              <a href="#" class="nav-link">
              @endif
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Alta de Clientes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(in_array('MisSolicitudes', $permissions))
                <li class="nav-item">
                  <a href="/MisSolicitudes" class="nav-link">
                    <i class="far fa-address-card nav-icon"></i>
                    <p>Mis solicitudes</p>
                  </a>
                </li>
                @endif
                @if(in_array('Estadistica Cliente', $permissions))
                <li class="nav-item">
                  <a href="/EstadisticaSolicitudesClientes" class="nav-link">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <p>Estadistica Cliente</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @endif

            @if(in_array('Promociones', $permissions) || in_array('Pedidos', $permissions))
            <li class="nav-item">
              @if($active == 'Ventas')
              <a href="#" class="nav-link active">
              @else
              <a href="#" class="nav-link">
              @endif
                <i class="nav-icon fas fa-search-dollar"></i>
                <p>
                  Ventas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(in_array('Promociones', $permissions))
                <li class="nav-item">
                  <a href="/promociones" class="nav-link">
                    <i class="fas fa-tags nav-icon"></i>
                    <p>Promociones</p>
                  </a>
                </li>
                @endif
                @if(in_array('Pedidos', $permissions))
                <li class="nav-item">
                  <a href="/pedidos" class="nav-link">
                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                    <p>Pedidos</p>
                  </a>
                </li>
                @endif
                @if(in_array('ForzarPedidos', $permissions))
                <li class="nav-item">
                  <a href="/forzarPedido" class="nav-link">
                    <i class="fas fa-paper-plane nav-icon"></i>
                    <p>Forzar Pedidos</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @endif

            @if(in_array('Portal Viaticos', $permissions))
            <li class="nav-item">
              @if($active == 'Viaticos')
              <a href="#" class="nav-link active">
              @else
              <a href="#" class="nav-link">
              @endif
                <i class="nav-icon fas fa-plane"></i>
                <p>
                  Viáticos
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="https://5327814.extforms.netsuite.com/app/site/hosting/scriptlet.nl?script=980&deploy=1&compid=5327814&h=a519d7a1694f67babcc1&ppConfId=1" class="nav-link" target="_blank">
                    <i class="fas fa-globe nav-icon"></i>
                    <p>Portal Viáticos</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
            @if(in_array('Planeador',$permissions))
            <li class="nav-item">
              @if($active == 'Logistica')
                <a href="#" class="nav-link active">
              @else
                <a href="#" class="nav-link">
              @endif
              
                <i class="fas fa-boxes nav-icon"></i>
                <p>
                  Logistica
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('logistica.mesaControl.planeador') }}" class="nav-link">
                    <i class="fas fa-solar-panel"></i>
                    <p> Mesa Control</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('logistica.distribucion') }}" class="nav-link">
                    <i class="fas fa-solid fa-dolly"></i>
                    <p>Distribución</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('logistica.reportes') }}" class="nav-link">
                    <i class="fas fa-clipboard-list ml-1 mr-1"></i>
                    <p>Reportes</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
            @if(in_array('CXC', $permissions))
            <li class="nav-item">
                @if($active == 'CXC')
                <a href="#" class="nav-link active">
                @else
                <a href="#" class="nav-link">
                @endif
                  <i class="nav-icon fas fa-file-invoice"></i>
                  <p>
                    Cuentas Por Cobrar
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-hand-holding-usd nav-icon"></i>
                          <p>
                            Pagos
                            <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/AplicarPagos" class="nav-link">
                                  <p>Aplicar Pagos</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                </ul>
              </li>
              @endif

              <li class="nav-item">
                @if($active == 'Comisiones')
                <a href="#" class="nav-link active">
                @else
                <a href="#" class="nav-link">
                @endif
                  <i class="nav-icon fas fa-cash-register"></i>
                  <p>
                    Comisiones
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/comisionesVendedor" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>Comisiones</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/comisionesEspeciales" class="nav-link">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Especiales</p>
                        </a>
                    </li>
                </ul>
              </li>
        </ul>
        </nav>
      </div>
    </aside>
          </div>
        </div>
    </div>


    @yield('body')

  <!-- jQuery {{asset('assets/js/scripts.js')}} -->
  <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
  <!-- JQVMap -->
  <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
  <!-- select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.js"></script>

        <!-- DATEPICKER -->

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <!-- CHOSEN SELECT -->
        <script type="text/javascript" src="{{asset('plugins/chosen/chosen.jquery.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/chosen/chosen.min.css')}}" />

         <!-- DataTables  & Plugins -->
         <!-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> -->
        <!-- <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script> -->
        <!-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> -->

        <!-- xlsx reader  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.8/xlsx.full.min.js"></script>

  @yield('js')
</body>

</html>

