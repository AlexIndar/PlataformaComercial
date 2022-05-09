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
    selectedItemsFromInventory=[];
    especiales = [];
    cuotas = [];

    selectedItemsFromInventory.push({ ejercicio: 2022, aperiodo: 4, especiales });

    jsonObj = JSON.parse(json);

    cantItemsPorCargar = jsonObj.length;
    for (var x = 0; x < jsonObj.length; x++) {
        especiales.push({ cons: jsonObj[x]['Zona'], nombre: jsonObj[x]['E01'], tipo : jsonObj[x]['pesos'], cuotas });
        cuotas.push({ zona: jsonObj[x]['Zona'], cuota: jsonObj[x]['E01'] });
    }

    console.log(selectedItemsFromInventory);

    document.getElementById("excelEspeciales").value = "";
}

function cargarArticulosExcel(json) {
    articulosJson = [];
    articulo = [];

    articulosJson.push({ especial: 1 , articulo });

    jsonObj = JSON.parse(json);
    cantItemsPorCargar = jsonObj.length;
    for (var x = 0; x < jsonObj.length; x++) {
        articulo.push({ valor: jsonObj[x]['E1'] });
    }

    console.log(JSON.stringify(articulosJson));

    document.getElementById("excelArticulos").value = "";
}




</script>
@endsection
