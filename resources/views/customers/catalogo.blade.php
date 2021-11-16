
@extends('layouts.customers.customer')

@section('title') Indar - Catalogo @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section">
        <div class="section-body">
            <div class="section-title">
                <h3 data-aos="fade-right" data-aos-duration="2000">Catálogo INDAR</h3>
            </div>
            <br><br>
            <div class="container">
                <div class="row section-row">
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/indar_2022.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/indar.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo INDAR</h5>
                            <h5>2022</h5>
                        </a>
                    </div> 
                    <!-- <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo cat-yellow"></div>
                            <h5 class="mb-0 mt-3">Catálogo INDAR</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>   -->
                </div>
            </div>

            <br>

            <div class="section-title">
                <h3 class="appear-1000">Catálogo Proveedores:</h3>
            </div>
            <br><br>
            <div class="container">
                <div class="row section-row">
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/austromex.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/bosch.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/bosch.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>  
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/dremel.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/evans.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>  
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/fandeli.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/foy.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>  
                </div>

                <div class="row section-row">
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/klein.svg')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/lock.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>  
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/norton.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="110%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/rugo.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>  
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/skil.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/surtek.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div>  
                </div>

                <div class="row section-row">
                    <div data-aos="fade-up" data-aos-duration="2000" class="col-lg-2 col-md-4 col-sm-6 d-flex flex-column justify-content-center align-items-center col-catalogo">
                        <a style="text-decoration:none;" target="_blank" href="{{asset('assets/customers/pdf/catalogos/astromex.pdf')}}">
                            <div class="catalogo d-flex flex-column justify-content-center align-items-center"><img width="90%" height="auto" src="{{asset('assets/customers/img/png/Proveedores/urrea.png')}}" alt=""></div>
                            <h5 class="mb-0 mt-3">Catálogo Proveedor</h5>
                            <h5>AÑO</h5>
                        </a>
                    </div> 
                </div>


            </div>

            <br><br><br>

        </div>        
    </div>

@endsection
