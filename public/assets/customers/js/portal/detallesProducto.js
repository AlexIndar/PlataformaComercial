 var promociones = [];



var bigImageHeight = $('.bigImage').height();
$('.thumbnails').css('max-height', bigImageHeight);
var urlZoom;


$(document).ready(function () {

    urlZoom = document.getElementById("bigImage").src;

    calculaPrecioCliente();
    validateActivePromo();
    var evt = new Event();
    var m = new Magnifier(evt);
    

    var bigImageHeight = $('.bigImage').height();
    $('.thumbnails').css('max-height', bigImageHeight);

    if($(this).width() <= 991){
        document.getElementById('img-magnifier-container').setAttribute('class', 'col-12 img-magnifier-container');
        m.attach({
            thumb:  '#bigImage',
            large: urlZoom,
            mode: 'inside',
            largeWrapper: 'preview',
            zoom: 3,
            zoomable: true,
            onthumbenter: function () {
                document.getElementById('preview').style.border = '1px solid black';
            },
            onthumbleave: function () {
                document.getElementById('preview').style.border = 'none';
            },
        });
    }
    else{
        document.getElementById('img-magnifier-container').setAttribute('class', 'col-lg-10 col-md-9 col-sm-12 img-magnifier-container');
        m.attach({
            thumb:  '#bigImage',
            large: urlZoom,
            // mode: 'inside',
            largeWrapper: 'preview',
            zoom: 3,
            zoomable: true,
            onthumbenter: function () {
                document.getElementById('preview').style.border = '1px solid black';
                document.getElementById('preview').style.boxShadow = '1px 1px 10px 2px #ccc';
            },
            onthumbleave: function () {
                document.getElementById('preview').style.border = 'none';
                document.getElementById('preview').style.boxShadow = 'none';
            },
        });
    }

    $('#bigImage-large').attr("src", urlZoom);

    $(window).on('resize', function(){
        if($(this).width() <= 991){
            document.getElementById('img-magnifier-container').setAttribute('class', 'col-12 img-magnifier-container');
        }
        else{
            document.getElementById('img-magnifier-container').setAttribute('class', 'col-lg-10 col-md-9 col-sm-12 img-magnifier-container');
        }
        var bigImageHeight = $('.bigImage').height();
        $('.thumbnails').css('max-height', bigImageHeight);
    });

    $('.thumbnail').hover(function() {
        var clicked = $(this);
        var newSelection = clicked.data('big');
        var img = $('.bigImage').attr("src", newSelection);
        
        $('#bigImage-large').attr("src", newSelection);
        
        var activeId = parseInt(clicked.data('number'));
        document.getElementById('numberSelected').innerText = activeId+' ';
        clicked.parent().find('.thumbnail').removeClass('activeThumbnail');
        clicked.addClass('activeThumbnail');
        $('.bigImage').append(img.fadeIn('slow'));
    });

});


function slide(to){
    var cantThumb = document.querySelectorAll('.thumbnail').length;
    var active = document.querySelector('.activeThumbnail');
    var activeId = active.id;
    var idSplit = activeId.split('-');
    var activeNumber = idSplit.pop();
    var newActiveNumber = 0;
    if(parseInt(activeNumber) + (to) > cantThumb){
        newActiveNumber = 1;
    }
    else if(parseInt(activeNumber) + (to) < 1){
        newActiveNumber = cantThumb;
    }
    else{
        newActiveNumber = parseInt(activeNumber) + (to);
    }

    document.getElementById('numberSelected').innerText = newActiveNumber + ' ';
    var newActive = idSplit.join('-') + '-' + newActiveNumber;
    active.classList.remove('activeThumbnail');
    document.getElementById(newActive).classList.add('activeThumbnail');
    var newSelection = document.getElementById(newActive).src;
    var img = $('.bigImage').attr("src", newSelection);
    $('.bigImage').append(img.fadeIn('slow'));
    
}

function stepUp(){
    document.getElementById('quantity').stepUp();
    updatePrecioCliente();

}

function stepDown(){
    document.getElementById('quantity').stepDown();
    updatePrecioCliente();
}

function noDisponible(img) {
    img.src = '/assets/customers/img/jpg/imagen_no_disponible.jpg';
}

function calculaPrecioCliente(){
    let multiploVenta = parseInt(document.getElementById('multiploVenta').innerText);
    let precioLista = parseFloat(document.getElementById('precioLista').innerText);
    let precioCliente = 0;
    let promoART = document.querySelectorAll('[id^="promoART"]');
    promoART.forEach(promo => {
        let p = promo.id.split('-');
        let temp = {
            cantidad: parseFloat(p[1]),
            descuento: parseFloat(p[2])
        };
        promociones.push(temp);
    });

    if (promociones.length > 0) {
        var y = 0;
        while (y < promociones.length) {
            if (multiploVenta >= promociones[y]['cantidad']) {
                precioCliente = ((100 - promociones[y]['descuento']) / 100) * precioLista;
            }
            if (precioCliente == 0)
                    precioCliente = ((100 - promociones[0]['descuento']) / 100) * precioLista;
            y++;
        }
    }

    if (precioCliente == 0)
        precioCliente =  precioLista;

    let precioClienteFormat = ((precioCliente)).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
    });

    document.getElementById('precioCliente').innerText = precioClienteFormat +' + IVA';
}

function updatePrecioCliente(){
    let cant = parseInt(document.getElementById('quantity').value);
    validateActivePromo();
    let precioLista = parseFloat(document.getElementById('precioLista').innerText);
    let precioClienteActual = 0;
    if (document.getElementById('quantity').value != '') {
        getPrecioClientePromo();
        precioClienteActual = getPrecioClientePromo().toFixed(2);
        let precioClienteFormat = ((precioClienteActual * cant)).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
    
        document.getElementById('precioCliente').innerText = precioClienteFormat +' + IVA';
    }
    else {
        precioClienteActual = precioLista;
        let precioClienteFormat = ((precioClienteActual)).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
    
        document.getElementById('precioCliente').innerText = precioClienteFormat +' + IVA';
    }
    
}

function validateActivePromo(){
    let cant = parseInt(document.getElementById('quantity').value);
    let badgesPromo = document.querySelectorAll('[id^="promoART"]');
    
    badgesPromo.forEach((promo) => {
        if(promo.classList.contains('activePromo')){
            promo.classList.remove('activePromo');
        }
    })
 
    for(let x = badgesPromo.length - 1; x >= 0; x --){
        let minPzas = parseInt(badgesPromo[x].id.split('-')[1]);
        if(parseInt(cant) >= minPzas){
            minPzas == 1 ? document.getElementById('promoMinPzas').innerText = minPzas + ' pieza' : document.getElementById('promoMinPzas').innerText = minPzas + ' piezas';
            badgesPromo[x].classList.add('activePromo');
            break;
        }
    }    
}

function updateQuantityByPromo(cant){
    document.getElementById('quantity').value = cant - 1;
    stepUp();
}

function getPrecioClientePromo() {
    let cant = parseInt(document.getElementById('quantity').value);
    let precioLista = parseFloat(document.getElementById('precioLista').innerText);
    let precioCliente = 0;
    if (cant != null && cant != NaN && cant != 0) {
        if (promociones.length > 0) {
            for (let y = 0; y < promociones.length; y++) {
                if (cant >= promociones[y]['cantidad']) {
                    precioCliente = ((100 - promociones[y]['descuento']) / 100) * precioLista;
                }
            }
            if (precioCliente == 0)
                    precioCliente = ((100 - promociones[0]['descuento']) / 100) * precioLista;
        }


        if (precioCliente == 0)
            precioCliente = precioLista;

    }
    else {
        precioCliente = precioLista;
    }

    return precioCliente;
}