
@extends('layouts.customers.customer')

@section('title') Indar - Contacto @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
@endsection

@section('body')

    <!-- CATALOGO -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section appear-500">
        <div class="section-body">
            <div class="section-title appear-500">
                <h3 data-aos="fade-right" data-aos-duration="2000">Contacto</h3>
            </div>
            <br><br>

            <div class="container">
               
                <div class="row">
                    <div class="col-lg-3">
                        <h4 class="blue-indar appear-500">Ventas</h4>
                        <br><br>

                        <h5 class="gray-h5 appear-500">Guadalajara</h5>
                        <h5 class="blue-indar appear-500 mb-0">jramirez@indar.com.mx</h5>
                        <h5 class="blue-indar appear-500">ventas@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Aguascalientes</h5>
                        <h5 class="blue-indar appear-500">ventas_ags@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Querétaro</h5>
                        <h5 class="blue-indar appear-500">ventas_qro@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">León</h5>
                        <h5 class="blue-indar appear-500">ventas_leon@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Culiacán</h5>
                        <h5 class="blue-indar appear-500">ventas_culiacan@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Morelia</h5>
                        <h5 class="blue-indar appear-500">ventas_morelia@indar.com.mx</h5>
                        <br><br><br>

                    </div>




                    <div class="col-lg-3">
                        <h4 class="blue-indar appear-500">Corporativo</h4>
                        <br><br>

                        <h5 class="gray-h5 appear-500">Auditoría</h5>
                        <h5 class="blue-indar appear-500">auditoria@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Compras</h5>
                        <h5 class="blue-indar appear-500">compras@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Contabilidad</h5>
                        <h5 class="blue-indar appear-500">contabilidad@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Crédito y Cobranza</h5>
                        <h5 class="blue-indar appear-500">cobranza@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Mercadotecnia</h5>
                        <h5 class="blue-indar appear-500">mercadotecnia@indar.com.mx</h5>

                        <br>

                        <h5 class="gray-h5 appear-500">Pagos</h5>
                        <h5 class="blue-indar appear-500">pagos@indar.com.mx</h5>

                        <br>

                    <h5 class="gray-h5 appear-500">Recursos Humanos</h5>  
                    <h5 class="blue-indar appear-500">hector.miranda@indar.com.mx</h5>

                        <br><br><br>

                    </div>

                    <div class="col-lg-6">
                        <div class="w-100" style="margin-left: 0; padding-left:0; border-bottom: 5px solid #FFC61E">
                            <h4 class="blue-indar appear-500" style="margin-left:0;">Contacto:</h4>
                        </div>
                        <br><br>

                        <div class="modal-body" style="height:auto;">
                            <form action="#">
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="To">Enviar a:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="to" name="to" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Nombre">Nombre:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="name" name="name" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Telefono">Teléfono:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="phone" name="phone" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Ciudad">Ciudad:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="city" name="city" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Correo">Correo:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="email" name="email" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Empresa">Empresa:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="company" name="company" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Puesto">Puesto:</label></div>
                                    <div class="col-lg-9 col-md-12"><input class="w-100" type="text" id="position" name="position" required></div>      
                                </div> <br>
                                <div class="modal-inputs row mb-0">
                                    <div class="col-lg-3 col-md-12"><label class="gray-h5 appear-500" style="font-size:20px; font-weight: 500;" for="Menaje">Mensaje:</label></div>
                                    <div class="col-lg-9 col-md-12"><textarea class="w-100" style="min-height:200px;" type="text" id="message" name="message" required></textarea></div>      
                                </div> <br>

                                    <button style="float:right;" class="btn login-btn btn-effect-hover" type="submit">Enviar</button>
                            </form>
                            <br><br><br>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>   
             
    </div>

@endsection
