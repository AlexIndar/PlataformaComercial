var itemsCurrentFilter = [];
var itemsFullList = [];
var filters = [];


$(document).ready(function () {

    $(window).scroll(() => { 
        adjustFixedFilters();
      });
    
    $(window).on("resize", function(event){
        var cards = document.getElementsByClassName('cardItem');
        if( $(this).width() < 992){
            document.getElementById('productListDiv').classList = 'col-12';
            for (const card of [...cards]) {
                card.className = "col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem";
            }
        }
        else{
            var status = document.getElementById('statusFilter').innerText;
            if(status == 'Ocultar'){
                document.getElementById('productListDiv').classList = 'col-lg-9 col-md-8 col-sm-12';
                for (const card of [...cards]) {
                    card.className = "col-sm-6 col-xl-4 cardItem";
                }
            }
            else{
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
        'data': {'filter': filter},
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
           itemsFullList = data;
           itemsCurrentFilter = data['items'];
           showSkeleton();
            updateProductList();
            setTimeout(() => {
                hideSkeleton();
            }, 1500);
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


    $('#showCant').change(function() {
        var cant = $(this).find(":selected").val();
        cant == 'All' ? cant = itemsCurrentFilter.length : cant = cant;
        document.getElementById('paginationCant').setAttribute('value', cant);
         showSkeleton();
        updateProductList();
        setTimeout(() => {
            hideSkeleton();
        }, 1000);
    });

    $('#showCantModal').change(function() {
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


    $('#orderBy').change(function() {
        var value = $(this).find(":selected").val();
        var key;
        var order;
        switch(value){  
            case 'pricemainor': key = 'price'; order = 'asc'; break;
            case 'pricemayor': key = 'price'; order = 'desc'; break;
            case 'itemid': key = 'id'; order = 'asc'; break;
            default: break;
        }
        orderByKey(key, order);
    });

    $('#orderByModal').change(function() {
        var value = $(this).find(":selected").val();
        var key;
        var order;
        switch(value){  
            case 'pricemainor': key = 'price'; order = 'asc'; break;
            case 'pricemayor': key = 'price'; order = 'desc'; break;
            case 'itemid': key = 'id'; order = 'asc'; break;
            default: break;
        }
        orderByKey(key, order);
        activeModalFilters();
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

function hideFilterModal(container){
    if(document.getElementById('filterControl'+container+'Modal').classList.contains('collapsed')){
        $('#filter'+container+'Modal').slideDown();
        $('#filterControl'+container+'Modal').toggleClass('collapsed');
    }
    else{
        $('#filter'+container+'Modal').slideUp();
        $('#filterControl'+container+'Modal').toggleClass('collapsed');
    }
}

function detalleArticulo(codigo){
    window.location.href = '/portal/detallesProducto/'+codigo.replace(' ','_');
}


function pagination(from, to, index){
    var iniPagination = (to - from + 1) * (index - 1) + 1;
    var endPagination = (to - from + 1) * index;
    var minPagination = document.getElementById('paginationCant').value;
    endPagination < minPagination ? endPagination = minPagination : endPagination = endPagination; 
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
    var checksFilter = document.querySelectorAll('[id="checkbox-'+key+'-'+value+'"]');
    for(var i = 0; i < checksFilter.length; i++) {
        checksFilter[i].checked = true;
    }
    addTagFilter(key, value);
    filterItems();
}

function removeFilter(key, value){ //quita filtro del array para llevar control de los filtros aplicados, ejecuta funciones para reacomodar items y eliminar la etiqueta
    var indexFilter = filters.findIndex(o => o.key === key);
    filters[indexFilter].values = filters[indexFilter].values.filter(e => e !== value);
    document.getElementById('filterLabel-'+key+'-'+value).remove();
    var checksFilter = document.querySelectorAll('[id="checkbox-'+key+'-'+value+'"]');
    for(var i = 0; i < checksFilter.length; i++) {
        checksFilter[i].checked = false;
    }
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
    
    var totalFormat = (total).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    document.getElementById('paginationTotal').innerText = totalFormat.split('.')[0].substring(1);
    
    var iniPagination = 0;
    var endPagination = 0;

    var numPages = Math.ceil(total / (to - from));
    activePage - 2 > 0 ? iniPagination = activePage - 2 : iniPagination = 1;
    activePage - 3 > 0 ? iniPagination = activePage - 3 : iniPagination = 1;
    activePage - 4 > 0 ? iniPagination = activePage - 4 : iniPagination = 1;
    activePage + 2 < 5 ? endPagination = 5 : endPagination = activePage + 2;
    endPagination * to > total ? endPagination = numPages : endPagination = endPagination;

    // VACIAR PAGINACIÓN
    var ul = document.getElementById("paginationUl");
    if(ul != undefined){
        var child = ul.lastElementChild; 
        while (child) {
            ul.removeChild(child);
            child = ul.lastElementChild;
        }
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
        }

        var liSiguiente = document.createElement('li');
        activePage == endPagination ? liSiguiente.setAttribute('class', 'page-item disabled') : liSiguiente.setAttribute('class', 'page-item');
        var aSiguiente = document.createElement('a');
        aSiguiente.setAttribute('class', 'page-link');
        aSiguiente.setAttribute('onclick', 'pagination("'+from+'", "'+to+'", "'+(activePage + 1 )+'")');
        aSiguiente.innerText = 'Siguiente';
        liSiguiente.appendChild(aSiguiente);
        ul.appendChild(liSiguiente);

    }
}

function updateProductList(from = 1, to = parseInt(document.getElementById('paginationCant').value), activePage = 1){

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
    console.log(itemsCurrentFilter);
    for(let x = from - 1; x < to; x++){
        itemsToShow.push(itemsCurrentFilter[x]);
    }



    var container = document.getElementById("productList");

    
    var child = container.lastElementChild; 
    while (child) {
        container.removeChild(child);
        child = container.lastElementChild;
    }

    for(let x = 0; x < itemsToShow.length; x ++){

        var mainDiv = document.createElement('div');

        if( $(this).width() < 992){
            document.getElementById('productListDiv').classList = 'col-12';
            document.getElementById('filtersDiv').style.display = 'none';
            mainDiv.setAttribute('class', 'col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem');
            document.getElementById('statusFilter').innerText = 'Mostrar';
        }
        else if($('#filtersDiv').css('display') == 'block'){
            document.getElementById('productListDiv').classList = 'col-lg-9 col-md-8 col-sm-12';
            mainDiv.setAttribute('class', 'col-sm-6 col-xl-4 cardItem');
            document.getElementById('statusFilter').innerText = 'Ocultar';
        }
        else{
            document.getElementById('productListDiv').classList = 'col-12';
            document.getElementById('filtersDiv').style.display = 'none';
            mainDiv.setAttribute('class', 'col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem');
            document.getElementById('statusFilter').innerText = 'Mostrar';
        }


        var divContainer = document.createElement('div');
        divContainer.setAttribute('class', 'item');

        var divImg = document.createElement('div');
        divImg.setAttribute('class', 'imgItem');

        var imgItem = document.createElement('img');
        imgItem.setAttribute('src', "http://indarweb.dyndns.org:8080/assets/articulos/img/02_WEBP_MD/" + itemsToShow[x]['itemid'].replaceAll(" ", "_").replaceAll("-", "_") + "_MD.webp");
        imgItem.setAttribute('loading', 'lazy');
        imgItem.setAttribute('onerror', 'noDisponible(this)');

        divImg.appendChild(imgItem);
        divImg.setAttribute('onclick', "detalleArticulo('"+itemsToShow[x]['itemid']+"')");

        divContainer.appendChild(divImg);

        var itemInfo = document.createElement('div');
        itemInfo.setAttribute('class', 'itemInfo');

        var h5ItemIdManufacturer = document.createElement('h5');
        h5ItemIdManufacturer.setAttribute('class', 'itemManufacturer');
        h5ItemIdManufacturer.innerHTML = itemsToShow[x]['itemid'] + ' - ' + itemsToShow[x]['familia'] + ' - <span class="categoriaDescription">'+itemsToShow[x]['categoriaItem']+'</span>'

        var divDescription = document.createElement('div');
        divDescription.setAttribute('class', 'itemDescriptionContainer');

        var h5Description = document.createElement('h5');
        h5Description.setAttribute('class', 'itemDescription');
        h5Description.innerText = itemsToShow[x]['purchasedescription'];

        divDescription.appendChild(h5Description);

        var precios = document.createElement('div');
        precios.setAttribute('class', 'precios');
        precios.innerHTML = getPreciosItem(itemsToShow[x]);    

        itemInfo.appendChild(divDescription);
        itemInfo.appendChild(h5ItemIdManufacturer);
        itemInfo.appendChild(precios);

        itemInfo.setAttribute('onclick', "detalleArticulo('"+itemsToShow[x]['itemid']+"')");

        

        divContainer.appendChild(itemInfo);

        var actions = document.createElement('actions');
        actions.setAttribute('class', 'itemActions row');
        actions.innerHTML = '<div class="col-12"><button class="btn-actions" onclick="detalleArticulo(\''+itemsToShow[x]['itemid']+'\')">Ver producto</button></div><div class="col-12 input-group mt-2"><input type="number" value='+itemsToShow[x]['multiploVenta']+' step='+itemsToShow[x]['multiploVenta']+' min='+itemsToShow[x]['multiploVenta']+' class="form-control" id="input-cantidad-'+itemsToShow[x]['itemid']+'"><div class="input-group-append"><button class="btn btn-indar" onclick="comprar(\''+itemsToShow[x]['itemid']+'\')" type="button">Comprar</button></div></div>';

        divContainer.appendChild(actions);

        mainDiv.appendChild(divContainer);

        if(itemsToShow[x]['competitividad'] == "true"){
            var ribbon = document.createElement('div');
            ribbon.setAttribute('class', 'ribbon-indar');
            ribbon.innerHTML = '<img src="/assets/customers/img/png/ribbon-mejor-precio.png" loading="lazy">';
            mainDiv.appendChild(ribbon);
        }
        container.appendChild(mainDiv);
    }

    container.style.display = 'block';
    updatePagination(parseInt(activePage));
    window.scrollTo(0, 0);

    // setTimeout(() => {
    //     hideSkeleton();
    // }, 500);

}

function hideSkeleton(){
    document.getElementById('productList-skeleton').style.display = 'none';
    document.getElementById('productListContainer').style.display = 'block';
}

function showSkeleton(){
    document.getElementById('productList-skeleton').style.display = 'block';
    document.getElementById('productListContainer').style.display = 'none';
}

function toggleFilters(){
    var status = document.getElementById('statusFilter').innerText;
    var cards = document.getElementsByClassName('cardItem');

    if(status == 'Ocultar'){
        document.getElementById('filtersDiv').style.display = 'none';
        document.getElementById('productListDiv').classList = 'col-12';
        document.getElementById('statusFilter').innerText = 'Mostrar';
        for (const card of [...cards]) {
            card.className = "col-xs-12 col-sm-6 col-lg-4 col-xl-3 cardItem";
        }
    }
    else{
        document.getElementById('filtersDiv').style.display = 'block';
        document.getElementById('productListDiv').classList = 'col-lg-9 col-md-8 col-sm-12';
        document.getElementById('statusFilter').innerText = 'Ocultar';
        for (const card of [...cards]) {
            card.className = "col-sm-6 col-xl-4 cardItem";
        }
    }

}

function activeModalFilters(){
    if(document.getElementById('filterHideShowSquare').classList.contains('collapsed')){
        $('.modalFilters').slideDown();
        $('#filterHideShowSquare').toggleClass('collapsed');
    }
    else{
        $('.modalFilters').slideUp();
        $('#filterHideShowSquare').toggleClass('collapsed');
    }
}

function getPreciosItem(item){
    // var precioCliente = 0;
    // if (item['promoART'] != null) {
    //     var y = 0;
    //     while (y < item['promoART'].length) {
    //         if (item['multiploVenta'] >= item['promoART'][y]['cantidad']) {
    //             precioCliente = ((100 - item['promoART'][y]['descuento']) / 100) * item['price'];
    //         }
    //         y++;
    //     }
    //     if (precioCliente == 0)
    //         precioCliente = ((100 - item['promoART'][0]['descuento']) / 100) * item['price'];
    // }
    // else
    //     precioCliente = item['price'];
        
    var precioLista = (item['price']).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    // var precioIVA = ((precioCliente * ((100 - 4) / 100) * 1.16)).toLocaleString('en-US', {
    //     style: 'currency',
    //     currency: 'USD',
    // });

    // var precioSugerido;
    // var promociones = "";
    var descuentos = '';
    if (item['promoART'] == null) {
        descuentos = "<p class='precio'><span class='precio-min'>$</span><span class='precio-lista'>" + precioLista.split('.')[0].substring(1) + "</span><span class='precio-min'>"+precioLista.split('.')[1]+"</span> + IVA</span></p>";
        // precioSugerido = item['price'] / 0.65;
        // precioSugerido = (precioSugerido).toLocaleString('en-US', {
        //     style: 'currency',
        //     currency: 'USD',
        // });
        // descuentos = descuentos + "<p class='precio'>Prec. sug. de venta: <span class='precio-right' style='width: auto !important'>" + precioSugerido + " con IVA</span></p>"
    }
    else {
        // precioSugerido = (((100 - item['promoART'][0]['descuento']) * item['price']) / 100) / 0.65;
        var y = 0;
        while (y < item['promoART'].length) {
            var precioClienteDescuento = ((100 - item['promoART'][y]['descuento']) * item['price']) / 100;
            precioClienteDescuento = (precioClienteDescuento).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            if(item['promoART'][y]['cantidad'] == 1 || item['promoART'][y]['cantidad'] <= item['multiploVenta'] ){
                descuentos = "<p class='precio'><span class='precio-min'>$</span><span class='precio-lista'>" + precioClienteDescuento.split('.')[0].substring(1) + "</span><span class='precio-min'>"+precioClienteDescuento.split('.')[1]+"</span> + IVA</span> <span class='text-promo'>" + item['promoART'][y]['descuento'] + "% OFF</span></p>";
            }
            else if(y == 0){
                descuentos = "<p class='precio'><span class='precio-min'>$</span><span class='precio-lista'>" + precioLista.split('.')[0].substring(1) + "</span><span class='precio-min'>"+precioLista.split('.')[1]+"</span> + IVA</span></p>";
            }
            // else{
            //     descuentos = descuentos + "<p class='precio'>"+item['promoART'][y]['cantidad']+" pzas <span class='text-red'>-" + item['promoART'][y]['descuento'] + "% </span></p><span class='precio-min'>$</span><span class='precio-lista'>" + precioClienteDescuento.split('.')[0].substring(1) + "</span><span class='precio-min'>"+precioClienteDescuento.split('.')[1]+"</span> + IVA</span>"
            // }
            y++;
        }
        // precioSugerido = (precioSugerido).toLocaleString('en-US', {
        //     style: 'currency',
        //     currency: 'USD',
        // });
        // descuentos = descuentos + "<p class='precio'>Prec. sug. de venta: <span class='precio-right' style='width: auto !important'>" + precioSugerido + " con IVA</span></p>";
    }
    // descuentos = descuentos + "<p class='precio'>P. Pago IVA incluído: <span class='precio-right' id='precioIVA-" + item['itemid'] + "' style='width: auto !important'>" + precioIVA + "</span></p>"
    
    return descuentos;
}

function adjustFixedFilters(){
    // Distance from top of document to top of footer.
    topOfFooter = $('.footer').position().top;
    // Distance user has scrolled from top, adjusted to take in height of sidebar (570 pixels inc. padding).
    scrollDistanceFromTopOfDoc = $(document).scrollTop() + $('#filtersDiv').height() + 200;
    // Difference between the two.
    scrollDistanceFromTopOfFooter = scrollDistanceFromTopOfDoc - topOfFooter;
  
    // If user has scrolled further than footer,
    // pull sidebar up using a negative margin.
    if (scrollDistanceFromTopOfDoc > topOfFooter) {
      $('#filtersDiv').css('margin-top',  0 - scrollDistanceFromTopOfFooter);
    } else  {
      $('#filtersDiv').css('margin-top', 45);
    }
}

function orderByKey(key, order){

    if(key == 'price'){
        itemsCurrentFilter.sort((a,b) => {
            var priceA;
            a['promoART'] != undefined ? priceA =  ((100 - a['promoART'][0]['descuento']) * a['price']) / 100 : priceA = a['price'];
            var priceB;
            b['promoART'] != undefined ? priceB =  ((100 - b['promoART'][0]['descuento']) * b['price']) / 100 : priceB = b['price'];

            if(order == 'asc'){
                return priceA - priceB;
            }
            else{
                return priceB - priceA;
            }
        });
    }
    else{
        itemsCurrentFilter.sort((a,b) => {
            if(order == 'asc'){
                return a[key] - b[key];
            }
            else{
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

function comprar(item){
    var cantidad = document.getElementById('input-cantidad-'+item).value;
    console.log('Comprar '+cantidad+' de '+item);
}