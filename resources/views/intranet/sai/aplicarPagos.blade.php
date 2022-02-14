@extends('layouts.intranet.main', ['active' => 'CXC', 'permissions' => $permissions])

@section('title') Indar - CXC | Aplicar Pagos @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection

@section('body')

<div class="content-wrapper" style="min-height: 2128.12px;">
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h1 class="m-0">Aplicar Pagos</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">CxC</a></li>
                   <li class="breadcrumb-item active">Aplicar Pagos</li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <div class="content">
       <div class="container-fluid">
          <div class="row">
             <div class="col-lg-4">
                <div class="card">
                   <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                         <h3 class="card-title">Controles</h3>
                      </div>
                   </div>
                   <div class="card-body">
                    <div class="form-group">
                    <form id="myForm">
                    <div class="form-check form-check-inline form-group">
                        <input class="form-check-input" type="radio" name="radiobtn" id="radioZona" value="zona"  checked>
                        <label class="form-check-label" for="inlineRadio1">Zona</label>
                     </div>
                     <div class="form-check form-check-inline form-group">
                        <input class="form-check-input" type="radio" name="radiobtn" id="radioCliente" value="cliente">
                        <label class="form-check-label" for="inlineRadio2">Cliente</label>
                     </div>
                    </form>
                        <div class="form-group zonas" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Zona: </label>
                            <select class="js-example-basic-single form-control" id="zonas" name="zonas"  data-live-search="true">
                            </select>
                        </div>
                        <div class="form-group clientes" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Clientes: </label>
                            <select class="js-example-basic-single form-control" id="clientes" name="clientes" data-live-search="true">
                            </select>
                        </div>
                   <div class="col-auto text-center">
                    <button type="submit" class="btn btn-success mb-3"   onclick="consultar()" id="btnConsultar"> Consultar</button>
                   </div>
                </div>
                   <hr>
                   <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Pagos</h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <table id="pagosTable" class="table table-striped table-bordered" style=" width:100%">
                            <thead>
                               <tr>
                                  <th>Pago</th>
                                  <th>SaldoPendiente</th>
                                  <th>Cliente</th>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                  <td>Ejemplo</td>
                                  <td>Ejemplo</td>
                                  <td>Ejemplo</td>
                               </tr>
                            </tbody>
                         </table>
                         <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Cliente: </label>
                            <input class="form-control form-control-sm" type="text" placeholder="Ingrese Nombre de Cliente" name="cliente"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Cob: </label>
                            <input class="form-control form-control-sm" type="text"  name="cob"/>
                            <label class="form-control-sm">Ven: </label>
                            <input class="form-control form-control-sm" type="text" name="ven"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Zona: </label>
                            <input class="form-control form-control-sm" type="text"name="zona"/>
                            <label class="form-control-sm">Limite: </label>
                            <input class="form-control form-control-sm" type="text" name="limite"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Pago: </label>
                            <input class="form-control form-control-sm" type="text"name="pago"/>
                            <label class="form-control-sm">Actual: </label>
                            <input class="form-control form-control-sm" type="text" name="actual"/>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">SAT: </label>
                            <select class="form-control js-example-basic" id="select-sat" data-live-search="true">
                                <option data-tokens="0">Seleccione Opción</option>
                                <option data-tokens="1">Opcion2</option>
                                <option data-tokens="2">Opcion3</option>
                             </select>
                        </div>
                        <div class="col-auto text-center">
                            <button type="btn" class="btn btn-success mb-3">Excel</button>
                            <button type="btn" class="btn btn-secondary mb-3">Netsuite</button>
                         </div>
                    </div>
                </div>
             </div>
             </div>
             <div class="col-lg-8">
                <div class="card-body table-responsive p-0">
                   <table id="aplicarPagos" class="table table-striped table-bordered" style="width:100% ; font-size:90%">
                      <thead>
                         <tr>
                            <th>NumDoc</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                            <th>FechaRecibo</th>
                            <th>Terminos</th>
                            <th>Vencimiento</th>
                            <th>DescuentoFact</th>
                            <th>ImporteBruto</th>
                            <th>SaldoPendiente</th>
                            <th>Porcentaje</th>
                            <th>DescuentoTotal</th>
                            <th>APagar</th>
                            <th>DIFFECHA</th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                            <td>Ejemplo</td>
                         </tr>
                      </tbody>
                   </table>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
@endsection

@section('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script>


    $(document).ready(function() {

        $('#aplicarPagos').DataTable();
        //$('#pagosTable').DataTable();


        //Recibe Json
        var zonas = JSON.parse({!! json_encode($zonas) !!});
        var clientes = JSON.parse({!! json_encode($clientes) !!});


        //Llena select zonas
        $('.js-example-basic-single').select2();

        var $selectZonas = $('#zonas');
        $.each(zonas, function(id, name) {
            $selectZonas.append('<option value=' + name.id + '>'+ name.id + '&nbsp|&nbsp'+ name.zona+'</option>');
        });
        //Llena select Clientes
        var $selectClientes = $('#clientes');
        $.each(clientes, function(id, name) {
            $selectClientes.append('<option value=' + name.internalid + '>'+ name.internalid + '&nbsp|&nbsp'+ name.companyId+'</option>');
        });

        //RadioButtons
        $("div.clientes").hide();
        $("input[name$='radiobtn']").click(function() {
        var test = $(this).val();
        if(test == 'cliente'){
            $("div.clientes").show();
            $("div.zonas").hide();
        }else{
            $("div.clientes").hide();
            $("div.zonas").show();
        }
        });

    });
    function consultar() {
        //var x = document.getElementById("zonas").value;
        var selectedRadio = $('input[name=radiobtn]:checked', '#myForm').val()
        if(selectedRadio === 'zona'){
            var idZona = document.getElementById("zonas").value;
            console.log(idZona);
        }else{
            var idCliente = document.getElementById("clientes").value;
            console.log(idCliente);
        }
    }
</script>
@endsection
