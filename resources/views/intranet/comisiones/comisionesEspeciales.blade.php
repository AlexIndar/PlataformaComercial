@extends('layouts.intranet.main', ['active' =>'Comisiones', 'permissions' => $permissions])
@section('title') Indar | Comisiones @endsection
@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('body')
<div class="content-wrapper" style="min-height: 316px;">
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
          </div>
       </div>
    </div>
    <section class="content">
     <div class="container-fluid">
        <div class="row">
           <div class="col-12">
              <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-md-12 form-group">
                     <h4>
                         <i class="fas fa-tags"></i> Carga de Especiales
                         <small class="float-right"><?php echo "Fecha :  " . date("d/m/Y") . "<br>"; ?></small>
                     </h4>
                    </div>
                 </div>
                 <div class="row form-group">
                    <div id="divEjercicio" class="input-group col-md-3 ">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="ejercicio">Ejercicio</label>
                        </div>
                        <select class="custom-select" id="selectEjercicio">
                            <option value="2022" selected>2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                        </select>
                    </div>
                    <div id="divPeriodo" class="input-group col-md-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="periodo">Periodo</label>
                        </div>
                        <select class="custom-select" id="selectPeriodo">
                            <option value="0" selected>Seleccione el Periodo</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="spinner-border text-secondary" style="display:none" id="btnSpinner" ></div>
                        <button type="submit" class="btn btn-secondary" style="background-color:#002868"  style="display: block" id="btnConsultar">Cargar Especiales</button>
                        <button type="submit" class="btn btn-secondary" style="background-color:#002868; display: none"  onclick="refresh()" id="btnRefresh">Cargar Otro Periodo</button>
                    </div>
                </div>
                <hr>
                <div id="divEspeciales" style="display:none" class="row">
                    <div class="col-md-auto">
                        <a href="{{ asset('plantillas/plantillaespeciales.xlsx') }}" download="plantillaespeciales.xlsx"><button class="btn btn-primary"> Descargar Plantilla Especiales</button></a>&nbsp;
                        <button type="button" id="importarCodigos" class="btn btn-success" onclick="triggerInputEsp()"><i class="fas fa-file-excel"></i> Importar Especiales </button> &nbsp; &nbsp;
                        <input type="file" name="excelEspeciales" id="excelEspeciales" accept=".csv, .xls, .xlsx" hidden>
                        <a href="{{ asset('plantillas/plantillaarticulos.xlsx') }}" download="plantillaarticulos.xlsx"><button class="btn btn-primary"> Descargar Plantilla Artículos</button></a>
                        <button type="button" id="importarCodigos" class="btn btn-success" onclick="triggerInputArt()"><i class="fas fa-file-excel"></i> Importar Artículos</button>
                        <input type="file" name="excelArticulos" id="excelArticulos" accept=".csv, .xls, .xlsx" hidden>
                    </div>
                </div>
                <hr>
                <div   class="col-lg-12">
                    <div class="card-body table-responsive p-0">
                       <table id="articulosTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                          <thead style="background-color:#002868; color:white">
                             <tr>
                                <th class="text-center" style="font-size:15px " colspan =3 >DETALLE</th>
                             </tr>
                             <tr>
                                 <th>Especial</th>
                                 <th>Tipo</th>
                                 <th>Valor</th>
                             </tr>
                          </thead>
                             <tbody id="bodyArt">

                             </tbody>
                       </table>
                    </div>
                 </div>
                 <hr>
                <div   class="col-lg-12">
                    <div class="card-body table-responsive p-0">
                       <table id="especialesTable" class="table table-striped table-bordered table-hover " style="width:100% ; font-size:75% ;font-weight: bold">
                          <thead style="background-color:#002868; color:white">
                             <tr>
                                <th class="text-center" style="font-size:15px " colspan =23 >ESPECIALES</th>
                             </tr>
                                <tr id="headerEspeciales">
                                </tr>
                                <tr id="headerTipo">
                                </tr>
                             </thead>
                             <tbody id="llenaCuotas">
                             </tbody>
                       </table>
                    </div>
                 </div>


              </div>
           </div>
        </div>
     </div>
    </section>
</div>
@endsection
@section('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<!-- SWAL -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    //Collapse sideBar
    $("body").addClass("sidebar-collapse");

    $( "#btnConsultar" ).click(function() {
        var ejercicio = document.getElementById('selectEjercicio').value;
        var periodo = document.getElementById('selectPeriodo').value;
        var fileSelector;
        var fileSelector2;
        //console.log(ejercicio,periodo);
        if(periodo == "0"){
            Swal.fire({
            position: 'top',
            icon: 'warning',
            title: 'Error! Seleccione un Periodo',
            showConfirmButton: false,
            timer: 5000
          })
        }else{
        $.ajax({
           'headers': {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           'url': "/comisiones/getEspecialesPorPeriodo",
           'type': 'GET',
           'dataType': 'json',
           'data': { year: ejercicio , month: periodo},
           'enctype': 'multipart/form-data',
           'timeout': 4 * 60 * 60 * 1000,
           success: function (data){
            //console.log('RespuestaAjaxEspeciales'+data);
            if(data.length == 0){
                Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Carga Tus Documentos , Periodo sin Datos',
                showConfirmButton: false,
                timer: 5000
                })
            }else{

                document.getElementById("divEspeciales").disabled = true;
                Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Se cargarón los Datos Exitosamente',
                showConfirmButton: false,
                timer: 5000
                })
                var htmlheaderEspecial = '<th></th>';
                var htmlheaderTipo = '<th>Zona</th>';
                var htmlCuotas = '';
                var htmlArticulos = '';

                for(i=0; i < data.length; i++){
                    var count = 0;
                    arrArt = [];
                    var especial = data[i].conse;
                    /* if(data[i].detalle.length == 0){
                        var artExist = 0;
                    } */
                    var artExist= data[i].detalle[0].articulos;

                    htmlheaderEspecial += '<th>'+ data[i].especialdelmes +'</th>';
                    htmlheaderTipo += '<th>'+ data[i].unidad +'</th>';
                    if(artExist.length != 0){

                        for(x=0; x< artExist.length; x++){

                           htmlArticulos += '<tr>'+
                            '<td>' + especial + '</td>'+
                            '<td>' + artExist[x].campo+ '</td>'+
                            '<td>' + artExist[x].valor+ '</td>'+
                            '</tr>';
                        }
                    }
                }
                arraryCuotas = [];

                for(x=0; x < data[0].detalle.length ; x++){
                    cuotas = [];
                    for(i=0; i < data.length; i++){
                        //console.log(data[i].detalle[x]);
                        cuotas.push(data[i].detalle[x].cuota);
                    }

                    arraryCuotas.push({zona: data[0].detalle[x].zona, cuota: cuotas});
                }

                for(i= 0; i< arraryCuotas.length; i++){
                    var tdCuotas='';
                    for(x=0; x < arraryCuotas[i].cuota.length; x++){
                        tdCuotas += '<td>'+ arraryCuotas[i].cuota[x].toLocaleString('es-MX',{minimumFractionDigits: 2, maximumFractionDigits: 2}) +'</td>';
                    }
                    htmlCuotas +='<tr>'+
                        '<td>'+ arraryCuotas[i].zona +'</td>'+
                        tdCuotas+
                        '<tr></tr>';
                }


                $('#headerEspeciales').html(htmlheaderEspecial);
                $('#headerTipo').html(htmlheaderTipo);
                $('#bodyArt').html(htmlArticulos);
                $('#llenaCuotas').html(htmlCuotas);
            }
            },
            error: function() {
            Swal.fire({
            position: 'top',
            icon: 'warning',
            title: 'Error Al cargar los Archivos',
            showConfirmButton: false,
            timer: 5000
            })
            }
        });
        }
        fileSelector = document.getElementById('excelEspeciales');
        fileSelector.addEventListener('change', (event) => {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var fileData = reader.result;
                var wb = XLSX.read(fileData, { type: 'binary' });
                var rowObj = XLSX.utils.sheet_to_json(wb.Sheets[wb['SheetNames'][0]]);
                var jsonObj = JSON.stringify(rowObj);
                cargarEspecialesExcel(jsonObj,ejercicio,periodo);
            };
            reader.readAsBinaryString(input.files[0]);
        });

        fileSelector2 = document.getElementById('excelArticulos');
        fileSelector2.addEventListener('change', (event) => {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var fileData = reader.result;
                var wb = XLSX.read(fileData, { type: 'binary' });
                var rowObj = XLSX.utils.sheet_to_json(wb.Sheets[wb['SheetNames'][0]]);
                var jsonObj = JSON.stringify(rowObj);
                cargarArticulosExcel(jsonObj,ejercicio,periodo);
            };
            reader.readAsBinaryString(input.files[0]);
        });
    });


 $(document).ajaxStart(function() {
    document.getElementById("btnSpinner").style.display = "block";
    document.getElementById("btnConsultar").style.display = "none";
 });

//Func Termina Ajax
$(document).ajaxStop(function() {
    //Esconde y muestra DIV

    document.getElementById("divEspeciales").style.display="block";
    document.getElementById("btnSpinner").style.display = "none";
    document.getElementById("btnRefresh").style.display = "block";
    document.getElementById("selectEjercicio").disabled = true;
    document.getElementById("selectPeriodo").disabled = true;

    var table2 = $('#articulosTable').DataTable();
    $('#especialesTable').DataTable();


});

});

function refresh() {
    location.reload();
}

function triggerInputEsp() {
    document.getElementById('excelEspeciales').click();
}

function triggerInputArt() {
    document.getElementById('excelArticulos').click();
}

function cargarEspecialesExcel(json, ejercicio, periodo) {

    var currentTime = new Date();
    var year = ejercicio;
    var month = periodo;
    //console.log(year,month);
    var json;
    jsonCompleto = [];
    jsonEspeciales = [];
    especiales = [];

    jsonObj = JSON.parse(json);

    let claves = Object.keys(jsonObj[0]);

    for ( var x=0 ; x < claves.length; x++ ){
        cuotas = [];
        for ( var y=2 ; y < jsonObj.length; y++){
            cuotas.push({ zona: jsonObj[y]['E00'], cuota: parseFloat(jsonObj[y]['E'+(x+1)])});
        }

        especiales.push({ cons: x+1, nombre: jsonObj[1]['E'+(x+1)], tipo : jsonObj[0]['E'+(x+1)] ,cuotas});
    }
    jsonEspeciales.push({ ejercicio: year, periodo: month, especiales });

    jsonEspeciales = JSON.stringify(jsonEspeciales);
    jsonEspeciales = jsonEspeciales.slice(1,-1);
    console.log (jsonEspeciales);
    //jsonEspeciales = JSON.parse(jsonEspeciales);
    json = jsonEspeciales;
    console.log(jsonEspeciales);
    $.ajax({
           'headers': {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           'url': "/comisiones/postActualizarEspeciales",
           'type': 'POST',
           'dataType': 'json',
           'data': { EspecialesModel: json},
           'enctype': 'multipart/form-data',
           'timeout': 4 * 60 * 60 * 1000,
           success: function (data){
            console.log(data);
            Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Se cargarón los Especiales Correctamente ',
            showConfirmButton: false,
            timer: 5000
          })

        },
        error: function() {
            console.log(data);
            Swal.fire({
            position: 'top',
            icon: 'warning',
            title: 'Error Vuelva a cargar el Archivo',
            showConfirmButton: false,
            timer: 5000
          })
        }
    });

    document.getElementById("excelEspeciales").value = "";
}

function cargarArticulosExcel(json, ejercicio, periodo) {
    var ejercicio = ejercicio;
    var periodo = periodo;
    var json;
    jsonCompleto = [];
    data = [];
    arrayEjer=[];
    jsonObj = JSON.parse(json);
    cantItemsPorCargar = jsonObj.length;
    var property = '';
    //let claves = Object.keys(jsonObj[0]);

    for ( var x=0 ; x < jsonObj.length; x++ ){
        //

       data.push(jsonObj[x]);
    }
    arrayEjer.push({ejercicio: ejercicio, periodo: periodo, detalle: data})
    arrayEjer = JSON.stringify(arrayEjer);
    arrayEjer = arrayEjer.slice(1,-1);
    //console.log(arrayEjer);
    arrayEjer = JSON.parse(arrayEjer);
    jsonCompleto.push(arrayEjer);
    //console.log(jsonCompleto)
    json = JSON.stringify(jsonCompleto);
    json = json.slice(1, -1)
    console.log(json);
    /* json = JSON.parse(json);
    json = json.ArtEspeciales;
    json = JSON.stringify(json); */
    //console.log(json);

    $.ajax({
           'headers': {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           'url': "/comisiones/postActualizarArticulosEspeciales",
           'type': 'POST',
           'dataType': 'text',
           'data': { ArtEspeciales: json},
           'enctype': 'multipart/form-data',
           'timeout': 4 * 60 * 60 * 1000,
           success: function (data){
            console.log('RespuestaAjaxArti'+data);
            Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Se cargó el Archivo Correctamente ',
            showConfirmButton: false,
            timer: 5000
          })
        },
        error: function(data) {
            console.log(data);
            Swal.fire({
            position: 'top',
            icon: 'warning',
            title: 'Error Vuelva a cargar el Archivo',
            showConfirmButton: false,
            timer: 5000
          })
        }
    });


    document.getElementById("excelArticulos").value = "";
}




</script>
@endsection
