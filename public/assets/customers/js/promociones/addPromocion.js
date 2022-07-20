var startDate;
var endDate;
var reglas = [];
var cantRegalos = 0; //cantidad de regalos, para saber si quita o agrega
$('document').ready(function () {
    $("body").addClass("sidebar-collapse");

    //Inicia Ajax
    $(document).ajaxStart(function () {
        document.getElementById('div-loading').style.opacity = '1';
        var btnActions = document.getElementsByClassName('btnActions');
        for (var x = 0; x < btnActions.length; x++) {
            btnActions[x].disabled = true;
        }
    });

    //Func Termina Ajax
    $(document).ajaxStop(function () {
        document.getElementById('div-loading').style.opacity = '0';
        var btnActions = document.getElementsByClassName('btnActions');
        for (var x = 0; x < btnActions.length; x++) {
            btnActions[x].disabled = false;
        }
    });

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/promociones/getPromocionesInfo",
        'type': 'GET',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        'async': false,
        success: function (data) {
            reglas = data;
        },
        error: function (error) {
        }
    });

    intervalRules = window.setInterval(checkRules, 1000);

    $(".chosen").chosen({
        no_results_text: "Sin resultados para",
        placeholder_text_single: "Buscar",
        placeholder_text_multiple: "Seleccione una o más opciones",
        max_shown_results: 11, //NÚMERO MÁXIMO DE RESULTADOS EN CADA SELECT PARA QUE AL FILTRAR SEA MÁS RÁPIDO
        hide_results_on_select: false,
    });

    $('#regalos').on('change', function (evt, params) {
        var elements = document.querySelectorAll('#regalos_chosen .chosen-choices .search-choice');
        if (elements.length > cantRegalos) {
            var itemID = (elements[elements.length - 1]['innerText'].split(']'))[0].substring(1);
            var index = 1;
            var selectRegalos = document.getElementById('regalos');
            for (let i = 0; i < elements.length; i++) {
                if ((elements[i]['innerText'].split(']'))[0].substring(1) == itemID) {
                    exists = true;
                    if (index == 1)
                        itemFull = elements[i]['innerText'];
                    index++;
                }
            }
            cantRegalos++;
            var option = document.createElement("option");
            option.text = itemFull + "-" + (index);
            option.value = itemID + '-' + (index);
            selectRegalos.appendChild(option);
            $('#regalos').trigger("chosen:updated");
        }
        else {
            cantRegalos--;
        }

    });



    const fileArticulos = document.getElementById('articulosFile');
    fileArticulos.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'articulos');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const fileCategorias = document.getElementById('categoriasFile');
    fileCategorias.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'categorias');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const fileGiros = document.getElementById('girosFile');
    fileGiros.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'giros');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const fileClientes = document.getElementById('clientesFile');
    fileClientes.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'clientes');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const fileProveedores = document.getElementById('proveedoresFile');
    fileProveedores.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'proveedores');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    const fileMarcas = document.getElementById('marcasFile');
    fileMarcas.addEventListener('change', (event) => {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var wb = XLSX.read(fileData, { type: 'binary' });

            wb.SheetNames.forEach(function (sheetName) {
                var rowObj = XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                var jsonObj = JSON.stringify(rowObj);
                addTags(jsonObj, 'marcas');
            })
        };
        reader.readAsBinaryString(input.files[0]);
    });

    $('#fechas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-fechas').innerHTML = "Estas fechas <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-fechas').classList.remove('green');
            document.getElementById('mensaje-fechas').classList.add('red');
        }
        else {
            document.getElementById('mensaje-fechas').innerHTML = "<strong>Sólo estas fechas</strong> participan en la promoción";
            document.getElementById('mensaje-fechas').classList.add('green');
            document.getElementById('mensaje-fechas').classList.remove('red');
        }
    });

    $('#listaCategoriaClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-categorias').innerHTML = "Estas categorías de clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-categorias').classList.remove('green');
            document.getElementById('mensaje-categorias').classList.add('red');
        }
        else {
            document.getElementById('mensaje-categorias').innerHTML = "<strong>Sólo estas categorías de clientes</strong> participan en la promoción";
            document.getElementById('mensaje-categorias').classList.add('green');
            document.getElementById('mensaje-categorias').classList.remove('red');
        }
    });

    $('#listaGirosClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-giros').innerHTML = "Estos giros de clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-giros').classList.remove('green');
            document.getElementById('mensaje-giros').classList.add('red');
        }
        else {
            document.getElementById('mensaje-giros').innerHTML = "<strong>Sólo estos giros de clientes</strong> participan en la promoción";
            document.getElementById('mensaje-giros').classList.add('green');
            document.getElementById('mensaje-giros').classList.remove('red');
        }
    });

    $('#listaClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-clientes').innerHTML = "Estos clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-clientes').classList.remove('green');
            document.getElementById('mensaje-clientes').classList.add('red');
        }
        else {
            document.getElementById('mensaje-clientes').innerHTML = "<strong>Sólo estos clientes</strong> participan en la promoción";
            document.getElementById('mensaje-clientes').classList.add('green');
            document.getElementById('mensaje-clientes').classList.remove('red');
        }
    });

    $('#listaProveedores').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-proveedores').innerHTML = "Estos proveedores <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-proveedores').classList.remove('green');
            document.getElementById('mensaje-proveedores').classList.add('red');
        }
        else {
            document.getElementById('mensaje-proveedores').innerHTML = "<strong>Sólo estos proveedores</strong> participan en la promoción";
            document.getElementById('mensaje-proveedores').classList.add('green');
            document.getElementById('mensaje-proveedores').classList.remove('red');
        }
    });

    $('#listaMarcas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-marcas').innerHTML = "Estas marcas <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-marcas').classList.remove('green');
            document.getElementById('mensaje-marcas').classList.add('red');
        }
        else {
            document.getElementById('mensaje-marcas').innerHTML = "<strong>Sólo estas marcas</strong> participan en la promoción";
            document.getElementById('mensaje-marcas').classList.add('green');
            document.getElementById('mensaje-marcas').classList.remove('red');
        }
    });

    $('#listaArticulos').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if (clickedIndex == 1) {
            document.getElementById('mensaje-articulos').innerHTML = "Estos artículos <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-articulos').classList.remove('green');
            document.getElementById('mensaje-articulos').classList.add('red');
        }
        else {
            document.getElementById('mensaje-articulos').innerHTML = "<strong>Sólo estos artículos</strong> participan en la promoción";
            document.getElementById('mensaje-articulos').classList.add('green');
            document.getElementById('mensaje-articulos').classList.remove('red');
        }
    });

    $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        autoUpdateInput: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: 'Aplicar',
            daysOfWeek: [
                'Do',
                'Lu',
                'Ma',
                'Mi',
                'Ju',
                'Vi',
                'Sa'
            ],
            monthNames: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ]
        }
    }, function (start, end, label) {
        startDate = start.format('YYYY-MM-DD');
        endDate = end.format('YYYY-MM-DD');
    });


    $('#descuento').on('input', function () {
        var val = document.getElementById('descuento').value;
        document.getElementById('percent-disccount').innerHTML = val;
    });

});

function existingTag(text) {
    var existing = false,
        text = text.toLowerCase();

    $(".tags").each(function () {
        if ($(this).text().toLowerCase() == text) {
            existing = true;
            return "";
        }
    });

    return existing;
}



$(function () {
    $(".tags-new input").focus();

    $(".tags-new input").keyup(function (e) {

        var tag = $(this).val().trim(),
            length = tag.length;

        if (e.key === "Enter" || e.keyCode === 13) {
            tag = tag.substring(0, length);

            if (!existingTag(tag)) {
                var last = document.querySelector('.last');
                if (last != null) {
                    document.querySelector('.last').classList.remove('last');
                }
                $('<li class="tags last"><span>' + tag + '</span><i class="fa fa-times"></i></i></li>').insertBefore($(".tags-new"));
                $(this).val("");
            }
            else {
                $(this).val(tag);
            }
        }


        if (e.key === "Backspace" || e.keyCode === 46) {
            var tag = document.querySelector('.last');
            if (tag != null) {
                if (tag.style.background == "rgb(250, 91, 91)") {
                    tag.remove();
                }
                else {
                    tag.style.background = "rgb(250, 91, 91)";
                }
            }

            var lastTag = document.querySelectorAll(".tags");
            if (lastTag.length != 0) {
                lastTag[lastTag.length - 1].classList.add('last');
            }
        }


    });

    $(document).on("click", ".tags i", function () {
        $(this).parent("li").remove();
    });

});


function triggerInputFile(input) {
    document.getElementById(input + 'File').click();
}


function checkRules() {
    if (reglas.length > 0) {
        document.getElementById('regalos_chosen').style.display = "block";
        document.getElementById('regalosLoading').style.display = "none";
        var selectRegalos = document.getElementById('regalos');
        for (var x = 0; x < reglas[7].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[7][x];
            option.value = (reglas[7][x].split(']'))[0].substring(1);
            selectRegalos.appendChild(option);
        }
        $('#regalos').trigger("chosen:updated");
        document.getElementById('regalos_chosen').style.width = '100%';

        if (document.getElementById('reemplaza_chosen') != undefined) {
            document.getElementById('reemplaza_chosen').style.display = "block";
            document.getElementById('reemplazaLoading').style.display = "none";
            var selectReemplaza = document.getElementById('reemplaza');
            for (var x = 0; x < reglas[8].length; x++) {
                if (!reglas[8][x]['paquete'] && reglas[8][x]['idPaquete'] == 0) {
                    var option = document.createElement("option");
                    option.text = reglas[8][x]['nombrePromo'];
                    option.value = reglas[8][x]['id'];
                    selectReemplaza.appendChild(option);
                }
            }
            $('#reemplaza').trigger("chosen:updated");
            document.getElementById('reemplaza_chosen').style.width = '100%';
        }

        document.getElementById('categorias_chosen').style.display = "block";
        document.getElementById('categoriasLoading').style.display = "none";
        var selectCategorias = document.getElementById('categorias');
        for (var x = 0; x < reglas[1].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[1][x];
            option.value = reglas[1][x];
            selectCategorias.appendChild(option);
        }
        $('#categorias').trigger("chosen:updated");
        document.getElementById('categorias_chosen').style.width = '100%';


        document.getElementById('clientes_chosen').style.display = "block";
        document.getElementById('clientesLoading').style.display = "none";
        var selectClientes = document.getElementById('clientes');
        for (var x = 0; x < reglas[3].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[3][x];
            option.value = (reglas[3][x].split(']'))[0].substring(1);
            selectClientes.appendChild(option);
        }
        $('#clientes').trigger("chosen:updated");
        document.getElementById('clientes_chosen').style.width = '100%';

        document.getElementById('proveedores_chosen').style.display = "block";
        document.getElementById('proveedoresLoading').style.display = "none";
        var selectProveedores = document.getElementById('proveedores');
        for (var x = 0; x < reglas[5].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[5][x];
            option.value = reglas[5][x];
            selectProveedores.appendChild(option);
        }
        $('#proveedores').trigger("chosen:updated");
        document.getElementById('proveedores_chosen').style.width = '100%';

        document.getElementById('marcas_chosen').style.display = "block";
        document.getElementById('marcasLoading').style.display = "none";
        var selectMarcas = document.getElementById('marcas');
        for (var x = 0; x < reglas[6].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[6][x];
            option.value = reglas[6][x];
            selectMarcas.appendChild(option);
        }
        $('#marcas').trigger("chosen:updated");
        document.getElementById('marcas_chosen').style.width = '100%';

        document.getElementById('articulos_chosen').style.display = "block";
        document.getElementById('articulosLoading').style.display = "none";
        var selectArticulos = document.getElementById('articulos');
        for (var x = 0; x < reglas[7].length; x++) {
            var option = document.createElement("option");
            option.text = reglas[7][x];
            option.value = (reglas[7][x].split(']'))[0].substring(1);
            selectArticulos.appendChild(option);
        }
        $('#articulos').trigger("chosen:updated");
        document.getElementById('articulos_chosen').style.width = '100%';

        if (window.location.href.includes('promociones/paquete') || (window.location.href.includes('promociones/editar') && document.getElementById('tipoPromo').value == 'paquete')) { //SI ES PAQUETE, AGREGAR REGALOS A SUBREGLAS
            document.getElementById('regalosSub_chosen').style.display = "block";
            document.getElementById('regalosSubLoading').style.display = "none";
            var selectregalosSub = document.getElementById('regalosSub');
            for (var x = 0; x < reglas[7].length; x++) {
                var option = document.createElement("option");
                option.text = reglas[7][x];
                option.value = (reglas[7][x].split(']'))[0].substring(1);
                selectregalosSub.appendChild(option);
            }
            $('#regalosSub').trigger("chosen:updated");
            document.getElementById('regalosSub_chosen').style.width = '100%';
        }

        clearInterval(intervalRules);
        if (window.location.href.includes('promociones/editar')) { //SI LA PROMOCION VA A SER ACTUALIZADA, CARGAR INFORMACIÓN DEL EVENTO
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "/promociones/getEventById/" + document.getElementById('idPromo').value,
                'type': 'GET',
                'enctype': 'multipart/form-data',
                'timeout': 2 * 60 * 60 * 1000,
                'async': false,
                success: function (data) {
                    addPromoRules(data);
                },
                error: function (error) {
                }
            });
        }

    }
    else {
        document.getElementById('regalos_chosen').style.display = "none";
        if (document.getElementById('reemplaza_chosen') != undefined)
            document.getElementById('reemplaza_chosen').style.display = "none";
        document.getElementById('giros_chosen').style.display = "none";
        document.getElementById('marcas_chosen').style.display = "none";
        document.getElementById('proveedores_chosen').style.display = "none";
        document.getElementById('articulos_chosen').style.display = "none";
        document.getElementById('categorias_chosen').style.display = "none";
        document.getElementById('clientes_chosen').style.display = "none";
    }
}

function addTags(json, id) {
    var jsonObj = JSON.parse(json);
    var selectedOptions = [];
    var key = '';
    switch (id) {
        case 'categorias': key = 'Categoria'; break;
        case 'giros': key = 'Giro'; break;
        case 'clientes': key = 'CompanyId'; break;
        case 'proveedores': key = 'Proveedor'; break;
        case 'marcas': key = 'Marca'; break;
        case 'articulos': key = 'Codigo'; break;
        case 'clientesCuotas': key = 'CompanyId'; break;
        default: break;
    }
    jsonObj.forEach(function (valor, indice, array) {
        selectedOptions.push(valor[key]);
    });
    $('#' + id).val(selectedOptions).trigger('chosen:updated');
}

function downloadTemplate(template) {
    window.location.href = '/downloadTemplate' + template;
}

function validarPromo() {
    var bodyValidations = '';
    var save = true;
    var proveedores = $('#proveedores').chosen().val();
    var marcas = $('#marcas').chosen().val();
    var articulos = $('#articulos').chosen().val();
    if (document.getElementById('nombrePromo').value == '') {
        save = false;
        document.getElementById('nombrePromo').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un nombre para la promoción</h5>';
    }
    else {
        document.getElementById('nombrePromo').classList.remove('invalid-input');
        document.getElementById('nombrePromo').classList.add('valid-input');
    }

    if (startDate == undefined || endDate == undefined) {
        save = false;
        document.getElementById('rangoFechas').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa un rango de fechas para la promoción</h5>';
    }
    else {
        document.getElementById('rangoFechas').classList.remove('invalid-input');
        document.getElementById('rangoFechas').classList.add('valid-input');
    }

    if (document.getElementById('startTime').value == "") {
        save = false;
        document.getElementById('startTime').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa una hora de inicio</h5>';
    }
    else {
        document.getElementById('startTime').classList.remove('invalid-input');
        document.getElementById('startTime').classList.add('valid-input');
    }

    if (document.getElementById('endTime').value == "") {
        save = false;
        document.getElementById('endTime').classList.add('invalid-input');
        bodyValidations += '<h5>Ingresa una hora de fin</h5>';
    }
    else {
        document.getElementById('endTime').classList.remove('invalid-input');
        document.getElementById('endTime').classList.add('valid-input');
    }
    if (proveedores.length == 0 && marcas.length == 0 && articulos.length == 0) {
        save = false;
        bodyValidations += '<h5>Carga proveedores, marcas y/o artículos</h5>';
    }



    if (save && !document.getElementById('btn-guardar').disabled) {
        var giros = $('#giros').chosen().val();
        var categorias = $('#categorias').chosen().val();
        var clientes = $('#clientes').chosen().val();
        var proveedores = $('#proveedores').chosen().val();
        var marcas = $('#marcas').chosen().val();
        var articulos = $('#articulos').chosen().val();


        var optionsClientes = $("#clientes option:selected");
        var valuesClientes = $.map(optionsClientes, function (option) {
            return option.text;
        });

        var optionsArticulos = $("#articulos option:selected");
        var valuesArticulos = $.map(optionsArticulos, function (option) {
            return option.text;
        });


        document.getElementById('listaCategoriaClientes').value == 'negra' ? categorias = reglas[1].filter(x => !categorias.includes(x)) : categorias = $('#categorias').chosen().val();
        document.getElementById('listaClientes').value == 'negra' ? clientes = reglas[3].filter(x => !valuesClientes.includes(x)) : clientes = $('#clientes').chosen().val();
        document.getElementById('listaProveedores').value == 'negra' ? proveedores = reglas[5].filter(x => !proveedores.includes(x)) : proveedores = $('#proveedores').chosen().val();
        document.getElementById('listaMarcas').value == 'negra' ? marcas = reglas[6].filter(x => !marcas.includes(x)) : marcas = $('#marcas').chosen().val();
        document.getElementById('listaArticulos').value == 'negra' ? articulos = reglas[7].filter(x => !valuesArticulos.includes(x)) : articulos = $('#articulos').chosen().val();

        //remove brackets from customers and items lists if list is black

        if (document.getElementById('listaClientes').value == 'negra') {
            for (let x = 0; x < clientes.length; x++) {
                clientes[x] = clientes[x].split(']')[0].substring(1);
            };
        }

        if (document.getElementById('listaArticulos').value == 'negra') {
            for (let x = 0; x < articulos.length; x++) {
                articulos[x] = articulos[x].split(']')[0].substring(1);
            };
        }



        var regalosChosen = document.querySelector('#regalos_chosen .chosen-choices').childNodes;
        var regalos = [];
        for (var x = 1; x < regalosChosen.length - 1; x++) {
            var regalo = regalosChosen[x].innerText.split(']');
            regalo = regalo[0].substring(1);
            regalos.push(regalo);
        }

        var regalos = regalos.join().slice(0, -1);
        var reemplaza = $('#reemplaza').chosen().val();

        var startTime = startDate + " " + document.getElementById('startTime').value + ":00";
        var endTime = endDate + " " + document.getElementById('endTime').value + ":00";

        var listaPedidoPromoRulesD = [];

        for (var x = 0; x < proveedores.length; x++) {
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'PROVEEDOR',
                valor: proveedores[x],
                incluye: document.getElementById('listaProveedores').value == 'blanca' ? true : false,
                idPedidoPromoNavigation: ''
            });
        }


        for (var x = 0; x < marcas.length; x++) {
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'MARCA',
                valor: marcas[x],
                incluye: document.getElementById('listaMarcas').value == 'blanca' ? true : false,
                idPedidoPromoNavigation: ''
            });
        }



        for (var x = 0; x < articulos.length; x++) {
            listaPedidoPromoRulesD.push({
                idPedidoPromoD: 0,
                idPedidoPromo: 0,
                tipo: 'ARTICULO',
                valor: articulos[x],
                incluye: document.getElementById('listaArticulos').value == 'blanca' ? true : false,
                idPedidoPromoNavigation: ''
            });
        }

        var cuotasList = [];
        var cuotasObj = {
            'customer': '',
            'importeCuota': 0,
            'p1': '0',
            'p2': '0',
            'p3': '0',
        };
        cuotasList.push(cuotasObj);

        var idPromo;
        if (window.location.href.includes('promociones/editar'))//SI LA PROMO SERÁ ACTUALIZADA, ENVIAR ID PROMO
            idPromo = document.getElementById('idPromo').value;
        else
            idPromo = 0;



        var json = {
            id: idPromo,
            nombrePromo: document.getElementById('nombrePromo').value,
            descuento: document.getElementById('descuento').value = "" ? 0 : parseFloat(document.getElementById('descuento').value),
            descuentoWeb: document.getElementById('descuentoWeb').value = "" ? 0 : parseFloat(document.getElementById('descuentoWeb').value),
            puntosIndar: document.getElementById('puntos').value == "" ? 0 : parseInt(document.getElementById('puntos').value),
            plazosIndar: parseInt(document.getElementById('plazos').value),
            regalosIndar: regalos.toString(),
            reemplazaRegalo: reemplaza.toString() != '' ? parseInt(reemplaza.toString()) : 0,
            categoriaClientes: categorias.toString(),
            categoriaClientesIncluye: document.getElementById('listaCategoriaClientes').value == 'blanca' ? parseInt('1') : parseInt('0'),
            gruposclientesIds: giros.toString(),
            gruposclientesIncluye: document.getElementById('listaGirosClientes').value == 'blanca' ? true : false,
            clientesId: clientes.toString(),
            clientesIncluye: document.getElementById('listaClientes').value == 'blanca' ? true : false,
            plazo: '',
            montoMinCash: document.getElementById('preciomin').value == "" ? 0 : parseFloat(document.getElementById('preciomin').value),
            montoMinQty: document.getElementById('cantidadmin').value == "" ? 0 : parseInt(document.getElementById('cantidadmin').value),
            fechaInicio: startTime,
            fechaFin: endTime,
            paquete: false,
            idPaquete: 0,
            pedidoPromoRulesD: listaPedidoPromoRulesD,
            cuotasPersonalizadas: cuotasList,
        }

        console.log(json);

        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "storePromo",
            'type': 'POST',
            'dataType': 'json',
            'data': json,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            'async': false,
            success: function (data) {
                if (data['status'] != undefined) {
                    console.log(data);
                    alert(Object.entries(data['errors']));
                }
                else {
                    alert('Promoción guardada correctamente');
                    window.location.href = '/promociones';
                }
            },
            error: function (error) {
                console.log(error);
                alert('Error guardando promoción');
                // window.location.href = '/promociones';
            }
        });
    }

    if (!save) {
        document.getElementById('bodyValidations').innerHTML = bodyValidations;
        var modal = document.getElementById('validateModal');
        modal.style.opacity = 1;
        modal.style.zIndex = 1000;
        modal.classList.add("active-modal");
    }

    if (save && document.getElementById('btn-guardar').disabled) {
        document.getElementById('btn-guardar').disabled = false;
        document.getElementById('btn-guardar').classList.add('btnActions');
    }
}

function clearSelection(id) {
    document.getElementById('listaDelete').innerHTML = id;
    var modal = document.getElementById('deleteModal');
    modal.style.opacity = 1;
    modal.style.zIndex = 1000;
    modal.classList.add("active-modal");
}

function closeModal() {
    var activeModal = document.getElementsByClassName("active-modal");
    if (activeModal.length > 1)
        activeModal = activeModal[1];
    else
        activeModal = activeModal[0];
    activeModal.style.opacity = 0;
    activeModal.style.zIndex = -1000;
    activeModal.classList.remove("active-modal");
}

function clearSelectionAccept() {
    var list = document.getElementById('listaDelete').innerHTML.toLowerCase();
    closeModal();
    $('#' + list).val('').trigger('chosen:updated');
    $('#' + list + "File").val('');
}

function addPromoRules(rules) {

    startDate = rules['fechaInicio'].split('T')[0];
    endDate = rules['fechaFin'].split('T')[0];
    document.getElementById('rangoFechas').style.display = "block";
    document.getElementById('fechasLoading').style.display = "none";
    var pedidoPromoRules = rules['pedidoPromoRulesD'];
    var regalos = rules['regalosIndar'];
    var reemplazaRegalo = rules['reemplazaRegalo'];

    var clientes = rules['clientesId'];
    var categorias = rules['categoriaClientes'];

    let negativeClientes = [];
    let negativeCategorias = [];
    let negativeArticulos = [];

    let incluyeProveedores = true;
    let incluyeMarcas = true;
    let incluyeArticulos = true;

    if (!rules['clientesIncluye']) { //si se guardó con clientes como lista negra, mostrar los que no se incluyen
        let tempClientesReglas = [...reglas[3]];
        for (let x = 0; x < tempClientesReglas.length; x++) {
            tempClientesReglas[x] = tempClientesReglas[x].split(']')[0].substring(1);
        };
        negativeClientes = tempClientesReglas.filter(x => !rules['clientesId'].includes(x));
        $('#listaClientes').val('negra');
        $('#listaClientes').selectpicker('refresh');
        document.getElementById('mensaje-clientes').innerHTML = "Estos clientes <strong>no participan</strong> en la promoción";
        document.getElementById('mensaje-clientes').classList.remove('green');
        document.getElementById('mensaje-clientes').classList.add('red');
    }

    if (rules['categoriaClientesIncluye'] == 0) { //si se guardó con categorias como lista negra, mostrar las que no se incluyen
        negativeCategorias = reglas[1].filter(x => !categorias.includes(x));
        $('#listaCategoriaClientes').val('negra');
        $('#listaCategoriaClientes').selectpicker('refresh');
        document.getElementById('mensaje-categorias').innerHTML = "Estas categorías de clientes <strong>no participan</strong> en la promoción";
        document.getElementById('mensaje-categorias').classList.remove('green');
        document.getElementById('mensaje-categorias').classList.add('red');
    }

    var proveedores = [];
    var marcas = [];
    var articulos = [];
    if (regalos != null) {
        regalos = regalos.split(',');
        cantRegalos = regalos.length;
        var selectRegalos = document.getElementById('regalos');
        var regalosFinal = [];
        var repeticiones = 1;
        for (var x = 0; x < regalos.length; x++) {
            if (regalos[x] == regalos[x + 1]) {
                var fullnameRegalo = '';
                repeticiones++;
                for (let i = 0; i < reglas[7].length; i++) {
                    if (reglas[7][i].includes(regalos[0])) {
                        fullnameRegalo = reglas[7][i];
                        break;
                    }
                }
                var option = document.createElement("option");
                option.text = fullnameRegalo + "-" + repeticiones;
                option.value = regalos[x] + "-" + repeticiones;
                selectRegalos.appendChild(option);
                regalosFinal.push(regalos[x] + "-" + repeticiones);
            }
            else {
                var fullnameRegalo = '';
                repeticiones++;
                for (let i = 0; i < reglas[7].length; i++) {
                    if (reglas[7][i].includes(regalos[x])) {
                        fullnameRegalo = reglas[7][i];
                        break;
                    }
                }
                var option = document.createElement("option");
                option.text = fullnameRegalo + "-" + repeticiones;
                option.value = regalos[x] + "-" + repeticiones;
                selectRegalos.appendChild(option);
                regalosFinal.push(regalos[x]);
                repeticiones = 1;
            }
        }
        $('#regalos').trigger("chosen:updated");
        $('#regalos').val(regalosFinal).trigger('chosen:updated');
    }
    if (reemplazaRegalo != 0) {
        $('#reemplaza').val(reemplazaRegalo).trigger('chosen:updated');
    }
    if (clientes != null) {
        clientes = clientes.split(',');
        rules['clientesIncluye'] ? $('#clientes').val(clientes).trigger('chosen:updated') : $('#clientes').val(negativeClientes).trigger('chosen:updated');
    }
    if (categorias != null) {
        categorias = categorias.split(',');
        rules['categoriaClientesIncluye'] == 1 ? $('#categorias').val(categorias).trigger('chosen:updated') : $('#categorias').val(negativeCategorias).trigger('chosen:updated');
    }

    for (var x = 0; x < pedidoPromoRules.length; x++) {
        if (pedidoPromoRules[x]['tipo'] == 'PROVEEDOR') {
            proveedores.push(pedidoPromoRules[x]['valor']);
            incluyeProveedores = pedidoPromoRules[x]['incluye'];
        }
        if (pedidoPromoRules[x]['tipo'] == 'MARCA') {
            marcas.push(pedidoPromoRules[x]['valor']);
            incluyeMarcas = pedidoPromoRules[x]['incluye'];
        }
        if (pedidoPromoRules[x]['tipo'] == 'ARTICULO') {
            articulos.push(pedidoPromoRules[x]['valor']);
            incluyeArticulos = pedidoPromoRules[x]['incluye'];
        }
    }


    if (!incluyeProveedores) { //si se guardó con proveedores como lista negra, mostrar los que no se incluyen
        proveedores = reglas[5].filter(x => !proveedores.includes(x))
        $('#listaProveedores').val('negra');
        $('#listaProveedores').selectpicker('refresh');
        document.getElementById('mensaje-proveedores').innerHTML = "Estos proveedores <strong>no participan</strong> en la promoción";
        document.getElementById('mensaje-proveedores').classList.remove('green');
        document.getElementById('mensaje-proveedores').classList.add('red');
    }

    if (!incluyeArticulos) { //si se guardó con articulos como lista negra, mostrar los que no se incluyen
        let tempArticulosReglas = [...reglas[7]];
        for (let x = 0; x < tempArticulosReglas.length; x++) {
            tempArticulosReglas[x] = tempArticulosReglas[x].split(']')[0].substring(1);
        };
        articulos = tempArticulosReglas.filter(x => !articulos.includes(x));
        $('#listaArticulos').val('negra');
        $('#listaArticulos').selectpicker('refresh');
        document.getElementById('mensaje-articulos').innerHTML = "Estos articulos <strong>no participan</strong> en la promoción";
        document.getElementById('mensaje-articulos').classList.remove('green');
        document.getElementById('mensaje-articulos').classList.add('red');
    }

    if (!incluyeMarcas) { //si se guardó con marcas como lista negra, mostrar los que no se incluyen
        marcas = reglas[6].filter(x => !marcas.includes(x))
        $('#listaMarcas').val('negra');
        $('#listaMarcas').selectpicker('refresh');
        document.getElementById('mensaje-marcas').innerHTML = "Estas marcas <strong>no participan</strong> en la promoción";
        document.getElementById('mensaje-marcas').classList.remove('green');
        document.getElementById('mensaje-marcas').classList.add('red');
    }

    if (proveedores.length > 0)
        $('#proveedores').val(proveedores).trigger('chosen:updated');
    if (articulos.length > 0)
        $('#articulos').val(articulos).trigger('chosen:updated');
    if (marcas.length > 0)
        $('#marcas').val(marcas).trigger('chosen:updated');


    if (rules['paquete'])
        validarPaquete();
}


