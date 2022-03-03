<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud</title>
    <style>
        body {
            background-color: #eaeced;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif
        }

        .container-principal {
            min-width: 320px;
            margin: auto;
            width: 70%;
            margin-top: 20px;
        }

        .row-principal {
            background-color: white;
        }

        .row-img {
            background-color: #57BFBF;
            width: 100%;
            text-align: center;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .row-body {
            text-align: center;
            padding-top: 30px;
            padding-bottom: 50px;
        }

        hr {
            width: 80%;
            color: #FFC61E;
        }
    </style>
</head>

<body>
    <div class="container-principal">
        <div class="row-principal">
            <div class="col-principal" style='padding: 15px;'>
                <div class="row-img">
                    <br>
                    <br>
                    <a class="img-indar" href="http://indarweb.dyndns.org:8080/" target="_blank"><img src="data:image/png;base64,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" alt="Indar"></a>
                    <br>
                    <br>
                </div>
                <div class="row-body">
                    <br>
                    <br>
                    <p>Solicitud No. <b>{{$folio}}</b>: {{$status}} para <b>{{$tipoSol}}</b> ingresada</p>
                    <hr>
                    <p>No. de Cliente: <b>{{$cliente}}</b></p>
                    <p>Razon Social: <b>{{$razonSocial}}</b></p>
                    <p>RFC: <b>{{$rfc}}</b></p>
                    <p>Zona: <b>{{$zona}}</b></p>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="row-footer">
            <p>Ferreteria Indar, S.A. de C.V. , 2018. &nbsp; All Rights Reserved.</p>
        </div>
    </div>
</body>

</html>