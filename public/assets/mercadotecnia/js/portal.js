$('document').ready(function () {
    $("body").addClass("sidebar-collapse");
    (() => { enableDragSort('drag-sort-enable') })();
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
    let imagesHero = getImagesHero();

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/mercadotecnia/portal/storeTempImages",
        'type': 'POST',
        'data': { 'hero': imagesHero },
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
    let imagesOnServerHero = document.querySelectorAll('.imageOnServer-hero'); //obtener las imágenes que ya están en el servidor
    let imagesHero = [];
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

function deleteRow(row) {
    row.parentNode.remove();
}

function activeModal(id, section) {
    document.getElementById('sectionElement').setAttribute('value', section);
    $('#' + id).modal('show');
}

function closeModal(id) {
    $('#' + id).modal('hide');
}

function storeNewAction(){
    let section = document.getElementById('sectionElement').getAttribute('value');
    let file_data = $("#newFileImage").prop("files")[0];
    var form_data = new FormData();
    form_data.append("file", file_data);
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
            if (result.success == true) { alert("success!"); }
            else { alert("fail!"); }

        },
    })        
    console.log(file_data);
}

function addRow(row) {

}