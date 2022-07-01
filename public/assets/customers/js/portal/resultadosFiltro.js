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
    var minPagination = document.getElementById('paginationCant').value;
    endPagination < minPagination ? endPagination = minPagination : endPagination = endPagination; 
    var location = window.location.href.split('/');
    var route = location[0] + '//' + location[2] + '/' + location[3] + '/' + location[4] + '/' + location[5];  
    window.location.href = route + '/' + iniPagination + '/' + endPagination;
}

function filter(key, value){
    alert('Filtrar resultados por '+key+' = '+value);
}