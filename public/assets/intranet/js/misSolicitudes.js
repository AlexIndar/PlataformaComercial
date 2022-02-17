// var items = [];
// $(document).ready(function() {
//     intervalInventario = window.setInterval(checkItems, 1000);

//     function checkItems() {
//         alert(items.length);
//         if (items.length > 0) {
//             clearInterval(intervalInventario);
//             cargarInventario()
//             console.log("aqui1");
//         } else {
//             console.log("aqui2");

//         }
//     }

//     var zoneP = document.getElementById('zoneP').value;

//     if (zoneP != "") {
//         getItems(zoneP);
//     }


//     function getItems(zoneP) {
//         let data = { zoneP: zoneP };
//         console.log(data);
//         console.log("INfo data");
//         $.ajax({
//             'headers': {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             'url': "misSolicitudes/getSolicitudes/All",
//             'type': 'POST',
//             'dataType': 'json',
//             'data': data,
//             'enctype': 'multipart/form-data',
//             'timeout': 2 * 60 * 60 * 1000,
//             success: function(data) {
//                 items = data;
//             },
//             error: function(error) {
//                 console.log(error + "D");
//             }
//         });
//     }



// });

// function mensaje() {
//     alert("hola");
// }

// function cargarInventario() {
//     var dataset = [];
//     for (var x = 0; x < items.length; x++) {
//         var arr = [];

//         arr.push(items[x]['claveP']);
//         arr.push(items[x]['razonSocial']);
//         arr.push(items[x]['fechaAlta']);
//         arr.push(items[x]['status']);

//         dataset.push(arr);
//     }


//     $("#example1").dataTable({
//         "data": dataset,
//         "scrollX": 900,
//         "responsive": true,
//         "lengthChange": true,
//         "autoWidth": false,
//         "paging": true,
//         "searching": true,
//         "ordering": true,
//         "info": true,
//         "orderCellsTop": true,
//         "fixedHeader": true,
//     });

// }


// ----------------------------------------------------------------- VARIABLES GLOBALES ------------------------------------------


var tipoForm = '';
var archivosType = [];
var archivosBase64 = [];
var businessLines = [];


// DATOS GENERALES

var rfc = '';
var razonSocial = '';
var nombreComercial = '';
var numProspecto = '';
var constanciaSituacionFiscal = '';
var constanciaSituacionFiscalBack = '';
var fotoSolicitud = '';

// DIRECCIÓN FISCAL

var calle = '';
var numExt = '';
var numInt = '';
var comprobanteDomicilio = '';
var comprobanteDomicilioBack = '';
var comprobanteDomicilioShipping = '';
var comprobanteDomicilioShippingBack = '';
var colonias;
var coloniaSelect = '';
var auxColonias;
var auxColoniaSelect = '';

// NEGOCIO

var tipoNegocio = 1;
var giroSelect = '';
var antiguedad = '';
var negocioFrente = '';
var negocioLeft = '';
var negocioRight = '';

// DATOS DE CONTACTO

var contactos = [];

var maxContactos = 3;

// CREDITO

var local = '';
var tipoPersona = '';
var pagare = '';
var ineRep = '';
var ineRepBack = '';
var ineAval = '';
var ineAvalBack = '';

// ACTA CONSTITUTIVA

var docsActa = [];
var subtype;

// REFERENCIAS
var referenciasSol = [];
var caratula = '';
var facturasSol = [];
var cartaResponsiva = '';


$(document).ready(function() {

    $('#inputGroupFile01').change(function(e) {
        var fileName = e.target.files[0].name;
        constanciaSituacionFiscal = toBase64(e.target.files[0], 1, null);
        $('#label-inputGroupFile01').html(fileName);
    });

    $('#inputGroupFile02').change(function(e) {
        var fileName = e.target.files[0].name;
        constanciaSituacionFiscalBack = toBase64(e.target.files[0], 11, null);
        $('#label-inputGroupFile02').html(fileName);
    });

    $('#inputGroupFile03').change(function(e) {
        var fileName = e.target.files[0].name;
        fotoSolicitud = toBase64(e.target.files[0], 13, null);
        $('#label-inputGroupFile03').html(fileName);
    });

    $('#inputGroupFile04').change(function(e) {
        var fileName = e.target.files[0].name;
        comprobanteDomicilio = toBase64(e.target.files[0], 2, null);
        $('#label-inputGroupFile04').html(fileName);
    });

    $('#inputGroupFile05').change(function(e) {
        var fileName = e.target.files[0].name;
        comprobanteDomicilioBack = toBase64(e.target.files[0], 21, null);
        $('#label-inputGroupFile05').html(fileName);
    });

    $('#inputGroupFile06').change(function(e) {
        var fileName = e.target.files[0].name;
        negocioFrente = toBase64(e.target.files[0], 4, null);
        $('#label-inputGroupFile06').html(fileName);
    });

    $('#inputGroupFile07').change(function(e) {
        var fileName = e.target.files[0].name;
        negocioLeft = toBase64(e.target.files[0], 5, null);
        $('#label-inputGroupFile07').html(fileName);
    });

    $('#inputGroupFile08').change(function(e) {
        var fileName = e.target.files[0].name;
        negocioRight = toBase64(e.target.files[0], 6, null);
        $('#label-inputGroupFile08').html(fileName);
    });

    $('#inputGroupFile09').change(function(e) {
        var fileName = e.target.files[0].name;
        pagare = toBase64(e.target.files[0], 7, null);
        $('#label-inputGroupFile09').html(fileName);
    });

    $('#inputGroupFile10').change(function(e) {
        var fileName = e.target.files[0].name;
        ineRep = toBase64(e.target.files[0], 3, null);
        $('#label-inputGroupFile10').html(fileName);
    });

    $('#inputGroupFile11').change(function(e) {
        var fileName = e.target.files[0].name;
        ineRepBack = toBase64(e.target.files[0], 31, null);
        $('#label-inputGroupFile11').html(fileName);
    });

    $('#inputGroupFile12').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAval = toBase64(e.target.files[0], 8, null);
        $('#label-inputGroupFile12').html(fileName);
    });

    $('#inputGroupFile13').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAvalBack = toBase64(e.target.files[0], 81, null);
        $('#label-inputGroupFile13').html(fileName);
    });

    $('#inputGroupFile14').change(function(e) {
        var fileName = e.target.files[0].name;
        actaConstitutiva = e.target.files[0];
        $('#label-inputGroupFile14').html(fileName);
    });

    $('#inputGroupFile15').change(function(e) {
        var fileName = e.target.files[0].name;
        caratula = toBase64(e.target.files[0], 10, null);
        $('#label-inputGroupFile15').html(fileName);
    });

    $('#inputGroupFile16').change(function(e) {
        var fileName = e.target.files[0].name;
        $('#label-inputGroupFile16').html(fileName);
    });

    $('#inputGroupFile17').change(function(e) {
        var fileName = e.target.files[0].name;
        $('#label-inputGroupFile17').html(fileName);
    });

    $('#inputGroupFile18').change(function(e) {
        var fileName = e.target.files[0].name;
        cartaResponsiva = toBase64(e.target.files[0], 12, null);
        $('#label-inputGroupFile18').html(fileName);
    });

    $('#colDF').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex;
        if (colonias[selected] == undefined) {
            document.getElementById('rowOtraColonia').classList.remove('d-none');
        } else {
            document.getElementById('rowOtraColonia').classList.add('d-none');
            coloniaSelect = colonias[selected];
        }
    });

    $('#colDFShipping').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex;

        if (auxColonias[selected] == undefined) {
            document.getElementById('rowOtraColonia').classList.remove('d-none');
        } else {
            document.getElementById('rowOtraColonia').classList.add('d-none');
            auxColoniaSelect = auxColonias[selected];
        }
    });

    $('#inputGroupSelect01').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex + 1;
        if (businessLines.length < selected) {
            tipoNegocio = -1;
            document.getElementById('rowOtroGiro').classList.remove('d-none');
        } else {
            document.getElementById('rowOtroGiro').classList.add('d-none');
            tipoNegocio = businessLines[clickedIndex]['id'];
        }
    });

    $('#antiguedad').change(function() {
        if (document.getElementById('antiguedad').value >= 2) {
            document.getElementById('ineAval').classList.add('d-none');
            document.getElementById('ineAvalBack').classList.add('d-none');
            document.getElementById('pagare').classList.add('d-none');
        } else {
            document.getElementById('ineAval').classList.remove('d-none');
            document.getElementById('ineAvalBack').classList.remove('d-none');
            document.getElementById('pagare').classList.remove('d-none');
        }
        if (tipoForm == 'changeRS') {
            document.getElementById('ineAval').classList.remove('d-none');
            document.getElementById('ineAvalBack').classList.remove('d-none');
        }
    });

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getBusinessLines",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            businessLines = data;

            var selectBusinessLines = $('#inputGroupSelect01 option');
            selectBusinessLines.remove();
            $('#inputGroupSelect01').selectpicker('refresh');

            for (var x = 0; x < businessLines.length; x++) { //Agregar todas las inputGroupSelect01es del cliente seleccionado al select inputGroupSelect01
                $('#inputGroupSelect01').append('<option value="' + businessLines[x]['id'] + '">' + businessLines[x]['description'] + '</option>');
                $('#inputGroupSelect01').val(businessLines[x]['id']);
                $('#inputGroupSelect01').selectpicker("refresh");
            }

            /*$('#inputGroupSelect01').append('<option value="-1">Otro</option>'); //Agregar Primera opción de inputGroupSelect01 en Blanco
            $('#inputGroupSelect01').val('1');
            $('#inputGroupSelect01').selectpicker("refresh");*/

        },
        error: function(error) {
            console.log(error + "Error");
        }
    });

    $('#respuestaForm').on('hidden.bs.modal', function() {
        location.reload();
    })

})



function toBase64(file, type, subtype) { //FUNCION QUE TOMA UNA IMAGEN COMO PARAMETRO Y LA RETORNA EN BASE 64
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(subtype) {
        var result = reader.result.split(',')[1];
        base64 = result;
        archivosBase64.push(base64);
    };
    reader.onerror = function(error) {
        return "Error"
    };

    var temp = {
        type: type,
        subtype: subtype,
    };

    for (var x = 0; x < archivosType.length; x++) {
        if (archivosType[x]['type'] == type && archivosType[x]['type'] != 9) {
            archivosType.splice(x, 1);
            archivosBase64.splice(x, 1);
        }
    }

    archivosType.push(temp);
}


function startForm() {
    clearForm();
    $('#solicitudModal').modal('show');
    $('#creditRadio').prop('checked', true);
    tipoForm = "credit";
    valiteTypeForm();
}

function clearForm() {
    document.getElementById('creditoInput').value = "";
    document.getElementById('rfcInput').value = "";
    document.getElementById('rzInput').value = "";
    document.getElementById('nameComeInput').value = "";
    document.getElementById('prospecto').value = "";
    document.getElementById('inputGroupFile01').value = "";
    document.getElementById('label-inputGroupFile01').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile02').value = "";
    document.getElementById('label-inputGroupFile02').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile03').value = "";
    document.getElementById('label-inputGroupFile03').innerHTML = "Seleccionar Archivo...";
    constanciaSituacionFiscal = '';
    constanciaSituacionFiscalBack = '';
    fotoSolicitud = '';

    document.getElementById('calleInput').value = "";
    document.getElementById('noExtInput').value = "";
    document.getElementById('noIntInput').value = "";
    document.getElementById('cpInput').value = "";
    document.getElementById('emailFac').value = "";
    document.getElementById('colDF').value = "";
    document.getElementById('auxColDF').value = "";
    document.getElementById('ciudadDF').value = "";
    document.getElementById('estadoDF').value = "";
    // document.getElementById('rowInputsGeo').classList.add('d-none');
    document.getElementById('inputGroupFile04').value = "";
    document.getElementById('label-inputGroupFile04').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile05').value = "";
    document.getElementById('label-inputGroupFile05').innerHTML = "Seleccionar Archivo...";
    comprobanteDomicilio = '';
    comprobanteDomicilioBack = '';

    document.getElementById("checkAddAddress").checked = false;
    document.getElementById('shippingAddress').style.display = 'none';
    document.getElementById('calleInputShipping').value = "";
    document.getElementById('noExtInputShipping').value = "";
    document.getElementById('noIntInputShipping').value = "";
    document.getElementById('cpInputShipping').value = "";
    document.getElementById('colDFShipping').value = "";
    document.getElementById('ciudadDFShipping').value = "";
    document.getElementById('estadoDFShipping').value = "";

    document.getElementById('antiguedad').value = "";
    document.getElementById('inputGroupFile06').value = "";
    document.getElementById('label-inputGroupFile06').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile07').value = "";
    document.getElementById('label-inputGroupFile07').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile08').value = "";
    document.getElementById('label-inputGroupFile08').innerHTML = "Seleccionar Archivo...";
    negocioFrente = '';
    negocioLeft = '';
    negocioRight = '';

    cleanDatosContacto();
    clearTableDatos("contactData");
    contactos = [];

    document.getElementById('inputGroupFile09').value = "";
    document.getElementById('label-inputGroupFile09').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile10').value = "";
    document.getElementById('label-inputGroupFile10').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile11').value = "";
    document.getElementById('label-inputGroupFile11').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile12').value = "";
    document.getElementById('label-inputGroupFile12').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile13').value = "";
    document.getElementById('label-inputGroupFile13').innerHTML = "Seleccionar Archivo...";
    pagare = '';
    ineRep = '';
    ineRepBack = '';
    ineAval = '';
    ineAvalBack = '';

    document.getElementById('inputGroupSelect14').value = '-1';
    document.getElementById('inputGroupFile14').value = "";
    document.getElementById('label-inputGroupFile14').innerHTML = "Seleccionar Archivo...";
    docsActa = [];
    clearTableDatos("actaConsData");

    cleanDatosRefData();
    clearTableDatos("refData");
    referenciasSol = [];

    document.getElementById('inputGroupFile15').value = "";
    document.getElementById('label-inputGroupFile15').innerHTML = "Seleccionar Archivo...";
    caratula = '';

    document.getElementById('inputGroupFile16').value = "";
    document.getElementById('label-inputGroupFile16').innerHTML = "Seleccionar Archivo...";
    document.getElementById('inputGroupFile17').value = "";
    document.getElementById('label-inputGroupFile17').innerHTML = "Seleccionar Archivo...";
    document.getElementById('importFactura').value = "";
    clearTableDatos("facturaData");
    facturasSol = [];

    document.getElementById('inputGroupFile18').value = "";
    document.getElementById('label-inputGroupFile18').innerHTML = "Seleccionar Archivo...";
    cartaResponsiva = '';
}

function clearTableDatos(id) {
    var table = document.getElementById(id);
    // console.log(table.rows.length);
    if (table.rows.length > 1) {
        for (var i = table.rows.length - 1; i >= 1; i--) {
            table.deleteRow(i);
        }
    }
}

/*function changeMoney() {
    var money = document.getElementById("creditoInput").value;
    document.getElementById("creditoInput").value = new Intl.NumberFormat().format(money);
}

function changeMoneyF() {
    var money = document.getElementById("importFactura").value;
    document.getElementById("importFactura").value = new Intl.NumberFormat().format(money);
}*/

function addAddress() {
    // Get the checkbox
    var checkBox = document.getElementById("checkAddAddress");
    var divShippingAddress = document.getElementById('shippingAddress');
    if (checkBox.checked == true) {
        divShippingAddress.style.display = 'block';
    } else {
        divShippingAddress.style.display = 'none';
        comprobanteDomicilioShipping = '';
        comprobanteDomicilioShippingBack = '';
        $('#label-inputGroupFile04-2').html('Seleccionar Archivo...');
        $('#label-inputGroupFile05-2').html('Seleccionar Archivo...');

    }
}

function updateGeolocation() {
    validarCP();
    var cp = document.getElementById('cpInput').value;
    if (cp == "") {
        alert('Ingresa un código postal');
    } else {
        let data = { cp: cp };
        getCpCol(data);
    }
}

function getCpCol(data) {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getCPData",
        'type': 'GET',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            if (data.state != undefined) {
                document.getElementById('colDFRow1').classList.remove('d-none');
                document.getElementById('colDFRow2').classList.add('d-none');
                colonias = data['suburbs'];
                document.getElementById('ciudadDF').value = data['town'];
                document.getElementById('estadoDF').value = data['state'];
                // document.getElementById('rowInputsGeo').classList.remove('d-none');

                var itemSelectorOption = $('#colDF option');
                itemSelectorOption.remove();
                $('#colDF').selectpicker('refresh');

                for (var x = 0; x < colonias.length; x++) { //Agregar todas las colonias del CP ingresado
                    $('#colDF').append('<option value="' + x + '">' + colonias[x] + '</option>');
                    $('#colDF').val(colonias[x]);
                    $('#colDF').selectpicker("refresh");
                }
                $('#cpInput').removeClass("warningText");

            } else {
                alert("Error, codigo postal no registrado");
                $('#cpInput').addClass("warningText");
            }
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function addContactData() {
    var nombre = document.getElementById('nombreContacto').value.toUpperCase();
    var telefono = document.getElementById('telefonoContacto').value;
    var celular = document.getElementById('celularContacto').value;
    var email = document.getElementById('emailContacto').value;
    var tipo = document.getElementById('tipoContacto').value;

    if (contactos.length < maxContactos) {
        if (tipo != "SELECCIONAR") {
            $('#tipoContacto').removeClass("warningText");
            if (validarDataContact(nombre, email, telefono, celular)) {
                var data = {
                    "tipo": tipo,
                    "nombre": nombre,
                    "telefono": telefono,
                    "celular": celular,
                    "email": email
                };

                contactos.push(data);

                switch (tipo) {
                    case "1":
                        tipo = "PRINCIPAL";
                        break;
                    case "2":
                        tipo = "PAGOS";
                        break;
                    case "3":
                        tipo = "COMPRAS";
                        break;
                    case "4":
                        tipo = "ADMON";
                        break;
                    case "5":
                        tipo = "EMERGENCIA";
                        break;
                }

                var table = document.getElementById('contactData');
                var row = table.insertRow(table.rows.length);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                cell1.innerHTML = nombre;
                cell2.innerHTML = celular;
                cell3.innerHTML = tipo;
                cell4.innerHTML = "<i class='fas fa-pencil-alt' onclick='editContactRow(this)'></i>Editar /<i class='fas fa-user-times' onclick='deleteContactRow(this)'></i> Eliminar";
                cleanDatosContacto();
            }
        } else {
            $('#tipoContacto').addClass("warningText");
        }
    } else {
        alert("Maximo de contactos agregado");
    }

}

function validateNameC() {
    if (!validacionTextOne("nombreContacto")) {
        getAlert("alertContacto", "El nombre no puede ser numeros o menor a cuatro caracteres")
    }
}

function cleanDatosContacto() {
    document.getElementById('nombreContacto').value = "";
    document.getElementById('telefonoContacto').value = "";
    document.getElementById('celularContacto').value = "";
    document.getElementById('emailContacto').value = "";
    document.getElementById('tipoContacto').value = "SELECCIONAR";
    document.getElementById('flexCheckChecked').checked = false;
}

function validarDataContact(nombre, email, telefono, celular) {
    var auxN = validacionText("#nombreContacto", nombre);
    var auxE = validacionEmail("#emailContacto", email);
    var auxP = validarPhoneCell("#telefonoContacto", telefono);
    var auxC = validarPhoneCell("#celularContacto", celular);
    if (auxN && auxE && auxP && auxC) {
        return true;
    } else {
        return false;
    }
}

function validacionText(id, nombre) {
    if (nombre.length > 4 && nombre != "") {
        $(id).removeClass("warningText");
        return true;
    } else {
        $(id).addClass("warningText");
        return false;
    }
}

function validarPhoneCell(id, cellPhone) {
    numbers = /^[0-9]+$/;
    if (cellPhone.match(numbers) && cellPhone.length > 9) {
        $(id).removeClass("warningText");
        return true;
    } else {
        $(id).addClass("warningText");
        return false;
    }
}

function validacionEmail(id, email) {
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(email)) {
        $(id).removeClass("warningText");
        return true;
    } else {
        $(id).addClass("warningText");
        return false;
    }
}

function deleteContactRow(t) {
    console.log(t);
    var row = t.parentNode.parentNode;
    var table = document.getElementById('contactData');
    var index = row.rowIndex;
    console.log("index" + index);
    table.deleteRow(index);
    contactos.splice(index - 1, 1);
}

function editContactRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('contactData');
    var index = row.rowIndex;
    document.getElementById('nombreContacto').value = contactos[index - 1].nombre;
    document.getElementById('telefonoContacto').value = contactos[index - 1].telefono;
    document.getElementById('celularContacto').value = contactos[index - 1].celular;
    document.getElementById('emailContacto').value = contactos[index - 1].email;
    document.getElementById('tipoContacto').value = contactos[index - 1].tipo;
    table.deleteRow(index);
    contactos.splice(index - 1, 1);
}

function changeTipoLocal(tipo) {
    if (tipo == 'Propio') {
        local = 'Propio';
    }
    if (tipo == 'Rentado') {
        local = 'Rentado';
    }
}

function changeTipoPersona(tipo) {
    if (tipo == 'Fisica') {
        tipoPersona = 'Fisica';
        document.getElementById("actaConst").style.display = 'none';
    }
    if (tipo == 'Moral') {
        tipoPersona = 'Moral';
        document.getElementById("actaConst").style.display = 'flex';
    }
}


function addActaConstData() {
    var typeConst = document.getElementById('inputGroupSelect14').value;
    if (typeConst != -1) {
        var file = document.getElementById('label-inputGroupFile14').innerHTML;

        var data = {
            "tipo": typeConst,
            "file": file,
        };

        docsActa.push(data);

        subtype = document.getElementById('inputGroupSelect14').value;
        actaConstitutiva = toBase64(actaConstitutiva, 9, subtype);





        document.getElementById('label-inputGroupFile14').innerHTML = "";
        document.getElementById('inputGroupFile14').value = "";
        document.getElementById('inputGroupSelect14').value = '-1';


        var table = document.getElementById('actaConsData');
        var row = table.insertRow(table.rows.length);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var nameTypeConst = "";
        switch (typeConst) {
            case '1':
                nameTypeConst = "RAZON SOCIAL";
                break;
            case '2':
                nameTypeConst = "FECHA DE CONSTITUCION";
                break;
            case '3':
                nameTypeConst = "GIRO DE LA EMPRESA";
                break;
            case '4':
                nameTypeConst = "TRANSITORIOS";
                break;
            case '5':
                nameTypeConst = "ACCIONISTAS";
                break
            default:
                nameTypeConst = "ERROR";
                break;
        }

        cell1.innerHTML = nameTypeConst;
        cell2.innerHTML = file;
        cell3.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteActaRow(this)'></i>";
        $('#inputGroupSelect14').removeClass("warningText");
    } else {
        $('#inputGroupSelect14').addClass("warningText");
    }
}



function deleteActaRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('actaConsData');
    var index = row.rowIndex;
    table.deleteRow(index);
    tipoDelete = docsActa[index - 1]['tipo'];
    docsActa.splice(index - 1, 1);

    for (var x = 0; x < archivosType.length; x++) {
        if (archivosType[x]['subtype'] == tipoDelete && archivosType[x]['type'] == 9) {
            archivosType.splice(x, 1);
            archivosBase64.splice(x, 1);
        }
    }
}



function changeRef() {
    let ref = $('input[name="refSoli"]:checked').val();
    if (ref == "datos") {
        document.getElementById("refGroup").style.display = 'flex';
        document.getElementById("cartGroup").style.display = 'none';
        document.getElementById("factGroup").style.display = 'none';
    }
    if (ref == "caratula") {
        document.getElementById("refGroup").style.display = 'none';
        document.getElementById("cartGroup").style.display = 'flex';
        document.getElementById("factGroup").style.display = 'none';
    }
    if (ref == "facturas") {
        document.getElementById("refGroup").style.display = 'none';
        document.getElementById("cartGroup").style.display = 'none';
        document.getElementById("factGroup").style.display = 'flex';
    }
}

function addRefData() {
    var rzRef = document.getElementById('razonSocialRef').value.toUpperCase();
    var contRef = document.getElementById('contactoRef').value.toUpperCase();
    var cityRef = document.getElementById('ciudadRef').value.toUpperCase();
    var telRef = document.getElementById('telefonoRef').value;

    if (validarDataDatosF(rzRef, contRef, cityRef, telRef)) {
        var data = {
            "rzRef": rzRef,
            "contRef": contRef,
            "cityRef": cityRef,
            "telRef": telRef
        };

        referenciasSol.push(data);


        var table = document.getElementById('refData');
        var row = table.insertRow(table.rows.length);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);

        cell1.innerHTML = rzRef;
        cell2.innerHTML = contRef;
        cell3.innerHTML = cityRef;
        cell4.innerHTML = telRef;
        cell5.innerHTML = "<i class='fas fa-pencil-alt' onclick='editRefRow(this)'></i>/<i class='fas fa-trash-alt' onclick='deleteRefRow(this)'></i>";
        cleanDatosRefData();
    }
}

function deleteRefRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('refData');
    var index = row.rowIndex;
    table.deleteRow(index);
    referenciasSol.splice(index - 1, 1);
}


function editRefRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('refData');
    var index = row.rowIndex;
    document.getElementById('razonSocialRef').value = referenciasSol[index - 1].rzRef;
    document.getElementById('contactoRef').value = referenciasSol[index - 1].contRef;
    document.getElementById('ciudadRef').value = referenciasSol[index - 1].cityRef;
    document.getElementById('telefonoRef').value = referenciasSol[index - 1].telRef;
    table.deleteRow(index);
    referenciasSol.splice(index - 1, 1);
}

function cleanDatosRefData() {
    document.getElementById('razonSocialRef').value = "";
    document.getElementById('contactoRef').value = "";
    document.getElementById('ciudadRef').value = "";
    document.getElementById('telefonoRef').value = "";
}

function validarDataDatosF(rz, cont, city, phone) {
    var auxR = validacionText("#razonSocialRef", rz);
    var auxC = validacionText("#contactoRef", cont);
    var auxCt = validacionText("#ciudadRef", city);
    var auxT = validarPhoneCell("#telefonoRef", phone);
    if (auxR && auxC && auxCt && auxT) {
        return true;
    } else {
        return false;
    }
}

function addFacturaData() {
    var fact1 = document.getElementById('label-inputGroupFile16').innerHTML;
    var fact2 = document.getElementById('label-inputGroupFile17').innerHTML;
    var importFact = document.getElementById('importFactura').value;

    var data = {
        "fact1": fact1,
        "fact2": fact2,
        "impor": importFact
    };

    facturasSol.push(data);


    var table = document.getElementById('facturaData');
    var row = table.insertRow(table.rows.length);

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = fact1;
    cell2.innerHTML = fact2;
    cell3.innerHTML = importFact;
    cell4.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteFactRow(this)'></i>";

    document.getElementById('label-inputGroupFile16').innerHTML = "";
    document.getElementById('label-inputGroupFile17').innerHTML = "";
    document.getElementById('importFactura').value = "";
}

function deleteFactRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('facturaData');
    var index = row.rowIndex;
    table.deleteRow(index);
    facturasSol.splice(index - 1, 1);
}

function valiteTypeForm() {
    let activoFijo = $('input[name="typeSoli"]:checked').val();
    tipoForm = activoFijo;
    if (activoFijo == "cash") {
        document.getElementById("amountSol").style.display = 'none';
        document.getElementById("credSol").style.display = 'none';
        document.getElementById("actaConst").style.display = 'none';
        document.getElementById("referenciaSol").style.display = 'none';
        maxContactos = 1;
        document.getElementById("compDom1").classList.add('d-none');
        document.getElementById("compDom2").classList.add('d-none');
    } else {
        document.getElementById("amountSol").style.display = 'flex';
        document.getElementById("credSol").style.display = 'flex';
        document.getElementById("actaConst").style.display = 'flex';
        document.getElementById("referenciaSol").style.display = 'flex';
        maxContactos = 3;
        document.getElementById("compDom1").classList.remove('d-none');
        document.getElementById("compDom2").classList.remove('d-none');
    }

    if (activoFijo == "changeRS") {
        document.getElementById('referenciasCarta').classList.remove('d-none');
        document.getElementById('referenciasOptions').classList.add('d-none');
        document.getElementById('refGroup').style.display = 'none';
        document.getElementById('cartGroup').style.display = 'none';
        document.getElementById('factGroup').style.display = 'none';
        document.getElementById('refSoliDatos').checked = false;
        document.getElementById('refSoliCaratula').checked = false;
        document.getElementById('refSoliFactura').checked = false;
    } else {
        document.getElementById('referenciasCarta').classList.add('d-none');
        document.getElementById('referenciasOptions').classList.remove('d-none');
    }


    if (activoFijo == "changeRS") {
        document.getElementById('ineAval').classList.remove('d-none');
        document.getElementById('ineAvalBack').classList.remove('d-none');
    }

    /*switch (activoFijo) {
        case "credit":
            document.getElementById("amountSol").style.display = 'flex';
            break;
        case "creditAB":
            document.getElementById("amountSol").style.display = 'flex';
            break;
        case "cash":
            document.getElementById("amountSol").style.display = 'none';
            break;
        case "changeRS":
            document.getElementById("amountSol").style.display = 'flex';
            break;
        default:
            break;
    }*/
}

function headerTypeForm() {
    const items = "<h1>Mis Solicitudes</h1>";
    /*document.getElementById("headerUNO").innerHTML;*/
}

function verificarDatosGenerales() {
    let rfc = document.getElementById("rfcInput").value;
    let razonSocial = document.getElementById("rzInput").value;
    let nameCome = document.getElementById("nameComeInput").value;
    let prospecto = document.getElementById("prospecto").value;
    let file1 = document.getElementById("inputGroupFile01").value;
    let file2 = document.getElementById("inputGroupFile02").value;
    let firm = document.getElementById("inputGroupFile03").value;

    // if (rfc == "" || razonSocial == "" || nameCome == "" || prospecto == "" || file1 == "" || file2 == "" || firm == "") {
    //     return false;
    // } else {
    //     return true;
    // }
    return true;
}

function changeName() {
    let firm = document.getElementById("FirmCtrl").value;
    document.getElementById("firmCtrlL").innerHTML = firm;
}

function refresh() {
    let seePend = document.getElementById("defaultCheck1").checked;
    alert(seePend);
}

function getTipoForm() {
    var tipo = null;
    switch (tipoForm) {
        case 'cash':
            tipo = 0;
            break;
        case 'credit':
            tipo = 1;
            break;
        case 'creditAB':
            tipo = 2;
            break;
        case 'changeRS':
            tipo = null;
            break;
    }

    return tipo;
}

function getDateTime() {
    return (new Date()).toJSON();
}

// function getColoniaSelected() {
//     if (document.getElementById('rowOtraColonia').classList.contains('d-none')) {
//         return coloniaSelect;
//     } else {
//         return document.getElementById('otraCol').value;
//     }
// }

function validateFullForm() {
    let activoFijo = $('input[name="typeSoli"]:checked').val();
    console.log(activoFijo);
    var save = true;
    var rfc = document.getElementById('rfcInput').value;
    var razonSocial = document.getElementById('rzInput').value;
    var nombreComercial = document.getElementById('nameComeInput').value;
    var prospecto = document.getElementById('prospecto').value;
    var constanciaSituacionFiscal = document.getElementById('inputGroupFile01').value;
    var constanciaSituacionFiscalBack = document.getElementById('inputGroupFile02').value;
    var solicitud = document.getElementById('inputGroupFile03').value;
    var calleFiscal = document.getElementById('calleInput').value;
    var noExtFiscal = document.getElementById('noExtInput').value;
    var noIntFiscal = document.getElementById('noIntInput').value;
    var cpFiscal = document.getElementById('cpInput').value;
    var emailFac = document.getElementById('emailFac').value;
    var colDF = document.getElementById('colDF').value != "" ? document.getElementById('colDF').value : document.getElementById('auxColDF').value;;
    var comprobanteDomicilio = document.getElementById('inputGroupFile04').value;
    var comprobanteDomicilioBack = document.getElementById('inputGroupFile05').value;

    if (getTipoForm() != 0 && document.getElementById('creditoInput').value == '') {
        alert('false');
        save = false;
    }
    if (getTipoForm() != 0) {
        if (comprobanteDomicilio == '' || comprobanteDomicilioBack == '') {
            save = false;
        }
    }

    if (tipoForm == '' || rfc == '' || razonSocial == '' || nombreComercial == '' || prospecto == '' || constanciaSituacionFiscal == '' || constanciaSituacionFiscalBack == '' || solicitud == '' || calleFiscal == '' || noExtFiscal == '' || cpFiscal == '' || emailFac == '' || colDF == '' || coloniaSelect == '') {
        alert('false 2');
        save = false;
    }

    return save;
}

function validateSaveForm() {
    var save = true;

    var rfc = document.getElementById('rfcInput').value;
    var razonSocial = document.getElementById('rzInput').value;
    // var nombreComercial = document.getElementById('nameComeInput').value;
    var prospecto = document.getElementById('prospecto').value;
    var emailFac = document.getElementById('emailFac').value;
    var colDF = document.getElementById('colDF').value;
    var cpFiscal = document.getElementById('cpInput').value;
    console.log(colDF);
    // || nombreComercial == ''
    console.log(tipoForm);
    console.log(rfc);
    console.log(razonSocial);
    console.log(prospecto);
    console.log(tipoNegocio);
    console.log(emailFac);
    console.log(cpFiscal);
    if (tipoForm == '' || rfc == '' || razonSocial == '' || prospecto == '' || tipoNegocio == '' || emailFac == '' || cpFiscal == '' || colDF == '') {
        save = false;
    }

    return save;
}

function SendForm(zone) {
    if (validateFullForm()) {
        var json = createJsonSolicitud(zone);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "MisSolicitudes/storeSolicitud",
            'type': 'POST',
            'dataType': 'json',
            'data': json,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                console.log(data);
                $('#solicitudModal').modal('hide');
                document.getElementById('infoModalR').innerHTML = 'Solicitud enviada correctamente';
                // window.location.href = "/MisSolicitudes";
                $('#respuestaForm').modal('show');
            },
            error: function(error) {
                console.log(error);
                alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
            }
        });

    } else {
        alert('Error al intentar enviar la solicitud, verifique los datos');
    }
}

function saveForm(zone) {
    if (validateSaveForm()) {
        var json = createJsonSolicitud(zone);
        console.log(json);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/saveSolicitud",
            'type': 'POST',
            'dataType': 'json',
            'data': json,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                if (Number.isInteger(data)) {
                    $('#solicitudModal').modal('hide');
                    document.getElementById('infoModalR').innerHTML = `Solicitud guardada correctamente No. ${data}`;
                    $('#respuestaForm').modal('show');
                } else {
                    console.log(data);
                    alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                }
            },
            error: function(error) {
                console.log(error);
                alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
            }
        });
    } else {
        alert('La solicitud no se puede guardar sin los siguientes datos:\nTipo de Solicitud, RFC, Nombre o Razón Social, Nombre comercial, Número de Prospecto, Email de facturacion, Codigo Postal y Colonia Datos Fiscales');
    }
}



function createJsonSolicitud(zone) {
    var contactosData = [];
    var referenciasData = [];
    var archivosData = [];
    var archivosNull = [{
            "Id": 0,
            "FileStr": "",
            "Type": 1,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 11,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 13,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 4,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 5,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 6,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 2,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 3,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 31,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 7,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 8,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 81,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 9,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 10,
            "SubType": null
        },
        {
            "Id": 0,
            "FileStr": "",
            "Type": 12,
            "SubType": null
        }
    ];

    var contactosNull = [{
        "Id": 0,
        "Tipo": 1,
        "Nombre": "",
        "Email": "",
        "Celular": "",
        "Phone": "0"
    }, ];

    for (var x = 0; x < contactos.length; x++) {
        var temp = {
            id: 0,
            tipo: parseInt(contactos[x]['tipo']),
            nombre: contactos[x]['nombre'],
            email: contactos[x]['email'],
            celular: contactos[x]['celular'],
            phone: contactos[x]['telefono'],
        };
        contactosData.push(temp);
    }


    for (var x = 0; x < referenciasSol.length; x++) {
        var temp = {
            id: 0,
            tipo: 1,
            nombre: referenciasSol[x]['rzRef'],
            email: null,
            celular: referenciasSol[x]['contRef'],
            phone: referenciasSol[x]['telRef'],
            city: referenciasSol[x]['cityRef'],
        };
        referenciasData.push(temp);
    }

    for (var x = 0; x < archivosType.length; x++) {
        var temp = {
            id: 0,
            fileStr: archivosBase64[x],
            type: archivosType[x]['type'],
            subtype: archivosType[x]['subtype'] != null ? parseInt(archivosType[x]['subtype']) : null,
        };
        archivosData.push(temp);
    }

    if (document.getElementById('cpInput').value == '') {
        document.getElementById('cpInput').value = '0';
    }

    if (document.getElementById('antiguedad').value == '') {
        document.getElementById('antiguedad').value = '0';
    }

    var json = {
        folio: -1,
        fecha: getDateTime(),
        tipo: getTipoForm(),
        credito: getTipoForm() == 0 ? null : document.getElementById('creditoInput').value == "" ? 0 : parseInt(document.getElementById('creditoInput').value),
        zona: JSON.parse(zone),
        cliente: {
            clave: document.getElementById('prospecto').value,
            nombreComercial: document.getElementById('nameComeInput').value,
            tipoNegocio: tipoNegocio,
            otroGiro: tipoNegocio == -1 ? document.getElementById('otroGiro').value : null,
            tiempoConst: parseInt(document.getElementById('antiguedad').value),
            tipoLocal: local == 'Propio' ? true : false,
            tipoPersona: tipoPersona == 'Moral' ? true : false,
            status: 1,
            datosF: {
                id: 0,
                rfc: document.getElementById('rfcInput').value,
                razonSocial: document.getElementById('rzInput').value,
                emailFacturacion: document.getElementById('emailFac').value,
                domicilio: {
                    id: 0,
                    calle: document.getElementById('calleInput').value,
                    noInt: document.getElementById('noIntInput').value,
                    colonia: coloniaSelect != "" ? coloniaSelect : document.getElementById("auxColDF").value,
                    ciudad: document.getElementById('ciudadDF').value,
                    estado: document.getElementById('estadoDF').value,
                    cp: document.getElementById('cpInput').value,
                    noExt: document.getElementById('noExtInput').value == "" ? "0" : document.getElementById('noExtInput').value,
                    longitude: 0,
                    latitude: 0,
                }
            },
            datosE: {
                id: 0,
                nombre: "Direccion Entrega",
                rutaVenta: false,
                ruta: null,
                formaEnvio: null,
                domicilio: {
                    id: 0,
                    calle: document.getElementById('calleInputShipping').value == '' ? document.getElementById('calleInput').value : document.getElementById('calleInputShipping').value,
                    noInt: document.getElementById('noIntInputShipping').value == '' ? document.getElementById('noIntInput').value : document.getElementById('noIntInputShipping').value,
                    colonia: auxColoniaSelect != '' ? auxColoniaSelect : coloniaSelect != "" ? coloniaSelect : document.getElementById("auxColDF").value,
                    ciudad: document.getElementById('ciudadDFShipping').value == '' ? document.getElementById('ciudadDF').value : document.getElementById('ciudadDFShipping').value,
                    estado: document.getElementById('estadoDFShipping').value == '' ? document.getElementById('estadoDF').value : document.getElementById('estadoDFShipping').value,
                    cp: document.getElementById('cpInputShipping').value == '' ? document.getElementById('cpInput').value : document.getElementById('cpInputShipping').value,
                    noExt: document.getElementById('noExtInputShipping').value != '' ? document.getElementById('noExtInputShipping').value : document.getElementById('noExtInput').value == "" ? "0" : document.getElementById('noExtInput').value,
                    longitude: 0,
                    latitude: 0,
                }
            },
            contactos: contactosData.length > 0 ? contactosData : contactosNull,
            metodoPago: "pd",
            noCuentaBanco: null,
        },
        referencias: $('input[name="refSoli"]:checked').val() == 'datos' ? referenciasData : null,
        // historyForm: {
        //     id: null,
        //     folioSol: null,
        //     fecha: null,
        //     tipo: null, 
        //     idTipo: null, 
        // }, 
        archivos: archivosData.length > 0 ? archivosData : archivosNull,
        factura: $('input[name="refSoli"]:checked').val() == 'facturas' ? facturasSol : null,
        observations: null
    };

    console.log(json);
    console.log(JSON.stringify(json));
    return json;
}

function detalleSol(item) {
    if (item != null) {
        getInfoDetalleSol(item);
    }
}

function getInfoDetalleSol(item) {
    let info = { Item: item };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getInfoSol",
        'type': 'POST',
        'dataType': 'json',
        'data': info,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "/MisSolicitudes/getValidationRequest",
                'type': 'POST',
                'dataType': 'json',
                'data': info,
                'enctype': 'multipart/form-data',
                'timeout': 2 * 60 * 60 * 1000,
                success: function(data2) {
                    $.ajax({
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'url': "/MisSolicitudes/getValidacionContactos",
                        'type': 'POST',
                        'dataType': 'json',
                        'data': info,
                        'enctype': 'multipart/form-data',
                        'timeout': 2 * 60 * 60 * 1000,
                        success: function(valContac) {
                            $.ajax({
                                'headers': {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                'url': "/MisSolicitudes/getFiles",
                                'type': 'POST',
                                'dataType': 'json',
                                'data': info,
                                'enctype': 'multipart/form-data',
                                'timeout': 2 * 60 * 60 * 1000,
                                success: function(filesList) {
                                    showInfoModal(data, data2, valContac, filesList);
                                },
                                error: function(error) {
                                    console.log(error + "Error");
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error + "Error");
                        }
                    });
                },
                error: function(error) {
                    console.log(error + "Error");
                }
            });
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}



function getGiro(id) {
    businessLines;
    var giro = "";
    console.log(id);
    switch (id) {
        case 7:
            giro = "FERRETERIA Y TLAPLALERIA";
            break;
        case 29:
            giro = "FERRETERIA Y TLAPLALERIA";
            break;
        default:
            giro = "INFO";
    }
    return giro;
}

function getTypeCont(id) {
    var typeCont = "";
    switch (id) {
        case 1:
            typeCont = "Principal";
            break;
        default:
            typeCont = "ERROR";
    }
    return typeCont;
}

function editText(item) {
    document.getElementById(item).disabled = false;
}

function getButtons(dato, id) {
    var buttons = dato == false ? `<button class="btn btn-primary btn-circle" onclick="editText('` + id + `')"><i class="fas fa-edit"></i></button>` : ``;
    if (dato == null) {
        buttons += `<button class="btn btn-secondary btn-circle float-right"><i class="fas fa-minus"></i></button>`;
    } else if (dato == true) {
        buttons += `<button class="btn btn-success btn-circle float-right"><i class="fas fa-check"></i></button>`;
    } else {
        buttons += `<button class="btn btn-danger btn-circle float-right"><i class="fas fa-times"></i></button>`;
    }
    return buttons;
}

function showInfoModal(data, data2, valContac, filesList) {
    document.getElementById("refSection").style.display = "none";
    document.getElementById("crediSection").style.display = "none";
    document.getElementById("pagareSection").style.display = "none";
    document.getElementById("ifeASection").style.display = "none";
    document.getElementById("ifeARSection").style.display = "none";
    document.getElementById("aCSection").style.display = "none";
    document.getElementById("cRSection").style.display = "none";
    document.getElementById("cartSection").style.display = "none";
    if (data != null) {
        console.log(data);
        console.log(data2);
        console.log(valContac);
        console.log(filesList);
        //DATOS HEADER
        document.getElementById("folioInf").innerHTML = "No. " + data.folio;
        //DATOS GENERALES
        document.getElementById("rfcEdit").value = data.cliente.datosF.rfc;
        document.getElementById("rfcButtons").innerHTML = getButtons(data2.calleEntrega, "rfcEdit");

        document.getElementById("rzEdit").value = data.cliente.datosF.razonSocial;
        document.getElementById("rzButtons").innerHTML = getButtons(data2.calleEntrega, "rzEdit");

        document.getElementById("nomComEdit").value = data.cliente.nombreComercial;
        document.getElementById("nomComButtons").innerHTML = getButtons(data2.calleEntrega, "nomComEdit");
        getAlert("alertDG", data.observations.datosGenerales);
        //DIRECCION FISCAL
        document.getElementById("calleFEdit").value = data.cliente.datosF.domicilio.calle;
        document.getElementById("callFEButtons").innerHTML = getButtons(data2.calleEntrega, "calleFEdit");

        document.getElementById("noFEdit").value = data.cliente.datosF.domicilio.noExt;
        document.getElementById("noFEButtons").innerHTML = getButtons(data2.calleEntrega, "noFEdit");

        document.getElementById("cityFEdit").value = data.cliente.datosF.domicilio.ciudad;
        document.getElementById("cityFEButtons").innerHTML = getButtons(data2.calleEntrega, "cityFEdit");

        document.getElementById("estadoFEdit").value = data.cliente.datosF.domicilio.estado;
        document.getElementById("estadoFEButtons").innerHTML = getButtons(data2.calleEntrega, "estadoFEdit");

        document.getElementById("coloniaFEdit").value = data.cliente.datosF.domicilio.colonia;
        document.getElementById("coloniaFEButtons").innerHTML = getButtons(data2.calleEntrega, "coloniaFEdit");

        document.getElementById("cpFEdit").value = data.cliente.datosF.domicilio.cp;
        document.getElementById("cpFEButtons").innerHTML = getButtons(data2.calleEntrega, "cpFEdit");

        getAlert("alertDF", data.observations.direccionFiscal);

        //DIRECCION DE ENTREGA
        document.getElementById("calleEEdit").value = data.cliente.datosE.domicilio.calle;
        document.getElementById("calleEEButtons").innerHTML = getButtons(data2.calleEntrega, "calleEEdit");

        document.getElementById("noEEdit").value = data.cliente.datosE.domicilio.noExt;
        document.getElementById("noEEButtons").innerHTML = getButtons(data2.numeroExteriorEntrega, "noEEdit");

        document.getElementById("cityEEdit").value = data.cliente.datosE.domicilio.ciudad;
        document.getElementById("cityEEButtons").innerHTML = getButtons(data2.ciudadEntrega, "cityEEdit");

        document.getElementById("estadoEEdit").value = data.cliente.datosE.domicilio.estado;
        document.getElementById("estadoEEButtons").innerHTML = getButtons(data2.estadoEntrega, "estadoEEdit");

        document.getElementById("coloniaEEdit").value = data.cliente.datosE.domicilio.colonia;
        document.getElementById("coloniaEEButtons").innerHTML = getButtons(data2.coloniaEntrega, "coloniaEEdit");

        document.getElementById("cpEEdit").value = data.cliente.datosE.domicilio.cp;
        document.getElementById("cpEEButtons").innerHTML = getButtons(data2.cpEntrega, "cpEEdit");
        getAlert("alertDE", data.observations.direccionEntrega);

        //NEGOCIO
        document.getElementById("metPagoEdit").value = (data.cliente.metodoPago == "pd") ? "Por Definir" : "Error";
        document.getElementById("metPagoButtons").innerHTML = getButtons(data2.cpEntrega, "metPagoEdit");

        document.getElementById("giroEdit").value = getGiro(data.cliente.tipoNegocio);
        document.getElementById("giroButtons").innerHTML = getButtons(data2.cpEntrega, "giroEdit");

        document.getElementById("antiguedadEdit").value = data.cliente.tiempoConst;
        document.getElementById("antiguedadButtons").innerHTML = getButtons(data2.cpEntrega, "antiguedadEdit");

        getAlert("alertNegocio", data.observations.negocio);
        //DATOS CONTACTO
        var itemsC = "";
        for (var i = 0; i < data.cliente.contactos.length; i++) {
            var nom = getButtons(valContac[0].nombre, "nombreCEdit" + i);
            var tel = getButtons(valContac[0].telefono, "phoneCEdit" + i);
            var cel = getButtons(valContac[0].celular, "celCEdit" + i)
            itemsC += `<div class="row mb-3">
                                <div class="col-md-4">Tipo Contacto</div>
                                <div class="col-md-6"><input type="text" value="` + getTypeCont(data.cliente.contactos[i].tipo) + `" name="typeContCEdit` + i + `" id="typeContCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="typeContButtons` + i + `">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Nombre</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].nombre + `" name="nombreCEdit` + i + `" id="nombreCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="nombreCButtons` + i + `">` +
                nom + `
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Telefono</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].phone + `" name="phoneCEdit` + i + `" id="phoneCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="phoneCButtons` + i + `">` +
                tel + `
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Celular</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].celular + `" name="celCEdit` + i + `" id="celCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="celCButtons` + i + `">` +
                cel + `
                                </div>
                            </div>
                            <hr>`;
        }



        document.getElementById("datContactos").innerHTML = itemsC;
        getAlert("alertCont", data.observations.contactoPrincipal);


        if (data.tipo != false) {
            //CREDITO
            document.getElementById("crediSection").style.display = "flex";
            document.getElementById("typeLEdit").value = data.cliente.tipoLocal == true ? "Propio" : "Rentado";
            document.getElementById("typeLButtons").innerHTML = getButtons(data2.tipoLocal, "typeLEdit");

            document.getElementById("typePEdit").value = data.cliente.tipoPersona == true ? "Moral" : "Fisica";
            document.getElementById("typePButtons").innerHTML = getButtons(data2.tipoPersona, "typePEdit");
            getAlert("alertCredit", data.observations.credito);

            if (data.cliente.tiempoConst < 2) {
                document.getElementById("pagareSection").style.display = "flex";
            }
            if (data.cliente.tiempoConst < 2 || data.tipo == null) {
                document.getElementById("ifeASection").style.display = "flex";
                document.getElementById("ifeARSection").style.display = "flex";
            } // else {
            //     document.getElementById("pagareSection").style.display = "none";
            //     document.getElementById("ifeASection").style.display = "none";
            //     document.getElementById("ifeARSection").style.display = "none";
            // }

            if (filesList != null) {
                var actaList = filesList.filter(r => r.type == 9 && r.subType != -1).length > 0 ? filesList.filter(r => r.type == 9 && r.subType != -1) : null;
                /*console.log("Entra");
                console.log(actaList);*/
                if (actaList != null) {
                    document.getElementById("aCSection").style.display = "flex";
                    var fileActa = "";
                    for (var i = 0; i < actaList.length; i++) {
                        fileActa = `<div class="row mb-3">
                            <div class="col-md-4">Acta Constitutiva ` + actaList[i].subType + `</div>
                            <div class="col-md-4" id="imgAC` + i + `"> <button class="btn btn-warning" onclick="showIMG('` + actaList[i].fileStr + `')"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-md-4" id="ActCButtons` + i + `">
                            </div>
                        </div>`;
                    }
                    document.getElementById("acRow").innerHTML = fileActa;
                }

                var responsiveList = filesList.filter(x => x.type == 12 && x.subType != -1).length > 0 ? filesList.filter(x => x.type == 12 && x.subType != -1) : null;
                if (responsiveList != null) {
                    document.getElementById("cRSection").style.display = "flex";
                    getAlert("alertActa", data.observations.actaConstitutiva);
                }
            }

            if (data.referencias.length > 0) {
                document.getElementById("refSection").style.display = "flex";
                var fileRef = "";
                for (var i = 0; i < data.referencias.length; i++) {
                    fileRef += `<div class="row mb-3">
                            <div class="col-md-4">` + data.referencias[i].nombre + `(` + data.referencias[i].city + `)</div>
                            <div class="col-md-4">` + data.referencias[i].phone + `</div>
                            <div class="col-md-4" id="refCheck` + i + `">
                            </div>
                        </div>`;
                }
                document.getElementById("refList").innerHTML = fileRef;
                getAlert("alertRef", data.observations.referencias);
            }
        }
        //CARGAR BOTONES CON IMAGENES
        for (var i = 0; i < filesList.length; i++) {
            switch (filesList[i].type) {
                case 1:
                    getButtonImg("imgCSFButton", filesList[i].fileStr);
                    break;
                case 2:
                    getButtonImg("imgCDButton", filesList[i].fileStr);
                    break;
                case 3:
                    getButtonImg("imgIfeR", filesList[i].fileStr);
                    break;
                case 4:
                    getButtonImg("imgFFN", filesList[i].fileStr);
                    break;
                case 5:
                    getButtonImg("imgFIN", filesList[i].fileStr);
                    break;
                case 6:
                    getButtonImg("imgFDN", filesList[i].fileStr);
                    break;
                case 7:
                    getButtonImg("imgPagA", filesList[i].fileStr);
                    break;
                case 8:
                    getButtonImg("imgIfeA", filesList[i].fileStr);
                    break;
                case 10:
                    document.getElementById("cartSection").style.display = "flex";
                    getButtonImg("imgCara", filesList[i].fileStr);
                    break;
                case 11:
                    getButtonImg("imgCSF2Button", filesList[i].fileStr);
                    break;
                case 12:
                    getButtonImg("imgCR", filesList[i].fileStr);
                    break;
                case 13:
                    getButtonImg("imgFSButton", filesList[i].fileStr);
                    break;
                case 21:
                    getButtonImg("imgCDRButton", filesList[i].fileStr);
                    break;
                case 31:
                    getButtonImg("imgIfeRR", filesList[i].fileStr);
                    break;
                case 81:
                    getButtonImg("imgIfeAR", filesList[i].fileStr);
                    break;
            }
        }
        $('#infoModal').modal('show');
    }
}

function saveEdit() {
    $('#infoModal').modal('hide');

    $('#respuestaForm').modal('show');
}

function getButtonImg(idBtn, file) {
    if (document.getElementById(idBtn))
        document.getElementById(idBtn).innerHTML = `<button class="btn btn-warning" onclick="showIMG('` + file + `')"><i class="far fa-eye"></i> Ver Archivo</button>`;
}

function getAlert(idAlert, msg) {
    if (msg != null && msg != "") {
        document.getElementById(idAlert).innerHTML = `<div class="alert alert-danger" role="alert" >` + msg + `</div>`;
    }
}

function showIMG(itemIMG) {
    $('#showIMGModal').modal('show');
    var imgen = "data:image/jpg;base64," + itemIMG;
    var img = `<img src="` + imgen + `" alt="imagen muestra" class="imageModal">`
    document.getElementById("showIMGBody").innerHTML = img;
}

//HISTORY FORM
function getTransactionHistory(item) {
    if (item != null) {
        let data = { Item: item };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/getTransactionHistory",
            'type': 'POST',
            'dataType': 'json',
            'data': data,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                showHistoryModal(data);
            },
            error: function(error) {
                console.log(error + "Error");
            }
        });
    }
}

function showHistoryModal(data) {
    if (data != null) {
        console.log(data);
        document.getElementById("titleHistory").innerHTML = "Historial de transacciones de la solicitud " + data[0].folioSol;
        var historyList = "";
        for (var i = 0; i < data.length; i++) {
            historyList += `<div class="row mb-3">
                                <div class="col-md-6 text-bold">` + data[i].fecha + `</div>
                                <div class="col-md-6">` + data[i].tipo + `</div>
                            </div>`;
        }
        document.getElementById("historyList").innerHTML = historyList;
        $('#historialModal').modal('show');
    }
}

function validacionTextOne(id) {
    var item = document.getElementById(id).value.toUpperCase();
    document.getElementById(id).value = item.toUpperCase();
    if (item.length > 4 && item != "") {
        $('#' + id).removeClass("warningText");
        return true;
    } else {
        $('#' + id).addClass("warningText");
        return false;
    }
}

function validaRFC() {
    var rfc = document.getElementById("rfcInput").value.toUpperCase();
    document.getElementById("rfcInput").value = rfc.toUpperCase();
    var auxRFC = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;

    if (rfc != "" && auxRFC.test(rfc)) {
        $('#rfcInput').removeClass("warningText");
        return true;
    } else {
        $('#rfcInput').addClass("warningText");
        return false;
    }
}

function validaRZI() {
    validacionTextOne("rzInput");
}

function validaNameC() {
    validacionTextOne("nameComeInput");
}

function validaProsP() {
    var item = document.getElementById("prospecto").value.toUpperCase();
    document.getElementById("prospecto").value = item.toUpperCase();
    if (item.length > 4 && item != "" && item[0] == 'P') {
        $('#prospecto').removeClass("warningText");
    } else {
        $('#prospecto').addClass("warningText");
    }
}

function validaCalle() {
    validacionTextOne("calleInput");
}

function validaNoEx() {
    var item = document.getElementById("noExtInput").value.toUpperCase();
    document.getElementById("noExtInput").value = item.toUpperCase();
    if (item != "") {
        $('#noExtInput').removeClass("warningText");
    } else {
        $('#noExtInput').addClass("warningText");
    }
}

function validaNoIn() {
    var item = document.getElementById("noIntInput").value.toUpperCase();
    document.getElementById("noIntInput").value = item.toUpperCase();
}

function validarCP() {
    numbers = /^[0-9]+$/;
    var num = document.getElementById("cpInput").value;
    if (num.match(numbers) && num.length > 3) {
        $('#cpInput').removeClass("warningText");
    } else {
        $('#cpInput').addClass("warningText");
    }
}

function validaEmailF() {
    var item = document.getElementById("emailFac").value;
    validacionEmail("#emailFac", item);
}

function validaCalleS() {
    validacionTextOne("calleInputShipping");
}

function validaNoExS() {
    var item = document.getElementById("noExtInputShipping").value.toUpperCase();
    document.getElementById("noExtInputShipping").value = item.toUpperCase();
    if (item != "") {
        $('#noExtInputShipping').removeClass("warningText");
    } else {
        $('#noExtInputShipping').addClass("warningText");
    }
}

function validaNoInS() {
    var item = document.getElementById("noIntInputShipping").value.toUpperCase();
    document.getElementById("noIntInputShipping").value = item.toUpperCase();
}

function validarCPS() {
    numbers = /^[0-9]+$/;
    var cp = document.getElementById("cpInputShipping").value;
    if (cp.match(numbers) && cp.length > 3) {
        $('#cpInputShipping').removeClass("warningText");
        let data = { cp: cp };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/getCPData",
            'type': 'GET',
            'dataType': 'json',
            'data': data,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                console.log(data['suburbs']);
                auxColonias = data['suburbs'];
                document.getElementById('ciudadDFShipping').value = data['town'];
                document.getElementById('estadoDFShipping').value = data['state'];
                // document.getElementById('rowInputsGeo').classList.remove('d-none');

                var itemSelectorOption = $('#colDFShipping option');
                itemSelectorOption.remove();
                $('#colDFShipping').selectpicker('refresh');

                for (var x = 0; x < auxColonias.length; x++) { //Agregar todas las colonias del CP ingresado
                    $('#colDFShipping').append('<option value="' + x + '">' + auxColonias[x] + '</option>');
                    $('#colDFShipping').val(auxColonias[x]);
                    $('#colDFShipping').selectpicker("refresh");
                }

            },
            error: function(error) {
                console.log(error + "Error");
            }
        });
    } else {
        $('#cpInputShipping').addClass("warningText");
    }
}

function validaAnti() {
    numbers = /^[0-9]+$/;
    var num = document.getElementById("antiguedad").value;
    if (num.match(numbers) && num.length != "") {
        $('#antiguedad').removeClass("warningText");
    } else {
        $('#antiguedad').addClass("warningText");
    }
}


function reSendFol(item) {
    $('#confirModal').modal('show');
    document.getElementById("titleModalConfirm").innerHTML = "¿Desea reenviar la solicitud No. " + item + "?";
    var buttons = `<button class="btn btn-success btn-circle" onclick="confirmReSend('` + item + `')"><i class="fas fa-paper-plane"></i> Si, Reenviar</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelForm('` + item + `')" style="margin-left: 10px;"><i class="fas fa-times"></i> No, Cancelar</button>`;
    document.getElementById("bodyModalConfirm").innerHTML = buttons;
}

function confirmReSend(item) {
    if (item != null) {
        let data = { Item: item };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/reSendForm",
            'type': 'POST',
            'dataType': 'json',
            'data': data,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                alert("Enviado correctamente");
            },
            error: function(error) {
                alert(error + "Error");
            }
        });
    }
}

function cancelForm(item) {
    alert("Se cancelo el reenvio de la solicitud " + item);
    $('#confirModal').modal('hide');
}

function continueForm(item) {
    clearForm();
    let info = { Item: item };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getBills",
        'type': 'POST',
        'dataType': 'json',
        'data': info,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(facturas) {
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "/MisSolicitudes/getFiles",
                'type': 'POST',
                'dataType': 'json',
                'data': info,
                'enctype': 'multipart/form-data',
                'timeout': 2 * 60 * 60 * 1000,
                success: function(archivos) {
                    $.ajax({
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'url': "/MisSolicitudes/getInfoSol",
                        'type': 'POST',
                        'dataType': 'json',
                        'data': info,
                        'enctype': 'multipart/form-data',
                        'timeout': 2 * 60 * 60 * 1000,
                        success: function(data) {
                            continueModal(facturas, archivos, data);
                        },
                        error: function(error) {
                            console.log(error + "Error");
                        }
                    });
                },
                error: function(error) {
                    console.log(error + "Error");
                }
            });
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function manejoArchivos(archivos) {
    console.log(archivos);
    if (archivos != null) {
        for (var i = 0; i < archivos.length; i++) {
            console.log(archivos[i].type);
            switch (archivos[i].type) {
                case 1:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile01').value = "Archivo";
                        document.getElementById('label-inputGroupFile01').innerHTML = "ConstanciaSituacionFiscal.jpg";
                        constanciaSituacionFiscal = archivos[i].fileStr;
                    }
                    break;
                case 2:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile04').value = "Archivo";
                        document.getElementById('label-inputGroupFile04').innerHTML = "ComprobanteDomicilio.jpg";
                        comprobanteDomicilio = archivos[i].fileStr;
                    }
                    break;
                case 3:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile10').value = "Archivo";
                        document.getElementById('label-inputGroupFile10').innerHTML = "IFERepresentante.jpg";
                        ineRep = archivos[i].fileStr;
                    }
                    break;
                case 4:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile06').value = "Archivo";
                        document.getElementById('label-inputGroupFile06').innerHTML = "FotoFrente.jpg";
                        negocioFrente = archivos[i].fileStr;
                    }
                    break;
                case 5:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile07').value = "Archivo";
                        document.getElementById('label-inputGroupFile07').innerHTML = "FotoIzquierda.jpg";
                        negocioLeft = archivos[i].fileStr;
                    }

                    break;
                case 6:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile08').value = "Archivo";
                        document.getElementById('label-inputGroupFile08').innerHTML = "FotoDerecha.jpg";
                        negocioRight = archivos[i].fileStr;
                    }
                    break;
                case 7:
                    if (archivos[i].fileStr != "") {
                        //document.getElementById('inputGroupFile09').value = "Archivo";
                        document.getElementById('label-inputGroupFile09').innerHTML = "Pagare.jpg";
                        pagare = archivos[i].fileStr;
                    }

                    break;
                case 8:
                    if (archivos[i].fileStr != "") {
                        //document.getElementById('inputGroupFile12').value = "Archivo";
                        document.getElementById('label-inputGroupFile12').innerHTML = "IFEAval.jpg";
                        ineAval = archivos[i].fileStr;
                    }

                    break;
                case 10:
                    if (archivos[i].fileStr != "") {
                        //document.getElementById('inputGroupFile15').value = "Archivo";
                        document.getElementById('label-inputGroupFile15').innerHTML = "Caratula.jpg";
                        caratula = archivos[i].fileStr;
                    }
                    break;
                case 11:
                    if (archivos[i].fileStr != "") {
                        //document.getElementById('inputGroupFile02').value = "Archivo";
                        document.getElementById('label-inputGroupFile02').innerHTML = "ConstanciaSituacionFiscalReverso.jpg";
                        constanciaSituacionFiscalBack = archivos[i].fileStr;
                    }
                    break;
                case 12:
                    if (archivos[i].fileStr != "") {
                        //document.getElementById('inputGroupFile18').value = "Archivo";
                        document.getElementById('label-inputGroupFile18').innerHTML = "CartaResponsiva.jpg";
                        cartaResponsiva = archivos[i].fileStr;
                    }
                    break;
                case 13:
                    if (archivos[i].fileStr != "") {
                        //document.getElementById('inputGroupFile03').value = "Archivo";
                        console.log(archivos[i].fileStr);
                        document.getElementById('label-inputGroupFile03').innerHTML = "FirmaSolicitud.jpg";
                        fotoSolicitud = archivos[i].fileStr;
                    }
                    break;
                case 31:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile11').value = "Archivo";
                        document.getElementById('label-inputGroupFile11').innerHTML = "IFERepresentanteReverso.jpg";
                        ineRepBack = archivos[i].fileStr;
                    }
                    break;
                case 81:
                    if (archivos[i].fileStr != "") {
                        // document.getElementById('inputGroupFile13').value = "Archivo";
                        document.getElementById('label-inputGroupFile13').innerHTML = "IFEAvalReverso.jpg";
                        ineAvalBack = archivos[i].fileStr;
                    }
                    break;
            }
        }
    }
}

function continueModal(facturas, archivos, data) {
    // console.log(facturas);
    // console.log(archivos);
    //console.log(data);
    $('#solicitudModal').modal('show');
    var idTypeSol = data.tipo == null ? "changeRSRadio" : data.tipo == 2 ? "creditABRadio" : data.tipo == 1 ? "creditRadio" : "cashRadio";
    document.getElementById(idTypeSol).checked = true;
    valiteTypeForm();
    manejoArchivos(archivos);
    document.getElementById('creditoInput').value = data.credito;
    document.getElementById('rfcInput').value = data.cliente.datosF.rfc;
    document.getElementById('rzInput').value = data.cliente.datosF.razonSocial;
    document.getElementById('nameComeInput').value = data.cliente.nombreComercial;
    document.getElementById('prospecto').value = data.cliente.clave;

    document.getElementById('calleInput').value = data.cliente.datosF.domicilio.calle;
    document.getElementById('noExtInput').value = data.cliente.datosF.domicilio.noExt;
    document.getElementById('noIntInput').value = data.cliente.datosF.domicilio.noInt;
    document.getElementById('cpInput').value = data.cliente.datosF.domicilio.cp;
    document.getElementById('emailFac').value = data.cliente.datosF.emailFacturacion;
    document.getElementById('colDFRow1').classList.add('d-none');
    document.getElementById('colDFRow2').classList.remove('d-none');
    document.getElementById('auxColDF').value = data.cliente.datosF.domicilio.colonia;
    document.getElementById('ciudadDF').value = data.cliente.datosF.domicilio.ciudad;
    document.getElementById('estadoDF').value = data.cliente.datosF.domicilio.estado;
    // document.getElementById('rowInputsGeo').classList.remove('d-none');

    document.getElementById("checkAddAddress").checked = true;
    // document.getElementById('shippingAddress').style.display = 'block';
    document.getElementById('calleInputShipping').value = data.cliente.datosE.domicilio.calle;
    document.getElementById('noExtInputShipping').value = data.cliente.datosE.domicilio.noExt;
    document.getElementById('noIntInputShipping').value = data.cliente.datosE.domicilio.noInt;
    document.getElementById('cpInputShipping').value = data.cliente.datosE.domicilio.cp;
    document.getElementById('colDFShipping').value = data.cliente.datosE.domicilio.colonia;
    document.getElementById('ciudadDFShipping').value = data.cliente.datosE.domicilio.ciudad;
    document.getElementById('estadoDFShipping').value = data.cliente.datosE.domicilio.estado;

    document.getElementById('antiguedad').value = data.cliente.tiempoConst;

    addContactDataCon(data.cliente.contactos);
    contactos = data.cliente.contactos;

    var idTypeP = data.cliente.tipoPersona == true ? "typeMoral" : "typeFisica";
    document.getElementById(idTypeP).checked = true;

    var idTypeL = data.cliente.tipoLocal == true ? "typePropio" : "typeRentado";
    document.getElementById(idTypeL).checked = true;

    // document.getElementById('inputGroupSelect14').value = '-1';
    // document.getElementById('inputGroupFile14').value = "";
    // document.getElementById('label-inputGroupFile14').innerHTML = "Seleccionar Archivo...";
    docsActa = [];
    // clearTableDatos("actaConsData");

    referenciasSol = data.referencias;
    addRefDataR(data.referencias);

    addFacturaDataR(facturas);
    facturasSol = facturas;

}

function addContactDataCon(conCon) {
    if (conCon != null) {
        for (var i = 0; i < conCon.length; i++) {
            var data = {
                "tipo": conCon[i].tipo,
                "nombre": conCon[i].nombre,
                "telefono": conCon[i].telefono,
                "celular": conCon[i].celular,
                "email": conCon[i].email
            };

            switch (conCon[i].tipo) {
                case "1":
                    tipo = "PRINCIPAL";
                    break;
                case "2":
                    tipo = "PAGOS";
                    break;
                case "3":
                    tipo = "COMPRAS";
                    break;
                case "4":
                    tipo = "ADMON";
                    break;
                case "5":
                    tipo = "EMERGENCIA";
                    break;
            }

            var table = document.getElementById('contactData');
            var row = table.insertRow(table.rows.length);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = conCon[i].nombre;
            cell2.innerHTML = conCon[i].celular;
            cell3.innerHTML = conCon[i].tipo;
            cell4.innerHTML = "<i class='fas fa-user-times' onclick='deleteContactRow(this)'></i>";
        }
    }
}


function addRefDataR(dataRef) {

    if (dataRef != null) {
        for (var i = 0; i < dataRef.length; i++) {
            var data = {
                "rzRef": dataRef[i].nombre,
                "contRef": dataRef[i].nombre,
                "cityRef": dataRef[i].city,
                "telRef": dataRef[i].phone
            };

            var table = document.getElementById('refData');
            var row = table.insertRow(table.rows.length);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            cell1.innerHTML = dataRef[i].nombre;
            cell2.innerHTML = dataRef[i].nombre;
            cell3.innerHTML = dataRef[i].city;
            cell4.innerHTML = dataRef[i].phone;
            cell5.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteRefRow(this)'></i>";
        }
    }

}


function addFacturaDataR(dataFact) {

    if (dataFact != null) {
        for (var i = 0; i < dataFact.length; i++) {

            var table = document.getElementById('facturaData');
            var row = table.insertRow(table.rows.length);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = "Factura " + i;
            cell2.innerHTML = "Imp. Factura " + i;
            cell3.innerHTML = dataFact[i].importe;
            cell4.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteFactRow(this)'></i>";
        }
    }


}