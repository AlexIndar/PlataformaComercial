
@extends('layouts.customers.customer')

@section('title') Indar - Servicio Postventa @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section">
        <div class="section-body">
            <div class="section-title">
                <h3 data-aos="fade-right" data-aos-duration="2000">Servicio Postventa</h3>
            </div>
            <br><br>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        
                        <div class="appear-1000" style="width:90%;">
                            <h5 class="gray-h5">Indar, "Tu Bodega Ferretera", hace efectivas las garantías ofrecidas por sus proveedores tal y como se especifican detalladamente para cada producto en los catálogos, manuales y etiquetas de producto de cada proveedor.
                            <br><br>
                            Las garantías de máquinas y equipos están sujetas a revisión en los Centros de Servicio Autorizados (CSA) por el fabricante correspondiente. Donde el usuario debe presentar directamente los productos con falla. Los manuales en la caja de cada producto, así como las páginas web y catálogos de los respectivos fabricantes listan direcciones y teléfonos donde se encuentran localizados estos CSA.
                            <br><br>
                            Los productos sujetos a caducidades están especificados en etiquetas y empaques de los mismos.
                            <br><br>
                            Los productos vencidos ya no reciben garantía.
                            <br><br>
                            Como regla general las garantías están sujetas a revisión por el fabricante.
                            <br><br>
                            En ningún caso Indar, "Tu Bodega Ferretera", garantiza un producto más allá de lo que lo hace el fabricante del mismo. Ni tampoco se hace responsable por los daños y accidentes personales que puedan resultar por el uso inadecuado, alteración, abuso o uso más allá de la vida esperada de los productos distribuidos.
                            </h5>
                        </div>
                        <br><br>
                    </div>
                </div>

                <div class="estado row">
                    <div class="col-lg-1 col-md-4 col-sm-12 text-center mb-5"><h5 class="blue-h5">Estado:</h5></div>
                    <div class="col-lg-3 col-md-8 col-sm-12">
                        
                                <div class="btn-group dropdown w-100" style="margin-top: -5px">
                                    <button id="estado" class="btn btn-secondary dropdown-toggle input-indar w-100" data-bs-flip="false" type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                        Seleccionar Estado
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="defaultDropdown">
                                        <li><a onclick="changeEstadoPostventa('Aguascalientes', 'Aguascalientes')" class="dropdown-item">Aguascalientes</a></li>
                                        <li><a onclick="changeEstadoPostventa('Colima', 'Colima')" class="dropdown-item">Colima</a></li>
                                        <li><a onclick="changeEstadoPostventa('Guanajuato', 'Guanajuato')" class="dropdown-item">Guanajuato</a></li>
                                        <li><a onclick="changeEstadoPostventa('Jalisco', 'Jalisco')" class="dropdown-item">Jalisco</a></li>
                                        <li><a onclick="changeEstadoPostventa('Michoacán', 'Michoacan')" class="dropdown-item">Michoacán</a></li>
                                        <li><a onclick="changeEstadoPostventa('Nayarit', 'Nayarit')" class="dropdown-item">Nayarit</a></li>
                                        <li><a onclick="changeEstadoPostventa('Querétaro', 'Queretaro')" class="dropdown-item">Querétaro</a></li>
                                        <li><a onclick="changeEstadoPostventa('San Luis Potosí', 'San_Luis_Potosi')" class="dropdown-item">San Luis Potosí</a></li>
                                        <li><a onclick="changeEstadoPostventa('Sinaloa', 'Sinaloa')" class="dropdown-item">Sinaloa</a></li>
                                        <li><a onclick="changeEstadoPostventa('Zacatecas', 'Zacatecas')" class="dropdown-item">Zacatecas</a></li>
                                    </ul>
                                </div>

                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-12">
                        <img width="100%"  height="auto" src="" id="estadoPostventa" alt="">
                    </div>
                </div>

                <br><br><br><br>


            </div>
        </div>        
    </div>

@endsection
