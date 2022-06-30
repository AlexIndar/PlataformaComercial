
var coincidenciasArticulo = 0;
var coincidenciasProveedor = 0;
var coincidenciasMarca = 0;
var timeoutBuscador;
var intervalActive = false;
var intervalBuscador = 2000;
var sugerencias;

var lastType = ''; //datetime de ultima tecla presionada. Si pasó más de 4 segundos desactivar refresh
var timeToDisable = 4000; /* ms */

$(document).ready(function () {

    document.cookie.indexOf('_usn') >= 0 ? document.getElementById('buscador').removeAttribute('disabled') : document.getElementById('buscador').setAttribute('disabled');

    $("#buscador").keyup(function(e) {
        lastType = new Date();
        var cadena = document.getElementById('buscador').value;
        if(e.keyCode == 8){
            desactivaBuscador();
            recargaSugerencias(sugerencias); //volver a recargar recuadro de sugerencias pero con las que ya tengo del back, no es necesario volverlas a pedir
            highlight(cadena);
        }
        else{
            cadena != '' && !intervalActive ? activaBuscador() : console.log('vacio');
        }
        cadena == '' && intervalActive ? desactivaBuscador() : console.log('buscando');

        if(cadena == ''){
            closeSugerencias();
        }
    });

    $("#buscador").focusout(function(){
        desactivaBuscador();
        closeSugerencias();
    });

    $("#buscador").focusin(function(){
        var cadena = document.getElementById('buscador').value;
        cadena != '' && !intervalActive ? activaBuscador() : console.log('vacio');
    });

});

function activaBuscador(){
    $(".resultadoBusqueda").slideDown();
    $(".overlayBusqueda").fadeIn();
    intervalActive = true;
    buscar();
    timeoutBuscador = setInterval(buscar, intervalBuscador);
}

function desactivaBuscador(){
    intervalActive = false;
    clearInterval(timeoutBuscador);
}

function buscar(){
    if((new Date()) - lastType < timeToDisable){
        var data = "";
        data = getFilterString();
        console.log(data);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/portal/busquedaGeneralItem",
            'data': {"data": data},
            'type': 'POST',
            'enctype': 'multipart/form-data',
            'async': false,
            'timeout': 2 * 60 * 60 * 1000,
            success: function (data) {
                if(data.length > 0){
                    sugerencias = data;
                }
                recargaSugerencias(sugerencias); //cargar sugerencias con respuesta del back
            },
            error: function (error) {
            }
        });  
    }
    else{
        desactivaBuscador();
    }
}


function addSugerenciaArticulo(sugerencia){
    var descripcion = sugerencia['purchasedescription'] + " ";
    var codigo = sugerencia['itemid'];
    var srcImgLogotipo =  "http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + sugerencia['familia'].replaceAll(" ", "_").replaceAll("-", "_").replaceAll(".", "_") + ".jpg";
    var container = document.getElementById('listSugerenciasArticulo');
    
    var lineSugerencia = document.createElement('div');
    lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaArticulo');

    var h5Sugerencia = document.createElement('h5');
    h5Sugerencia.setAttribute('class', 'h5Sugerencia');

    var spanDescripcion = document.createElement('span');
    spanDescripcion.setAttribute('class', 'descripcionArticulo')
    spanDescripcion.innerText = descripcion;

    var spanCodigo = document.createElement('span');
    spanCodigo.innerText = codigo;


    h5Sugerencia.appendChild(spanDescripcion);
    h5Sugerencia.appendChild(spanCodigo);

    var br = document.createElement('br');

    var imgSugerencia = document.createElement('img');
    imgSugerencia.setAttribute('class', 'imgSugerencia');
    imgSugerencia.setAttribute('src', srcImgLogotipo);

    var stars = document.createElement('div');
    stars.setAttribute('class', 'Stars');
    stars.setAttribute('style', '--rating: 5;');

    lineSugerencia.appendChild(h5Sugerencia);
    lineSugerencia.appendChild(br);
    lineSugerencia.appendChild(imgSugerencia);
    lineSugerencia.appendChild(stars);

    container.appendChild(lineSugerencia);
}

function addSugerenciasProveedor(proveedores){
    var x = 0;
    var container = document.getElementById('listSugerenciasProveedor');

    while(x < proveedores.length){
        var proveedor = proveedores[x]['proveedor'] + ' [ '+proveedores[x]['marcas'][0]+' ]';

        var lineSugerencia = document.createElement('div');
        lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaProveedor');
        lineSugerencia.setAttribute('onclick', "buscarFiltro(\""+proveedores[x]['proveedor']+"\")");

        var h5Sugerencia = document.createElement('h5');
        h5Sugerencia.setAttribute('class', 'h5Sugerencia');
    
        var spanProveedor = document.createElement('span');
        spanProveedor.innerText = proveedor;
    
        h5Sugerencia.appendChild(spanProveedor);

        var br = document.createElement('br');

        
        lineSugerencia.appendChild(h5Sugerencia);
        lineSugerencia.appendChild(br);

        var y = 0;
        while(y < proveedores[x]['marcas'].length){
            var srcImgLogotipo =  "http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + proveedores[x]['marcas'][y].replaceAll(" ", "_").replaceAll("-", "_").replaceAll(".", "_") + ".jpg";
            var imgSugerencia = document.createElement('img');
            imgSugerencia.setAttribute('class', 'imgSugerencia');
            imgSugerencia.setAttribute('src', srcImgLogotipo);
            lineSugerencia.appendChild(imgSugerencia);
            addSugerenciaMarca(proveedores[x]['marcas'][y]);
            y++;
        }
    
    
        container.appendChild(lineSugerencia);
        x++;
    }
}


function addSugerenciaMarca(marca){
    coincidenciasMarca ++;
    var container = document.getElementById('listSugerenciasMarca');
    var lineSugerencia = document.createElement('div');
    lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaMarca');
    
    var h5Sugerencia = document.createElement('h5');
    h5Sugerencia.setAttribute('class', 'h5Sugerencia');

    var spanMarca = document.createElement('span');
    spanMarca.innerText = marca;

    h5Sugerencia.appendChild(spanMarca);

    var srcImgLogotipo =  "http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + marca.replaceAll(" ", "_").replaceAll("-", "_").replaceAll(".", "_") + ".jpg";
    var imgSugerencia = document.createElement('img');
    imgSugerencia.setAttribute('class', 'imgSugerencia ml-2');
    imgSugerencia.setAttribute('src', srcImgLogotipo);

    lineSugerencia.appendChild(h5Sugerencia);
    lineSugerencia.appendChild(imgSugerencia);
    container.appendChild(lineSugerencia);

}


function highlight(cadena) {
    var arrCadena = cadena.split(' ');
    var descripciones = document.getElementsByClassName('descripcionArticulo');
    var removeSpan = new RegExp("</?span[^>]*>","g");

    for(var z = 0; z < descripciones.length; z++){
        descripciones[z]['innerHTML'] = descripciones[z]['innerHTML'].replace(removeSpan, '');
    }

    for(var x = 0; x < arrCadena.length; x++){
        if(arrCadena[x] != ''){
            for(var y = 0; y < descripciones.length; y++){
                var innerHTML = descripciones[y]['innerHTML'];
                var index = innerHTML.indexOf(arrCadena[x].toUpperCase());
                if(index >= 0){
                    innerHTML = innerHTML.substring(0,index) + "<span style='background-color: yellow;'>" + innerHTML.substring(index,index+arrCadena[x].length) + "</span>" + innerHTML.substring(index + arrCadena[x].length);
                    descripciones[y]['innerHTML'] = innerHTML;
                }
            }
        }
    }
}

function clearSugerencias(){
    $('#listSugerenciasArticulo').empty();
    $('#listSugerenciasProveedor').empty();
    $('#listSugerenciasMarca').empty();
}

function closeSugerencias(){
    $(".resultadoBusqueda").slideUp('100');
    $(".overlayBusqueda").fadeOut('100');
}

function isNumeric(n) { //validar si ingresó número en la búsqueda, para hacer el filtro desde js con lo que ya se tenga
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function recargaSugerencias(data){
    var cadena = document.getElementById('buscador').value;
    var arrCadena = cadena.split(' ');
    clearSugerencias();
    var x = 0;
    var proveedores = [];
    coincidenciasArticulo = 0;
    coincidenciasMarca = 0;
    coincidenciasProveedor = 0;
        while(x < data.length){
            var y = 0;
            var add = true;
            //validar que la descripción del artículo contenga todo lo que está en el input de búsqueda
            while(y < arrCadena.length){
                if(!(arrCadena[y] != '' && data[x]['purchasedescription'].includes(arrCadena[y].toUpperCase()))){
                    add = false;
                }
                if(arrCadena[y] == ''){
                    add = true;
                }
                y++;
            }
            //si add es false es porque algo no coincidió, no va a agregarlo como sugerencia
            if(add){
                addSugerenciaArticulo(data[x]);
                coincidenciasArticulo ++;
                y = arrCadena.length;
            }

            if(proveedores.length == 0){
                var tmp = {
                    'proveedor': data[x]['fabricante'],
                    'marcas': []
                };

                tmp['marcas'].push(data[x]['familia']);
                proveedores.push(tmp);
            }

            else{
                var proveedor = proveedores.find(o => o.proveedor == data[x]['fabricante']);
                if(proveedor != undefined){
                    if(!proveedor['marcas'].includes(data[x]['familia'])){
                        proveedor['marcas'].push(data[x]['familia']);
                    }
                }
                else{
                    var tmp = {
                        'proveedor': data[x]['fabricante'],
                        'marcas': []
                    };
                    tmp['marcas'].push(data[x]['familia']);
                    proveedores.push(tmp);
                }
            }
            x++;
        }
        addSugerenciasProveedor(proveedores);
        coincidenciasProveedor = proveedores.length;
            

        document.getElementById('cantidadRecomendacionesArticulo').innerText = coincidenciasArticulo + " coincidencias";
        document.getElementById('cantidadRecomendacionesProveedor').innerText = coincidenciasProveedor + " coincidencias";
        document.getElementById('cantidadRecomendacionesMarca').innerText = coincidenciasMarca + " coincidencias";
        highlight(cadena);
}

function getFilterString(){
    var cadena = document.getElementById('buscador').value;
        var arrCadena = cadena.split(' ');
        var data = '';
        for(var x = 0; x < arrCadena.length; x++){ //Quitar X y comilla doble " porque da problemas al mandarlo al sp 
            if(arrCadena[x] != '' && arrCadena[x].toUpperCase() != 'X' && !isNumeric(arrCadena[x]) && !arrCadena[x].includes('"') && !arrCadena[x].includes('/')){ 
                data = data + arrCadena[x].replaceAll('"', '') + ' ~ ';
            }
            if(isNumeric(arrCadena[x]) || arrCadena[x].includes('"') || arrCadena[x].includes('/')){
                recargaSugerencias(sugerencias);
            }
        }
        data = data.slice(0, -3);
        return data;
}

function buscarFiltro(filtro){
    console.log('buscar '+filtro);
    var data = getFilterString();
    data != '' ? filtro = filtro + ' ~ '+ data : filtro = filtro;
    window.location = "/portal/busqueda/" + filtro;
}