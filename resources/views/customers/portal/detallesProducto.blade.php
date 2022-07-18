
@extends('layouts.customers.customer')

@section('title') Indar - Detalles Producto @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('assets/libraries/Magnify/css/Magnifier.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/portal/detallesProducto.css')}}">
<script src="{{asset('assets/libraries/Magnify/js/Event.js')}}"></script>
<script src="{{asset('assets/libraries/Magnify/js/Magnifier.js')}}"></script>
<script src="{{asset('assets/customers/js/portal/detallesProducto.js')}}"></script>
@endsection

@section('body')
            
    <div class="container-fluid container-detallesProducto">
        <div class="row">


            @if(isset($itemInfo->error))
                <h3 style="height: 60vh">{{$itemInfo->error}}</h3>
            @else

                <div class="container-images col-lg-6 col-12">
                    <div class="row">
                        <div class="thumbnails col-lg-2 col-md-12 col-sm-12 col-12">
                                <img id="thumbnail-{{$itemInfo['itemid']}}-1" class="thumbnail activeThumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="1" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">
                                <img id="thumbnail-{{$itemInfo['itemid']}}-2" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="2" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">                            
                                <img id="thumbnail-{{$itemInfo['itemid']}}-3" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="3" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">                            
                                <img id="thumbnail-{{$itemInfo['itemid']}}-4" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="4" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">                            
                                <img id="thumbnail-{{$itemInfo['itemid']}}-5" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="5" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">                            
                                <img id="thumbnail-{{$itemInfo['itemid']}}-6" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="6" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">                            
                                <img id="thumbnail-{{$itemInfo['itemid']}}-7" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" data-number="7" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="" onerror="noDisponible(this)">                            
                                <img id="thumbnail-{{$itemInfo['itemid']}}-8" class="thumbnail" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/P8_SAC1B30_MD.webp" data-number="8" data-big="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/P8_SAC1B30_MD.webp" alt="">                            
                        </div>
                        <div class="col-lg-10 col-md-12 col-sm-12 col-12 img-magnifier-container" id="img-magnifier-container">
                            <div>
                                <div class="numberSelectedControl">
                                    <h5><span class="numberSelected" id="numberSelected">1 </span>/<span class="totalImages"> 9</span></h5>
                                </div>
                                <div class="control leftControl" onclick="slide(-1)">
                                    <h5><i class="fas fa-angle-left"></i></h5>
                                </div>
                                <div class="control rightControl" onclick="slide(+1)">
                                    <h5><i class="fas fa-angle-right"></i></h5>
                                </div>
                                <a class="magnifier-thumb-wrapper d-flex flex-column justify-content-center" href="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp">
                                    <img class="bigImage" id="bigImage" onerror="noDisponible(this)" src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/{{str_replace("-", "_", str_replace(" ", "_", $itemInfo['itemid']))}}_MD.webp" alt="">
                                </a>
                                <p id='text-zoomIndicator' class="mt-5 w-100 text-center">Pasa el mouse encima de la imagen para aplicar zoom</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-info col-lg-6 col-12">
                    <div class="row">
                        <div class="magnifier-preview" id="preview"></div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <h4 class="itemid">{{$itemInfo['itemid']}}</h4>
                                    <h5 class="purchasedescription">{{ucwords(strtolower($itemInfo['purchasedescription']))}}</h5>
                                    @if($itemInfo['competitividad'] == "true")
                                        <img class="imgRibbon" src="/assets/customers/img/png/ribbon-mejor-precio.png" loading="lazy"/> <a class="textRibbon">En México</a>
                                        {{-- <div class="ribbon-title">
                                            <a href="#">Mejor Precio <span class="text-yellow">Indar</span></a>
                                        </div> --}}
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <img class="imgManufacturer" src="{{"http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/".str_replace("-", "_", str_replace(".", "_", str_replace(" ", "_", $itemInfo['familia']))).".jpg"}}" alt="">   
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 mt-5">
                                    <div class="detallesContainer">
                                        <h5 class="infoItem">Categoría: <span class="text-green">{{$itemInfo['categoriaItem']}}</span></h5>
                                        <h5 class="infoItem">Disponibilidad: 
                                            @if ($itemInfo['disponible'] > 10) 
                                                <span class="text-green">Suficiente</span> 
                                            @else 
                                                @if ($itemInfo['disponible'] == 0) 
                                                    <span class="text-red">Sin existencias</span>  
                                                    @else 
                                                        @if ($itemInfo['disponible'] == 1) 
                                                            <span class="text-red">Última pieza</span>  
                                                            @else 
                                                                <span class="text-red">Últimos {{$itemInfo['disponible']}}</span> 
                                                        @endif
                                                @endif 
                                            @endif 
                                        </h5>
                                        <h5 class="infoItem">Múltiplo venta: <span class="text-blue" id='multiploVenta'>{{$itemInfo['multiploVenta']}}</span></h5>
                                        <h5 class="infoItem">Cant. en empaque: <span class="text-blue">{{$itemInfo['inner']}}</span></h5>
                                        <h5 class="infoItem">Cant. Master: <span class="text-blue">{{$itemInfo['master']}}</span></h5>
                                        <h5 class="infoItem">Unidad: <span class="text-blue">{{$itemInfo['unidad']}}</span></h5>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mt-5">
                                    <div class="detallesContainer">
                                        <span id="precioLista" class="d-none">{{$itemInfo['price']}}</span>
                                        <h5 class="infoItem">Precio Lista: <span class="text-blue">${{ number_format($itemInfo['price'], 2, '.', ',')}} + IVA</span></h5>
                                        @if($itemInfo['promoART'] != null)
                                            @for($x=0; $x < count($itemInfo['promoART']); $x++)
                                                <h5 class="infoItem">Precio Cliente: <span class="text-red">(-{{$itemInfo['promoART'][$x]['descuento']}}%)</span> <span class="text-blue">${{ number_format(round((100 - $itemInfo['promoART'][$x]['descuento']) * ($itemInfo['price']) / 100, 2), 2, '.', ',')}} + IVA</span></h5>
                                            @endFor
                                            <h5 class="infoItem">Prec. sugerido de venta: <span class="text-blue">${{ number_format(round(((100 - $itemInfo['promoART'][0]['descuento']) * ($itemInfo['price']) / 100 ) / 0.65, 2), 2, '.', ',')}} con IVA</span></h5>
                                        @else
                                            <h5 class="infoItem">Prec. sugerido de venta: <span class="text-blue">${{ number_format(round($itemInfo['price'] / 0.65, 2), 2, '.', ',')}} con IVA</span></h5>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 mt-5">
                                    @if($itemInfo['promoART'] != null)
                                        <h5 class="infoItem"><span>Promoción</span></h5>
                                        <h5 class="infoItem"><span>A partir de <span id="promoMinPzas"></span></span></h5>
                                        <div class="promosContainer">
                                        @for($x=0; $x < count($itemInfo['promoART']); $x++)
                                                {{-- @if($itemInfo['promoART'][$x]['cantidad'] == 1)
                                                    <h5 onclick="updateQuantityByPromo('{{$itemInfo['promoART'][$x]['cantidad']}}')" class="infoItem badgePromo activePromo" id='promoART-1-{{$itemInfo['promoART'][$x]['descuento']}}'><span>-{{$itemInfo['promoART'][$x]['descuento']}} %</span></h5>
                                                @else
                                                    <h5 onclick="updateQuantityByPromo('{{$itemInfo['promoART'][$x]['cantidad']}}')" class="infoItem badgePromo" id='promoART-{{$itemInfo['promoART'][$x]['cantidad']}}-{{$itemInfo['promoART'][$x]['descuento']}}'><span>-{{$itemInfo['promoART'][$x]['descuento']}} %</span></h5>
                                                @endif --}}

                                                <div class="chip-group">
                                                    @if($itemInfo['promoART'][$x]['cantidad'] == 1)
                                                    <div class="chip active">
                                                        <h5 onclick="updateQuantityByPromo('{{$itemInfo['promoART'][$x]['cantidad']}}')" class="infoItem" id='promoART-1-{{$itemInfo['promoART'][$x]['descuento']}}'><span>-{{$itemInfo['promoART'][$x]['descuento']}} %</span></h5>
                                                    </div>
                                                    @else
                                                        <div class="chip">
                                                            <h5 onclick="updateQuantityByPromo('{{$itemInfo['promoART'][$x]['cantidad']}}')" class="infoItem" id='promoART-{{$itemInfo['promoART'][$x]['cantidad']}}-{{$itemInfo['promoART'][$x]['descuento']}}'><span>-{{$itemInfo['promoART'][$x]['descuento']}} %</span></h5>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                        @endFor
                                            </div>


                                    @else
                                        <h5 class="infoItem"><span class="text-red">Sin promoción</span></h5>
                                    @endif

                                    <div class="input-group mb-3">
                                        <button class="btnControlQuantity" onclick="stepDown()" type="button">-</button>
                                        <input type="number" id="quantity" onkeyup="updatePrecioCliente()" value="{{$itemInfo['multiploVenta']}}" step="{{$itemInfo['multiploVenta']}}" min="{{$itemInfo['multiploVenta']}}" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                        <button class="btnControlQuantity" onclick="stepUp()" type="button">+</button>
                                    </div>

                                    <h5>Precio Cliente: <span class="text-blue" id='precioCliente'></span></h5>

                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mt-5">
                                    <div class="actions">
                                        <button class='btn-actions btn-actions-primary'>Agregar al carrito</button>
                                        <button class='btn-actions btn-actions-secondary mt-2'>Ver video</button>
                                        <button onclick="openModalFicha('{{$itemInfo['itemid']}}')" class='btn-actions btn-actions-secondary mt-2'>Ver ficha técnica</button>
                                    </div>  
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            @endif
    
        </div>
        

        

    </div>
    
    {{-- MODAL FICHA TÉCNICA --}}


    <!-- Modal -->
    <div class="modal fade" id="modalFichaTecnica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <i class="fa-solid fa-lg fa-xmark" id="closeModalIcon" style="cursor: pointer; margin-top: -8px;" onclick="closeModal('modalFichaTecnica')"></i>
                <img class="imgFichaTecnica" src="" onload="fichaDisponible()" onerror="fichaNoDisponible()" alt="">
                <h5 id='errorFicha'></h5>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('modalFichaTecnica')">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

@endsection



