<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/png" href="../assets/customers/img/png/favicon.png">
        <link rel="stylesheet" href="{{asset('assets/customers/css/pedidos/pedidosAnteriores.css')}}">
        <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>   
        <script src="{{asset('assets/customers/js/pedidos/pedidosAnteriores.js')}}"></script>
        <script src="{{asset('assets/libraries/blazy/blazy.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <script src="https://kit.fontawesome.com/c5238cc839.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://nightly.datatables.net/js/jquery.dataTables.min.js"></script>
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
                <option style="height: 30px !important;" value="all">Todos</option>
                <option style="height: 30px !important;" value="2017">2017</option>
                <option style="height: 30px !important;" value="2018">2018</option>
                <option style="height: 30px !important;" value="2019">2019</option>
                <option style="height: 30px !important;" value="2020">2020</option>
                <option style="height: 30px !important;" value="2021">2021</option>
                <option style="height: 30px !important;" value="2022">2022</option>
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
                <div class="col-lg-1 col-md-2 col-sm-3 col-6 box" onclick="openDetail('{{$order->numPedido}}')">
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


<!-- MODAL DETALLE PEDIDO -->


<!-- Modal -->
<div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModalDetail">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalDetail">
            <!-- <div class="process flat">
                <a href="#" class="active">PEDIDO LEVANTADO</a>
                <a href="#" id="labelWMS">WMS</a>
                <a href="#" id="labelFactura">FACTURA</a>
                <a href="#" id="labelEmbarque">EMBARQUE</a>
            </div> -->

            <ul id="progressbar">
                <li class="active">PEDIDO LEVANTADO</li>  
                <li id="labelWMS">WMS</li>
                <li id="labelFactura">FACTURA</li>
                <li id="labelEmbarque">EMBARQUE</li>
            </ul>
            <div class="saleOrderDetail mt-5" id='saleOrderDetail'>
            <table id="tablaDetalle" class="table-striped table-bordered table-hover compact display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="customHeader">Img</th>
                                            <th class="customHeader">Cod Art</th>
                                            <th class="customHeader">Pedido</th>
                                            <th class="customHeader">Empacado</th>
                                            <th class="customHeader">Facturado</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bodyInventario" style="height: 200px; overflow-y: auto;"></tbody>
                                   
                                </table>
            </div>
            <div class="sinDetalle" id="sinDetalle">

            </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> -->
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="containerImgProduct" id="containerImgProduct">
    <div class="magnify">
        <div class="large" id="zoom"></div>
        <img src="" alt="" class="imgProductMD small bigImageProduct gallery" id="imgProductMD">
    </div>
    
    <i class="fas fa-times closeImgProductMDIcon" id="closeImgProductMDIcon" onclick="closeImgProductMD()"></i>
</div>



</body>
</html>
