
@extends('layouts.customers.customer')

@section('title') Indar - Catalogo @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('assets/customers/css/items.css')}}">
<link rel="stylesheet" href="{{asset('assets/libraries/AnythingZoomer/AnythingZoomer/css/style.css')}}">
<script src="{{asset('assets/customers/js/items.js')}}"></script>
<script src="{{asset('assets/libraries/AnythingZoomer/AnythingZoomer/js/zoomer.jquery.js')}}"></script>
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section" style="padding: 0px !important;">
            <div class="container" style="padding-top:50px; padding-bottom:50px;">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row" style="max-height:500px; overflow:hidden;">
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>
                                    <div class="col-12" style="padding-bottom:5px;"><img class="smallImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""></div>

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <!-- <img class="bigImageProduct gallery" id="main-img" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt=""> -->
                                <div id="zoom" class="az-wrap">
                                    <span class="az-wrap-inner">

                                        <div class="small az-small">
                                        <div class="az-overly az-overlay"></div>
                                        <span class="az-small-inner">
                                            <img class="bigImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt="small rushmore">
                                        </span>
                                        </div>

                                        <div class="az-zoom az-windowed">
                                        <div class="large az-large">
                                            <img class="bigImageProduct" src="https://www.officedepot.com.mx/medias/83878.jpg-1200ftw?context=bWFzdGVyfHJvb3R8MzcyMzkyfGltYWdlL2pwZWd8aGExL2g4OS85NjM5OTUzMzM0MzAyLmpwZ3xiYmE5NGEzMjg4MmNkNjQ5ZjI3MzY1Mjc1MDhmYzI0MTFjMzY0ODlmMDZjYmQ0N2VjYWNlZDVjNmZjNjRkMzAw" alt="big rushmore">
                                        </div>
                                        </div>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h5>Nombre del producto</h5>
                        <h5>Código</h5>
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
    </div>

@endsection
