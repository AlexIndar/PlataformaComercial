
@extends('layouts.customers.customer')

@section('title') Indar - Nosotros @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/datatables.css')}}">
<script src="{{asset('assets/customers/js/datatables.js')}}"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

@endsection

@section('body')

<br><br>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Empleados</div>

                <div class="panel-body">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <input type="text" class="form-control filter-input" placeholder="Buscar por nombre" data-column="0"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control filter-input" placeholder="Buscar por apellido" data-column="1"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control filter-input" placeholder="Buscar por email" data-column="2"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select data-column="0"  class="form-control filter-select">
                                        <option value="">Seleccionar nombre...</option>
                                        @foreach($nombres as $nombre)
                                        <option value="{{$nombre}}">{{$nombre}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select data-column="1"  class="form-control filter-select">
                                        <option value="">Seleccionar apellido...</option>
                                        @foreach($apellidos as $apellido)
                                        <option value="{{$apellido}}">{{$apellido}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br>
    
@endsection
