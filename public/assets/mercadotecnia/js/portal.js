let imagesHero = [];
let imagesEventos = [];
let actions = [];

$('document').ready(function () {


    if (getCookie("_mkt")) {
        if (getCookie("_mkt").includes('Error')) {
            var toast = Swal.mixin({
                toast: true,
                icon: 'error',
                title: 'General Title',
                animation: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            toast.fire({
                animation: true,
                title: 'Error actualizando portal',
                icon: 'error'
            });
        }
        else {
            var toast = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            toast.fire({
                animation: true,
                title: '¡Portal actualizado correctamente!',
                icon: 'success'
            });
        }
        document.cookie = '_mkt =; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    $("body").addClass("sidebar-collapse");

    (() => { enableDragSort('drag-sort-enable') })();

    $("#image-edit-file").on("change", () => {
        const imgInp = document.getElementById('image-edit-file');
        const [file] = imgInp.files;
        document.getElementById('image-edit-preview').src = URL.createObjectURL(file);
    });

    $("#image-add-file").on("change", () => {
        const imgInp = document.getElementById('image-add-file');
        const [file] = imgInp.files;
        document.getElementById('image-add-preview').src = URL.createObjectURL(file);
    });

    $('#select-action').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        let action = $("#select-action").val();
        if (action == 'Externo' || action == 'Interno') {
            document.getElementById('action-link-container').classList.remove('d-none');
            document.getElementById('action-file-container').classList.add('d-none');
            document.getElementById('action-file-preview').classList.add('d-none');
            document.getElementById('action-file-preview').innerHTML = "";
            document.getElementById('action-filter-container').classList.add('d-none');
        }
        if (action == 'Descarga') {
            document.getElementById('action-file-container').classList.remove('d-none');
            document.getElementById('action-link-container').classList.add('d-none');
            document.getElementById('action-filter-container').classList.add('d-none');
        }
        if (action == 'Filtro') {
            document.getElementById('action-filter-container').classList.remove('d-none');
            document.getElementById('action-file-container').classList.add('d-none');
            document.getElementById('action-link-container').classList.add('d-none');
        }
    });

    $('#select-edit-action').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        let action = $("#select-edit-action").val();
        if (action == 'Externo' || action == 'Interno') {
            document.getElementById('edit-action-link-container').classList.remove('d-none');
            document.getElementById('edit-action-file-container').classList.add('d-none');
            document.getElementById('edit-action-file-preview').classList.add('d-none');
            document.getElementById('edit-action-filter-container').classList.add('d-none');
            document.getElementById('edit-action-file-preview').innerHTML = "";
        }
        if (action == 'Descarga') {
            document.getElementById('edit-action-file-container').classList.remove('d-none');
            document.getElementById('edit-action-link-container').classList.add('d-none');
            document.getElementById('edit-action-filter-container').classList.add('d-none');
        }
        if (action == 'Filtro') {
            document.getElementById('edit-action-link-container').classList.add('d-none');
            document.getElementById('edit-action-file-container').classList.add('d-none');
            document.getElementById('edit-action-file-preview').classList.add('d-none');
            document.getElementById('edit-action-file-preview').innerHTML = "";
            document.getElementById('edit-action-filter-container').classList.remove('d-none');
        }
    });

    $('#modalEditElement').on('hidden.bs.modal', function () { //Al cerrar la modal de editar
        let editing = document.querySelectorAll('.editing');
        [].forEach.call(editing, function (el) {
            el.classList.remove("editing");
        });
        clearModalEditAction();
    });

    $('#modalAddElement').on('hidden.bs.modal', function () { //Al cerrar la modal de agregar
        clearModalAddAction();
    });

    $(".chosen").chosen({ //inicializar select múltiples
        no_results_text: "Sin resultados para",
        placeholder_text_single: "Buscar",
        placeholder_text_multiple: "Seleccione una o más opciones",
        max_shown_results: 11, //NÚMERO MÁXIMO DE RESULTADOS EN CADA SELECT PARA QUE AL FILTRAR SEA MÁS RÁPIDO
        hide_results_on_select: false,
    });

    const fileArticulos = document.getElementById('articulosFile');
    fileArticulos.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'articulos');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const editfileArticulos = document.getElementById('editarticulosFile');
    editfileArticulos.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'editarticulos');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const fileProveedores = document.getElementById('proveedoresFile');
    fileProveedores.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'proveedores');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const editfileProveedores = document.getElementById('editproveedoresFile');
    editfileProveedores.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'editproveedores');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });


    const fileMarcas = document.getElementById('marcasFile');
    fileMarcas.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'marcas');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const editfileMarcas = document.getElementById('editmarcasFile');
    editfileMarcas.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });
            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'editmarcas');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    getImagesOnServer();
    loadFilterData();

});


https://codepen.io/fitri/full/oWovYj/ */

function enableDragSort(listClass) {
    const sortableLists = document.getElementsByClassName(listClass);
    Array.prototype.map.call(sortableLists, (list) => { enableDragList(list) });
}

function enableDragList(list) {
    Array.prototype.map.call(list.children, (item) => { enableDragItem(item) });
}

function enableDragItem(item) {
    item.setAttribute('draggable', true)
    item.ondrag = handleDrag;
    item.ondragend = handleDrop;
}

function handleDrag(item) {
    const selectedItem = item.target,
        list = selectedItem.parentNode,
        x = event.clientX,
        y = event.clientY;

    selectedItem.classList.add('drag-sort-active');
    let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);

    if (list === swapItem.parentNode) {
        swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
        list.insertBefore(selectedItem, swapItem);
    }
}

function handleDrop(item) {
    item.target.classList.remove('drag-sort-active');
}

function preview() {
    let actionsNewOrder = getActionsInNewOrder();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/mercadotecnia/portal/orderPreview",
        'type': 'POST',
        'data': { 'actions': actionsNewOrder },
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            data == 1 ? window.open('/mercadotecnia/portal/preview', '_blank') : alert('Error guardando imagenes temporales');
        },
        error: function (error) {
            alert('Error guardando imagenes temporales');
            console.log(error);
        }
    });
}

function getActionsInNewOrder() { //obtener arreglo de acciones en el orden en el que estén en el dom
    actionsNewOrder = [];
    let imagesOnServer = document.querySelectorAll('.imageOnServer'); //obtener las imágenes que ya están en el servidor
    imagesOnServer.forEach((image) => {
        let imageInfo = image.id.split('/');
        let action = actions.find(object => {
            return (object.portalMkt_.seccion == imageInfo[0] && object.portalMkt_.filename == imageInfo[1]);
        })
        actionsNewOrder.push(action);
    });
    return actionsNewOrder;
}

function deleteRow(row) { //eliminar banner, quitarlo del dom y del array de acciones
    event.stopPropagation();
    let idImage = row.parentNode.children[0].id;

    let indexAction = actions.findIndex(action => {
        return action.portalMkt_.rutaImg.includes(idImage);
    })
    actions.splice(indexAction, 1);

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/mercadotecnia/portal/deleteImage",
        'type': 'POST',
        'data': { 'image': idImage },
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (result) {
            if (result == 1) {
                row.parentNode.remove();
            }
            else {
                alert('Error eliminando imagen');
            }
        },
    });
}

function activeModal(id, section, row = null) { //abrir modal, puede abrir modal agregar y editar
    document.getElementById('sectionElement').setAttribute('value', section);
    $('#' + id).modal('show');
    if (row != null) { //Si la modal es editar, pre cargar la información de la acción
        let src = row.children[0].src;
        let id = row.children[0].id;
        row.children[0].classList.add('editing');
        let action = actions.find((e) => {
            return e.portalMkt_.rutaImg.includes(id);
        });
        $('#select-edit-action').val(action.portalMkt_.accion).trigger('change');
        if (action.portalMkt_.accion == 'Interno' || action.portalMkt_.accion == 'Externo') {
            document.getElementById('edit-action-link-container').classList.remove('d-none');
            document.getElementById('edit-action-link').value = action.portalMkt_.valor;
            document.getElementById('edit-action-file-container').classList.add('d-none');
            document.getElementById('edit-action-file-preview').classList.add('d-none');
            document.getElementById('edit-action-file-preview').innerHTML = "";
            document.getElementById('edit-action-filter-container').classList.add('d-none');
        }
        if (action.portalMkt_.accion == 'Descarga') {
            document.getElementById('edit-action-file-container').classList.remove('d-none');
            document.getElementById('edit-action-link-container').classList.add('d-none');
            document.getElementById('edit-action-filter-container').classList.add('d-none');
            let preview = document.getElementById('edit-action-file-preview');
            let filename = (action.portalMkt_.valor.split('/')).pop();
            if (filename.includes('.xl')) {
                preview.innerHTML = `
                    <p>Este tipo de archivos no pueden visualizarse automáticamente en el navegador.</p>
                    <a href="${action.portalMkt_.valor}">Descargar archivo</a>
                `;
            }
            else {
                preview.innerHTML = `
                <embed src="../../../../assets/mercadotecnia/Files/${filename}" width="100%" height="auto" />
            `;
            }
            preview.classList.remove('d-none');
        }

        if (action.portalMkt_.accion == 'Filtro') {
            document.getElementById('edit-action-link-container').classList.add('d-none');
            document.getElementById('edit-action-file-container').classList.add('d-none');
            document.getElementById('edit-action-file-preview').classList.add('d-none');
            document.getElementById('edit-action-file-preview').innerHTML = "";
            document.getElementById('edit-action-filter-container').classList.remove('d-none');
            let filters = action.portalMkt_.portalMktd;
            console.log(action);
            let jsonProveedores = [];
            let jsonMarcas = [];
            let jsonArticulos = [];

            filters.forEach(filter => {
                switch(filter.tipo){
                    case 'PROVEEDOR':
                        let tmpProveedor = {
                            "Proveedor": filter.valor
                        }
                        jsonProveedores.push(tmpProveedor);
                        break;
                    case 'MARCA':
                        let tmpMarca = {
                            "Marca": filter.valor
                        }
                        jsonMarcas.push(tmpMarca);
                        break;
                    case 'ARTICULO':
                        let tmpArticulo = {
                            "Codigo": filter.valor
                        }
                        jsonArticulos.push(tmpArticulo);
                        break;
                    default: break;
                }
            });

            jsonProveedores.length > 0 && addTags(JSON.stringify(jsonProveedores), 'editproveedores');
            jsonMarcas.length > 0 && addTags(JSON.stringify(jsonMarcas), 'editmarcas');
            jsonArticulos.length > 0 && addTags(JSON.stringify(jsonArticulos), 'editarticulos');
        }
        document.getElementById('image-edit-preview').src = src;
    }
}

function closeModal(id) {
    $('#' + id).modal('hide');
}


function addNewAction() { //Agregar nueva acción, guardar imagen en /mercadotecnia/Temp
    let section = document.getElementById('sectionElement').getAttribute('value');
    let file_data = $("#image-add-file").prop("files")[0];
    var form_data = new FormData();
    form_data.append("file", file_data);
    form_data.append("section", section);

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/mercadotecnia/portal/uploadImage",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,       // Setting the data attribute of ajax with file_data                  
        type: 'post',
        success: function (result) {
            addRow(result.split('/')[1], section);
        },
    });


}

function addRow(filename, section) { //Agregar acción al array y al dom
    let container = document.getElementById('ul-' + section);
    let li = document.createElement('li');
    li.setAttribute('class', 'drag-sort-item divImg');
    li.setAttribute('onclick', "activeModal('modalEditElement', 'Hero', this)");
    enableDragItem(li);
    let row = `
        <img loading="lazy" class="image-${section.toLowerCase()} imageOnServer" id="${section}/${filename}" src="../../../../assets/mercadotecnia/Temp/${section}/${filename}" alt="">
        <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
    `;
    li.innerHTML = row;
    container.appendChild(li);

    let link = "";
    let action = $("#select-action").val();
    let portalMktd = [];

    if (action == "Externo" || action == "Interno") {
        link = document.getElementById('action-link').value;
    }

    if (action == "Descarga") {
        let file_download = $("#action-file").prop("files")[0];
        var form_download = new FormData();
        form_download.append("file", file_download);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/mercadotecnia/portal/uploadFile",
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            data: form_download,       // Setting the data attribute of ajax with file_data                  
            type: 'post',
            success: function (result) {
                link = "/mercadotecnia/portal/download/" + result;
            },
        });
    }

    if (action == 'Filtro') {
        let proveedores = $('#proveedores').chosen().val();
        let marcas = $('#marcas').chosen().val();
        let articulos = $('#articulos').chosen().val();

        proveedores.forEach(proveedor => {
            let tmpProveedor = {
                idPortalMktd: "0",
                idPortalMkt: "0",
                tipo: "PROVEEDOR",
                valor: proveedor,
                idPortalMktNavigation: ""
            }
            portalMktd.push(tmpProveedor);
        });

        marcas.forEach(marca => {
            let tmpMarcas = {
                idPortalMktd: "0",
                idPortalMkt: "0",
                tipo: "MARCA",
                valor: marca,
                idPortalMktNavigation: ""
            }
            portalMktd.push(tmpMarcas);

        });

        articulos.forEach(art => {
            let tmpArticulo = {
                idPortalMktd: "0",
                idPortalMkt: "0",
                tipo: "ARTICULO",
                valor: art,
                idPortalMktNavigation: ""
            }
            portalMktd.push(tmpArticulo);
        });

    }

    let tmp = {
        portalMkt_: {
            idPortalMkt: 0,
            seccion: section,
            rutaImg: "assets/mercadotecnia/Temp/" + section + "/" + filename,
            filename: filename,
            accion: action,
            valor: link,
            portalMktd: portalMktd
        }
    };

    actions.push(tmp);

    closeModal('modalAddElement');
}

function getImagesOnServer() { //Obtener acciones del back (PortalMKT/GetPortalMKT)
    $.ajax({
        type: "GET",
        enctype: 'multipart/form-data',
        url: "/mercadotecnia/portal/getActions",
        data: FormData,
        'async': false,
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function (data) {
            actions = data;
        },
        error: function (error) {
            alert('Error obteniendo acciones actuales');
        }
    });
}

function clearModalAddAction() {
    $('#image-add-file').val("");
    $('#select-action').val("none").trigger('change');
    $('#action-link').val("");
    $('#action-link-container').addClass('d-none');
    $('#action-file').val("");
    $('#action-file-container').addClass('d-none');
    $('#action-file-preview').addClass('d-none');
    $('#action-file-preview').innerHTML = "";
    $('#image-add-preview').attr('src', '');
    clearSelection('Proveedores');
    clearSelection('Marcas');
    clearSelection('Articulos');
    $('#action-filter-container').addClass('d-none');
}

function clearModalEditAction() {
    $('#image-edit-file').val("");
    $('#select-edit-action').val("none").trigger('change');
    $('#edit-action-link').val("");
    $('#edit-action-link-container').addClass('d-none');
    $('#edit-action-file').val("");
    $('#edit-action-file-container').addClass('d-none');
    $('#edit-action-file-preview').addClass('d-none');
    $('#edit-action-file-preview').innerHTML = "";
    clearSelection('editProveedores');
    clearSelection('editMarcas');
    clearSelection('editArticulos');
    $('#image-edit-preview').attr('src', '');

}

function updateAction() {
    let section = document.getElementById('sectionElement').getAttribute('value');
    let file_data = $("#image-edit-file").prop("files")[0];
    let row = document.querySelector('.editing');
    let action = actions.find((e) => {
        return e.portalMkt_.rutaImg.includes(row.id);
    });
    if (file_data != undefined) { //Si cargó una nueva imagen
        var form_data = new FormData();
        let src = row.src;
        let filenameDelete = src.split('/').pop();
        form_data.append("file", file_data);
        form_data.append("section", section);
        form_data.append("delete", filenameDelete);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/mercadotecnia/portal/uploadImage",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                 
            type: 'post',
            success: function (result) { //Mostrar la nueva imagen cargada en el dom y actualizar acción en el array
                row.src = "../../../../assets/mercadotecnia/Temp/" + section + "/" + result.split('/')[1];
                row.id = section + "/" + result.split('/')[1];
                action.portalMkt_.rutaImg = "assets/mercadotecnia/Temp/" + section + "/" + result.split('/')[1];
                action.portalMkt_.filename = result.split('/')[1];
            },
        });
    }

    let link = "";
    let actionSelected = $("#select-edit-action").val();
    let portalMktd = [];

    if (actionSelected == "Externo" || actionSelected == "Interno") {
        link = document.getElementById('edit-action-link').value;
    }

    if (actionSelected == "Descarga") {
        let file_download = $("#edit-action-file").prop("files")[0];
        var form_download = new FormData();
        form_download.append("file", file_download);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/mercadotecnia/portal/uploadFile",
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            data: form_download,       // Setting the data attribute of ajax with file_data                  
            type: 'post',
            success: function (result) {
                link = "/mercadotecnia/portal/download/" + result;
            },
        });
    }

    if (actionSelected == 'Filtro') {
        let proveedores = $('#editproveedores').chosen().val();
        let marcas = $('#editmarcas').chosen().val();
        let articulos = $('#editarticulos').chosen().val();

        proveedores.forEach(proveedor => {
            let tmpProveedor = {
                idPortalMktd: "0",
                idPortalMkt: "0",
                tipo: "PROVEEDOR",
                valor: proveedor,
                idPortalMktNavigation: ""
            }
            portalMktd.push(tmpProveedor);
        });

        marcas.forEach(marca => {
            let tmpMarcas = {
                idPortalMktd: "0",
                idPortalMkt: "0",
                tipo: "MARCA",
                valor: marca,
                idPortalMktNavigation: ""
            }
            portalMktd.push(tmpMarcas);

        });

        articulos.forEach(art => {
            let tmpArticulo = {
                idPortalMktd: "0",
                idPortalMkt: "0",
                tipo: "ARTICULO",
                valor: art,
                idPortalMktNavigation: ""
            }
            portalMktd.push(tmpArticulo);
        });

    }

    action.portalMkt_.accion = actionSelected;
    action.portalMkt_.valor = link;
    action.portalMkt_.portalMktd = portalMktd;
    closeModal('modalEditElement');
    clearModalEditAction();
}

function saveChanges() {
    document.getElementById("btnSpinner").style.display = "block";
    document.getElementById("btn-save-changes").style.display = "none !important";
    let actionsNewOrder = getActionsInNewOrder();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/mercadotecnia/portal/saveChanges",
        'type': 'POST',
        'data': { 'actions': actionsNewOrder },
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            document.cookie = "_mkt=Acciones actualizadas; Path=/;";
            location.reload();
        },
        error: function (error) {
            document.cookie = "_mkt=Error actualizando acciones; Path=/;";
            alert('Error guardando imagenes temporales');
            console.log(error);
        }
    });
}

function getCookie(name) { //Saber si una cookie existe 
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
}

function downloadTemplate(template) {
    window.location.href = '/downloadTemplate' + template;
}

function clearSelection(id) {
    id = id.toLowerCase();
    $('#' + id).val('').trigger('chosen:updated');
    $('#' + id + "File").val('');
}

function triggerInputFile(input) { //Abrir ventana para seleccionar un documento
    document.getElementById(input + 'File').click();
}

function loadFilterData() {
    let response = $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/promociones/getPromocionesInfo",
        'type': 'GET',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        'async': true,
    });

    response.then((reglas) => {
        document.getElementById('proveedores_chosen').style.display = "block";
        document.getElementById('proveedoresLoading').style.display = "none";
        var selectProveedores = document.getElementById('proveedores');
        for (var x = 0; x < reglas[5].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[5][x];
            option.value = reglas[5][x];
            selectProveedores.appendChild(option);
        }
        $('#proveedores').trigger("chosen:updated");
        document.getElementById('proveedores_chosen').style.width = '100%';

        document.getElementById('editproveedores_chosen').style.display = "block";
        document.getElementById('editproveedoresLoading').style.display = "none";
        var selecteditProveedores = document.getElementById('editproveedores');
        for (var x = 0; x < reglas[5].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[5][x];
            option.value = reglas[5][x];
            selecteditProveedores.appendChild(option);
        }
        $('#editproveedores').trigger("chosen:updated");
        document.getElementById('editproveedores_chosen').style.width = '100%';

        document.getElementById('marcas_chosen').style.display = "block";
        document.getElementById('marcasLoading').style.display = "none";
        var selectMarcas = document.getElementById('marcas');
        for (var x = 0; x < reglas[6].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[6][x];
            option.value = reglas[6][x];
            selectMarcas.appendChild(option);
        }
        $('#marcas').trigger("chosen:updated");
        document.getElementById('marcas_chosen').style.width = '100%';

        document.getElementById('editmarcas_chosen').style.display = "block";
        document.getElementById('editmarcasLoading').style.display = "none";
        var selecteditMarcas = document.getElementById('editmarcas');
        for (var x = 0; x < reglas[6].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[6][x];
            option.value = reglas[6][x];
            selecteditMarcas.appendChild(option);
        }
        $('#editmarcas').trigger("chosen:updated");
        document.getElementById('editmarcas_chosen').style.width = '100%';

        document.getElementById('articulos_chosen').style.display = "block";
        document.getElementById('articulosLoading').style.display = "none";
        var selectArticulos = document.getElementById('articulos');
        for (var x = 0; x < reglas[7].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[7][x];
            option.value = (reglas[7][x].split(']'))[0].substring(1);
            selectArticulos.appendChild(option);
        }
        $('#articulos').trigger("chosen:updated");
        document.getElementById('articulos_chosen').style.width = '100%';

        document.getElementById('editarticulos_chosen').style.display = "block";
        document.getElementById('editarticulosLoading').style.display = "none";
        var selecteditArticulos = document.getElementById('editarticulos');
        for (var x = 0; x < reglas[7].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[7][x];
            option.value = (reglas[7][x].split(']'))[0].substring(1);
            selecteditArticulos.appendChild(option);
        }
        $('#editarticulos').trigger("chosen:updated");
        document.getElementById('editarticulos_chosen').style.width = '100%';
    });
}


function addTags(json, id) {
    var jsonObj = JSON.parse(json);
    var selectedOptions = [];
    var key = '';
    switch (id) {
        case 'proveedores': key = 'Proveedor'; break;
        case 'editproveedores': key = 'Proveedor'; break;
        case 'marcas': key = 'Marca'; break;
        case 'editmarcas': key = 'Marca'; break;
        case 'articulos': key = 'Codigo'; break;
        case 'editarticulos': key = 'Codigo'; break;
        default: break;
    }
    jsonObj.forEach(function (valor, indice, array) {
        selectedOptions.push(valor[key]);
    });
    $('#' + id).val(selectedOptions).trigger('chosen:updated');
}