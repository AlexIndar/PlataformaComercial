
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
                <h3>Catálogo INDAR</h3>
            </div>
            <br><br>
            <div class="container">
                <div class="row section-row">
                    <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                        <div class="catalogo cat-blue"></div>
                        <h5 class="mb-0 mt-3" style=>Catálogo INDAR</h5>
                        <h5>AÑO</h5>
                    </div> 
                    <div class="col-2">
                    <div class="catalogo cat-yellow"></div>
                    </div> 
                </div>
            </div>
            <br>
        </div>        
    </div>

@endsection
