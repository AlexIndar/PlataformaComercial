let imagesHero = [];
let imagesEventos = [];

$('document').ready(function () {
    $("body").addClass("sidebar-collapse");
    (() => { enableDragSort('drag-sort-enable') })();

    $("#image-edit-file").on("change", () => {
        const imgInp = document.getElementById('image-edit-file');
        const [file] = imgInp.files;
        document.getElementById('image-edit').src = URL.createObjectURL(file);
    });
});

/* Made with love by @fitri
 This is a component of my ReactJS project
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
    getImagesHero();
    getImagesEventos();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/mercadotecnia/portal/orderPreview",
        'type': 'POST',
        'data': { 'hero': imagesHero, 'eventos': imagesEventos },
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

function getImagesHero() {
    imagesHero = [];
    let imagesOnServerHero = document.querySelectorAll('.image-hero'); //obtener las imágenes que ya están en el servidor
    let newPosition = 1;
    imagesOnServerHero.forEach((image) => {
        let srcSplit = image.src.split('/');
        let tmpObj = {
            filename: srcSplit[srcSplit.length - 1],
            onServer: true,
            currentPosition: srcSplit[srcSplit.length - 1].split('.')[0],
            newPosition: newPosition,
        }

        imagesHero.push(tmpObj);

        newPosition++;
    });
    return imagesHero;
}

function getImagesEventos() {
    imagesEventos = [];
    let imagesOnServerEventos = document.querySelectorAll('.image-eventos'); //obtener las imágenes que ya están en el servidor
    let newPosition = 1;
    imagesOnServerEventos.forEach((image) => {
        let srcSplit = image.src.split('/');
        let tmpObj = {
            filename: srcSplit[srcSplit.length - 1],
            onServer: true,
            currentPosition: srcSplit[srcSplit.length - 1].split('.')[0],
            newPosition: newPosition,
        }
        imagesEventos.push(tmpObj);
        newPosition++;
    });
    return imagesEventos;
}

function deleteRow(row) {
    let idImage = row.parentNode.children[0].id;
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
        document.getElementById('image-edit').src = src;
    }
}

function closeModal(id) {
    $('#' + id).modal('hide');
}

function storeNewAction() {
    let section = document.getElementById('sectionElement').getAttribute('value');
    let file_data = $("#newFileImage").prop("files")[0];
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
        <img loading="lazy" class="image-${section.toLowerCase()}" id="${section}/${filename}" src="../../../../assets/mercadotecnia/Temp/${section}/${filename}" alt="">
        <i onclick='deleteRow(this)' class="fas fa-times delete-icon fa-xl"></i>
    `;
    li.innerHTML = row;
    container.appendChild(li);
    closeModal('modalAddElement');
}