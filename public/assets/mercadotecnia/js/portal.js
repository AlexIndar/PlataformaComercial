let imagesHero = [];
let imagesEventos = [];
let actions = [];

$('document').ready(function () {
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

    $('#select-action').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue){
        let action = $("#select-action").val();
        if(action == 'Externo' || action == 'Interno'){
            document.getElementById('action-link-container').classList.remove('d-none');
            document.getElementById('action-file-container').classList.add('d-none');
        }
        if(action == 'Descarga'){
            document.getElementById('action-file-container').classList.remove('d-none');
            document.getElementById('action-link-container').classList.add('d-none');
        }
    });

    $('#modalEditElement').on('hidden.bs.modal', function () {
        let editing = document.querySelectorAll('.editing');
        [].forEach.call(editing, function(el) {
            el.classList.remove("editing");
        });
    });

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
            console.log(actions);
        },
        error: function (error) {
            alert('Error obteniendo acciones actuales');
        }
    });

    getImagesOnServer();
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



function saveChanges() {
    alert('Guardar cambios');
}

function preview() {
    let actionsPreview = getActionsPreview();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/mercadotecnia/portal/preview",
        'type': 'POST',
        'data': { 'actions': actionsPreview },
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            console.log(data);
        },
        error: function (error) {
            alert('Error guardando imagenes temporales');
            console.log(error);
        }
    });

}

function postForm(path, params, method) {
    method = method || 'post';

    var form = document.createElement('form');
    form.setAttribute('method', method);
    form.setAttribute('action', path);

    for (var key in params) {
        if (params.hasOwnProperty(key)) {
            var hiddenField = document.createElement('input');
            hiddenField.setAttribute('type', 'hidden');
            hiddenField.setAttribute('name', key);
            hiddenField.setAttribute('value', params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}


function getActionsPreview() {
    actionsPreview = [];
    let imagesOnServer = document.querySelectorAll('.imageOnServer'); //obtener las imágenes que ya están en el servidor
    imagesOnServer.forEach((image) => {
        let imageInfo = image.id.split('/');
        let action = actions.find(object => {
            return (object.portalMkt_.seccion == imageInfo[0] && object.portalMkt_.filename == imageInfo[1]);
        })
        actionsPreview.push(action);
    });
    return actionsPreview;
}

function deleteRow(row) {
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
        'data': {'image': idImage},
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (result) {
            if(result == 1){
                row.parentNode.remove();
            }
            else{
                alert('Error eliminando imagen');
            }
        },
    });
}

function activeModal(id, section, row = null) {
    document.getElementById('sectionElement').setAttribute('value', section);
    $('#' + id).modal('show');

    if(row != null){
        let src = row.children[0].src;
        row.children[0].classList.add('editing');
        document.getElementById('image-edit-preview').src = src;
    }
}

function closeModal(id) {
    $('#' + id).modal('hide');
    
}


function addNewAction() {
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

function addRow(filename, section) {
    let container = document.getElementById('ul-' + section);
    let li = document.createElement('li');
    li.setAttribute('class', 'drag-sort-item divImg');
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

    if(action == "Externo" || action == "Interno"){
        link = document.getElementById('action-link').value;
    }

    let tmp = {
        portalMkt: {
            idPortalMkt: 0,
            seccion: section,
            rutaImg: "assets/mercadotecnia/"+section+"/"+filename,
            accion: action,
            valor: link,
            portalMktd: portalMktd
        }
    };

    actions.push(tmp);
    console.log(actions);

    closeModal('modalAddElement');
}

function getImagesOnServer(){
    // hacer el get de lo que está actualmente en la bd
}