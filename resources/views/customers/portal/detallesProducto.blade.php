
@extends('layouts.customers.customer')

@section('title') Indar - Detalles Producto @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/items.css')}}">
<script src="{{asset('assets/customers/js/items.js')}}"></script>
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

            <div class="container-fluid section-body" style="padding-top:50px; padding-bottom:50px; margin-top:10px !important;">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-3">
                                <div class="row" style="max-height:500px; overflow:hidden;">
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 magnify">
                                <div class="large" id="zoom"></div>
                                <img src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_JPG_MD/B2_G720_B3_MD.jpg" alt="" class="imgProductMD small bigImageProduct gallery" id="imgProductMD">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <h5 class="detalleProductoBlack" id="codeItem">B2 G720</h5>
                        <h5 class="detalleProductoTiny detalleProductoGray"> <span id="statusItem">Nuevo</span> | <span id='soldItems'>3417</span> vendidos</h5>
                        <h5 class="detalleProductoBlack" id="nameItem">Esmeriladora angular Black+Decker G720 de 60 Hz naranja 820 W 120 V</h5>
                        <div class="Stars" style="--rating: 5;" aria-label="Rating of this product is 2.3 out of 5."></div> <h5 class="detalleProductoTiny detalleProductoGray mt-1"> <span id="opinionsItem">403</span> opiniones</h5>
                        <br>
                        <div class="badgeSuggest"> <img class="suggestIcon" src="{{ asset('assets/customers/img/png/suggestIcon.svg') }}" alt=""> <h5>RECOMENDADO</h5></div> <h5 class="detalleProductoTiny mt-2"> en <span id="suggestCategory">Esmeriladoras eléctricas</span></h5>
                        <hr class="hr-indar">
                        <h1> <span class="original-price">$000.000</span>  <br> <span class="price"></span>$000.000</h1>
                        <br>
                        <div class="quantity">
                            <h5>Cantidad </h5>
                            <div class="quantity-counter">
                                <h1 onclick="decreaseQuantity()">-</h1><h1 id="quantity">0</h1><h1 onclick="increaseQuantity()">+</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection
