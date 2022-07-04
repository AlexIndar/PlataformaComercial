var itemsCurrentFilter = [];
var itemsFullList = [];
var filters = [];

$(document).ready(function () {
    var filter = document.getElementById('busqueda').innerText.toLowerCase();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/portal/busqueda",
        'type': 'POST',
        'data': {'filter': filter},
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
           itemsFullList = data;
           console.log(itemsFullList);
        },
        error: function (error) {
            console.log(error);
        }
    });

    $(".filterCheck").change(function() {
        var filter = this.value.split('=');
        if(this.checked) {
            addFilter(filter[0], filter[1]);
        }
        else{
            removeFilter(filter[0], filter[1]);
        }
    });
});


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

function addFilter(key, value){ //agrega filtro a un array para llevar control de los filtros aplicados, ejecuta funciones para filtrar items y crear la etiqueta
    var indexFilter = filters.findIndex(o => o.key === key);
    console.log(indexFilter);
    if(indexFilter >= 0){
        filters[indexFilter].values.push(value);
    }
    else{
        var tmpFilter = {
            'key': key,
            'values': []
        };
        tmpFilter.values.push(value);
        filters.push(tmpFilter);
    }
    
    addTagFilter(key, value);
    filterItems();
}

function removeFilter(key, value){ //quita filtro del array para llevar control de los filtros aplicados, ejecuta funciones para reacomodar items y eliminar la etiqueta
    var indexFilter = filters.findIndex(o => o.key === key);
    filters[indexFilter].values = filters[indexFilter].values.filter(e => e !== value);
    document.getElementById('filterLabel-'+key+'-'+value).remove();
    document.getElementById('checkbox-'+key+'-'+value).checked = false;
    filterItems();
}

function addTagFilter(key, value){
    var container = document.getElementById('appliedFilters');
    
    var label = document.createElement('div');
    label.setAttribute('class', 'appliedFilterElement');
    label.setAttribute('id', 'filterLabel-'+key+'-'+value);
    label.setAttribute('onclick', 'removeFilter("'+key+'", "'+value+'")');

    var title = document.createElement('h5');
    title.innerText = value.toLowerCase();

    var cross = document.createElement('span');
    cross.setAttribute('class', 'crossFilter');

    var icon = document.createElement('i');
    icon.setAttribute('class', 'fas fa-times fa-lg');

    cross.appendChild(icon);
    title.appendChild(cross);
    label.appendChild(title);

    container.appendChild(label);
}

function filterItems(){
    
    let itemsFiltered = [];
    itemsCurrentFilter = [];

    itemsFullList.items.forEach(item => {
        let insert = true;
        for(let x=0; x < filters.length; x++){
            let key = filters[x]['key'];
            var nameKey = '';
            switch(key){
                case 'marca': nameKey = 'familia'; break;
                case 'categoria': nameKey = 'categoriaItem'; break;
                default: break;
            }
            for(y=0; y < filters[x]['values'].length; y++){
                let value = filters[x]['values'][y];
                if(item[''+nameKey+''] != value.toUpperCase()){
                    insert = false;
                }
                else{
                    insert = true;
                    break;
                }
            }
            if(!insert){
                break;
            }
        }
        if(insert){
            itemsFiltered.push(item);
        }
    });

    itemsCurrentFilter = itemsFiltered;
    console.log(itemsCurrentFilter);

    updateCantidadesFiltros();

}

function updateCantidadesFiltros(){
    for(let x = 0; x < itemsFullList.marcas.length; x ++){
        const count = itemsCurrentFilter.filter((obj) => obj.familia === itemsFullList.marcas[x].nombre).length;
        document.getElementById('filterCantidad-marca-'+itemsFullList.marcas[x].nombre).innerText = '('+count+')';
    }

    for(let x = 0; x < itemsFullList.categorias.length; x ++){
        const count = itemsCurrentFilter.filter((obj) => obj.categoriaItem === itemsFullList.categorias[x].nombre).length;
        document.getElementById('filterCantidad-categoria-'+itemsFullList.categorias[x].nombre).innerText = '('+count+')';
    }
}