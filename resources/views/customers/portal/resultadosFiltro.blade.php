
@extends('layouts.customers.customer')

@section('title') Indar - {{$data['filter']}} @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/portal/resultadosFiltro.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<script src="{{asset('assets/customers/js/portal/resultadosFiltro.js')}}"></script>
 <!-- AdminLTE App -->
 <script src="{{ asset('dist/js/adminlte.js') }}"></script>
@endsection

@section('body')

 <!-- Preloader -->
 <div class="preloader flex-column justify-content-center align-items-center">
    <img loading="lazy" class="logo" id="logo" src="{{ asset('assets/customers/img/png/indar.png') }}" alt="Login image" width="250">
</div>

<div class="headerFiltros  background-light-gray">
    <div class="row">
        <div class="col-12 lineResultadosDesktop">
            <div class="selects">
                        <span>Ver: </span>
                        <select name="selectMostrar" class="orderBySelect" id="showCant">
                            <option value="50" selected>50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                            <option value="All">Todos</option>
                          </select>
                        <span>Ordenar: </span>
                        <select name="selectOrderBy" class="orderBySelect" id="orderBy">
                            <option value="itemid" selected>ID Articulo</option>
                            <option value="pricemainor">Precio 1-10</option>
                            <option value="pricemayor">Precio 10-1</option>
                          </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <h5 onclick="toggleFilters()" class="filterHideShow" id="filterHideShow"><i class="fa-solid fa-bars"></i> <span id="statusFilter">Ocultar</span> Filtros</h5>
            <div class="filterHideShowSquare collapsed" id="filterHideShowSquare" onclick="activeModalFilters();">
                <h5 class="filterHideShow"><i class="fa-solid fa-bars"></i> Filtros</h5>
            </div>
        </div>
    </div>
</div>

<div class="modalFilters">
    <div class="selects">
        <span>Ver: </span>
        <select name="selectMostrar" class="orderBySelect" id="showCantModal">
            <option value="50" selected>50</option>
            <option value="75">75</option>
            <option value="100">100</option>
            <option value="All">Todos</option>
          </select>
        <span>Ordenar: </span>
        <select name="selectOrderBy" class="orderBySelect" id="orderByModal">
            <option value="itemid" selected>ID Articulo</option>
            <option value="pricemainor">Precio 1-10</option>
            <option value="pricemayor">Precio 10-1</option>
          </select>
    </div>
    <br>
    <div class="filterFull" id="filterFull">

        <h5 class="filterTitleContainer" onclick="hideFilterModal('Competitividad')"> <span class="filterTitle">Competitividad</span><span class="filterControlIcon plus-minus-toggle" id="filterControlCompetitividadModal"></span> </h5>
        <div class="filterCompetitividad" id="filterCompetitividadModal">
            @for($x=0; $x < count($data['competitividad']); $x++)
                <div class="filterElement">
                    <input class="filterCheck" autocomplete='off' id="checkbox-competitividad-{{$data['competitividad'][$x]['nombre']}}" type="checkbox" value="competitividad={{$data['competitividad'][$x]['nombre']}}">
                    <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['competitividad'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-competitividad-modal-{{$data['competitividad'][$x]['nombre']}}">({{$data['competitividad'][$x]['resultados']}})</span> </h5>
                </div>
            @endFor
        </div>

        <hr>

        <h5 class="filterTitleContainer" onclick="hideFilterModal('Marcas')"> <span class="filterTitle">Marca</span><span class="filterControlIcon plus-minus-toggle" id="filterControlMarcasModal"></span> </h5>
        <div class="filterMarcas" id="filterMarcasModal">
            @for($x=0; $x < count($data['marcas']); $x++)
                <div class="filterElement">
                    <input class="filterCheck" autocomplete='off' id="checkbox-marca-{{$data['marcas'][$x]['nombre']}}" type="checkbox" value="marca={{$data['marcas'][$x]['nombre']}}">
                    <img loading="lazy" class="filterImg" src={{"http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/".str_replace("-", "_", str_replace(".", "_", str_replace(" ", "_", $data['marcas'][$x]['nombre']))).".jpg"}}>
                    <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['marcas'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-marca-modal-{{$data['marcas'][$x]['nombre']}}">({{$data['marcas'][$x]['resultados']}})</span> </h5>
                </div>
            @endFor
        </div>

        <hr>

        <h5 class="filterTitleContainer" onclick="hideFilterModal('Categorias')"> <span class="filterTitle">Categoria</span><span class="filterControlIcon plus-minus-toggle" id="filterControlCategoriasModal"></span> </h5>
        <div class="filterCategorias" id="filterCategoriasModal">
            @for($x=0; $x < count($data['categorias']); $x++)
                <div class="filterElement">
                    <input class="filterCheck" autocomplete='off' id="checkbox-categoria-{{$data['categorias'][$x]['nombre']}}" type="checkbox" value="categoria={{$data['categorias'][$x]['nombre']}}">
                    <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['categorias'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-categoria-modal-{{$data['categorias'][$x]['nombre']}}">({{$data['categorias'][$x]['resultados']}})</span> </h5>
                </div>
            @endFor
        </div>

    </div>
</div>

<div class="container-fluid p-5 background-light-gray">
    <div class="row">

        <input type="text" id="paginationCant" value="{{$paginationCant}}" hidden>

        {{-- FILTROS ------------------------------------------------------------------------------------------------------------------------------------------------}}
        <div class="col-lg-3 col-md-4">
            <div class="filters" id="filtersDiv">
                <div class="filterFull" id="filterFull">

                    <h5 class="filterTitleContainer" onclick="hideFilter('Competitividad')"> <span class="filterTitle">Competitividad</span><span class="filterControlIcon plus-minus-toggle" id="filterControlCompetitividad"></span> </h5>
                    <div class="filterCompetitividad" id="filterCompetitividad">
                        @for($x=0; $x < count($data['competitividad']); $x++)
                            <div class="filterElement">
                                <input class="filterCheck" autocomplete='off' id="checkbox-competitividad-{{$data['competitividad'][$x]['nombre']}}" type="checkbox" value="competitividad={{$data['competitividad'][$x]['nombre']}}">
                                <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['competitividad'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-competitividad-{{$data['competitividad'][$x]['nombre']}}">({{$data['competitividad'][$x]['resultados']}})</span> </h5>
                            </div>
                        @endFor
                    </div>

                    <hr>
                    
                    <h5 class="filterTitleContainer" onclick="hideFilter('Marcas')"> <span class="filterTitle">Marca</span><span class="filterControlIcon plus-minus-toggle" id="filterControlMarcas"></span> </h5>
                    <div class="filterMarcas" id="filterMarcas">
                        @for($x=0; $x < count($data['marcas']); $x++)
                            <div class="filterElement">
                                <input class="filterCheck" autocomplete='off' id="checkbox-marca-{{$data['marcas'][$x]['nombre']}}" type="checkbox" value="marca={{$data['marcas'][$x]['nombre']}}">
                                <img loading="lazy" class="filterImg" src={{"http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/".str_replace("-", "_", str_replace(".", "_", str_replace(" ", "_", $data['marcas'][$x]['nombre']))).".jpg"}}>
                                <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['marcas'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-marca-{{$data['marcas'][$x]['nombre']}}">({{$data['marcas'][$x]['resultados']}})</span> </h5>
                            </div>
                        @endFor
                    </div>
        
                    <hr>
        
                    <h5 class="filterTitleContainer" onclick="hideFilter('Categorias')"> <span class="filterTitle">Categoria</span><span class="filterControlIcon plus-minus-toggle" id="filterControlCategorias"></span> </h5>
                    <div class="filterCategorias" id="filterCategorias">
                        @for($x=0; $x < count($data['categorias']); $x++)
                            <div class="filterElement">
                                <input class="filterCheck" autocomplete='off' id="checkbox-categoria-{{$data['categorias'][$x]['nombre']}}" type="checkbox" value="categoria={{$data['categorias'][$x]['nombre']}}">
                                <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['categorias'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-categoria-{{$data['categorias'][$x]['nombre']}}">({{$data['categorias'][$x]['resultados']}})</span> </h5>
                            </div>
                        @endFor
                    </div>

                </div>
                <br><br>
            </div>
        </div>
        
        {{-- ARTÍCULOS ------------------------------------------------------------------------------------------------------------------------------------------------}}

        <div class="col-lg-9 col-md-8 col-sm-12" id='productListDiv'>
            
            <div id="productListContainer">
                <h5 class="busqueda"><span id="paginationTotal">{{$data['resultados']}}</span> resultados para "<span id="busqueda">{{$data['filter']}}</span>"</h5>
                <div class="appliedFilters" id="appliedFilters">
                    {{-- ETIQUETAS DE FILTROS, SE GENERAN DESDE JS --}}
                 </div>
                <div class="row d-flex align-items-center flex-row" id="productList">
                        {{-- LISTA DE PRODUCTOS SE GENERA DESDE JS --}}
                </div>
            </div>
            

            <div id="productList-skeleton">
                <div class="row">
                    @for($x=0; $x < count($data['items']); $x++)
                        <div class="col-sm-6 col-xl-4 cardItem">
                            <div class="item-skeleton">
                                <div class="imgItem-skeleton skeleton"></div>
                                <div class="itemInfo">
                                    <div class="itemManufacturer-skeleton skeleton"></div>
                                    <div class="itemDescription-skeleton skeleton"></div>
                                    <h5 class="itemManufacturer-skeleton skeleton"></h5>
                                    <h5 class="itemManufacturer-skeleton skeleton"></h5>
                                </div>
                                <div class="itemActions-skeleton skeleton"></div>
                            </div>
                        </div>
                    @endFor
                </div>
            </div>

            <div class="paginationLine d-none" id="paginationLine">
                {{-- PAGINACIÓN --}}
                {{-- Sólo mostrar si los resultados disponibles son más de los mostrados en la página actual --}}
                @if($data['resultados'] > ($to - $from)) 
                    <nav aria-label="Page navigation example">
                        <ul class="pagination" id="paginationUl" max-size="5">
                            <li class="page-item @if($activePage == 1) disabled @endif"><a class="page-link" onclick="pagination({{$from}}, {{$to}}, {{$activePage - 1}})">Anterior</a></li>
                                        @for($x=$iniPagination; $x <= $endPagination; $x++ )
                                            <li class="page-item @if($activePage == $x) active @endif "><a class="page-link" onclick="pagination({{$from}}, {{$to}}, {{$x}})">{{$x}}</a></li>
                                        @endfor
                            <li class="page-item @if($activePage == $endPagination) disabled @endif"><a class="page-link" onclick="pagination({{$from}}, {{$to}}, {{$activePage + 1}})">Siguiente</a></li>
                        </ul>
                    </nav>   
                @endif         
            </div>


        </div>
    </div>
</div>
   

@endsection
