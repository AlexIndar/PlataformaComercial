
@extends('layouts.customers.customer')

@section('title') Indar - {{$data['filter']}} @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/portal/resultadosFiltro.css')}}">
<script src="{{asset('assets/customers/js/portal/resultadosFiltro.js')}}"></script>
@endsection

@section('body')

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

        @foreach ($data['filters'] as $filter)
                        <h5 class="filterTitleContainer" onclick="hideFilterModal('{{strtoupper($filter['filterKey'])}}')"> <span class="filterTitle">{{strtoupper($filter['filterKey'])}}</span>@if($filter['tooltip'] != '') <span data-tooltip="{{$filter['tooltip']}}"><img style="width: 12px; margin-left: 10px" src="{{ asset('assets/customers/img/png/tooltip.png') }}"></span> @endif<span class="filterControlIcon plus-minus-toggle" id="filterControl{{strtoupper($filter['filterKey'])}}Modal"></span> </h5>
                        <div class="filter{{strtoupper($filter['filterKey'])}}" id="filter{{strtoupper($filter['filterKey'])}}Modal">
                            @for($x=0; $x < count($filter['filterValue']); $x++)
                                <div class="filterElement">
                                    <input class="filterCheck" autocomplete='off' id="checkbox-{{$filter['filterKey']}}-{{$filter['filterValue'][$x]['nombre']}}" type="checkbox" value="{{$filter['filterKey']}}={{$filter['filterValue'][$x]['nombre']}}">
                                    <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($filter['filterValue'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-{{$filter['filterKey']}}-modal-{{$filter['filterValue'][$x]['nombre']}}">({{$filter['filterValue'][$x]['resultados']}})</span> </h5>
                                </div>
                            @endFor
                        </div>

                        <hr>
                    @endforeach

    </div>
</div>

<div class="container-fluid p-5 background-light-gray">
    <div class="row">

        <input type="text" id="paginationCant" value="{{$paginationCant}}" hidden>

        {{-- FILTROS ------------------------------------------------------------------------------------------------------------------------------------------------}}
        <div class="col-lg-3 col-md-4">
            <div class="filters" id="filtersDiv">
                <div class="filterFull" id="filterFull">
                    
                    @foreach ($data['filters'] as $filter)
                        <h5 class="filterTitleContainer" onclick="hideFilter('{{strtoupper($filter['filterKey'])}}')"> <span class="filterTitle">{{strtoupper($filter['filterKey'])}} </span> @if($filter['tooltip'] != '') <span data-tooltip="{{$filter['tooltip']}}"><img style="width: 12px; margin-left: 10px" src="{{ asset('assets/customers/img/png/tooltip.png') }}"></span> @endif<span class="filterControlIcon plus-minus-toggle" id="filterControl{{strtoupper($filter['filterKey'])}}"></span> </h5>
                        <div class="filter{{strtoupper($filter['filterKey'])}}" id="filter{{strtoupper($filter['filterKey'])}}">
                            @for($x=0; $x < count($filter['filterValue']); $x++)
                                <div class="filterElement">
                                    <input class="filterCheck" autocomplete='off' id="checkbox-{{$filter['filterKey']}}-{{$filter['filterValue'][$x]['nombre']}}" type="checkbox" value="{{$filter['filterKey']}}={{$filter['filterValue'][$x]['nombre']}}">
                                    <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($filter['filterValue'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-{{$filter['filterKey']}}-{{$filter['filterValue'][$x]['nombre']}}">({{$filter['filterValue'][$x]['resultados']}})</span> </h5>
                                </div>
                            @endFor
                        </div>

                        <hr>
                    @endforeach

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
