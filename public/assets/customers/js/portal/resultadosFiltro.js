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
           itemsCurrentFilter = data['items'];
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
    // var location = window.location.href.split('/');
    // var route = location[0] + '//' + location[2] + '/' + location[3] + '/' + location[4] + '/' + location[5];  
    // window.location.href = route + '/' + iniPagination + '/' + endPagination;
    updateProductList(iniPagination, endPagination, index);
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

function filterItems(){ //busca artículos que coincidan con todos los filtros agregados
    
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
    updateProductList();
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

function updatePagination(activePage = 1){
    var to = document.getElementById('paginationCant').value;
    var from = 1;
    var total = itemsCurrentFilter.length;
    to > total ? to = total : to = to;
    document.getElementById('paginationFrom').innerText = '1';
    document.getElementById('paginationTo').innerText = to;
    document.getElementById('paginationTotal').innerText = total;
    
    var iniPagination = 0;
    var endPagination = 0;

    var numPages = Math.ceil(total / (to - from));
    activePage - 2 > 0 ? iniPagination = activePage - 2 : iniPagination = 1;
    activePage + 2 < 5 ? endPagination = 5 : endPagination = activePage + 2;
    endPagination * to > total ? endPagination = numPages : endPagination = endPagination;

    // VACIAR PAGINACIÓN SUPERIOR
    var ul = document.getElementById("paginationUlSuperior");
    var child = ul.lastElementChild; 
    while (child) {
        ul.removeChild(child);
        child = ul.lastElementChild;
    }

    // VACIAR PAGINACIÓN INFERIOR
    var ulInferior = document.getElementById("paginationUlInferior");
    var child = ulInferior.lastElementChild; 
    while (child) {
        ulInferior.removeChild(child);
        child = ulInferior.lastElementChild;
    }


    if(total > (to - from) + 1){
        var liAnterior = document.createElement('li');
        activePage == 1 ? liAnterior.setAttribute('class', 'page-item disabled') : liAnterior.setAttribute('class', 'page-item');
        var aAnterior = document.createElement('a');
        aAnterior.setAttribute('class', 'page-link');
        aAnterior.setAttribute('onclick', 'pagination("'+from+'", "'+to+'", "'+(activePage - 1)+'")');
        aAnterior.innerText = 'Anterior';
        liAnterior.appendChild(aAnterior);
        ul.appendChild(liAnterior);
        ulInferior.appendChild(liAnterior.cloneNode(true));

        console.log(iniPagination);
        for(let x = iniPagination; x <= endPagination; x++){
            var li = document.createElement('li');
            activePage == x ? li.setAttribute('class', 'page-item active') : li.setAttribute('class', 'page-item');
            var a = document.createElement('a');
            a.setAttribute('class', 'page-link');
            a.setAttribute('onclick', 'pagination("'+from+'", "'+to+'", "'+x+'")');
            a.innerText = x;
            li.appendChild(a);
            ul.appendChild(li);
            ulInferior.appendChild(li.cloneNode(true));
        }

        var liSiguiente = document.createElement('li');
        activePage == endPagination ? liSiguiente.setAttribute('class', 'page-item disabled') : liSiguiente.setAttribute('class', 'page-item');
        var aSiguiente = document.createElement('a');
        aSiguiente.setAttribute('class', 'page-link');
        aSiguiente.setAttribute('onclick', 'pagination("'+from+'", "'+to+'", "'+(activePage + 1 )+'")');
        aSiguiente.innerText = 'Siguiente';
        liSiguiente.appendChild(aSiguiente);
        ul.appendChild(liSiguiente);
        ulInferior.appendChild(liSiguiente.cloneNode(true));

    }
}

function updateProductList(from = 1, to = parseInt(document.getElementById('paginationCant').value), activePage = 1){
    var total = itemsCurrentFilter.length;
    var iniPagination = 0;
    var endPagination = 0;

    var numPages = Math.ceil(total / (to - from));
    activePage - 2 > 0 ? iniPagination = activePage - 2 : iniPagination = 1;
    activePage + 2 < 5 ? endPagination = 5 : endPagination = activePage + 2;
    endPagination * to > total ? endPagination = numPages : endPagination = endPagination;

    var itemsToShow = [];
    to > total ? to = total : to = to;
    console.table(from, to, total);
    console.log(itemsCurrentFilter);
    for(let x = from - 1; x < to; x++){
        itemsToShow.push(itemsCurrentFilter[x]);
    }



    var container = document.getElementById("productListContainer");

    
    var child = container.lastElementChild; 
    while (child) {
        container.removeChild(child);
        child = container.lastElementChild;
    }

    for(let x = 0; x < itemsToShow.length; x ++){

        var mainDiv = document.createElement('div');
        mainDiv.setAttribute('class', 'col-lg-3 col-md-6 col-sm-6');

        var divContainer = document.createElement('div');
        divContainer.setAttribute('class', 'item');
        divContainer.setAttribute('onclick', 'detalleProducto("'+itemsToShow[x]['itemid']+'")');

        var divImg = document.createElement('div');
        divImg.setAttribute('class', 'imgItem');

        var imgItem = document.createElement('img');
        imgItem.setAttribute('src', "http://indarweb.dyndns.org:8080/assets/articulos/img/02_JPG_MD/" + itemsToShow[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_MD.jpg");
        imgItem.setAttribute('onerror', 'noDisponible(this)');

        divImg.appendChild(imgItem);
        divContainer.appendChild(divImg);

        var itemInfo = document.createElement('div');
        itemInfo.setAttribute('class', 'itemInfo');

        var h5ItemId = document.createElement('h5');
        h5ItemId.setAttribute('class', 'itemManufacturer');
        h5ItemId.innerText = itemsToShow[x]['itemid'];

        var divDescription = document.createElement('div');
        divDescription.setAttribute('class', 'itemDescriptionContainer');

        var h5Description = document.createElement('h5');
        h5Description.setAttribute('class', 'itemDescription');
        h5Description.innerText = itemsToShow[x]['purchasedescription'];

        divDescription.appendChild(h5Description);
        
        var h5ItemFamily = document.createElement('h5');
        h5ItemFamily.setAttribute('class', 'itemManufacturer');
        h5ItemFamily.innerText = itemsToShow[x]['familia'];

        var h5Categoria = document.createElement('h5');
        h5Categoria.setAttribute('class', 'categoriaLine');
        h5Categoria.innerHTML = '<span class="categoriaTitle">Categoría: </span> <span class="categoriaDescription">'+itemsToShow[x]['categoriaItem']+'</span>';

        itemInfo.appendChild(h5ItemId);
        itemInfo.appendChild(divDescription);
        itemInfo.appendChild(h5ItemFamily);
        itemInfo.appendChild(h5Categoria);
        divContainer.appendChild(itemInfo);

        var actions = document.createElement('actions');
        actions.setAttribute('class', 'itemActions row');
        actions.innerHTML = '<div class="col-12"><button class="btn-actions">Ver producto</button></div>';

        divContainer.appendChild(actions);

        mainDiv.appendChild(divContainer);

        container.appendChild(mainDiv);
    }

    container.style.display = 'block';
    updatePagination(parseInt(activePage));

}

function hideSkeleton(){
    console.log('timeout executed');
    document.getElementById('productList-skeleton').style.display = 'none !important';
    document.getElementById('productListContainer').style.display = 'block !important';
}