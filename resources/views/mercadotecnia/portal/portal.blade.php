@extends('layouts.intranet.main', ['active' => 'Mercadotecnia', 'permissions' => $permissions])

@section('title')
    Mercadotecnia - Portal
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/mercadotecnia/css/portal.css') }}">
    <script src="{{ asset('assets/mercadotecnia/js/portal.js') }}"></script>
@endsection

@section('body')
    <div class="content-wrapper p-5">
        <div class="container">

            {{-------------------------------------------------------------------- BANNER PRINCIPAL -----------------------------------------------------------------}}
            @for($x=0; $x < count($actions); $x++)
                @if($x == 0)
                <fieldset>
                    <legend>{{$actions[$x]['portalMkt_']['seccion']}}</legend>
                    <ul class="drag-sort-enable" id='ul-{{$actions[$x]['portalMkt_']['seccion']}}'>
                        <li class="drag-sort-item divImg" onclick="activeModal('modalEditElement', '{{$actions[$x]['portalMkt_']['seccion']}}', this)">
                            <img loading="lazy" class="image-{{$actions[$x]['portalMkt_']['seccion']}} imageOnServer" id="{{$actions[$x]['portalMkt_']['seccion']}}/{{$actions[$x]['portalMkt_']['filename']}}" src="{{asset($routeImages.'/'.$actions[$x]['portalMkt_']['seccion'].'/'.$actions[$x]['portalMkt_']['filename'])}}" alt="">
                            <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
                        </li>
                        
                @else
                @if($actions[$x]['portalMkt_']['seccion'] == $actions[$x-1]['portalMkt_']['seccion'])
                        <li class="drag-sort-item divImg" onclick="activeModal('modalEditElement', '{{$actions[$x]['portalMkt_']['seccion']}}', this)">
                            <img loading="lazy" class="image-{{$actions[$x]['portalMkt_']['seccion']}} imageOnServer" id="{{$actions[$x]['portalMkt_']['seccion']}}/{{$actions[$x]['portalMkt_']['filename']}}" src="{{asset($routeImages.'/'.$actions[$x]['portalMkt_']['seccion'].'/'.$actions[$x]['portalMkt_']['filename'])}}" alt="">
                            <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
                        </li>
                @else
                        <div class="actions">
                            <button class="btn-add" onclick="activeModal('modalAddElement', '{{$actions[$x-1]['portalMkt_']['seccion']}}')">Agregar</button>
                        </div>
                    </ul>
                </fieldset>
                <fieldset>
                    <legend>{{$actions[$x]['portalMkt_']['seccion']}}</legend>
                    <ul class="drag-sort-enable" id='ul-{{$actions[$x]['portalMkt_']['seccion']}}'>
                        <li class="drag-sort-item divImg" onclick="activeModal('modalEditElement', '{{$actions[$x]['portalMkt_']['seccion']}}', this)">
                            <img loading="lazy" class="image-{{$actions[$x]['portalMkt_']['seccion']}} imageOnServer" id="{{$actions[$x]['portalMkt_']['seccion']}}/{{$actions[$x]['portalMkt_']['filename']}}" src="{{asset($routeImages.'/'.$actions[$x]['portalMkt_']['seccion'].'/'.$actions[$x]['portalMkt_']['filename'])}}" alt="">
                            <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
                        </li>
                @endif
                @endif
                
            @endFor

            
             {{------------------------------------------------------------------------- EVENTOS ---------------------------------------------------------------------}}

             {{-- <fieldset>
                <legend>Eventos</legend>
                <ul class="drag-sort-enable" id='ul-Eventos'>
                @for($x=1; $x <= count($eventosImages); $x++)
                    <li class="drag-sort-item divImg" onclick="activeModal('modalEditElement', 'Eventos', this)">
                        <img loading="lazy" class="image-eventos imageOnServer" id='Eventos/{{$eventosImages[$x-1]->getBasename()}}' src="{{asset('assets/mercadotecnia/Temp/Eventos/'.$eventosImages[$x-1]->getBasename())}}" alt="">
                        <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
                    </li>
                @endFor
                </ul>
                <div class="actions">
                    <button class="btn-add" onclick="activeModal('modalAddElement', 'Eventos')">Agregar</button>
                </div>
            </fieldset> --}}


            <br><br>
            <div class="actions">
                <button class="btn-save" onclick="preview()">Preview</button>
                <button class="btn-save" onclick="saveChanges()">Guardar Cambios</button>
            </div>
        </div>
    </div>



    <!-- MODAL PARA AGREGAR ELEMENTO -->

        <!-- Modal -->
        <div class="modal fade" id="modalAddElement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <input type="text" value="" name="sectionElement" id="sectionElement" hidden>
                <div class="modal-header">
                    <h4 id="h4-modalAddElement">Agregar</h4>
                    <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal('modalAddElement')"></i>
                </div>
                <div class="modal-body">
                    <img loading="lazy" class="image-add-preview" id='image-add-preview' src="" alt="">
                    <input class="mt-2" type="file" name="image-add-file" id="image-add-file" accept=".jpg, .jpeg, .png, .webp">

                    <select id="select-action" name="select-action" class="form-control selectpicker mt-3" data-live-search="true">
                        <option selected value="none">Selecciona una acción</option>
                        <option class="" style="height: 30px !important;" value="Externo">Link externo</option>
                        <option class="" style="height: 30px !important;" value="Interno">Link interno</option>
                        <option class="" style="height: 30px !important;" value="Descarga">Descarga</option>
                        {{-- <option class="" style="height: 30px !important;" value="Filtro">Filtro</option> --}}
                    </select>

                    <div class="action-link-container mt-3 d-none" id="action-link-container">
                        <p>Ingresa un enlace</p>
                        <input type="text" class="w-100" id="action-link" name="action-link">
                    </div>

                    <div class="action-file-container mt-3 d-none" id="action-file-container">
                        <p>Carga un documento</p>
                        <input class="" type="file" name="action-file" id="action-file" accept=".jpg, .jpeg, .png, .webp">
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="spinner-border text-secondary" style="display:none; margin-right: 15px; width: 25px; height: 25px; margin-top: 2px;" id="btnSpinner" ></div>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('modalAddElement')">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="addNewAction()">Agregar</button>
                </div>
                </div>
            </div>
        </div>

     <!-- MODAL PARA EDITAR ELEMENTO -->

        <!-- Modal -->
        <div class="modal fade" id="modalEditElement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <input type="text" value="" name="sectionElement" id="sectionElement" hidden>
                <div class="modal-header">
                    <h4 id="h4-modalEditElement">Editar</h4>
                    <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal('modalEditElement')"></i>
                </div>
                <div class="modal-body">
                    <img loading="lazy" class="image-edit-preview" id='image-edit-preview' src="" alt="">
                    <p class="mt-2">Cargar nueva imagen </p>
                    <input type="file" name="image-edit-file" id="image-edit-file" accept=".jpg, .jpeg, .png, .webp">
                </div>
                <div class="modal-footer">
                    <div class="spinner-border text-secondary" style="display:none; margin-right: 15px; width: 25px; height: 25px; margin-top: 2px;" id="btnSpinner" ></div>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('modalEditElement')">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="storeNewAction()">Guardar</button>
                </div>
                </div>
            </div>
        </div>



@endsection
