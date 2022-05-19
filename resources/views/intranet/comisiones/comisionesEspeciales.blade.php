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
                    <div class="col-12">
                     <h4>
                         <i class="fas fa-tags"></i> Carga de Especiales
                         <small class="float-right"><?php echo "Fecha :  " . date("d/m/Y") . "<br>"; ?></small>
                     </h4>
                    </div>
                 </div>
                 <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <a href="{{ asset('plantillas/plantillaespeciales.xlsx') }}" download="plantillaespeciales.xlsx"><button class="btn btn-primary"> Descargar Plantilla Especiales</button></a>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="importarCodigos" class="btn btn-success" onclick="triggerInputEsp()"><i class="fas fa-file-excel"></i> Importar</button>
                        <input type="file" name="excelEspeciales" id="excelEspeciales" accept=".csv, .xls, .xlsx" hidden>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <a href="{{ asset('plantillas/plantillaarticulos.xlsx') }}" download="plantillaarticulos.xlsx"><button class="btn btn-primary"> Descargar Plantilla Artículos</button></a>
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="importarCodigos" class="btn btn-success" onclick="triggerInputArt()"><i class="fas fa-file-excel"></i> Importar</button>
                        <input type="file" name="excelArticulos" id="excelArticulos" accept=".csv, .xls, .xlsx" hidden>
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

 const fileSelector = document.getElementById('excelEspeciales');
 fileSelector.addEventListener('change', (event) => {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function() {
         var fileData = reader.result;
         var wb = XLSX.read(fileData, { type: 'binary' });
         var rowObj = XLSX.utils.sheet_to_json(wb.Sheets[wb['SheetNames'][0]]);
         var jsonObj = JSON.stringify(rowObj);
         cargarEspecialesExcel(jsonObj);
     };
     reader.readAsBinaryString(input.files[0]);
 });

 const fileSelector2 = document.getElementById('excelArticulos');
 fileSelector2.addEventListener('change', (event) => {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function() {
         var fileData = reader.result;
         var wb = XLSX.read(fileData, { type: 'binary' });
         var rowObj = XLSX.utils.sheet_to_json(wb.Sheets[wb['SheetNames'][0]]);
         var jsonObj = JSON.stringify(rowObj);
         cargarArticulosExcel(jsonObj);
     };
     reader.readAsBinaryString(input.files[0]);
 });

});

function triggerInputEsp() {
    document.getElementById('excelEspeciales').click();
}

function triggerInputArt() {
    document.getElementById('excelArticulos').click();
}

function cargarEspecialesExcel(json) {

    var currentTime = new Date();
    var year = currentTime.getFullYear();
    var month = currentTime.getMonth();
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
    jsonEspeciales = JSON.parse(jsonEspeciales);
    json = jsonEspeciales;
    //console.log(jsonEspeciales);

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
            //console.log(data);
            Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Se cargarón los Especiales Correctamente ',
            showConfirmButton: false,
            timer: 5000
          })
        },
        error: function() {
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

function cargarArticulosExcel(json) {

    var json;
    jsonCompleto = [];
    data = [];
    jsonObj = JSON.parse(json);
    cantItemsPorCargar = jsonObj.length;
    var property = '';
    //let claves = Object.keys(jsonObj[0]);

    for ( var x=0 ; x < jsonObj.length; x++ ){
        //

       data.push(jsonObj[x]);
    }
    jsonCompleto.push({ ArtEspeciales: data});
    //console.log(jsonCompleto)
    json = JSON.stringify(jsonCompleto);
    json = json.slice(1, -1)
    //console.log(json);
    json = JSON.parse(json);
    json = json.ArtEspeciales;
    console.log(json);

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
            console.log(data);
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
