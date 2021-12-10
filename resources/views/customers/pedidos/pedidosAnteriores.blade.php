<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../assets/customers/img/png/favicon.png">
        <link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/pedidosAnteriores.css')}}">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>   
        <script src="{{asset('assets/customers/js/pedidos/pedidosAnteriores.js')}}"></script>
        <script src="{{asset('assets/libraries/blazy/blazy.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <title>Pedidos anteriores</title>
       
</head>
<body>



<br><br>
<div style="overflow-x: hidden !important; padding: 0px 30px 0px 30px !important;">

    <input type="text" value="{{$customer}}" id="companyId" hidden>

    <div class="row">
        <div class="col-12 text-center">
            <h3><strong>Pedidos Anteriores</strong></h3>
            <h4>{{$customer}}</h4>
        </div>
    </div>

    <div class="row d-flex justify-content-center align-items-center flex-row">
        <div class="col-lg-4 col-12 text-center" style="margin-top:10px;">
            <h4>Cotización</h4> 
            <input type="text" id="findCotizacion" style="border: 1px solid black !important; height: 30px !important; width: 100% !important; background-color: #F7F5FF !important;" >
        </div>
        <div class="col-lg-4 col-6 text-center flex flex-row" style="margin-top:10px;">
            <h4>Año</h4> 
            <select id="findYear" style="border: 1px solid black !important; height: 30px !important; width: 100%; background-color: #F7F5FF !important;">
                <option style="height: 30px !important;" value="2021">2021</option>
                <option style="height: 30px !important;" value="2017">2017</option>
                <option style="height: 30px !important;" value="2018">2018</option>
                <option style="height: 30px !important;" value="2019">2019</option>
                <option style="height: 30px !important;" value="2020">2020</option>
            </select>
        </div>
        <div class="col-lg-4 col-6 text-center flex flex-row" style="margin-top:10px;">
            <h4>Mes</h4> 
            <select id="findMonth" style="border: 1px solid black !important; height: 30px !important; width: 100%; background-color: #F7F5FF !important;">
                <option style="height: 30px !important;" value="all">Todos</option>
                <option style="height: 30px !important;" value="1">Enero</option>
                <option style="height: 30px !important;" value="2">Febrero</option>
                <option style="height: 30px !important;" value="3">Marzo</option>
                <option style="height: 30px !important;" value="4">Abril</option>
                <option style="height: 30px !important;" value="5">Mayo</option>
                <option style="height: 30px !important;" value="6">Junio</option>
                <option style="height: 30px !important;" value="7">Julio</option>
                <option style="height: 30px !important;" value="8">Agosto</option>
                <option style="height: 30px !important;" value="9">Septiembre</option>
                <option style="height: 30px !important;" value="10">Octubre</option>
                <option style="height: 30px !important;" value="11">Noviembre</option>
                <option style="height: 30px !important;" value="12">Diciembre</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="d-flex align-items-center justify-content-center"  style="width: 100%;">
            <p id="hora"></p> <i class="fa fa-refresh fa-lg" aria-hidden="true"></i>
        </div>
    </div>

    <div class="row d-flex align-items-center flex-row" id="rowCotizaciones">
        @if(count($saleOrders)==0)
        <div class="col-12 text-center">
            <h4>No hay pedidos anteriores</h4>
        </div>
        @else
            @foreach($saleOrders as $order)
                <div class="col-lg-1 col-md-2 col-sm-3 col-6 box">
                    @if($order->numFactura != null)
                    <div class="inner inner-green">
                    @else
                    <div class="inner inner-red">
                    @endif
                        <h5><strong>Cotización </strong><br> {{$order->cotizacion}}</h5>
                        <h5><br>{{$order->trandate}}</h5>
                        <h5><strong>Pedido web</strong><br> {{$order->idWeb}}</h5>
                        <h5><br>${{number_format($order->importePedido, 2)}}</h5>
                        <hr>
                        <h5><strong>Sales Order</strong> {{$order->numPedido}}</h5>

                        <h5><strong>Num Factura</strong> <br> {{$order->numFactura}} </h5>
                        <h5><strong>Estatus:</strong></h5>
                        @if($order->numFactura != null)
                        <h5>FACTURADO</h5>
                        <div class="indicador green"></div>
                        @else
                        <h5>PENDIENTE</h5>
                        <div class="indicador red"></div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
</body>
</html>
