@extends('layouts.intranet.main', ['active' =>'Comisiones', 'permissions' => $permissions])
@section('title') Indar | Comisiones @endsection
@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('body')
<div id = "hidde" class="content-wrapper" style="min-height: 2128.12px;">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <a href="{{ asset('assets/plantillaespeciales.xlsx') }}" download="plantillaespeciales.xlsx"><button class="btn btn-primary"> Descargar Plantilla Especiales</button></a>
            <a href="{{ asset('assets/plantillaarticulos.xlsx') }}" download="plantillaarticulos.xlsx"><button class="btn btn-primary"> Descargar Plantilla Artículos</button></a>
         </div>
      </div>
   </div>
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


   });



</script>
@endsection
