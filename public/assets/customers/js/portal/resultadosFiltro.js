var itemsCurrentFilter = [];
var itemsFullList = [];
var filters = [];


$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip()
    $(window).scroll(() => {
        adjustFixedFilters();
    });

    $(window).on("resize", function (event) {
        var cards = document.getElementsByClassName('cardItem');
        if ($(this).width() < 992) {
            document.getElementById('productListDiv').classList = 'col-12';
            for (const card of [...cards]) {
                card.className = "col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem";
            }
        }
        else {
            var status = document.getElementById('statusFilter').innerText;
            if (status == 'Ocultar') {
                document.getElementById('productListDiv').classList = 'col-lg-9 col-md-8 col-sm-12';
                for (const card of [...cards]) {
                    card.className = "col-sm-6 col-xl-4 cardItem";
                }
            }
            else {
                document.getElementById('productListDiv').classList = 'col-12';
                for (const card of [...cards]) {
                    card.className = "col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem";
                }
            }
        }
    });

    var filter = document.getElementById('busqueda').innerText.toLowerCase();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/portal/busqueda",
        'type': 'POST',
        'data': { 'filter': filter },
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            // QUITAR TODOS LOS PROMOCIONALES
            data['items'] = data['items'].filter((item) => {
                return item.categoriaItem != 'PROMOCIONAL';
            })
            itemsFullList = data;
            itemsCurrentFilter = itemsFullList['items'];
            showSkeleton();

            orderByKey('price', 'asc', 'number');
            let checkLinea = document.getElementById('checkbox-categorias-LINEA');
            checkLinea != undefined && checkLinea.click();
        },
        error: function (error) {
            console.warn(error);
        }
    });

    $(".filterCheck").change(function () {
        var filter = this.value.split('=');
        if (this.checked) {
            addFilter(filter[0], filter[1]);
        }
        else {
            removeFilter(filter[0], filter[1]);
        }
    });


    $('#showCant').change(function () {
        var cant = $(this).find(":selected").val();
        cant == 'All' ? cant = itemsCurrentFilter.length : cant = cant;
        document.getElementById('paginationCant').setAttribute('value', cant);
        showSkeleton();
        updateProductList();
        setTimeout(() => {
            hideSkeleton();
        }, 1000);
    });

    $('#showCantModal').change(function () {
        var cant = $(this).find(":selected").val();
        cant == 'All' ? cant = itemsCurrentFilter.length : cant = cant;
        document.getElementById('paginationCant').setAttribute('value', cant);
        showSkeleton();
        updateProductList();
        setTimeout(() => {
            hideSkeleton();
        }, 1000);
        activeModalFilters();
    });


    $('#orderBy').change(function () {
        let value = $(this).find(":selected").val();
        changeOrder(value);
    });

    $('#orderByModal').change(function () {
        let value = $(this).find(":selected").val();
        changeOrder(value);
        activeModalFilters();
    });


});


function changeOrder(value) {
    let key;
    let order;
    let type;
    switch (value) {
        case 'pricemainor': key = 'price'; order = 'asc'; type = 'number'; break;
        case 'pricemayor': key = 'price'; order = 'desc'; type = 'number'; break;
        case 'itemid': key = 'id'; order = 'asc'; type = 'number'; break;
        case 'purchasedescription': key = 'purchasedescription'; order = 'asc'; type = 'string'; break;
        default: break;
    }
    orderByKey(key, order, type);
}


function noDisponible(img) {
    img.src = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
}

function imgLoaded(img) {
    img.style.height = 'auto';
}

function hideFilter(container) {
    if (document.getElementById('filterControl' + container).classList.contains('collapsed')) {
        $('#filter' + container).slideDown();
        $('#filterControl' + container).toggleClass('collapsed');
    }
    else {
        $('#filter' + container).slideUp();
        $('#filterControl' + container).toggleClass('collapsed');
    }
}

function hideFilterModal(container) {
    if (document.getElementById('filterControl' + container + 'Modal').classList.contains('collapsed')) {
        $('#filter' + container + 'Modal').slideDown();
        $('#filterControl' + container + 'Modal').toggleClass('collapsed');
    }
    else {
        $('#filter' + container + 'Modal').slideUp();
        $('#filterControl' + container + 'Modal').toggleClass('collapsed');
    }
}

function detalleArticulo(codigo) {
    window.location.href = '/portal/detallesProducto/' + codigo.replace(' ', '_');
}

function pagination(from, to, index) {
    var iniPagination = (to - from + 1) * (index - 1) + 1;
    var endPagination = (to - from + 1) * index;
    var minPagination = document.getElementById('paginationCant').value;
    endPagination < minPagination ? endPagination = minPagination : endPagination = endPagination;
    updateProductList(iniPagination, endPagination, index);
}

function addFilter(key, value) { //agrega filtro a un array para llevar control de los filtros aplicados, ejecuta funciones para filtrar items y crear la etiqueta
    var indexFilter = filters.findIndex(o => o.key === key);
    if (indexFilter >= 0) {
        filters[indexFilter].values.push(value);
    }
    else {
        var tmpFilter = {
            'key': key,
            'values': []
        };
        tmpFilter.values.push(value);
        filters.push(tmpFilter);
    }
    var checksFilter = document.querySelectorAll('[id="checkbox-' + key + '-' + value + '"]');
    for (var i = 0; i < checksFilter.length; i++) {
        checksFilter[i].checked = true;
    }
    addTagFilter(key, value);
    filterItems();
}

function removeFilter(key, value) { //quita filtro del array para llevar control de los filtros aplicados, ejecuta funciones para reacomodar items y eliminar la etiqueta
    var indexFilter = filters.findIndex(o => o.key === key);
    filters[indexFilter].values = filters[indexFilter].values.filter(e => e !== value);
    document.getElementById('filterLabel-' + key + '-' + value).remove();
    var checksFilter = document.querySelectorAll('[id="checkbox-' + key + '-' + value + '"]');
    for (var i = 0; i < checksFilter.length; i++) {
        checksFilter[i].checked = false;
    }
    filterItems();
}

function addTagFilter(key, value) {
    var container = document.getElementById('appliedFilters');

    var label = document.createElement('div');
    label.setAttribute('class', 'appliedFilterElement');
    label.setAttribute('id', 'filterLabel-' + key + '-' + value);
    label.setAttribute('onclick', 'removeFilter("' + key + '", "' + value + '")');

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

function filterItems() { //busca artículos que coincidan con todos los filtros agregados

    let itemsFiltered = [];
    itemsCurrentFilter = [];
    itemsFullList.items.forEach(item => {
        let insert = true;
        for (let x = 0; x < filters.length; x++) {
            let key = filters[x]['key'];
            var nameKey = '';
            switch (key) {
                case 'marcas': nameKey = 'familia'; break;
                case 'categorias': nameKey = 'categoriaItem'; break;
                case 'competitividad': nameKey = 'competitividad'; break;
                case 'existencias': nameKey = 'disponible'; break;
                default: break;
            }
            for (y = 0; y < filters[x]['values'].length; y++) {
                let value = filters[x]['values'][y];
                if (value == 'Mejor Precio Indar') {
                    if (item['' + nameKey + ''] != "true") {
                        insert = false;
                    }
                    else {
                        insert = true;
                        break;
                    }
                }
                else if (value == 'Con existencias') {
                    if (item['' + nameKey + ''] == 0) {
                        insert = false;
                    }
                    else {
                        insert = true;
                        break;
                    }
                }
                else {
                    if (item['' + nameKey + ''] != value.toUpperCase()) {
                        insert = false;
                    }
                    else {
                        insert = true;
                        break;
                    }
                }

            }
            if (!insert) {
                break;
            }
        }
        if (insert) {
            itemsFiltered.push(item);
        }
    });

    itemsCurrentFilter = itemsFiltered;

    updateProductList();
}

function updateCantidadesFiltros() {

    for (let x = 0; x < itemsFullList.filters.marcas.filterValue.length; x++) {
        const count = itemsCurrentFilter.filter((obj) => obj.familia === itemsFullList.filters.marcas.filterValue[x].nombre).length;
        document.getElementById('filterCantidad-marcas-' + itemsFullList.filters.marcas.filterValue[x].nombre).innerText = '(' + count + ')';
        document.getElementById('filterCantidad-marcas-modal-' + itemsFullList.filters.marcas.filterValue[x].nombre).innerText = '(' + count + ')';
    }

    for (let x = 0; x < itemsFullList.filters.categorias.filterValue.length; x++) {
        const count = itemsCurrentFilter.filter((obj) => obj.categoriaItem === itemsFullList.filters.categorias.filterValue[x].nombre).length;
        document.getElementById('filterCantidad-categorias-' + itemsFullList.filters.categorias.filterValue[x].nombre).innerText = '(' + count + ')';
        document.getElementById('filterCantidad-categorias-modal-' + itemsFullList.filters.categorias.filterValue[x].nombre).innerText = '(' + count + ')';
    }

    for (let x = 0; x < itemsFullList.filters.competitividad.filterValue.length; x++) {
        const count = itemsCurrentFilter.filter((obj) => obj.competitividad === "true").length;
        document.getElementById('filterCantidad-competitividad-' + itemsFullList.filters.competitividad.filterValue[x].nombre).innerText = '(' + count + ')';
        document.getElementById('filterCantidad-competitividad-modal-' + itemsFullList.filters.competitividad.filterValue[x].nombre).innerText = '(' + count + ')';
    }

    for (let x = 0; x < itemsFullList.filters.existencias.filterValue.length; x++) {
        const count = itemsCurrentFilter.filter((obj) => obj.disponible > 0).length;
        document.getElementById('filterCantidad-existencias-' + itemsFullList.filters.existencias.filterValue[x].nombre).innerText = '(' + count + ')';
        document.getElementById('filterCantidad-existencias-modal-' + itemsFullList.filters.existencias.filterValue[x].nombre).innerText = '(' + count + ')';
    }
}

function updatePagination(activePage = 1) {
    var to = document.getElementById('paginationCant').value;
    var from = 1;
    var total = itemsCurrentFilter.length;
    to > total ? to = total : to = to;

    var totalFormat = (total).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    document.getElementById('paginationTotal').innerText = totalFormat.split('.')[0].substring(1);

    var iniPagination = 0;
    var endPagination = 0;

    var numPages = Math.ceil(total / (to - from));
    activePage - 2 > 0 ? iniPagination = activePage - 2 : iniPagination = 1;
    activePage + 2 < 5 ? endPagination = 5 : endPagination = activePage + 2;
    endPagination * to > total ? endPagination = numPages : endPagination = endPagination;

    // VACIAR PAGINACIÓN
    var ul = document.getElementById("paginationUl");
    if (ul != undefined) {
        var child = ul.lastElementChild;
        while (child) {
            ul.removeChild(child);
            child = ul.lastElementChild;
        }
    }

    if (total > (to - from) + 1) {
        let linksData = [];
        for (let x = iniPagination; x <= endPagination; x++) {
            let temp = {
                number: x
            }
            linksData.push(temp);
        }
        let linkAnterior = `<li class="page-item ${activePage == 1 ? 'disabled' : ''}"><a class="page-link" onclick="pagination(${from}, ${to}, ${activePage - 1})">Anterior</a></li>`;
        let linkSiguiente = `<li class="page-item ${activePage == endPagination ? 'disabled' : ''}"><a class="page-link" onclick="pagination(${from}, ${to}, ${activePage + 1})">Siguiente</a></li>`
        function linkTemplate(link) {
            return `<li class="page-item ${activePage == link.number ? 'active' : ''} "><a class="page-link" onclick="pagination(${from}, ${to}, ${link.number})">${link.number}</a></li>`
        }
        ul.innerHTML = `
            ${linkAnterior}
            ${linksData.map(linkTemplate).join("")}
            ${linkSiguiente}
        `;
    }

    document.getElementById('paginationLine').classList.remove('d-none');
}

function updateProductList(from = 1, to = parseInt(document.getElementById('paginationCant').value), activePage = 1) {

    // showSkeleton();
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
    for (let x = from - 1; x < to; x++) {
        itemsToShow.push(itemsCurrentFilter[x]);
    }

    var container = document.getElementById("productList");

    var child = container.lastElementChild;
    while (child) {
        container.removeChild(child);
        child = container.lastElementChild;
    }

    let div = document.createElement('div');

    for (let x = 0; x < itemsToShow.length; x++) {

        let mainDiv = div.cloneNode(true);

        if ($(this).width() < 992) {
            document.getElementById('productListDiv').classList = 'col-12';
            document.getElementById('filtersDiv').style.cssText = ''.concat(
                'display: none;'
            );
            mainDiv.setAttribute('class', 'col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem');
            document.getElementById('statusFilter').innerText = 'Mostrar';
        }
        else if ($('#filtersDiv').css('display') == 'block') {
            document.getElementById('productListDiv').classList = 'col-lg-9 col-md-8 col-sm-12';
            mainDiv.setAttribute('class', 'col-sm-6 col-xl-4 cardItem');
            document.getElementById('statusFilter').innerText = 'Ocultar';
        }
        else {
            document.getElementById('productListDiv').classList = 'col-12';
            document.getElementById('filtersDiv').style.cssText = ''.concat(
                'display: none;'
            );
            mainDiv.setAttribute('class', 'col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem');
            document.getElementById('statusFilter').innerText = 'Mostrar';
        }

        let item = `
            <div class="item">
                <div class="imgItem" onclick="detalleArticulo('${itemsToShow[x]['itemid']}')">
                    <img src="http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/${itemsToShow[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_")}_MD.webp" loading="lazy" onerror="noDisponible(this)" onload="imgLoaded(this)">
                </div>
                <div class="itemInfo" onclick="detalleArticulo('${itemsToShow[x]['itemid']}')">
                    <div class="itemDescriptionContainer">
                        <h5 class="itemDescription">${itemsToShow[x]['purchasedescription']}</h5>
                    </div>
                    <h5 class="itemManufacturer">${itemsToShow[x]['itemid']} - ${itemsToShow[x]['familia']} - <span class="categoriaDescription">${itemsToShow[x]['categoriaItem']}</span></h5>
                    <div class="precios">
                        ${getPreciosItem(itemsToShow[x])}
                    </div>
                </div>
                <actions class="itemActions row">
                    <div class="col-12">
                        <button class="btn-actions" onclick="detalleArticulo('${itemsToShow[x]['itemid']}')">Ver producto</button>
                    </div>
                    <div class="col-12 input-group mt-2">
                        <input type="number" value="${itemsToShow[x]['multiploVenta']}" step="${itemsToShow[x]['multiploVenta']}" min="${itemsToShow[x]['multiploVenta']}" class="form-control" id="input-cantidad-${itemsToShow[x]['itemid']}"><div class="input-group-append"><button class="btn btn-indar" onclick="comprar('${itemsToShow[x]['itemid']}')" type="button">Comprar</button></div>
                    </div>
                </actions>
            </div>

            ${itemsToShow[x]['competitividad'] == "true" ? '<div class="ribbon-indar"><img src="/assets/customers/img/png/ribbon-mejor-precio.png" loading="lazy"></div>' : ''}
        `;

        mainDiv.innerHTML = item;
        container.appendChild(mainDiv);
    }

    container.style.display = 'block';
    updatePagination(parseInt(activePage));
    updateCantidadesFiltros();
    window.scrollTo(0, 0);
}

function hideSkeleton() {
    document.getElementById('productList-skeleton').style.display = 'none';
    document.getElementById('productListContainer').style.display = 'block';
}

function showSkeleton() {
    document.getElementById('productList-skeleton').style.display = 'block';
    document.getElementById('productListContainer').style.display = 'none';
}

function toggleFilters() {
    var status = document.getElementById('statusFilter').innerText;
    var cards = document.getElementsByClassName('cardItem');

    if (status == 'Ocultar') {
        document.getElementById('filtersDiv').style.display = 'none';
        document.getElementById('productListDiv').classList = 'col-12';
        document.getElementById('statusFilter').innerText = 'Mostrar';
        for (const card of [...cards]) {
            card.className = "col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem";
        }
    }
    else {
        document.getElementById('filtersDiv').style.display = 'block';
        document.getElementById('productListDiv').classList = 'col-lg-9 col-md-8 col-sm-12';
        document.getElementById('statusFilter').innerText = 'Ocultar';
        for (const card of [...cards]) {
            card.className = "col-sm-6 col-xl-4 cardItem";
        }
    }

}

function activeModalFilters() {
    if (document.getElementById('filterHideShowSquare').classList.contains('collapsed')) {
        $('.modalFilters').slideDown();
        $('#filterHideShowSquare').toggleClass('collapsed');
    }
    else {
        $('.modalFilters').slideUp();
        $('#filterHideShowSquare').toggleClass('collapsed');
    }
}

function getPreciosItem(item) {
    var precioLista = (item['price']).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    var descuentos = '';
    if (item['promoART'] == null) {
        descuentos = "<p class='precio'><span class='precio-min'>$</span><span class='precio-lista'>" + precioLista.split('.')[0].substring(1) + "</span><span class='precio-min'>" + precioLista.split('.')[1] + "</span> + IVA</span></p>";
    }
    else {
        var y = 0;
        while (y < item['promoART'].length) {
            var precioClienteDescuento = ((100 - item['promoART'][y]['descuento']) * item['price']) / 100;
            precioClienteDescuento = (precioClienteDescuento).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            if (item['promoART'][y]['cantidad'] == 1 || item['promoART'][y]['cantidad'] <= item['multiploVenta']) {
                descuentos = "<p class='precio'><span class='precio-min'>$</span><span class='precio-lista'>" + precioClienteDescuento.split('.')[0].substring(1) + "</span><span class='precio-min'>" + precioClienteDescuento.split('.')[1] + "</span> + IVA</span></p>";
            }
            else if (y == 0) {
                descuentos = "<p class='precio'><span class='precio-min'>$</span><span class='precio-lista'>" + precioLista.split('.')[0].substring(1) + "</span><span class='precio-min'>" + precioLista.split('.')[1] + "</span> + IVA</span></p>";
            }

            y++;
        }
    }
    return descuentos;
}

function adjustFixedFilters() {
    // Distance from top of document to top of footer.
    topOfFooter = $('.footer').position().top;
    // Distance user has scrolled from top, adjusted to take in height of sidebar (570 pixels inc. padding).
    scrollDistanceFromTopOfDoc = $(document).scrollTop() + $('#filtersDiv').height() + 200;
    // Difference between the two.
    scrollDistanceFromTopOfFooter = scrollDistanceFromTopOfDoc - topOfFooter;

    // If user has scrolled further than footer,
    // pull sidebar up using a negative margin.
    if (scrollDistanceFromTopOfDoc > topOfFooter) {
        $('#filtersDiv').css('margin-top', 0 - scrollDistanceFromTopOfFooter);
    } else {
        $('#filtersDiv').css('margin-top', 45);
    }
}

function orderByKey(key, order, type) {

    if (key == 'price') {
        itemsCurrentFilter.sort((a, b) => {
            var priceA;
            a['promoART'] != undefined ? priceA = ((100 - a['promoART'][0]['descuento']) * a['price']) / 100 : priceA = a['price'];
            var priceB;
            b['promoART'] != undefined ? priceB = ((100 - b['promoART'][0]['descuento']) * b['price']) / 100 : priceB = b['price'];

            if (order == 'asc') {
                return priceA - priceB;
            }
            else {
                return priceB - priceA;
            }
        });
    }
    else {
        itemsCurrentFilter.sort((a, b) => {
            if (order == 'asc' && type == 'number') {
                return a[key] - b[key];
            }
            else if(order == 'asc' && type == 'string'){
                if (a[key] > b[key]) {
                    return 1;
                }
                if (b[key] > a[key]) {
                    return -1;
                }
                return 0;
            }
            else if(order == 'desc' && type == 'number'){
                return b[key] - a[key];
            }
        });
    }

    showSkeleton();
    updateProductList();
    setTimeout(() => {
        hideSkeleton();
    }, 1000);
}

function comprar(item) {
    var cantidad = document.getElementById('input-cantidad-' + item).value;
    console.log('Comprar ' + cantidad + ' de ' + item);
}



// RELOAD SRC OF IMAGES AFTER EDITED
// d = new Date();
// $("#myimg").attr("src", "/myimg.jpg?"+d.getTime());