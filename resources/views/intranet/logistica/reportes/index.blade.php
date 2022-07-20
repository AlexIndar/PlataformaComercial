@extends('layouts.intranet.main',  ['active' => 'Logistica']) 

@section('title') Indar | Reportes @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/intranet/css/main.css') }}">
@endsection

@section('body')

<div class="content-wrapper">
      <div class="container">
            <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.reportes.facturasXEmbarcar') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-people-carry-box fa-2x"></i><br>
                        <h6>Facturas X Embarque</h6>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.reportes.gastoFleteras') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-sack-dollar fa-2x"></i><br>
                        <h6>Gasto Fleteras</h6>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.reportes.interfazRecibo') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-display fa-2x"></i><br>
                        <h6>Interfaz Recibo</h6>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="{{ route('logistica.reportes.interfazFacturacion') }}" class="card-link">
                      <div class="dashboard-cards">
                        <i class="fa-solid fa-display fa-2x"></i><br>
                        <h6>Interfaz Facturación</h6>
                      </div>
                    </a>
                  </div>
            </div>
            <br><br><br><br>
      </div>
  </div>

@endsection