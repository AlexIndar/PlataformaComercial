
@extends('layouts.customers.customer')

@section('title') Indar - {{$data['filter']}} @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css//portal/resultadosFiltro.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<script src="{{asset('assets/customers/js/items.js')}}"></script>
<script src="{{asset('assets/customers/js/portal/resultadosFiltro.js')}}"></script>
 <!-- AdminLTE App -->
 <script src="{{ asset('dist/js/adminlte.js') }}"></script>
@endsection

@section('body')

 <!-- Preloader -->
 <div class="preloader flex-column justify-content-center align-items-center">
    <img class="logo" id="logo" src="{{ asset('assets/customers/img/png/indar.png') }}" alt="Login image" width="250">
</div>

<div class="container-fluid p-5">
    <div class="row">

        <input type="text" id="paginationCant" value="{{$paginationCant}}" hidden>

        {{-- FILTROS ------------------------------------------------------------------------------------------------------------------------------------------------}}

        <div class="col-lg-3 col-md-4 col-sm-12 filters">
            <h5 class="busqueda" id="busqueda">{{ucwords(strtolower($data['filter']))}}</h5>
            <h5 class="mt-3">Filtrar por</h5>
            <hr>

            <h5 class="filterTitleContainer" onclick="hideFilter('Marcas')"> <span class="filterTitle">Marca</span><span class="filterControl plus-minus-toggle" id="filterControlMarcas"></span> </h5>
            <div class="filterMarcas" id="filterMarcas">
                @for($x=0; $x < count($data['marcas']); $x++)
                    <div class="filterElement">
                        <input class="filterCheck" id="checkbox-marca-{{$data['marcas'][$x]['nombre']}}" type="checkbox" value="marca={{$data['marcas'][$x]['nombre']}}">
                        <img class="filterImg" src={{"http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/".str_replace("-", "_", str_replace(".", "_", str_replace(" ", "_", $data['marcas'][$x]['nombre']))).".jpg"}}>
                        <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['marcas'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-marca-{{$data['marcas'][$x]['nombre']}}">({{$data['marcas'][$x]['resultados']}})</span> </h5>
                    </div>
                @endFor
            </div>

            <hr>

            <h5 class="filterTitleContainer" onclick="hideFilter('Categorias')"> <span class="filterTitle">Categoria</span><span class="filterControl plus-minus-toggle" id="filterControlCategorias"></span> </h5>
            <div class="filterCategorias" id="filterCategorias">
                @for($x=0; $x < count($data['categorias']); $x++)
                    <div class="filterElement">
                        <input class="filterCheck" id="checkbox-categoria-{{$data['categorias'][$x]['nombre']}}" type="checkbox" value="categoria={{$data['categorias'][$x]['nombre']}}">
                        <h5 class="filterLine"><span class="filterNombre">{{ucwords(strtolower($data['categorias'][$x]['nombre']))}}</span> <span class="filterCantidad" id="filterCantidad-categoria-{{$data['categorias'][$x]['nombre']}}">({{$data['categorias'][$x]['resultados']}})</span> </h5>
                    </div>
                @endFor
            </div>

        </div>

        {{-- ARTÍCULOS ------------------------------------------------------------------------------------------------------------------------------------------------}}


        <div class="col-lg-9 col-md-8 col-sm-12 productList">

            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="appliedFilters" id="appliedFilters">
                       
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="paginationLine headerPagination">
                        <h5 class="filterResultados">Mostrando {{$from}} - {{$to}} de {{$data['resultados']}} resultados</h5>
                        {{-- PAGINACIÓN --}}
                        {{-- Sólo mostrar si los resultados disponibles son más de los mostrados en la página actual --}}
                        @if($data['resultados'] > ($to - $from) +1) 
                            <nav aria-label="Page navigation example">
                                <ul class="pagination" max-size="5">
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

          

            

            <div class="row d-flex align-items-center flex-row">
                @for($x=0; $x < count($data['items']); $x++)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="item" onclick="detalleProducto('{{$data['items'][$x]->itemid}}')">
                            <div class="imgItem">
                                <img src={{"http://www.indar.com.mx/imagenes/articulos/02_JPG_MD/".str_replace("-", "_", str_replace(".", "_", str_replace(" ", "_", $data['items'][$x]->itemid)))."_MD.jpg"}} onerror='noDisponible(this)'>
                            </div>
                            <div class="itemInfo">
                                <h5 class="itemManufacturer">{{$data['items'][$x]->itemid}}</h5>
                                <div class="itemDescriptionContainer">
                                    <h5 class="itemDescription">{{$data['items'][$x]->purchasedescription}}</h5>
                                </div>
                                <h5 class="itemManufacturer">{{$data['items'][$x]->familia}}</h5>
                                <h5 class="categoriaLine"> <span class="categoriaTitle">Categoría: </span> <span class="categoriaDescription">{{$data['items'][$x]->categoriaItem}}</span> </h5>
                            </div>
                            <div class="itemActions row">
                                <div class="col-12">
                                    <button class="btn-actions">Ver producto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endFor
            </div>


            <div class="paginationLine footerPagination">
                <h5 class="filterResultados">Mostrando {{$from}} - {{$to}} de {{$data['resultados']}} resultados</h5>
                {{-- PAGINACIÓN --}}
                {{-- Sólo mostrar si los resultados disponibles son más de los mostrados en la página actual --}}
                @if($data['resultados'] > ($to - $from)) 
                    <nav aria-label="Page navigation example">
                        <ul class="pagination" max-size="5">
                            <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                @for($x=$iniPagination; $x <= $endPagination; $x++ )
                                    <li class="page-item @if($activePage == $x) active @endif "><a class="page-link" onclick="pagination({{$from}}, {{$to}}, {{$x}})">{{$x}}</a></li>
                                @endfor
                            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                        </ul>
                    </nav>   
                @endif         
            </div>


        </div>
    </div>
</div>
   

@endsection
