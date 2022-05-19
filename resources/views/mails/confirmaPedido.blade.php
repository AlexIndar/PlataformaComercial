<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$asunto}}</title>
    <style>
        h4, h5{
            line-height: 2px !important; 
        }
    </style>
</head>
<body>
    @if($idCotizacion == 0)
        <h4 style="line-height: 10px;">Cotización de Pedido</h4>
    @else
        <h4 style="line-height: 10px;">Pedido Web #{{$idCotizacion}}</h4>
    @endif

    <hr>

    <h4 style="line-height: 10px;">Cliente: {{$cliente}}</h4>
    <h4 style="line-height: 10px;">Forma de envío: {{$formaEnvio}}</h4>
    <h4 style="line-height: 10px;">Fletera: {{$fletera}}</h4>
    <h4 style="line-height: 10px;">Orden de compra: {{$ordenCompra}}</h4>
    <h4 style="line-height: 10px;">Comentarios: {{$comentarios}}</h4>


                <table style='border: 1px solid rgba(0, 0, 0, 0.1); width: 100%; min-width: 1000px;' cellspacing='0'>
                    <!-- CABECERA DE TABLA -->
                    <tr style='background-color:#002868; color:white; padding: 2px; text-align: center;'>
                        <th style='padding: 2px; text-align: center;'>#</th>
                        <th style='padding: 2px; text-align: center;'>Art</th>
                        <th style='padding: 2px; text-align: center;'>Cant</th>
                        <th style='padding: 2px; text-align: center;'>Descripción</th>
                        <th style='padding: 2px; text-align: center;'>Precio Lista</th>
                        <th style='padding: 2px; text-align: center;'>Promo</th>
                        <th style='padding: 2px; text-align: center;'>Precio Unitario</th>
                        <th style='padding: 2px; text-align: center;'>Importe</th>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                
                    @for($x=0; $x < count($pedido); $x++)
                        @if($pedido[$x]['regalo']==0)
                            <tr>
                            @if($pedido[$x]['tipo']=='BO')
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                @if(count($tranIds) > 0)
                                    <th style='background-color:#fcbf49; padding: 2px; text-align: center;'>Descuento: {{$pedido[$x]['descuento']}}% Plazo: {{$pedido[$x]['plazo']}} Tipo: {{$pedido[$x]['tipo']}} Subtotal: ${{$pedido[$x]['subtotal']}} Evento: {{$pedido[$x]['evento']}} TranID: {{$tranIds[$x]}}</th>
                                @else
                                    <th style='background-color:#fcbf49; padding: 2px; text-align: center;'>Descuento: {{$pedido[$x]['descuento']}}% Plazo: {{$pedido[$x]['plazo']}} Tipo: {{$pedido[$x]['tipo']}} Subtotal: ${{$pedido[$x]['subtotal']}} Evento: {{$pedido[$x]['evento']}}</th>
                                @endif
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                            @else
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                @if($tranIds != null)
                                    <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'>Descuento: {{$pedido[$x]['descuento']}}% Plazo: {{$pedido[$x]['plazo']}} Tipo: {{$pedido[$x]['tipo']}} Subtotal: ${{$pedido[$x]['subtotal']}} Evento: {{$pedido[$x]['evento']}} TranID: {{$tranIds[$x]}}</th>
                                @else
                                    <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'>Descuento: {{$pedido[$x]['descuento']}}% Plazo: {{$pedido[$x]['plazo']}} Tipo: {{$pedido[$x]['tipo']}} Subtotal: ${{$pedido[$x]['subtotal']}} Evento: {{$pedido[$x]['evento']}}</th>
                                @endif
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                            @endif
                            </tr>
                        @endif
                        @for($y=0; $y < count($pedido[$x]['items']); $y++)
                            <tr>
                                <td style='padding: 2px; text-align: center;'>{{$y+1}}</td>
                                <td style='padding: 2px; text-align: center;'>{{$pedido[$x]['items'][$y]['itemid']}}</td>
                                <td style='padding: 2px; text-align: center;'>{{$pedido[$x]['items'][$y]['cantidad']}}</td>
                                <td style='padding: 2px; text-align: center;'>{{$pedido[$x]['items'][$y]['purchasedescription']}}</td>
                                <td style='padding: 2px; text-align: center;'>${{$pedido[$x]['items'][$y]['price']}}</td>
                                <td style='padding: 2px; text-align: center;'>{{$pedido[$x]['items'][$y]['promo']}}%</td>
                                <td style='padding: 2px; text-align: center;'>${{$pedido[$x]['items'][$y]['precioUnitario']}}</td>
                                <td style='padding: 2px; text-align: center;'>${{$pedido[$x]['items'][$y]['importe']}}</td>
                            </tr>
                        @endfor
                    @endfor

                </table>

                <br>

                <fieldset class="scheduler-border" style="min-height: 140px !important">
                    <legend class="scheduler-border">Detalles Pedido</legend>
                    <h5><strong>SUBTOTAL:</strong> <span style="float: right; text-align: right">${{$detallesPedido['subtotal']}}</span></h5>
                    <h5><strong>IVA:</strong> <span style="float: right; text-align: right">${{$detallesPedido['iva']}}</span></h5>
                    <h5><strong>TOTAL:</strong> <span style="float: right; text-align: right">${{$detallesPedido['total']}}</span></h5>
                </fieldset>
</body>
</html> 