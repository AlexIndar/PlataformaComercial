<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Captura de errores</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/customers/img/png/favicon.png') }}">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/almacen/css/consolidado.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>  
    <div class="container-fluid">
        <div class="row">
			<div class="col col-12" style="background: linear-gradient(to right, #679acf, #5dade2); color: white" >
				<div class="row justify-content-between">
                   <div class="col-6 mt-4 mb-4">
                        <h1>Captura de errores</h1>
                   </div>
                   <div class="col-3 mt-4 mb-4 text-right">
                        <img id="logo" src="{{asset('assets/almacen/img/logo_indar.png')}}" alt="">
                   </div>
                </div>
			</div>
		</div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-5">
                        <div class="row" style="border: 1px solid gray;">
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="articulo" class="col-sm-3 col-form-label">Articulo:</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="articulo" placeholder="Codigo articulo" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="cantidad" class="col-sm-3 col-form-label">Cantidad:</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" id="cantidad" placeholder="Cantidad" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="pedido" class="col-sm-3 col-form-label">Pedido:</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="pedido" placeholder="Numero de pedido o Cons" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="surtidor" class="col-sm-3 col-form-label">Surtidor:</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="surtidor" placeholder="Usuario de surtido o consolidado" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="tipoError" class="col-sm-3 col-form-label">Error:</label>
                                    <div class="col-sm-9">
                                        <select name="tipoError" id="tipoError" class="form-control">
                                            <option value="Cambiado">Cambiado</option>
                                            <option value="Faltante">Faltante</option>
                                            <option value="Dañado">Dañado</option>
                                            <option value="Sobrante">Sobrante</option>
                                            <option value="Consolidado">Consolidado</option>
                                            <option value="Empaque">Empaque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="mesa" class="col-sm-3 col-form-label">Mesa:</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" id="mesa" placeholder="Mesa de empaque" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group row">
                                    <label for="usuario" class="col-sm-3 col-form-label">Usuario:</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="usuario" placeholder="Usuario que reporta" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2 mb-2">
                                <button type="button " class="btn btn-block btn-primary" onclick="capturaErroresController.capturaError()">Enviar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row mt-2">
                            <div class="col-8 ">
                                <button type="button " class="btn btn-block btn-primary" onclick="capturaErroresController.actualizar()" style="background: gray; border: 1px solid gray">Actualizar</button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-block btn-warning" onclick="capturaErroresController.consultaCaptura()">Consultar</button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 responsive">
                                <table class="table table-hover" style="font-size: 6px;">
                                    <thead style="background-color: #5dade2;color: white;">
                                        <tr>
                                            <th class="text-center p-0">Articulo</th>
                                            <th class="text-center p-0">Cantidad</th>
                                            <th class="text-center p-0">Pedido</th>
                                            <th class="text-center p-0">Surtidor</th>
                                            <th class="text-center p-0">Error</th>
                                            <th class="text-center p-0">Mesa</th>
                                            <th class="text-center p-0">Usuario</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-weight: bold" id="table-content-captura-errores">
                                        @foreach($errores as $error)
                                        <tr>
                                            <td class="text-center p-0">{{$error->articulo}}</td>
                                            <td class="text-center p-0">{{$error->cantidad}}</td>
                                            <td class="text-center p-0">{{$error->pedido}}</td>
                                            <td class="text-center p-0">{{$error->surtidor}}</td>
                                            <td class="text-center p-0">{{$error->tipoError}}</td>
                                            <td class="text-center p-0">{{$error->mesa}}</td>
                                            <td class="text-center p-0">{{$error->usuario}}</td>
                                            <td class="text-center p-0"><button type="button " class="btn btn-block btn-primary btn-sm" data-iderror="{{$error->idError}}" onclick="capturaErroresController.modalError(this)">Cerrar</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="ConsultaCaptura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Historico de Registros Capturados</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-12">
                <div class="row mt-3">
                    <div class="col-12 responsive">
                        <table class="table table-hover" style="font-size: 6px;">
                            <thead style="background-color: #5dade2;color: white;">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Articulo</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Pedido</th>
                                    <th class="text-center">SurtidorRR</th>
                                    <th class="text-center">Error</th>
                                    <th class="text-center">Mesa</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Facilitador</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: bold" id="table-content-consulta">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="modalError" tabindex="-1" role="dialog" aria-labelledby="myLrgeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-incidencia"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="idErrorInput" hidden>
                <div class="col-12 mt-2">
                    <div class="form-group row">
                        <label for="user" class="col-sm-3 col-form-label" style="font-weight: bold">Usuario:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="user" placeholder="Usuario" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label" style="font-weight: bold">Contraseña:</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="password" placeholder="**********">
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <div class="form-group row">
                        <label for="comentarios" class="col-sm-3 col-form-label" style="font-weight: bold">Comentarios:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="comentarios" id="comentarios" cols="30" rows="10" placeholder="Observaciones o comentarios"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="capturaErroresController.requestLogin()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
 <!-- jQuery {{asset('assets/js/scripts.js')}} -->
 <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
 <!-- Bootstrap 4 -->
 <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script src="{{asset('assets/almacen/js/capturaErroresController.js')}}"></script>
</body>
</html>