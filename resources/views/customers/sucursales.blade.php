
@extends('layouts.customers.customer')

@section('title') Indar - Sucursales @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section">
        <div class="section-body">
            <div class="section-title">
                <h3 data-aos="fade-right" data-aos-duration="2000">Sucursales:</h3>
            </div>
            <br><br>

            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                       <h5 class="gray-h5 appear-1000">Con gusto te atenderemos en las siguientes ubicaciones:</h5>

                       <br>

                       <div class="row">
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Cumplimiento INDAR</h5>
                                   <h4>Carr. El Verde San Martín de las Flores #480 <br>Col. San Martín de las Flores <br>Tlaquepaque, Jalisco <br><strong>(33) 5000 2200</strong> </h4>
                               </div>
                           </div>
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención AGU-01</h5>
                                   <h4>Av. de la Convención de 1914 Sur #1510-A<br>Col. La Salud <br> Aguascalientes, Ags. C.P. 20240 <br><strong>(444) 915 7310, (444) 916 0916 <br> ventas_ags@indar.com.mx</strong> </h4>
                               </div>
                           </div>
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención BJX-02</h5>
                                   <h4>Mariano Escobedo #4151<br>Col. San Isidro <br> León, Guanajuato. C.P. 37685 <br><strong>(477) 711 8256, (477) 711 8069 <br> ventas_leon@indar.com.mx</strong> </h4>
                               </div>
                           </div>
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención QRO-03</h5>
                                   <h4>Av. Campo Militar #9-A <br>Col. La Sierrita <br> Querétaro, Qro. C.P. 76137 <br><strong>(442) 242 8109, (442) 215 6708 <br> ventas_qro@indar.com.mx</strong> </h4>
                               </div>
                           </div>

                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención CUL-04</h5>
                                   <h4>Blvd. Jesús Kumate Rodríguez #3831 D<br>Fracc. del Valle <br> Culiacán, Sinaloa. C.P. 80155 <br><strong>(667) 721 5885, (667) 721 5546 <br> ventas_culiacan@indar.com.mx</strong> </h4>
                               </div>
                           </div>
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención MLM-05</h5>
                                   <h4>Periférico Paseo de la República #4621<br>Col. Ignacio Zaragoza <br> Morelia, Michoacán. C.P. 58114 <br><strong>(443) 299 1236<br> ventas_morelia@indar.com.mx</strong> </h4>
                               </div>
                           </div>
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención TRC-06</h5>
                                   <h4>Blvd. El Tajito #8785, Local 4-D<br>Col. Nueva Laguna 1ra Etapa <br> Torreón, Coahuila. C.P. 27100 <br><strong>(871) 204 0808<br> ventas_torreon@indar.com.mx</strong> </h4>
                               </div>
                           </div>
                           <div class="col-lg-3 col-md-4 col-sm-6">
                               <img class="appear-1000" width="90%" height="auto" src="{{asset('assets/customers/img/jpg/sucursales/cci.jpg')}}" alt="">
                               <div class="sucursal-info d-flex flex-column justify-content-center mt-5 mb-5 appear-1000">
                                   <h5>Centro de Atención GDL-07</h5>
                                   <h4>Plátano #1438<br>Col. del Fresno <br> Guadalajara, Jalisco. C.P. 44900 <br><strong>(33) 2466 8000<br> ventas_gdl07@indar.com.mx <br> clienterecogegdl07-1@indar.com.mx <br> clienterecogegdl07-2@indar.com.mx </strong> </h4>
                               </div>
                           </div>
                       </div>


                       <br><br>

                    </div>
                </div>
            </div>
        </div>        
    </div>

@endsection
