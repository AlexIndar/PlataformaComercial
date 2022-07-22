
var coincidenciasArticulo = 0;
var coincidenciasProveedor = 0;
var coincidenciasMarca = 0;
var timeoutBuscador;
var intervalActive = false;
var intervalBuscador = 1000; //buscar cada segundo, no cada tecla presionada
var sugerencias;

var lastType = ''; //datetime de ultima tecla presionada
var timeToDisable = 1000; // desactivar búsqueda si pasan 2 segundos sin presionar tecla

$(document).ready(function () {

    $(window).click(function () {
        closeSugerencias();
    });

    $('#resultado-busqueda').click(function (event) {
        event.stopPropagation();
    });

    $('#input-busqueda').click(function (event) {
        event.stopPropagation();
    });

    // Si el usuario está loggueado, activar buscador
    document.cookie.indexOf('_usn') >= 0 ? document.getElementById('buscador').removeAttribute('disabled') : document.getElementById('buscador').setAttribute('disabled');

    $("#buscador").keyup(function (e) {
        lastType = new Date();
        var cadena = document.getElementById('buscador').value;
        if (e.keyCode == 8) { //si está borrando
            desactivaBuscador();
            recargaSugerencias(sugerencias); //volver a recargar recuadro de sugerencias pero con las que ya tengo del back, no es necesario volverlas a pedir
            highlight(cadena);
        }
        else if (e.keyCode == 13) {
            buscarFiltro("");
        }
        else {
            (cadena != '' && !intervalActive) && activaBuscador();
        }
        (cadena == '' && intervalActive) && desactivaBuscador();

        if (cadena == '') {
            closeSugerencias();
        }
    });

    $("#buscador").focusin(function () {
        var cadena = document.getElementById('buscador').value;
        (cadena != '' && !intervalActive) && activaBuscador();
    });

});

function activaBuscador() {
    document.getElementById('btnBuscar').style.display = "none";
    document.getElementById('btnSpinner').style.display = "block";
    if (document.getElementById('bigImage-large')) {
        document.getElementById('bigImage-large').classList.add('hide-important');
    }
    $(".resultadoBusqueda").slideDown();
    $(".overlayBusqueda").fadeIn();
    intervalActive = true;
    buscar();
    timeoutBuscador = setInterval(buscar, intervalBuscador);
}

function desactivaBuscador() {
    intervalActive = false;
    clearInterval(timeoutBuscador);
}

function buscar() {
    if ((new Date()) - lastType < timeToDisable) {
        var data = "";
        data = getFilterString();
        busquedaGeneralItem(data)
            .then((resp) => {
                if (resp.length > 0) { sugerencias = resp }
                recargaSugerencias(sugerencias); //cargar sugerencias con respuesta del back
            })
            .catch(console.warn);
    }
    else {
        desactivaBuscador();
    }
}

const busquedaGeneralItem = (data) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/portal/busquedaGeneralItem",
            'data': { "data": data },
            'type': 'POST',
            'enctype': 'multipart/form-data',
            'async': true,
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

function addSugerenciaArticulo(sugerencia) {
    var descripcion = sugerencia['purchasedescription'] + " ";
    var codigo = sugerencia['itemid'];
    var srcImgLogotipo = "http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + sugerencia['familia'].replaceAll(" ", "_").replaceAll("-", "_").replaceAll(".", "_") + ".jpg";
    var container = document.getElementById('listSugerenciasArticulo');

    var lineSugerencia = document.createElement('div');
    lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaArticulo');
    lineSugerencia.setAttribute('onclick', "detalleArticulo(\"" + codigo + "\")");

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

function addSugerenciasProveedor(proveedores) {
    var x = 0;
    var container = document.getElementById('listSugerenciasProveedor');

    while (x < proveedores.length) {
        var proveedor = proveedores[x]['proveedor'] + ' [ ' + proveedores[x]['marcas'][0] + ' ]';

        var lineSugerencia = document.createElement('div');
        lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaProveedor');
        lineSugerencia.setAttribute('onclick', "buscarFiltro(\"" + proveedores[x]['proveedor'] + "\")");

        var h5Sugerencia = document.createElement('h5');
        h5Sugerencia.setAttribute('class', 'h5Sugerencia');

        var spanProveedor = document.createElement('span');
        spanProveedor.innerText = proveedor;

        h5Sugerencia.appendChild(spanProveedor);

        var br = document.createElement('br');


        lineSugerencia.appendChild(h5Sugerencia);
        lineSugerencia.appendChild(br);


        var y = 0;
        while (y < proveedores[x]['marcas'].length) {
            var srcImgLogotipo = "http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + proveedores[x]['marcas'][y].replaceAll(" ", "_").replaceAll("-", "_").replaceAll(".", "_") + ".jpg";
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


function addSugerenciaMarca(marca) {
    coincidenciasMarca++;
    var container = document.getElementById('listSugerenciasMarca');
    var lineSugerencia = document.createElement('div');
    lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaMarca');
    lineSugerencia.setAttribute('onclick', "buscarFiltro(\"" + marca.split(' ')[0] + "\")");

    var h5Sugerencia = document.createElement('h5');
    h5Sugerencia.setAttribute('class', 'h5Sugerencia');

    var spanMarca = document.createElement('span');
    spanMarca.innerText = marca;

    h5Sugerencia.appendChild(spanMarca);

    var srcImgLogotipo = "http://indarweb.dyndns.org:8080/assets/articulos/img/LOGOTIPOS/" + marca.replaceAll(" ", "_").replaceAll("-", "_").replaceAll(".", "_") + ".jpg";
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
    var removeSpan = new RegExp("</?span[^>]*>", "g");

    for (var z = 0; z < descripciones.length; z++) {
        descripciones[z]['innerHTML'] = descripciones[z]['innerHTML'].replace(removeSpan, '');
    }

    for (var x = 0; x < arrCadena.length; x++) {
        if (arrCadena[x] != '') {
            for (var y = 0; y < descripciones.length; y++) {
                var innerHTML = descripciones[y]['innerHTML'];
                var index = innerHTML.indexOf(arrCadena[x].toUpperCase());
                if (index >= 0) {
                    innerHTML = innerHTML.substring(0, index) + "<span style='background-color: yellow;'>" + innerHTML.substring(index, index + arrCadena[x].length) + "</span>" + innerHTML.substring(index + arrCadena[x].length);
                    descripciones[y]['innerHTML'] = innerHTML;
                }
            }
        }
    }
}

function clearSugerencias() {

    var containerArticulos = document.getElementById('listSugerenciasArticulo');
    while (containerArticulos.firstChild) {
        containerArticulos.removeChild(containerArticulos.firstChild);
    }

    var containerMarcas = document.getElementById('listSugerenciasMarca');
    while (containerMarcas.firstChild) {
        containerMarcas.removeChild(containerMarcas.firstChild);
    }

    var containerProveedor = document.getElementById('listSugerenciasProveedor');
    while (containerProveedor.firstChild) {
        containerProveedor.removeChild(containerProveedor.firstChild);
    }

}

function closeSugerencias() {
    $(".resultadoBusqueda").slideUp();
    $(".overlayBusqueda").fadeOut();
    if (document.getElementById('bigImage-large')) {
        document.getElementById('bigImage-large').classList.remove('hide-important');
    }
}

function isNumeric(n) { //validar si ingresó número en la búsqueda, para hacer el filtro desde js con lo que ya se tenga
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function recargaSugerencias(data) {
    var cadena = document.getElementById('buscador').value;
    var arrCadena = cadena.split(' ');
    clearSugerencias();
    var x = 0;
    var proveedores = [];
    coincidenciasArticulo = 0;
    coincidenciasMarca = 0;
    coincidenciasProveedor = 0;
    let buscarCoincidenciasArticulo = 50;
    while (x < data.length) {
        var y = 0;
        var add = true;
        if (coincidenciasArticulo < buscarCoincidenciasArticulo) {
            //validar que la descripción del artículo contenga todo lo que está en el input de búsqueda o que lo contenga en el itemid
            while (y < arrCadena.length) {
                if (!(arrCadena[y] != '' && (data[x]['purchasedescription'].includes(arrCadena[y].toUpperCase()) || data[x]['itemid'].includes(arrCadena[y].toUpperCase())))) {
                    add = false;
                }
                if (arrCadena[y] == '') {
                    add = true;
                }
                y++;
            }
        }
        else {
            add = false;
        }
        //si add es false es porque algo no coincidió, no va a agregarlo como sugerencia
        if (add) {
            addSugerenciaArticulo(data[x]);
            coincidenciasArticulo++;
            y = arrCadena.length;
        }

        if (proveedores.length == 0) {
            var tmp = {
                'proveedor': data[x]['fabricante'],
                'marcas': []
            };

            tmp['marcas'].push(data[x]['familia']);
            proveedores.push(tmp);
        }

        else {
            var proveedor = proveedores.find(o => o.proveedor == data[x]['fabricante']);
            if (proveedor != undefined) {
                if (!proveedor['marcas'].includes(data[x]['familia'])) {
                    proveedor['marcas'].push(data[x]['familia']);
                }
            }
            else {
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
    document.getElementById('btnBuscar').style.display = "block";
    document.getElementById('btnSpinner').style.display = "none";
}

const getFilterString = () => {
    var cadena = document.getElementById('buscador').value;
    var arrCadena = cadena.split(' ');
    var data = '';
    for (var x = 0; x < arrCadena.length; x++) { //Quitar X y comilla doble " porque da problemas al mandarlo al sp 
        if (arrCadena[x] != '' && arrCadena[x].toUpperCase() != 'X' && !arrCadena[x].includes('"') && !arrCadena[x].includes('/')) {
            data = data + arrCadena[x].replaceAll('"', '') + ' ~ ';
        }
        if (arrCadena[x].includes('/') || arrCadena[x].includes('"') || arrCadena[x].toUpperCase == 'X') {
            recargaSugerencias(sugerencias);
        }
    }
    return data.slice(0, -3);
}

function buscarFiltro(filtro) {
    let data = getFilterString();
    if (data != "") {
        if (filtro != "") {
            filtro = filtro.split(' ')[0];
            data != '' ? filtro = filtro + ' ~ ' + data : filtro = filtro;
        }
        else {
            filtro = data;
        }
        window.location = "/portal/busqueda/" + filtro;
    }
}

function detalleArticulo(codigo) {
    window.location.href = '/portal/detallesProducto/' + codigo.replace(' ', '_');
}

