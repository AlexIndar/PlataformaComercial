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
        }
        if (action == 'Descarga') {
            document.getElementById('action-file-container').classList.remove('d-none');
            document.getElementById('action-link-container').classList.add('d-none');
        }
    });

    $('#modalEditElement').on('hidden.bs.modal', function () {
        let editing = document.querySelectorAll('.editing');
        [].forEach.call(editing, function (el) {
            el.classList.remove("editing");
        });
    });

    $('#modalAddElement').on('hidden.bs.modal', function () {
        clearModalAddAction();
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

function getActionsInNewOrder() {
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

function activeModal(id, section, row = null) {
    document.getElementById('sectionElement').setAttribute('value', section);
    $('#' + id).modal('show');

    if (row != null) { //modal editar 
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
        }
        if (action.portalMkt_.accion == 'Descarga') {
            document.getElementById('edit-action-file-container').classList.remove('d-none');
            document.getElementById('edit-action-link-container').classList.add('d-none');
            //mostrar el documento que está cargado actualmente
        }
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

    if (action == "Externo" || action == "Interno") {
        link = document.getElementById('action-link').value;
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

function getImagesOnServer() {
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
    $('#image-add-preview').attr('src', '');
}

function clearModalEditAction() {
    $('#image-edit-file').val("");
    $('#select-edit-action').val("none").trigger('change');
    $('#edit-action-link').val("");
    $('#edit-action-link-container').addClass('d-none');
    $('#image-edit-preview').attr('src', '');
}

function updateAction() {

    let section = document.getElementById('sectionElement').getAttribute('value');
    let file_data = $("#image-edit-file").prop("files")[0];
    let row = document.querySelector('.editing');
    let action = actions.find((e) => {
        return e.portalMkt_.rutaImg.includes(row.id);
    });

    if (file_data != undefined) { //cambiar la imagen
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
            data: form_data,       // Setting the data attribute of ajax with file_data                  
            type: 'post',
            success: function (result) {
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

    action.portalMkt_.accion = actionSelected;
    action.portalMkt_.valor = link;
    action.portalMktd = portalMktd;

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

function getCookie(name) { //saber si una cookie existe 
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