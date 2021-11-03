
@extends('layouts.customers.customer')

@section('title') Indar - Catalogo @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section">
        <div class="section-body">
            <div class="section-title">
                <h3 data-aos="fade-right" data-aos-duration="2000">Nosotros</h3>
            </div>
            <br><br>

            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                        <img class="appear-1000" width="90%" height="auto" src="http://www.indar.com.mx/Imagenes/FOTO_GRUPAL.jpg" alt="">
                        <br>
                        <div class="appear-1000" style="width:90%;">
                            <h5 class="gray-h5">INDAR, es el principal mayorista ferretero en la región Centro-Occidente de la República Mexicana. Ofrece a sus clientes un negocio fácil y rentable, gracias a su propuesta de valor enfocada en los precios competitivos, entrega rápida y atención personalizada.
                            <br><br>
                            INDAR, opera desde la ciudad de Guadalajara y distribuye sus productos en un área de 500 Kms. alrededor de la misma. Para un rápido servicio de entrega pone a tu disposición un sólido inventario, en su moderno Centro de Cumplimiento INDAR (CCI), con más de 10,500 productos de línea y una importante flotilla de vehículos y convenios con las principales compañías de paquetería que operan en la región.
                            <br><br>
                            El Centro de Cumplimiento INDAR y oficinas generales están localizados sobre un área de 17,000m2 en una zona de fácil acceso a las principales rutas de distribución. Además cuenta con Centros de Atención en las ciudades de Aguascalientes, Ags. , León, Gto., Querétaro, Qro., Culiacán, Sin., Morelia, Mich., Torreón, Coah y Guadalajara, Jal. En todas estas ubicaciones existe personal altamente capacitado y enfocado a brindarte una atención personalizada.
                            <br><br>
                            INDAR, fue fundada en 1987 con la visión de cubrir las necesidades de la industria y ferreterías de la región. Empezó con un mostrador y una pequeña fuerza de ventas de campo que rápidamente fue desarrollándose para convertirse en la fuerza de ventas más importante del mayoreo ferretero en el occidente del país. Al mismo tiempo fue integrando proveedoresde las marcas más importantes de productos ferreteros que ayudan a que INDAR sea el proveedor preferido de la región.
                            </h5>
                        </div>
                        
                        <br>
                        <img class="appear-1000" width="90%" height="auto" src="http://www.indar.com.mx/Imagenes/QuienesSomos3.jpg" alt="">
                        <br><br>
                    </div>
                </div>
            </div>
        </div>        
    </div>

@endsection
