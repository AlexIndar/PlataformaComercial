
@extends('layouts.customers.customer')

@section('title') Indar @endsection

@section('styles')
@endsection

@section('body')
    <!-- HERO --------------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="hero">
        <div class="slider">
            <div class="carousel slide h-100 w-100" data-bs-ride="carousel">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <div class="slider-img slider-1"></div>
                        <div class="overlay"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" class="orange"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="yellow"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                        <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">Tu bodega ferretera. Precio, rapidez y atención.</h1>
                        <button data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="2500" data-aos-delay="1000" onclick="conocerMas()" class="slider-btn">Conocer más</button>
                    </div>
                    <div class="carousel-item h-100">
                        <div class="slider-img slider-2"></div>
                        <div class="overlay"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" class="orange"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="red"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                        <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">Principal mayorista ferretero en la región Centro-Occidente</h1>
                    </div>
                    <div class="carousel-item h-100">
                        <div class="slider-img slider-3"></div>
                        <div class="overlay"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" class="blue"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="500" class="black"></div>
                        <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="600" class="white"></div>
                        <h1 class="left" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000" data-aos-delay="1000">¡Ofertas relámpago! Aprovecha las mejores ofertas por tiempo limitado</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- NEW PRODUCTS -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="new-products">
        <div class="new-products-title">
            <h3>Nuevos Productos</h3>
        </div>
        <div class="carousel" data-aos="fade-left" data-aos-duration="2000">
          <!-- Slider main container -->
            <div class="swiper swiper-1">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://http2.mlstatic.com/D_NQ_NP_2X_730841-MLM44000592476_112020-F.webp" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://resources.sears.com.mx/medios-plazavip/fotos/productos_sears1/original/3031928.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://tiendamakita.com/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn.shopify.com/s/files/1/0033/8418/0848/products/73d47fb5-0b87-4bac-841a-de12606994f6_1024x.jpg?v=1630656145" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://www.diprofer.com/catalogo/5153-large_default/cerraduras-sobreponer-clasica-blister.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://www.diprofer.com/catalogo/5163-large_default/cerraduras-sobreponer-puertas-corredizas-clasica.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://tlapalero-16ac7.kxcdn.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/f/a/fan014_4.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRibv4h012POe7NdUlvZtQ553bsEIDDfnBlv1dmQLdNc6LpE9T85iyS7H3Vu4kaGOr-AcY&usqp=CAU" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/1616HD.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://s1.kaercher-media.com/products/11509300/main/1/d0.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn.homedepot.com.mx/productos/140503/140503-d.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M616_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M666_AS01?$zmmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://medios.urrea.com/catalogo/Surtek/hd/CP-NO.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://tauber.com.mx/storage/customer/images/83755_U1_268GHL.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/JC10.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/41ZU61_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn.masterlock.com/product/orig/MLLA_PRODUCT_S1017.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <img src="https://cdn1.coppel.com/images/catalog/mkp/226/3000/2261100-1.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>

                </div>
            </div>
        </div>
        <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-prev swiper-button-prev-1"></div>
        <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-next swiper-button-next-1"></div>
        <div class="swiper-pagination swiper-pagination-1"></div>
    </div>

    <!-- OUTLET ---------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div class="outlet-products">
        <div class="outlet-products-title">
            <h3 data-aos="fade-right" data-aos-duration="2000">Outlet y descontinuados <a class="show-more">Ver más</a> </h3>
        </div>
        <div class="carousel-2" data-aos="fade-left" data-aos-duration="2000">
          <!-- Slider main container -->
            <div class="swiper swiper-2">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://http2.mlstatic.com/D_NQ_NP_2X_730841-MLM44000592476_112020-F.webp" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://resources.sears.com.mx/medios-plazavip/fotos/productos_sears1/original/3031928.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://tiendamakita.com/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn.shopify.com/s/files/1/0033/8418/0848/products/73d47fb5-0b87-4bac-841a-de12606994f6_1024x.jpg?v=1630656145" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://www.diprofer.com/catalogo/5153-large_default/cerraduras-sobreponer-clasica-blister.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://www.diprofer.com/catalogo/5163-large_default/cerraduras-sobreponer-puertas-corredizas-clasica.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://tlapalero-16ac7.kxcdn.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/f/a/fan014_4.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRibv4h012POe7NdUlvZtQ553bsEIDDfnBlv1dmQLdNc6LpE9T85iyS7H3Vu4kaGOr-AcY&usqp=CAU" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/1616HD.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://s1.kaercher-media.com/products/11509300/main/1/d0.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn.homedepot.com.mx/productos/140503/140503-d.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M616_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/28M666_AS01?$zmmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://medios.urrea.com/catalogo/Surtek/hd/CP-NO.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://tauber.com.mx/storage/customer/images/83755_U1_268GHL.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://medios.urrea.com/catalogo/Urrea/hd/JC10.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://static.grainger.com/rp/s/is/image/Grainger/41ZU61_AS01?$glgmain$" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn.masterlock.com/product/orig/MLLA_PRODUCT_S1017.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>
                    <div class="swiper-slide swiper-slide-products">
                        <div class="ribbon ribbon-top-left"><span>¡OFERTA!</span></div>
                        <img src="https://cdn1.coppel.com/images/catalog/mkp/226/3000/2261100-1.jpg" alt="">
                        <h5>Nombre del producto <br>Marca del producto </h5>
                        <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                    </div>

                </div>
            </div>
        </div>

        <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-prev swiper-button-prev-2"></div>
        <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-next swiper-button-next-2"></div>
        <div class="swiper-pagination swiper-pagination-2"></div>

    </div>

@endsection