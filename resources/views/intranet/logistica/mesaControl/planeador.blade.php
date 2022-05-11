@extends('layouts.intranet.main',['active' => 'Logistica'])

@section('title') Indar @endsection

@section('styles')
{{-- <link rel="stylesheet" href="{{asset('assets/intranet/css/')}}"> --}}
@endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}assets/intranet/css/logistica.css">
@endsection
@section('body')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header title-table">
                          <h3 class="card-title">Planeador</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover table-sm">
                                    <thead class="encabezado-table">
                                        <tr>
                                            <th>PRIORIDAD</th>
                                            <th>FORMA ENVIO</th>
                                            <th>CLIENTE</th>
                                            <th>NUM. PEDIDO</th>
                                            <th>SECTOR 1</th>
                                            <th>SECTOR 2</th>
                                            <th>SECTOR 3</th>
                                            <th>SECTOR 4</th>
                                            <th>SECTOR 5</th>
                                            <th>VALIDANDO</th>
                                            <th>Z_BULK1</th>
                                            <th>Z_BULK2</th>
                                            <th>Z_BULKIN1</th>
                                            <th>Z_INF 1</th>
                                            <th>Z_VOL 1</th>
                                            <th>Z_VOL 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $area1='';
                                            $area2='';
                                            $area3='';
                                            $area4='';
                                            $area5='';
                                            $area6='';
                                            $area7='';
                                            $area8='';
                                            $area9='';
                                            $area10='';
                                            $area11='';
                                            $area12='';
                                            $styleA1='';
                                            $styleA2='';
                                            $styleA3='';
                                            $styleA4='';
                                            $styleA5='';
                                            $styleA6='';
                                            $styleA7='';
                                            $styleA8='';
                                            $styleA9='';
                                            $styleA10='';
                                            $styleA11='';
                                            $styleA12='';
                                        @endphp
                                        @foreach ($planeador as $pl)
                                        <tr>
                                            <td>{{ $pl['prioridad'] }}</td>
                                            <td>{{ $pl['formaEnvio'] }}</td>
                                            <td>{{ $pl['cliente'] }}</td>
                                            <td>{{ $pl['numPedido'] }}</td>
                                            {{-- {{ dd($pl['areas']) }} --}}
                                            @foreach ($pl['areas'] as $area)
                                                @php
                                                    

                                                    switch ($area['name']) {
                                                        case 'SECTOR 1':
                                                            $area1 = $area['porsurtir'];
                                                            $styleA1 = $area['style'];
                                                            break;
                                                        case 'SECTOR 2':
                                                            $area2 = $area['porsurtir'];
                                                            $styleA2 = $area['style'];
                                                            break;
                                                        case 'SECTOR 3':
                                                            $area3 = $area['porsurtir'];
                                                            $styleA3 = $area['style'];
                                                            break;
                                                        case 'SECTOR 4':
                                                            $area4 = $area['porsurtir'];
                                                            $styleA4 = $area['style'];
                                                            break;
                                                        case 'SECTOR 5':
                                                            $area5 = $area['porsurtir'];
                                                            $styleA5 = $area['style'];
                                                            break;
                                                        case 'VALIDANDO':
                                                            $area6 = $area['porsurtir'];
                                                            $styleA6 = $area['style'];
                                                            break;
                                                        case 'Z_BULK1':
                                                            $area7 = $area['porsurtir'];
                                                            $styleA7 = $area['style'];
                                                            break;
                                                        case 'Z_BULK2':
                                                            $area8 = $area['porsurtir'];
                                                            $styleA8 = $area['style'];
                                                            break;
                                                        case 'Z_BULKIN1':
                                                            $area9 = $area['porsurtir'];
                                                            $styleA9 = $area['style'];
                                                        break;
                                                        case 'Z_INFO1':
                                                            $area10 = $area['porsurtir'];
                                                            $styleA10 = $area['style'];
                                                            break;
                                                        case 'Z_VOL1':
                                                            $area11 = $area['porsurtir'];
                                                            $styleA11 = $area['style'];  
                                                            break;
                                                        case 'Z_VOL2':
                                                            $area12 = $area['porsurtir'];
                                                            $styleA12 = $area['style'];
                                                            break;
                                                    }
                                                @endphp
                                            @endforeach
                                            <td class="{{ $styleA1 }}">{{ $area1 }}</td>
                                            <td class="{{ $styleA2 }}">{{ $area2 }}</td>
                                            <td class="{{ $styleA3 }}">{{ $area3 }}</td>
                                            <td class="{{ $styleA4 }}">{{ $area4 }}</td>
                                            <td class="{{ $styleA5 }}">{{ $area5 }}</td>
                                            <td class="{{ $styleA6 }}">{{ $area6 }}</td>
                                            <td class="{{ $styleA7 }}">{{ $area7 }}</td>
                                            <td class="{{ $styleA8 }}">{{ $area8 }}</td>
                                            <td class="{{ $styleA9 }}">{{ $area9 }}</td>
                                            <td class="{{ $styleA10}}">{{ $area10 }}</td>
                                            <td class="{{ $styleA11}}">{{ $area11 }}</td>
                                            <td class="{{ $styleA12}}">{{ $area12 }}</td>
                                            @php
                                                $area1='';
                                                $area2='';
                                                $area3='';
                                                $area4='';
                                                $area5='';
                                                $area6='';
                                                $area7='';
                                                $area8='';
                                                $area9='';
                                                $area10='';
                                                $area11='';
                                                $area12='';
                                                $styleA1='';
                                                $styleA2='';
                                                $styleA3='';
                                                $styleA4='';
                                                $styleA5='';
                                                $styleA6='';
                                                $styleA7='';
                                                $styleA8='';
                                                $styleA9='';
                                                $styleA10='';
                                                $styleA11='';
                                                $styleA12='';
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('js')
<script src="{{ env('APP_URL')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/jszip/jszip.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ env('APP_URL')}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ env('APP_URL')}}assets/intranet/js/logisticaController.js"></script>
@endsection