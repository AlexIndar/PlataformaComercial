
@extends('layouts.customers.customer')

@section('title') Indar - Descontinuados @endsection

@section('assets')
@endsection

@section('body')

    <!-- DISCONTINUED YELLOW BAR -->

    <div class="yellow-bar mt-5 p-5">
        <div class="yellow-bar-content row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <h3>Descontinuados</h3>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="input-group input-discontinued mb-3" style="width: 50%; float:right;">
                    <div class="input-group-prepend">
                        <div class="btn-group">
                            <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                <li><a class="dropdown-item" href="#">Producto</a></li>
                                <li><a class="dropdown-item" href="#">Marca</a></li>
                            </ul>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-indar" type="button"><i class="fas fa-search fa-lg"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- DISCONTINUED PRODUCTS -->

    <div class="gray-background p-3">
        <div class="row p-50">
            <div class="col-lg-2 col-sm-12">
                <h5>FILTROS</h5>
            </div>
            

            <div class="col-lg-10 col-sm-12 d-flex flex-row row page-1 active-page" id="activePage">

                @for($x = 0; $x<=19; $x++)
                            <div class="col-xl-2 col-lg-3 col-sm-5 col-xs-12 card product-card">
                                    <div class="ribbon ribbon-discontinued ribbon-top-left"><span>¡OFERTA!</span></div>
                                    <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                                    <h5>Nombre del producto 1 <br>Marca del producto 1</h5>
                                    <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                            </div>
                @endfor

            </div>

            <div class="col-lg-10 col-sm-12 d-none flex-row row page-2">

                @for($x = 0; $x<=19; $x++)
                            <div class="col-xl-2 col-lg-3 col-sm-5 col-xs-12 card product-card">
                                    <div class="ribbon ribbon-discontinued ribbon-top-left"><span>¡OFERTA!</span></div>
                                    <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                                    <h5>Nombre del producto 2<br>Marca del producto 2</h5>
                                    <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                            </div>
                @endfor

            </div>

            <div class="col-lg-10 col-sm-12 d-none flex-row row page-3">

                @for($x = 0; $x<=19; $x++)
                            <div class="col-xl-2 col-lg-3 col-sm-5 col-xs-12 card product-card">
                                    <div class="ribbon ribbon-discontinued ribbon-top-left"><span>¡OFERTA!</span></div>
                                    <img src="https://m.media-amazon.com/images/I/61vJaKuqa6L._AC_SL1000_.jpg" alt="">
                                    <h5>Nombre del producto 3<br>Marca del producto 3</h5>
                                    <h5> <span class="original-price"></span>  <br> <span class="price"></span> </h5>
                            </div>
                @endfor

            </div>
           
            
        </div>

        <nav aria-label="Page navigation example" class="d-flex justify-content-center mb-5 mt-5 w-100">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                    <li onclick="changePagination(1)" class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li onclick="changePagination(2)" class="page-item"><a class="page-link" href="#">2</a></li>
                    <li onclick="changePagination(3)" class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                </ul>
        </nav>


    </div>

    

    <!-- RELATED PRODUCTS -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="new-products">
        <div class="new-products-title">
            <h3>Productos Relacionados</h3>
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
        <!-- <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-prev swiper-button-prev-1"></div>
        <div data-aos="fade-left" data-aos-duration="2000" class="swiper-button-next swiper-button-next-1"></div>
        <div class="swiper-pagination swiper-pagination-1"></div> -->
    </div>

    

@endsection