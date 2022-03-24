<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos con Error en Netsuite</title>
</head>
<body>



                    @for($x=0; $x < count($data); $x++)
                        @if($data[$x]['status']=="NOK")
                            <div class="row mt-3">
                                <p><strong>ID WEB: </strong>{{json_decode($data[$x]['json'])->idWeb}}</p>
                                <p><strong>MENSAJE: </strong>{{$data[$x]['message']}}</p>
                                <p><strong>JSON: </strong>{{$data[$x]['json']}}</p>
                            </div>
                            <hr style='width: 100%; height:1px;border:none;color:#002868; background-color:#002868;'>
                        @endif
                    @endfor

               
</body>
</html> 