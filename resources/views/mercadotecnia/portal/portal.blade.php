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
            <h2 class='sectionTitle'>Banner Principal</h2>
            <ul class="drag-sort-enable" id='ul-hero'>
            @for($x=1; $x <= count($heroImages); $x++)
                <li class="drag-sort-item divImg">
                    <img loading="lazy" class="imageOnServer-hero" src="{{asset('assets/mercadotecnia/Hero/'.$heroImages[$x-1]->getBasename())}}" alt="">
                    <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
                </li>
            @endFor
            </ul>
            <div class="actions">
                <button class="btn-add" onclick="activeModal('modalAddElement', 'hero')">Agregar</button>
            </div>
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
                    <h4 id="h4-modalAddElement">Agregar imagen</h4>
                    <i style="cursor:pointer;" class="fas fa-times" onclick="closeModal('modalAddElement')"></i>
                </div>
                <div class="modal-body">
                    <input type="file" name="newFileImage" id="newFileImage" accept=".jpg, .jpeg, .png, .webp">
                </div>
                <div class="modal-footer">
                    <div class="spinner-border text-secondary" style="display:none; margin-right: 15px; width: 25px; height: 25px; margin-top: 2px;" id="btnSpinner" ></div>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('modalAddElement')">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="storeNewAction()">Agregar</button>
                </div>
                </div>
            </div>
        </div>


@endsection
