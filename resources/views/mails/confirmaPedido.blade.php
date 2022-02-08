<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
</head>
<body>
    <h4>Confirmación de pedido</h4>
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
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'>Descuento: {{$pedido[$x]['descuento']}}% Plazo: {{$pedido[$x]['plazo']}} Tipo: {{$pedido[$x]['tipo']}} Subtotal: ${{$pedido[$x]['subtotal']}}</th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#fcbf49; padding: 2px; text-align: center;'></th>
                            @else
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'></th>
                                <th style='background-color:#002868; color:white; padding: 2px; text-align: center;'>Descuento: {{$pedido[$x]['descuento']}}% Plazo: {{$pedido[$x]['plazo']}} Tipo: {{$pedido[$x]['tipo']}} Subtotal: ${{$pedido[$x]['subtotal']}}</th>
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