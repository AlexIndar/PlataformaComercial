
@extends('layouts.customers.customer')

@section('title') Indar - Preguntas Frecuentes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
@endsection

@section('body')

    <!-- FAQ -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div class="section">
        <div class="section-body">
            <div class="section-title">
                <h3 data-aos="fade-right" data-aos-duration="2000">Preguntas Frecuentes</h3>
            </div>
            <br><br>
            <div class="container">
                <div class="row section-row">
                    <div class="col-lg-6 col-md-6 col-sm-12" data-aos="fade-up" data-aos-duration="2000">
                        <h5 class="question">¿Cómo hacer un pedido?</h5>
                        <h5 class="answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta temporibus sint possimus quas earum totam labore facere laudantium ipsum, omnis hic repellat deserunt eius unde quis tempore repellendus, ea reiciendis!</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 appear-1000">
                        <iframe width="80%" height="200px" src="https://www.youtube.com/embed/2yMEMcAUnXo" title="Cómo hacer un pedido INDAR" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <br>
                <div class="row section-row">
                    <div class="col-lg-6 col-md-6 col-sm-12" data-aos="fade-up" data-aos-duration="2000">
                        <h5 class="question">¿Cómo realizar un pago?</h5>
                        <h5 class="answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta temporibus sint possimus quas earum totam labore facere laudantium ipsum, omnis hic repellat deserunt eius unde quis tempore repellendus, ea reiciendis!</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 appear-1000">
                        <iframe width="80%" height="200px" src="https://www.youtube.com/embed/3n5NaC4dUcE" title="Cómo hacer un pedido INDAR" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="section-row">
                    <div class="col-11 appear-500">
                        <h5 class="question">¿Lorem ipsum dolor sit amet.?</h5>
                        <h5 class="answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta temporibus sint possimus quas earum totam labore facere laudantium ipsum, omnis hic repellat deserunt eius unde quis tempore repellendus, ea reiciendis!</h5>
                    </div>
                </div>

                <div class="section-row">
                    <div class="col-11 appear-500">
                        <h5 class="question">¿Lorem ipsum dolor sit amet.?</h5>
                        <h5 class="answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta temporibus sint possimus quas earum totam labore facere laudantium ipsum, omnis hic repellat deserunt eius unde quis tempore repellendus, ea reiciendis!</h5>
                    </div>
                </div>

                <div class="section-row">
                    <div class="col-11 appear-500">
                        <h5 class="question">¿Lorem ipsum dolor sit amet.?</h5>
                        <h5 class="answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta temporibus sint possimus quas earum totam labore facere laudantium ipsum, omnis hic repellat deserunt eius unde quis tempore repellendus, ea reiciendis!</h5>
                    </div>
                </div>

                <div class="section-row">
                    <div class="col-11 appear-500">
                        <h5 class="question">¿Lorem ipsum dolor sit amet.?</h5>
                        <h5 class="answer">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta temporibus sint possimus quas earum totam labore facere laudantium ipsum, omnis hic repellat deserunt eius unde quis tempore repellendus, ea reiciendis!</h5>
                    </div><br><br>
                </div>
            </div>
            <br><br><br>
        </div>        
    </div>

@endsection
