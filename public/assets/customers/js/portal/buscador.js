
var coincidenciasArticulo = 0;
var coincidenciasProveedor = 0;
var coincidenciasMarca = 0;

$(document).ready(function () {
    $("#buscador").keyup(function(e) {
        if(e.keyCode == 32 || e.keyCode == 13 || e.keyCode == 9){
            var cadena = document.getElementById('buscador').value;
            cadena.length > 0 ? buscar(cadena) : console.log('vacio');
        }
        else{
            var cadena = document.getElementById('buscador').value;
            cadena.length > 0 ? highlight(cadena) : console.log('vacio');
        }
    });
});


function buscar(cadena){
    var arrCadena = cadena.split(' ');
    var data = '';
    for(var x = 0; x < arrCadena.length; x++){
        if(arrCadena[x] != ''){
            data = data + arrCadena[x] + ' ~ ';
        }
    }
    data = data.slice(0, -3);
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/portal/busquedaGeneralItem/"+data,
        'type': 'GET',
        'enctype': 'multipart/form-data',
        'async': false,
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            clearSugerencias();
            console.log(data);
            var x = 0;
            var proveedores = [];
            coincidenciasArticulo = 0;
            coincidenciasMarca = 0;
            coincidenciasProveedor = 0;
            while(x < data.length){
                var y = 0;
                while(y < arrCadena.length){
                    if(arrCadena[y] != '' && data[x]['purchasedescription'].includes(arrCadena[y].toUpperCase())){
                        addSugerenciaArticulo(data[x]);
                        coincidenciasArticulo ++;
                    }
                    y++;
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
        },
        error: function (error) {
        }
    });


    $(".resultadoBusqueda").slideDown('500');
    $(".overlayBusqueda").fadeIn('500');
}


function addSugerenciaArticulo(sugerencia){
    var descripcion = sugerencia['purchasedescription'];
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
    console.log(proveedores);
    var x = 0;
    var container = document.getElementById('listSugerenciasProveedor');

    while(x < proveedores.length){
        var proveedor = proveedores[x]['proveedor'] + ' [ '+proveedores[x]['marcas'][0]+' ]';

        var lineSugerencia = document.createElement('div');
        lineSugerencia.setAttribute('class', 'lineSugerencia sugerenciaProveedor');

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
    for(var y = 0; y < descripciones.length; y++){
        var innerHTML = descripciones[y]['innerHTML'];
        innerHTML = innerHTML.replace(removeSpan, '');
    }
    for(var x = 0; x < arrCadena.length; x++){
        if(arrCadena[x] != ''){
            for(var y = 0; y < descripciones.length; y++){
                var index = innerHTML.indexOf(arrCadena[x]);
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