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
                <h6 class="m-0">Aplicar Pagos</h6>
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
                         <div class="form-group cli" style="display:flex; flex-direction: row">
                            <label class="form-control-sm">Clientes: </label>
                            <select class="js-example-basic-single form-control" id="cli" name="cli"  data-live-search="true">
                            </select>
                         </div>
                         <div class="col-auto text-center">
                            <div class="spinner-border text-success" style="display:none" id="btnSpinner" ></div>
                            <button type="submit" class="btn btn-success mb-3"  style="display: block" onclick="consultar()" id="btnConsultar">Consultar </button>
                         </div>
                      </div>
                      <hr>
                      <div class="card-header border-0">
                         <div class="d-flex justify-content-between">
                            <h3 class="card-title">Pagos</h3>
                         </div>
                      </div>
                      <div class="form-group">
                         <table id="pagosTable" class="display nowrap" style="width:100%;  font-size:13px">
                            <thead>
                               <tr>
                                  <th>Pago</th>
                                  <th>SaldoPendiente</th>
                                  <th>Cliente</th>
                               </tr>
                            </thead>
                            <tbody id="tablePagos">
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
                            <input class="form-control form-control-sm" type="text" value="0" id="actual" name="actual"/>
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
                <div class="card">
                   <div class="card-header border-0">
                   </div>
                   <div class="container">
                      <table id="example" class="display nowrap" style="display:none ; font-size:13px" width="100%">
                         <thead>
                            <tr>
                               <th></th>
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
                         <tbody id="DataResult">

                        </tbody>
                      </table>
                   </div>
                </div>
                <hr>
                <div class="card">
                   <div class="container">
                      <table id="example2" class="display nowrap" width="100%">
                         <thead>
                            <tr>
                               <th></th>
                               <th>NumDoc</th>
                               <th>ImporteBruto</th>
                               <th>FacturaMonto</th>
                               <th>Final</th>
                               <th>NotaCredito</th>
                            </tr>
                         </thead>
                         <tbody id="DataT2">

                         </tbody>
                      </table>
                   </div>
                   {{-- <button class="btn btn-primary" name="refresh">Refresh</button> --}}
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

    var tablepago = $('#pagosTable').DataTable({
            dom : 'rtip',
            scrollY: "250px",
            scrollCollapse: true,
            scrollX: true,
            bPaginate: false,

        } );

        $('#tablePagos').on( 'click', 'tr', function () {

        var datapago = tablepago.rows('.selected').data();
        console.log( datapago);


        });
    //Inica Ajax
    $(document).ajaxStart(function() {
    document.getElementById("btnSpinner").style.display = "block";
    document.getElementById("btnConsultar").style.display = "none";
    document.getElementById("example").style.display = "none";
    });
    //Func Termina Ajax
    $(document).ajaxStop(function() {
        document.getElementById("btnSpinner").style.display = "none";
        document.getElementById("btnConsultar").style.display = "block";
        document.getElementById("example").style.display = "block";
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollCollapse: true,
            scrollX: true,
            pageLength: 6,
            lengthMenu: [6, 10, 20, 50, 100, 200, 500],
            columnDefs: [ {
               targets: 0,
               data: null,
               defaultContent: "<input class='form-control' type='checkbox' name='checkTable' id='checkT' >",
            } ]

        } );

        $('#example tbody').on( 'click', 'tr', function () {

        $(this).toggleClass('selected');
        var data = table.rows('selected').data();
        //console.log( data);
        //console.log(JSON.parse(JSON.stringify(data)));

        var html = '';
            var i;
            var actual ;
            var suma=0;
            for (i = 0; i < data.length; i++) {
              html += '<tr>' +
                '<td></td>' +
                '<td>' + data[i][1]+ '</td>' +
                '<td>' + data[i][8] + '</td>' +
                '<td>' + data[i][12] + '</td>' +
                '<td>' + data[i][12] + '</td>' +
                '<td>' + data[i][11] + '</td>' +
                '</tr>';
             actual = data[i][12];
             var newActual = actual.slice(1);
             newActual = parseFloat(newActual);
             console.log(newActual);
            suma= suma + newActual;
            console.log(suma);

            }
            $('#DataT2').html(html);
            document.getElementById("actual").value = suma;

        });
    });
    //Click en Columna

    var table2 = $('#example2').DataTable({
      dom: 't',
    });

    //$('#pagosTable').DataTable();

    //Recibe Json
    var zonas = JSON.parse({!! json_encode($zonas) !!});
    var clientes = JSON.parse({!! json_encode($clientes) !!});

    //Llena select zonas
    $('.js-example-basic-single').select2();

    var $selectZonas = $('#zonas');
    $.each(zonas, function(id, name) {
        $selectZonas.append('<option value=' + name.id + '>'+ name.zona+'</option>');
    });
    //Llena select Clientes
    var $selectClientes = $('#cli');
    $.each(clientes, function(id, name) {
        $selectClientes.append('<option value=' + name.internalid + '>'+  name.companyId+'</option>');
    });

//RadioButtons
    $("div.cli").hide();
    $("input[name$='radiobtn']").click(function() {
    var test = $(this).val();
    if(test == 'cliente'){
        $("div.cli").show();
        $("div.zonas").hide();
    }else{
        $("div.cli").hide();
        $("div.zonas").show();
    }
    });

});

function consultar() {
//var x = document.getElementById("zonas").value;
$("#example").dataTable().fnDestroy();
var response = [];
var selectedRadio = $('input[name=radiobtn]:checked', '#myForm').val();
var id = '';
if(selectedRadio === 'zona'){
    id = document.getElementById("zonas").value;
    console.log(id);
}else{
    var idCliente = document.getElementById("cli").value;
    id = 'C'+idCliente;

}

$.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/AplicarPagos/getRegresaPrimerosDatos",
        'type': 'GET',
        'dataType': 'json',
        'data': {Id:id},
        'enctype': 'multipart/form-data',
        'timeout': 4 * 60 * 60 * 1000,
        success: function(data){
            var html = '';
            var tablePagos = '';
            var i;
            for (i = 0; i < data.length; i++) {
                var apagar = (data[i].saldoPendiente)-(data[i].descuentoTotal);
                if(data[i].documento !== "CustPymt"){


              html += '<tr>' +
                '<td></td>' +
                '<td>' + data[i].numDoc + '</td>' +
                '<td>' + data[i].nota + '</td>' +
                '<td>' + data[i].fecha + '</td>' +
                '<td>' + data[i].fechaRecibo + '</td>' +
                '<td>' + data[i].terminos + '</td>' +
                '<td>' + data[i].vencimiento + '</td>' +
                '<td>' + data[i].descuentoCliente + '</td>' +
                '<td>$' + data[i].importeBruto + '</td>' +
                '<td>$' + data[i].saldoPendiente + '</td>' +
                '<td>' + data[i].porcentaje + '</td>' +
                '<td>$' + data[i].descuentoTotal.toFixed(2) + '</td>' +
                '<td>$' +   apagar.toFixed(2)+ '</td>' +
                '<td>?</td>' +
                '</tr>';
                }else{
                    tablePagos += '<tr>' +
                    '<td>' + data[i].numDoc + '</td>' +
                    '<td>' + data[i].saldoPendiente + '</td>' +
                    '<td>' + data[i].cliente + '</td>' +
                    '</tr>';
                }
            }
            $('#DataResult').html(html);
            $('#tablePagos').html(tablePagos);

        },
        error: function() {
            console.log("Error");
            alert('Tiempo de espera agotado');
        }
    });



}



</script>
@endsection
