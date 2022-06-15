<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('assets/customers/img/png/favicon.png') }}">
    <link rel="stylesheet" href="{{env('APP_URL')}}assets/exporta/css/pedidos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ env('APP_URL') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   

    <title>exporta - pedidos</title>
</head>
<body>
<div class="container-fluid">
    <div id="cover-spin"></div>
    <div class="col-12 mt-4">
        <div class="row mt-3  justify-content-center">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary page">Pedido</button>
                <button type="button" class="btn btn-primary page">Precios</button>
                <button type="button" class="btn btn-primary page">Clientes</button>
                <button type="button" class="btn btn-primary page">O.C Pendientes</button>
                <button type="button" class="btn btn-primary page">Paquetes</button>
            </div>
        </div>
        <hr>
        <div class="row" id="Pedido">
            <div class="col-12">
                <div class="row">
                    <div class="col-4 text-center div-titulo">
                        <h3 class="titulo">FERRETERIA INDAR, S.A DE C.V <br>
                        FORMATO DE PEDIDO
                        </h3>
                    </div>
                    <div class="col-4">
                        <img class="img-log" src="{{env('APP_URL')}}assets/exporta/img/Logo-INDAR-2019.png" width="70%"alt="">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="row mt-1 justify-content-center">
                                    <button type="button" class="btn btn-secondary btn-xs btn-block">Actualizar</button>
                                </div>
                                <div class="row mt-1 justify-content-center">
                                    <button type="button" class="btn btn-secondary btn-xs btn-block">Limpiar Pedido</button>
                                </div>
                                <div class="row mt-1 justify-content-center">
                                    <button type="button" class="btn btn-secondary btn-xs btn-block">Generar Pedido</button>
                                </div>
                            </div>
                            <div class="col-8 mt-1">
                                <div class="row">
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-1"></button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-2"></button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-3"></button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-4"></button>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-5"></button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-6"></button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-7"></button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-secondary icon-8"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3 div-fecha">
                        <strong>Fecha: </strong> 
                        <strong>
                                <script>
                                date = new Date();
                                let day = date.getDay();
                                let month = date.toLocaleString("es-ES",{month: "long"});
                                let year = date.getFullYear(); 
                                document.write(day +' de '+ month +' del '+ year);
                            </script>
                        </strong>
                    </div>
                </div>
                <div class="row mt-3 " >
                    <div class="col-6" style="border: 2px solid black">
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">CLIENTE</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01">
                                        <option selected></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">NOMBRE</label>
                                    </div>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">DOMICILIO</label>
                                    </div>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">CIUDAD</label>
                                    </div>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">ESTADO</label>
                                    </div>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">PLAZO DIAS</label>
                                    </div>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">FORMA DE PAGO</label>
                                    </div>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="border: 2px solid black;font-size: 12px;">
                                <div class="row text-center" >
                                    <div class="col-12">
                                        <strong>CENTRO DE ATENCION A CLIENTES</strong>
                                    </div>
                                </div>
                                <div class="row text-center ml-2">
                                    <div class="col-12">
                                    <label>
                                        CDI TEL FAX GDL(33) 5000-2200   01800-87-46327  <br>
                                        SUCURSAL CALZADA INDEPENDENCIA (33) 5000-2240 <br>
                                        AGUASCALIENTES (449) 915-7310 FAX (449) 916-0916
                                    </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3" >
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-9" style="background-color: yellow; border: 2px solid black">
                                        <strong for="inputGroupSelect01">Enviar a:</strong>
                                    </div>
                                    <div class="col-3 text-center" style="border:2px solid black">
                                        <label for="inputGroupSelect01">0.00</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-3" style="background-color: yellow; border: 2px solid black">
                                <strong for="inputGroupSelect01">DESPP</strong>
                            </div>
                            <div class="col-3" style="background-color: yellow; border: 2px solid black">
                                <strong for="inputGroupSelect01">DESNEG</strong>
                            </div>
                            <div class="col-3 text-right" style="border: 2px solid black" >
                                <strong for="inputGroupSelect01" >SUMA</strong>
                            </div>
                            <div class="col-3 text-center" style="border: 2px solid black">
                                <label for="inputGroupSelect01" id="Suma">0.00</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9 text-right" style="border: 2px solid black">
                                <strong for="inputGroupSelect01">IVA</strong>
                            </div>
                            <div class="col-3 text-center" style="border: 2px solid black">
                                <label for="inputGroupSelect01" id="textIva">0.00</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-center" style="background-color: yellow; border: 2px solid black">
                                <strong for="inputGroupSelect01">PLAZO</strong>
                            </div>
                            <div class="col-3 text-right" style="border: 2px solid black">
                                <strong for="inputGroupSelect01" >TOTAL</strong>
                            </div>
                            <div class="col-3 text-center" style="border: 2px solid black">
                                <label for="inputGroupSelect01" id="SumaTotal">0.00</label>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-3 pl-1">
                        <div class="row">
                            <div class="col-12 pd-0">
                                <div class="d-flex align-items-end">
                                    <div class="col-3 text-center ml-2" style="border: 2px solid black;margin-top: 6.7rem;">
                                        <label for="inputGroupSelect01">0.00</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-left pd-0">
                        <button type="button" class="btn btn-primary mb-2" onclick="exportaController.addRow()"><strong>+</strong></button>
                        <table class="table" id="table-pedidos" >
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">PRODUCTO</th>
                                <th scope="col">CANT</th>
                                <th scope="col">UNIDAD</th>
                                <th scope="col">EMP</th>
                                <th scope="col">EXISTENCIA</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">PRECIO LISTA</th>
                                <th scope="col">PROMO</th>
                                <th scope="col">PRECIO VENTA</th>
                                <th scope="col">IMPORTE</th>
                                <th scope="col">PRECIO CON IVA INC</th>
                                <th scope="col">PRECIO CON PP INC</th>
                                <th scope="col">OBSERVACIONES</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="table-content-pedidos" hidden>
                                <tr id="row0">
                                    <td>0</td>
                                    <td style="background-color: #04d1db" id="prod0" data-row="0" onclick="exportaController.showInputProd(this)" width="10%">
                                        <input type="text" id="inputProd0" style="width: 100%;height: 50px;" class="form-control" data-row="0" onchange="exportaController.changeProducto(this)" onkeyup="this.value = this.value.toUpperCase()" hidden>
                                    </td>
                                    <td style="background-color: #04d1db" id="cant0" data-row="0" onclick="exportaController.showInputCant(this)" width="5%">
                                        <input type="number" id="inputCant0" style="width: 100%" class="form-control" data-row="0" onchange="exportaController.changeCant(this)"   hidden>
                                    </td>
                                    <td id="unidad0"></td>
                                    <td id="emp0"></td>
                                    <td id="existencia0"></td>
                                    <td id="descripcion0"></td>
                                    <td id="precioLista0">0.00</td>
                                    <td style="background-color: blanchedalmond" id="promo0">0.00</td>
                                    <td style="background-color: #db0404; color: white" id="precioventa0">0.00</td>
                                    <td id="importe0">0.00</td>
                                    <td id="iva0">0.00</td>
                                    <td id="pp0">0.00</td>
                                    <td id="observaciones0"></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-row="0" onclick="exportaController.deleteRow(this)">X</button>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="Precios" hidden>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 ">
                        <table class="table table-hover table-responsive" id="table-precios">
                            <thead>
                                <tr>
                                    <th>Clave Fabricante</th>
                                    <th>Articulo</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Moneda</th>
                                    <th>Promoción</th>
                                    <th>Unidad</th>
                                    <th>Existencias</th>
                                    <th>Categoria</th>
                                    <th>Multiplo</th>
                                    <th>IVA</th>
                                    <th>Proveedor</th>
                                    <th>Familia</th>
                                    <th>Linea</th>
                                    <th>Empaque</th>
                                    <th>Precio 7</th>
                                    <th>Precio 8</th>
                                    <th>Precio 10</th>
                                    <th>Precio 2</th>
                                    <th>Precio 3</th>
                                    <th>Minimo</th>
                                </tr>
                            </thead>
                            <tbody id="table-content-precios">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/exporta/js/exportaController.js')}}"></script>

</body>
</html>
