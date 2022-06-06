<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consolidado</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/customers/img/png/favicon.png') }}">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/almacen/css/consolidado.css')}}">
</head>
<body>  
    <div class="container-fluid">
        <div class="row justify-content-center">
			<div class="col col-sm-12 col-xs-12 col-xl-12">
				<div class="row justify-content-center">
                    <div class="col-12 mt-4">
                        <center>
                            <button type="button" class="btn btn-danger" style="font-size:40px;"><strong>Cte Recoge al 100%</strong> <span class="badge"></span></button>    
                            <button type="button" class="btn btn-success" style="font-size:40px;"><strong>Pedidos al 100%</strong> <span class="badge"></span></button>
                            <button type="button" class="btn btn-warning" style="font-size:40px;"><strong>Pedidos del 80% al 99%</strong><span class="badge"></span></button>
                        </center>
                    </div>
                </div>
				<div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">CONS</th>
                                    <th scope="col" class="text-center">PEDIDO</th>
                                    <th scope="col" class="text-center">FORMA DE ENVIO</th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center">CAJAS</th>
                                    <th scope="col" class="text-center">%</th></h2>
                                </tr>
                            </thead>
                            <tbody id="table-content-consolidado">
                                @foreach($consolidado as $con)
                                    @php
                                        if ($con->avance==100){
                                        $color="btn-success";
                                        }
                                        if ($con->avance<100){
                                        $color="btn-warning";
                                        }
                                        if ($con->avance==100 && (STRPOS($con->fletera,'CCI CLIENTE RECOGE')!==false))
                                        {
                                        $color="btn-danger";
                                        }
                                        if ($con->avance==100 && (STRPOS($con->fletera,'CCI Cliente Recoge')!==false))
                                        {
                                        $color="btn-danger";
                                        }
                                        if ($con->avance==100 && (STRPOS($con->fletera,'CCI CLIENTE ESTA AQUI')!==false))
                                        {
                                        $color="btn-danger";
                                        }
                                    @endphp
                                    <tr class={{$color}}>
                                        
                                        <td>
                                            <center><b>{{$con->ubicaciones}}</center>
                                        </td>
                                        <td>
                                            <center><b>{{$con->pedido}}</center>
                                        </td>
                                        <td>
                                            <center><b>{{$con->fletera}}</center>
                                        </td>
                                            @if($con->id == 1)
                                            <td><img src = '{{asset('assets/almacen/img/pallet.png')}}' height=70 width=75></td>
                                            @else
                                            <td></td>
                                            @endif
    
                                            @if($con->procesarTarima >= 15)
                                            <td><img src = '{{asset('assets/almacen/img/mesa14.png')}}' height=70 width=75></td>
                                            @else
                                            <td></td>
                                            @endif
                                        <td>
                                            <center><b>{{$con->cajas}}</center>
                                        </td>
                                        <td>
                                            <center><b>{{$con->avance}}</center>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
			</div>
		</div>
    </div>
 <!-- jQuery {{asset('assets/js/scripts.js')}} -->
 <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
 <!-- Bootstrap 4 -->
 <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script src="{{asset('assets/almacen/js/consolidadoController.js')}}"></script>
</body>
</html>