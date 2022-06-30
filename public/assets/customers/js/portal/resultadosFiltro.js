function noDisponible(img) {
    img.src = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
}

function hideFilter(container){
    if(document.getElementById('filterControl'+container).classList.contains('collapsed')){
        $('#filter'+container).slideDown();
        $('#filterControl'+container).toggleClass('collapsed');
    }
    else{
        $('#filter'+container).slideUp();
        $('#filterControl'+container).toggleClass('collapsed');
    }
    
}

function detalleProducto(item){
    alert('detalle item '+item);
}

function pagination(from, to, index){
    var iniPagination = (to - from + 1) * (index - 1) + 1;
    var endPagination = (to - from + 1) * index;
    window.location.href = window.location.href + '/' + iniPagination + '/' + endPagination;
}