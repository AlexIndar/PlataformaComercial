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

var tipoNegocio = -1;
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
var fileF = '';
var fileFI = '';
var cartaResponsiva = '';

//Edit Picture
var fileEdit = '';
var editBase64 = [];

// REFERENCIAS EDIT
var referenciasSolE = [];
var caratulaE = null;
var facturasSolE = [];
var fileFE = '';
var fileFIE = '';

//Acta cons
var actaConstitutivaEdit = '';
var actaConstList = [];

//emails
var emailList = [];

var flagCliente = false;
var flagDatosF = false;
var flagDomF = false;
var flagDomE = false;

$(document).ready(function() {
    // editarContactos();
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
        facturaToBase64(e.target.files[0], 1);
        $('#label-inputGroupFile16').html(fileName);
    });

    $('#inputGroupFile17').change(function(e) {
        var fileName = e.target.files[0].name;
        facturaToBase64(e.target.files[0], 2);
        $('#label-inputGroupFile17').html(fileName);
    });

    $('#inputGroupFile18').change(function(e) {
        var fileName = e.target.files[0].name;
        cartaResponsiva = toBase64(e.target.files[0], 12, null);
        $('#label-inputGroupFile18').html(fileName);
    });

    $('#inputGroupFile19').change(function(e) {
        var fileName = e.target.files[0].name;
        fileEdit = toBase64Edit(e.target.files[0]);
        $('#label-inputGroupFile19').html(fileName);
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
            // document.getElementById('rowOtroGiro').classList.remove('d-none');
        } else {
            // document.getElementById('rowOtroGiro').classList.add('d-none');
            tipoNegocio = businessLines[clickedIndex]['id'];
        }
    });

    $('#antiguedad').change(function() {
        changeAntiguedad();
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
            var itemSelectorOption = $('#inputGroupSelect01 option');
            itemSelectorOption.remove();
            let itemSelectE = $('#giroEdit option');
            itemSelectE.remove();
            $('#inputGroupSelect01').selectpicker('refresh');
            $('#giroEdit').selectpicker('refresh');

            for (var x = 0; x < businessLines.length; x++) {
                $('#inputGroupSelect01').append('<option value="' + businessLines[x]['id'] + '">' + businessLines[x]['description'] + '</option>');
                $('#inputGroupSelect01').val(businessLines[x]['id']);
                $('#inputGroupSelect01').selectpicker("refresh");

                $('#giroEdit').append('<option value="' + businessLines[x]['id'] + '">' + businessLines[x]['description'] + '</option>');
                $('#giroEdit').val(businessLines[x]['id']);
                $('#giroEdit').selectpicker("refresh");
            }

            $('#inputGroupSelect01').append('<option value="-1">Selecciona un opcion</option>'); //Agregar Primera opción de inputGroupSelect01 en Blanco
            $('#inputGroupSelect01').val('-1');
            $('#inputGroupSelect01').selectpicker("refresh");

            $('#giroEdit').append('<option value="-1">Selecciona un opcion</option>'); //Agregar Primera opción de inputGroupSelect01 en Blanco
            $('#giroEdit').val('-1');
            $('#giroEdit').selectpicker("refresh");

        },
        error: function(error) {
            console.log(error + "Error");
        }
    });

    $('#respuestaForm').on('hidden.bs.modal', function() {
        location.reload();
    })

    $('#editCaratulaInput').change(function(e) {
        var fileName = e.target.files[0].name;
        toBase64Caratula(e.target.files[0], 10, null);
        $('#label-editCaratulaInput').html(fileName);
    });

    $('#editFacturaInput').change(function(e) {
        var fileName = e.target.files[0].name;
        facturaToBase64E(e.target.files[0], 1);
        $('#label-editFacturaInput').html(fileName);
    });

    $('#editFacturaInputImp').change(function(e) {
        var fileName = e.target.files[0].name;
        facturaToBase64E(e.target.files[0], 2);
        $('#label-editFacturaInputImp').html(fileName);
    });

    $('#inputFileActaEdit').change(function(e) {
        var fileName = e.target.files[0].name;
        actaConstitutivaEdit = e.target.files[0];
        $('#label-inputFileActaEdit').html(fileName);
    });

    let jsonZona = {
        zona: document.getElementById("zoneP").value,
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/GetEmails",
        'type': 'POST',
        'dataType': 'json',
        'data': jsonZona,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(emailsL) {
            if (emailsL != null) {
                emailList = emailsL;
            } else {
                alert("Error");
            }
        },
        error: function(error) {
            console.log(error);
            alert("Error de Emails, enviar correo a adan.perez@indar.com.mx");
        }
    });

    $('#giroEdit').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var selected = clickedIndex + 1;
        if (businessLines.length < selected) {
            tipoNegocio = -1;
        } else {
            tipoNegocio = businessLines[clickedIndex]['id'];
            flagCliente = true;
        }
    });
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

function facturaToBase64(file, opc) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(subtype) {
        if (opc == 1)
            fileF = reader.result.split(',')[1];
        else
            fileFI = reader.result.split(',')[1];
    };
    reader.onerror = function(error) {
        return "Error"
    };
}

function toBase64Edit(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(subtype) {
        fileEdit = reader.result.split(',')[1];
        // fileEdit = result;
    };
    reader.onerror = function(error) {
        return "Error"
    };
}

function toBase64Caratula(file, type, subtype) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(subtype) {
        var result = reader.result.split(',')[1];
        base64 = result;
        let FileModel = {
            Id: 0,
            FileStr: result,
            Type: type,
            SubType: null
        }
        caratulaE = FileModel;
    };
    reader.onerror = function(error) {
        return "Error"
    };
}

function facturaToBase64E(file, opc) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(subtype) {
        if (opc == 1)
            fileFE = reader.result.split(',')[1];
        else
            fileFIE = reader.result.split(',')[1];
    };
    reader.onerror = function(error) {
        return "Error"
    };
}

function toBase64ActaConst(file, type, auxSubtype) {
    console.log(auxSubtype);
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(s) {
        var result = reader.result.split(',')[1];
        let FileModel = {
            Id: 0,
            FileStr: result,
            Type: type,
            SubType: auxSubtype
        }
        actaConstList.push(FileModel);
    };
    reader.onerror = function(error) {
        return "Error"
    };
}

function startForm() {
    clearForm();
    $('#solicitudModal').modal('show');
    $('#creditRadio').prop('checked', true);
    $('#typeRentado').prop('checked', true);
    $('#typeMoral').prop('checked', true);
    tipoForm = "credit";
    changeTipoPersona('Moral');
    changeTipoLocal('Rentado');
    valiteTypeForm();
}

function clearForm() {
    archivosType = [];
    archivosBase64 = [];
    document.getElementById("folioR").value = "";

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
    document.getElementById('auxColDFShipping').value = "";
    document.getElementById('colDFShipping').value = "";
    document.getElementById('ciudadDFShipping').value = "";
    document.getElementById('estadoDFShipping').value = "";

    $('#inputGroupSelect01').val(-1);
    $('#inputGroupSelect01').selectpicker("refresh");
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

const changeAntiguedad = () => {
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
        // $('#label-inputGroupFile04-2').html('Seleccionar Archivo...');
        // $('#label-inputGroupFile05-2').html('Seleccionar Archivo...');
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
                console.log(colonias);
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
    var phone = document.getElementById('telefonoContacto').value;
    var celular = document.getElementById('celularContacto').value;
    var email = document.getElementById('emailContacto').value;
    var tipo = document.getElementById('tipoContacto').value;
    if (contactos.length < maxContactos) {
        if (contactos.length == 0 && tipo != 1) {
            alert("Debes de agregar el primer contacto como principal");
            $('#tipoContacto').addClass("warningText");
        } else {
            if (tipo != "SELECCIONAR") {
                $('#tipoContacto').removeClass("warningText");
                if (validarDataContact(nombre, email, phone, celular)) {
                    let objContacto = {
                        "tipo": tipo,
                        "nombre": nombre,
                        "phone": phone,
                        "celular": celular,
                        "email": email
                    };

                    contactos.push(objContacto);

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
        }

    } else {
        alert("Maximo de contactos agregado");
    }

}

function validateNameC() {
    if (!validacionTextOne("nombreContacto")) {
        getAlert("alertContacto", "El nombre no puede ser numeros o menor a cuatro caracteres")
    } else {
        document.getElementById("alertContacto").innerHTML = "";
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

function validarDataContact(nombre, email, phone, celular) {
    var auxN = validacionText("#nombreContacto", nombre);
    var auxE = validacionEmail("#emailContacto", email);
    var auxP = validarPhoneCell("#telefonoContacto", phone);
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
    document.getElementById('telefonoContacto').value = contactos[index - 1].phone;
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

function addActaConstDataR(archivos) {
    for (let i = 0; i < archivos.length; i++) {
        if (archivos[i].type == 9) {
            var nameTypeConst = "";
            switch (archivos[i].subType) {
                case 1:
                    nameTypeConst = "RAZON SOCIAL";
                    break;
                case 2:
                    nameTypeConst = "FECHA DE CONSTITUCION";
                    break;
                case 3:
                    nameTypeConst = "GIRO DE LA EMPRESA";
                    break;
                case 4:
                    nameTypeConst = "TRANSITORIOS";
                    break;
                case 5:
                    nameTypeConst = "ACCIONISTAS";
                    break
                default:
                    nameTypeConst = "ERROR";
                    break;
            }
            let auxName = `${nameTypeConst}.jpg`;
            var data = {
                "tipo": archivos[i].subType,
                "file": auxName,
            };
            docsActa.push(data);

            var table = document.getElementById('actaConsData');
            var row = table.insertRow(table.rows.length);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = nameTypeConst;
            cell2.innerHTML = auxName;
            cell3.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteActaRow(this)'></i>";
        }
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
    console.log(t);
    console.log(referenciasSol);
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
    if (fileF != '' && fileFI != '' && document.getElementById('importFactura').value != "") {
        var fact1 = document.getElementById('label-inputGroupFile16').innerHTML;
        var fact2 = document.getElementById('label-inputGroupFile17').innerHTML;
        var importFact = parseInt(document.getElementById('importFactura').value);

        var data = {
            Id: 0,
            FileStr: fileF,
            FileTwoStr: fileFI,
            Importe: importFact
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

        document.getElementById('label-inputGroupFile16').innerHTML = "Seleccionar archivo...";
        document.getElementById('label-inputGroupFile17').innerHTML = "Seleccionar archivo...";
        document.getElementById('importFactura').value = "";
    } else {
        alert("Ingresa importe y/o facturas");
    }
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
        case "cash":
            tipo = 0;
            break;
        case "credit":
            tipo = 1;
            break;
        case "creditAB":
            tipo = 2;
            break;
        case "changeRS":
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
    let msgAlert = ``;
    var save = true;
    //DatosGenerales
    let rfc = document.getElementById('rfcInput').value;
    let razonSocial = document.getElementById('rzInput').value;
    let nombreComercial = document.getElementById('nameComeInput').value;
    let prospecto = document.getElementById('prospecto').value;

    let fotoSolicitud = archivosType.filter(x => x.type == 13).length == 1;
    let constanciaOne = archivosType.filter(x => x.type == 1).length == 1;
    let constanciaTwo = archivosType.filter(x => x.type == 11).length == 1;

    if (!constanciaOne || !constanciaTwo || !fotoSolicitud)
        msgAlert += `<p>Verifica las imagenes en Datos Generales</p>`;
    if (rfc == "" || razonSocial == "" || nombreComercial == "" || prospecto == "")
        msgAlert += `<p>Verifica la información en Datos Generales</p>`;

    //Dirección Fiscal
    let calleFiscal = document.getElementById('calleInput').value;
    let noExtFiscal = document.getElementById('noExtInput').value;
    let noIntFiscal = document.getElementById('noIntInput').value;
    let cpFiscal = document.getElementById('cpInput').value;
    let emailFac = document.getElementById('emailFac').value;
    let colDF = document.getElementById('colDF').value != "" ? document.getElementById('colDF').value : document.getElementById('auxColDF').value;
    if (calleFiscal == "" || noExtFiscal == "" || cpFiscal == "" || emailFac == "" || colDF == "")
        msgAlert += `<p>Verifica la información en Dirección Fiscal</p>`;


    //Negocio
    let antiguedad = document.getElementById("antiguedad").value;
    let negFrente = archivosType.filter(x => x.type == 4).length == 1;
    let negIzq = archivosType.filter(x => x.type == 5).length == 1;
    let negDer = archivosType.filter(x => x.type == 6).length == 1;
    if (tipoNegocio == -1 || antiguedad == "")
        msgAlert += `<p>Ingresa el giro del negocio o la antiguedad del negocio</p>`;
    if (!negFrente || !negIzq || !negDer) {
        msgAlert += `<p>Verifica las fotografias del negocio</p>`;
    }

    //DatosContacto
    if (contactos.length <= 0) {
        msgAlert += `<p>Agrega los contactos</p>`;
    }

    if (getTipoForm() != 0) {
        //DatosFiscales
        let comprobanteDomicilio = archivosType.filter(x => x.type == 2).length == 1;
        let comprobanteDomicilioBack = archivosType.filter(x => x.type == 2).length == 1;
        if (!comprobanteDomicilio)
            msgAlert += `<p>Verifica el comprobante de domicilio Dirección Fiscal</p>`;

        //Credito
        let auxTipoLocal = $('input[name="localSoli"]:checked').val();
        let auxTipoPersona = $('input[name="typePeople"]:checked').val();
        let negIfeRe = archivosType.filter(x => x.type == 3).length == 1;
        let negIfeRR = archivosType.filter(x => x.type == 31).length == 1;

        if (document.getElementById('creditoInput').value == '')
            msgAlert += `<p>Ingresa el credito</p>`;
        if (auxTipoLocal == undefined || auxTipoPersona == undefined)
            msgAlert += `<p>Verifica el tipo de local o Tipo persona</p>`;
        if (!negIfeRe || !negIfeRR)
            msgAlert += `<p>Ingresa la Ine del Representante</p>`;

        if (antiguedad < 2) {
            let credPag = archivosType.filter(x => x.type == 7).length == 1;
            let negIfeA = archivosType.filter(x => x.type == 8).length == 1;
            let negIfeAR = archivosType.filter(x => x.type == 81).length == 1;

            if (!credPag || !negIfeA || !negIfeAR)
                msgAlert += `<p>Ingresa pagare y/o IfeAval </p>`;
        }

        if ($('input[name="typePeople"]:checked').val() == "moral") {
            if (archivosType.filter(x => x.type == 9).length < 1)
                msgAlert += `<p>Ingresa acta constitutiva </p>`;
        }
    }

    if (tipoForm == '')
        msgAlert += `<p>Ingresa el tipo de formulario</p>`;

    if (msgAlert != "") {
        $('#alertModal').modal('show');
        document.getElementById("alertInfoModal").innerHTML = msgAlert;
        save = false;
    } else {
        document.getElementById("alertInfoModal").innerHTML = "";
        save = true;
    }

    return save;
}

function validateSaveForm() {
    var save = true;
    let msgAlert = ``;
    let auxMsg = `<h5>La solicitud no se puede guardar sin los siguientes datos:</h5>`;
    var rfc = document.getElementById('rfcInput').value;
    var razonSocial = document.getElementById('rzInput').value;
    var prospecto = document.getElementById('prospecto').value;
    var emailFac = document.getElementById('emailFac').value;
    var colDF = document.getElementById('colDF').value == "" ? document.getElementById('auxColDF').value : document.getElementById('colDF').value;
    var cpFiscal = document.getElementById('cpInput').value;
    let noExt = document.getElementById('noExtInput').value;
    let neg = document.getElementById('antiguedad').value;
    if (tipoForm == "")
        msgAlert += `<p>Ingresa el tipo de Solicitud</p>`;
    if (rfc == "")
        msgAlert += `<p>Ingresa el RFC</p>`;
    if (razonSocial == "")
        msgAlert += `<p>Nombre o Razón Social</p>`;
    if (prospecto == "")
        msgAlert += `<p>Número de Prospecto</p>`;
    if (emailFac == "")
        msgAlert += `<p>Email de facturacion</p>`;
    if (colDF == "")
        msgAlert += `<p>Colonia</p>`;
    if (cpFiscal == "")
        msgAlert += `<p>Codigo Postal</p>`;
    if (tipoNegocio == -1) {
        // msgAlert += `<p>Ingresa el giro del negocio</p>`;
        $('#inputGroupSelect01').val(23);
        $('#inputGroupSelect01').selectpicker("refresh");
        tipoNegocio = 23;
    }
    if (noExt == "") {
        document.getElementById('noExtInput').value = 1;
    }
    if (neg == "") {
        document.getElementById('antiguedad').value = 1;
    }
    if (msgAlert != "") {
        $('#alertModal').modal('show');
        document.getElementById("alertInfoModal").innerHTML = auxMsg + msgAlert;
        save = false;
    } else {
        save = true;
    }
    return save;
}


function SendForm(zone) {
    if (validateFullForm()) {
        $('#cargaModal').modal('show');
        var json = createJsonSolicitud(zone);
        let tp = getTipoForm();
        let cliente = {
            clave: document.getElementById('prospecto').value,
            datosF: {
                rfc: document.getElementById('rfcInput').value,
                razonSocial: document.getElementById('rzInput').value,
            }
        }
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
                if (Number.isInteger(data)) {
                    $('#cargaModal').modal('hide');
                    sendMail(data, tp, cliente, 1);
                    $('#solicitudModal').modal('hide');
                    document.getElementById('infoModalR').innerHTML = `Solicitud enviada correctamente No. ${data}, espera a envio de correo`;
                    $('#respuestaForm').modal('show');
                } else {
                    console.log(data);
                    alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                    $('#cargaModal').modal('hide');
                }
            },
            error: function(error) {
                console.log(error);
                alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
            }
        });
    }
}

function saveForm(zone) {
    if (validateSaveForm()) {
        $('#cargaModal').modal('show');
        var json = createJsonSolicitud(zone);
        let tp = getTipoForm();
        let cliente = {
            clave: document.getElementById('prospecto').value,
            datosF: {
                rfc: document.getElementById('rfcInput').value,
                razonSocial: document.getElementById('rzInput').value,
            }
        }
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
                    $('#cargaModal').modal('hide');
                    // sendMail(data, tp, cliente, 3);
                    $('#solicitudModal').modal('hide');
                    document.getElementById('infoModalR').innerHTML = `Solicitud guardada correctamente No. ${data}`;
                    $('#respuestaForm').modal('show');
                } else {
                    console.log(data);
                    alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                    $('#cargaModal').modal('hide');
                }
            },
            error: function(error) {
                console.log(error);
                alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
            }
        });
    }
}



function createJsonSolicitud(zone) {
    var contactosData = [];
    var referenciasData = [];
    var archivosData = [];
    var archivosNull = [{
        "Id": 0,
        "FileStr": "",
        "Type": 19,
        "SubType": null
    }];

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
            phone: contactos[x]['phone'],
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
            Id: 0,
            FileStr: archivosBase64[x],
            Type: archivosType[x]['type'],
            Subtype: archivosType[x]['subtype'] != null ? parseInt(archivosType[x]['subtype']) : null,
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
        folio: document.getElementById("folioR").value == "" ? -1 : document.getElementById("folioR").value,
        //folio: -1,
        fecha: getDateTime(),
        tipo: getTipoForm(),
        credito: getTipoForm() == 0 ? null : document.getElementById('creditoInput').value == "" ? 0 : parseInt(document.getElementById('creditoInput').value),
        zona: JSON.parse(zone),
        cliente: {
            clave: document.getElementById('prospecto').value,
            nombreComercial: document.getElementById('nameComeInput').value,
            tipoNegocio: tipoNegocio,
            otroGiro: null,
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
                    colonia: coloniaSelect != "" ? coloniaSelect : document.getElementById("auxColDF").value.toUpperCase(),
                    ciudad: document.getElementById('ciudadDF').value.toUpperCase(),
                    estado: document.getElementById('estadoDF').value.toUpperCase(),
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
                    colonia: auxColoniaSelect != '' ? auxColoniaSelect : coloniaSelect != "" ? coloniaSelect : document.getElementById("auxColDF").value.toUpperCase(),
                    ciudad: document.getElementById('ciudadDFShipping').value == '' ? document.getElementById('ciudadDF').value.toUpperCase() : document.getElementById('ciudadDFShipping').value.toUpperCase(),
                    estado: document.getElementById('estadoDFShipping').value == '' ? document.getElementById('estadoDF').value.toUpperCase() : document.getElementById('estadoDFShipping').value.toUpperCase(),
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
        archivos: archivosData.length > 0 ? archivosData : archivosNull,
        factura: $('input[name="refSoli"]:checked').val() == 'facturas' ? facturasSol : null,
        observations: null
    };
    //console.log(json);
    //console.log(JSON.stringify(json));
    calLengthMB(json);
    return json;
}

const calLengthMB = (json) => {
    let auxJson = JSON.stringify(json).length;
    auxJson = (auxJson / 1024).toFixed(2);
    if (auxJson > 1024) {
        auxJson = (auxJson / 1024).toFixed(2);
        console.log(`${auxJson} Mb`);
    } else {
        console.log(`${auxJson} Kb`);
    }
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
                                        success: function(factList) {
                                            showInfoModal(data, data2, valContac, filesList, factList);
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
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}



function getGiro(id) {
    let giro = businessLines.filter(x => x.id == id);
    return giro.length > 0 ? giro[0].description : "Error en giro";
}

function getTypeCont(id) {
    var typeCont = "";
    switch (id) {
        case 1:
            typeCont = "Principal";
            break;
        case 2:
            typeCont = "Pagos";
            break;
        case 3:
            typeCont = "Compras";
            break;
        case 4:
            typeCont = "Admon";
            break;
        case 5:
            typeCont = "Emergencia";
            break;
        default:
            typeCont = "ERROR";
    }
    return typeCont;
}


function editImage(type) {
    fileEdit = '';
    $('#label-inputGroupFile19').html("Fotografia a editar");
    let buttons = `<button class="btn btn-success btn-circle" onclick="confirmEditImage('` + type + `')"><i class="fas fa-paper-plane"></i>Guardar Imagen</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelEditForm()" style="margin-left: 10px;"><i class="fas fa-times"></i>Cancelar Imagen</button>`;
    document.getElementById("editConfirButtons").innerHTML = buttons;
    $('#editImageModal').modal('show');
}

function confirmEditImage(type) {
    let folio = parseInt(document.getElementById("folioInf").innerHTML);
    if (fileEdit != '') {
        $('#cargaModal').modal('show');
        let json = {
            Folio: folio,
            File: {
                Id: 0,
                FileStr: fileEdit,
                Type: type,
                Subtype: null,
            }
        }
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "MisSolicitudes/UpdateFile",
            'type': 'POST',
            'dataType': 'json',
            'data': json,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                if (Number.isInteger(data)) {
                    $('#cargaModal').modal('hide');
                    document.getElementById("editConfirButtons").innerHTML = "IMAGEN ACTUALIZADA";
                    $('#infoModal').modal('hide');
                    detalleSol(folio);
                } else {
                    console.log(data);
                    alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                    $('#cargaModal').modal('hide');
                }
            },
            error: function(error) {
                console.log(error);
                alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
                $('#cargaModal').modal('hide');
            }
        });
        console.log(json);
        console.log(JSON.stringify(json));
    } else {
        console.log(fileEdit);
        alert("Seleccione un archivo");
    }
}

function cancelEditForm() {
    $('#editImageModal').modal('hide');
}

const editList = () => {
    document.getElementById('giroEdit2').classList.remove('d-none');
    document.getElementById('giroEdit1').classList.add('d-none');
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

const getButtonsGiro = (dato) => {
    let buttons = dato == false ? `<button class="btn btn-primary btn-circle" onclick="editList()"><i class="fas fa-edit"></i></button>` : ``;
    if (dato == null) {
        buttons += `<button class="btn btn-secondary btn-circle float-right"><i class="fas fa-minus"></i></button>`;
    } else if (dato == true) {
        buttons += `<button class="btn btn-success btn-circle float-right"><i class="fas fa-check"></i></button>`;
    } else {
        buttons += `<button class="btn btn-danger btn-circle float-right"><i class="fas fa-times"></i></button>`;
    }
    return buttons;
}

function getButtonsFiles(dato, type) {
    var buttons = dato == false ? `<button class="btn btn-primary btn-circle" onclick="editImage('` + type + `')"><i class="fas fa-edit"></i></button>` : ``;
    if (dato == null) {
        buttons += `<button class="btn btn-secondary btn-circle float-right"><i class="fas fa-minus"></i></button>`;
    } else if (dato == true) {
        buttons += `<button class="btn btn-success btn-circle float-right"><i class="fas fa-check"></i></button>`;
    } else {
        buttons += `<button class="btn btn-danger btn-circle float-right"><i class="fas fa-times"></i></button>`;
    }
    return buttons;
}

function showInfoModal(data, data2, valContac, filesList, factList) {
    document.getElementById("refSection").style.display = "none";
    document.getElementById("crediSection").style.display = "none";
    document.getElementById("pagareSection").style.display = "none";
    document.getElementById("ifeASection").style.display = "none";
    document.getElementById("ifeARSection").style.display = "none";
    document.getElementById("aCSection").style.display = "none";
    document.getElementById("cRSection").style.display = "none";
    document.getElementById("cartSection").style.display = "none";
    document.getElementById("factSection").style.display = "none";
    cleanDetalleSol();
    cleanInfoSol();
    if (data != null) {
        // console.log(data);
        // console.log(data2);
        // console.log(valContac);
        // console.log(filesList);
        //DATOS HEADER
        document.getElementById("folioInf").innerHTML = data.folio;
        document.getElementById("typeFormInf").innerHTML = data.tipo;
        //DATOS GENERALES
        document.getElementById("rfcEdit").value = data.cliente.datosF.rfc;
        document.getElementById("rfcButtons").innerHTML = getButtons(data2.rfc, "rfcEdit");

        document.getElementById("rzEdit").value = data.cliente.datosF.razonSocial;
        document.getElementById("rzButtons").innerHTML = getButtons(data2.razonSocial, "rzEdit");

        document.getElementById("nomComEdit").value = data.cliente.nombreComercial;
        document.getElementById("nomComButtons").innerHTML = getButtons(data2.nombreComercial, "nomComEdit");

        document.getElementById("emailFactE").value = data.cliente.datosF.emailFacturacion;

        document.getElementById("csfButtons1").innerHTML = getButtonsFiles(data2.constanciaSituacion, 1);
        document.getElementById("csfButtons2").innerHTML = getButtonsFiles(data2.constanciaSituacionReverso, 11);
        document.getElementById("picSolButtons").innerHTML = getButtonsFiles(data2.firmaSolicitud, 13);

        getAlert("alertDG", data.observations.datosGenerales);
        //DIRECCION FISCAL
        document.getElementById("calleFEdit").value = data.cliente.datosF.domicilio.calle;
        document.getElementById("callFEButtons").innerHTML = getButtons(data2.calle, "calleFEdit");

        document.getElementById("noFEdit").value = data.cliente.datosF.domicilio.noExt;
        document.getElementById("noFEButtons").innerHTML = getButtons(data2.numeroExterior, "noFEdit");

        document.getElementById("noIntFEdit").value = data.cliente.datosF.domicilio.noInt;
        document.getElementById("noIntFEButtons").innerHTML = getButtons(data2.numeroExterior, "noIntFEdit");

        document.getElementById("cityFEdit").value = data.cliente.datosF.domicilio.ciudad;
        document.getElementById("cityFEButtons").innerHTML = getButtons(data2.ciudad, "cityFEdit");

        document.getElementById("estadoFEdit").value = data.cliente.datosF.domicilio.estado;
        document.getElementById("estadoFEButtons").innerHTML = getButtons(data2.estado, "estadoFEdit");

        document.getElementById("coloniaFEdit").value = data.cliente.datosF.domicilio.colonia;
        document.getElementById("coloniaFEButtons").innerHTML = getButtons(data2.colonia, "coloniaFEdit");

        document.getElementById("cpFEdit").value = data.cliente.datosF.domicilio.cp;
        document.getElementById("cpFEButtons").innerHTML = getButtons(data2.cp, "cpFEdit");

        if (data.tipo == 0) {
            document.getElementById('datFisCD').classList.add('d-none');
        } else {
            document.getElementById('datFisCD').classList.remove('d-none');
            document.getElementById("comDFEButtons").innerHTML = getButtonsFiles(data2.comprobanteDomicilio, 2);
        }
        getAlert("alertDF", data.observations.direccionFiscal);

        //DIRECCION DE ENTREGA
        document.getElementById("calleEEdit").value = data.cliente.datosE.domicilio.calle;
        document.getElementById("calleEEButtons").innerHTML = getButtons(data2.calleEntrega, "calleEEdit");

        document.getElementById("noEEdit").value = data.cliente.datosE.domicilio.noExt;
        document.getElementById("noEEButtons").innerHTML = getButtons(data2.numeroExteriorEntrega, "noEEdit");

        document.getElementById("noIntEEdit").value = data.cliente.datosE.domicilio.noInt;
        document.getElementById("noIntEButtons").innerHTML = getButtons(data2.numeroExteriorEntrega, "noIntEEdit");

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
        document.getElementById("metPagoButtons").innerHTML = getButtons(data2.metodoPago, "metPagoEdit");

        // document.getElementById("giroEditV").value = getGiro(data.cliente.tipoNegocio);
        // document.getElementById("giroButtons").innerHTML = getButtonsGiro(data2.cpEntrega, "giroEdit");
        tipoNegocio = data.cliente.tipoNegocio;
        document.getElementById("giroEditV").value = getGiro(data.cliente.tipoNegocio);
        $('#giroEdit').val(data.cliente.tipoNegocio);
        $('#giroEdit').selectpicker("refresh");
        document.getElementById("giroButtons").innerHTML = getButtonsGiro(data2.giroNegocio, "giroEdit");

        document.getElementById("antiguedadEdit").value = data.cliente.tiempoConst;
        document.getElementById("antiguedadButtons").innerHTML = getButtons(data2.antiguedad, "antiguedadEdit");

        document.getElementById("picNegFButtons").innerHTML = getButtonsFiles(data2.fotoFrente, 4);
        document.getElementById("picNegIButtons").innerHTML = getButtonsFiles(data2.fotoIzq, 5);
        document.getElementById("picNegDButtons").innerHTML = getButtonsFiles(data2.fotoDer, 6);

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
            document.getElementById("picIFERButtons").innerHTML = getButtonsFiles(data2.ineRepresentante, 3);
            document.getElementById("picIFERRButtons").innerHTML = getButtonsFiles(data2.ineRepresentanteReverso, 31);
            getAlert("alertCredit", data.observations.credito);

            if (data.cliente.tiempoConst < 2) {
                document.getElementById("pagareSection").style.display = "flex";
                document.getElementById("picPagAButtons").innerHTML = getButtonsFiles(data2.pagare, 7);
            }
            if (data.cliente.tiempoConst < 2 || data.tipo == null) {
                document.getElementById("ifeASection").style.display = "flex";
                document.getElementById("ifeARSection").style.display = "flex";
                document.getElementById("picIFEAButtons").innerHTML = getButtonsFiles(data2.ineAval, 8);
                document.getElementById("picIFERAButtons").innerHTML = getButtonsFiles(data2.ineAvalReverso, 81);
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
                        fileActa += `<div class="row mb-3">
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
                    document.getElementById("cartRButtons").innerHTML = getButtonsFiles(data2.cartaResponsiva, 12);
                    getAlert("alertAC", data.observations.actaConstitutiva);
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
                // console.log(data.observations.referencias);
            }

            if (factList.length > 0) {
                document.getElementById("factSection").style.display = "flex";
                let objFactura = ``;
                for (let i = 0; i < factList.length; i++) {
                    objFactura += `<div class="row mb-3">
                            <div class="col-md-3">No. ${(i + 1)} - Importe: ${factList[i].importe}</div>
                            <div class="col-md-3">
                            <button class="btn btn-warning" onclick="showIMG('` + factList[i].fileStr + `')"><i class="far fa-eye"></i> Ver Archivo</button>
                            </div>
                            <div class="col-md-3">
                            <button class="btn btn-warning" onclick="showIMG('` + factList[i].fileTwoStr + `')"><i class="far fa-eye"></i> Ver Archivo</button>
                            </div>
                            <div class="col-md-3">                            
                            </div>
                        </div>`
                }
                document.getElementById("factList").innerHTML = objFactura;
            }
            getAlert("alertRef", data.observations.referencias);
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
    if (flagCliente != false || flagDatosF != false || flagDomF != false || flagDomE != false) {
        let msgAlert = "";
        if (flagCliente) {
            let nom = document.getElementById("nomComEdit").value.toUpperCase();
            let giro = parseInt(document.getElementById("giroEdit").value);
            let antiguedad = parseInt(document.getElementById("antiguedadEdit").value);
            if (!Number.isInteger(antiguedad))
                msgAlert += "Error en antiguedad";
            if (nom == "" || giro == -1 || antiguedad < 0)
                msgAlert += "Error en Cliente";
        }
        if (flagDatosF) {
            let rfc = document.getElementById("rfcEdit").value.toUpperCase();
            let razonS = document.getElementById("rzEdit").value.toUpperCase();
            if (rfc == "" || razonS == "")
                msgAlert += "Error";
        }
        if (flagDomF) {
            let calle = document.getElementById("calleFEdit").value.toUpperCase();
            let col = document.getElementById("coloniaFEdit").value.toUpperCase();
            let city = document.getElementById("cityFEdit").value.toUpperCase();
            let estado = document.getElementById("estadoFEdit").value.toUpperCase();
            let cp = document.getElementById("cpFEdit").value.toUpperCase();
            let noE = document.getElementById("noFEdit").value.toUpperCase();
            if (calle == "" || col == "" || city == "" || estado == "" || cp == "" || noE == "")
                msgAlert += "Error";
        }
        if (flagDomE) {
            let calleE = document.getElementById("calleEEdit").value.toUpperCase();
            let colE = document.getElementById("coloniaEEdit").value.toUpperCase();
            let cityE = document.getElementById("cityEEdit").value.toUpperCase();
            let estadoE = document.getElementById("estadoEEdit").value.toUpperCase();
            let cpE = document.getElementById("cpEEdit").value.toUpperCase();
            let noEE = document.getElementById("noEEdit").value.toUpperCase();
            if (calleE == "" || colE == "" || cityE == "" || estadoE == "" || cpE == "" || noEE == "")
                msgAlert += "Error";
        }
        if (msgAlert == "") {
            let jsonEdit = getJsonEdit();
            let folioSend = parseInt(document.getElementById("folioInf").innerHTML);
            console.log(jsonEdit);
            console.log(JSON.stringify(jsonEdit));
            $('#cargaModal').modal('show');
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "MisSolicitudes/Update",
                'type': 'POST',
                'dataType': 'json',
                'data': jsonEdit,
                'enctype': 'multipart/form-data',
                'timeout': 2 * 60 * 60 * 1000,
                success: function(data) {
                    if (Number.isInteger(data)) {
                        $('#cargaModal').modal('hide');
                        $('#infoModal').modal('hide');
                        detalleSol(folioSend);
                    } else {
                        console.log(data);
                        alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                        $('#cargaModal').modal('hide');
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
                    $('#cargaModal').modal('hide');
                }
            });

        } else {
            alert("Verifica todos los datos de la solicitud");
        }
    } else {
        $('#infoModal').modal('hide');
        document.getElementById('infoModalR').innerHTML = `Solicitud guardada correctamente`;
        $('#respuestaForm').modal('show');
    }
}

const changeFlag = (item) => {
    switch (item) {
        case 1:
            flagCliente = true;
            break;
        case 2:
            flagDatosF = true;
            break;
        case 3:
            flagDomF = true;
            break;
        case 4:
            flagDomE = true;
            break;
    }
}

const getJsonEdit = () => {
    // let typeL = null;
    // let typeP = null;
    // if (document.getElementById("typeLEdit").value != "")
    //     typeL = document.getElementById("typeLEdit").value == "Propio" ? true : false;
    // if (document.getElementById("typePEdit").value != "")
    //     typeP = document.getElementById("typePEdit").value == "Moral" ? true : false;

    let jsonEdit = {
        Folio: parseInt(document.getElementById("folioInf").innerHTML),
        TypeForm: document.getElementById("typeFormInf").value == "" ? null : document.getElementById("typeFormInf").value,
        Cliente: {
            NombreComercial: document.getElementById("nomComEdit").value.toUpperCase(),
            TipoNegocio: parseInt(document.getElementById("giroEdit").value),
            TiempoConst: parseInt(document.getElementById("antiguedadEdit").value),
            TipoLocal: null,
            TipoPersona: null,
            MetodoPago: "pd",
        },
        DatosF: {
            RFC: document.getElementById("rfcEdit").value.toUpperCase(),
            RazonSocial: document.getElementById("rzEdit").value.toUpperCase(),
            EmailFacturacion: document.getElementById("emailFactE").value,
        },
        DomF: {
            Calle: document.getElementById("calleFEdit").value.toUpperCase(),
            NoInt: document.getElementById("noIntFEdit").value == "" ? null : document.getElementById("noIntFEdit").value.toUpperCase(),
            Colonia: document.getElementById("coloniaFEdit").value.toUpperCase(),
            Ciudad: document.getElementById("cityFEdit").value.toUpperCase(),
            Estado: document.getElementById("estadoFEdit").value.toUpperCase(),
            CP: document.getElementById("cpFEdit").value.toUpperCase(),
            NoExt: document.getElementById("noFEdit").value.toUpperCase(),
        },
        DomE: {
            Calle: document.getElementById("calleEEdit").value.toUpperCase(),
            NoInt: document.getElementById("noIntEEdit").value == "" ? null : document.getElementById("noIntEEdit").value.toUpperCase(),
            Colonia: document.getElementById("coloniaEEdit").value.toUpperCase(),
            Ciudad: document.getElementById("cityEEdit").value.toUpperCase(),
            Estado: document.getElementById("estadoEEdit").value.toUpperCase(),
            CP: document.getElementById("cpEEdit").value.toUpperCase(),
            NoExt: document.getElementById("noEEdit").value.toUpperCase(),
        },
        ClienteFlag: flagCliente,
        DatosFFlag: flagDatosF,
        DomFFlag: flagDomF,
        DomEFlag: flagDomE,
    }
    return jsonEdit;
}

function getButtonImg(idBtn, file) {
    if (document.getElementById(idBtn))
        document.getElementById(idBtn).innerHTML = `<button class="btn btn-warning" onclick="showIMG('` + file + `')"><i class="far fa-eye"></i> Ver Archivo</button>`;
}

function getAlert(idAlert, msg) {
    if (msg != null && msg != "") {
        // console.log(msg);
        document.getElementById(idAlert).innerHTML = `<div class="alert alert-danger" role="alert" >` + msg + `</div>`;
    }
}

function showIMG(itemIMG) {
    $('#showIMGModal').modal('show');
    console.log(itemIMG);
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
                document.getElementById('colDFRow3').classList.remove('d-none');
                document.getElementById('colDFRow4').classList.add('d-none');
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
    document.getElementById("titleModalConfirm").innerHTML = `¿Desea reenviar la solicitud No. ${item}?`;
    var buttons = `<button class="btn btn-success btn-circle" onclick="confirmReSend('` + item + `')"><i class="fas fa-paper-plane"></i> Si, Reenviar</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelForm('` + item + `')" style="margin-left: 10px;"><i class="fas fa-times"></i> No, Cancelar</button>`;
    document.getElementById("bodyModalConfirm").innerHTML = buttons;
}

function confirmReSend(item) {
    $('#confirModal').modal('hide');
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
            success: function(response) {
                if (response) {
                    alert("Enviado Correctamente");
                    location.reload();
                } else {
                    alert("Error en el servidor");
                }

            },
            error: function(error) {
                alert(error + "Error");
            }
        });
    }
}

function cancelForm(item) {
    $('#confirModal').modal('show');
    document.getElementById("titleModalConfirm").innerHTML = "Cancelación";
    document.getElementById("bodyModalConfirm").innerHTML = `Se cancelo el reenvio de la solicitud No. ${item}`;
}

function continueForm(item) {
    archivosType = [];
    archivosBase64 = [];
    docsActa = [];
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
                            console.log(error);
                        }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function manejoArchivos(archivos) {
    // console.log(archivos);
    if (archivos != null) {
        for (var i = 0; i < archivos.length; i++) {
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
                        document.getElementById('label-inputGroupFile05').innerHTML = "ComprobanteDomicilioReversa.jpg";
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
                        // console.log(archivos[i].fileStr);
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
    document.getElementById("folioR").value = data.folio;
    $('#solicitudModal').modal('show');
    var idTypeSol = data.tipo == null ? "changeRSRadio" : data.tipo == 2 ? "creditABRadio" : data.tipo == 1 ? "creditRadio" : "cashRadio";
    document.getElementById(idTypeSol).checked = true;
    valiteTypeForm();
    console.log(archivos);
    manejoArchivos(archivos);
    cargarArchivos(archivos);
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

    if (!compareDir(data.cliente.datosF.domicilio, data.cliente.datosE.domicilio)) {
        document.getElementById('colDFRow3').classList.add('d-none');
        document.getElementById('colDFRow4').classList.remove('d-none');
        document.getElementById("checkAddAddress").checked = true;
        addAddress();
        document.getElementById('calleInputShipping').value = data.cliente.datosE.domicilio.calle;
        document.getElementById('noExtInputShipping').value = data.cliente.datosE.domicilio.noExt;
        document.getElementById('noIntInputShipping').value = data.cliente.datosE.domicilio.noInt;
        document.getElementById('cpInputShipping').value = data.cliente.datosE.domicilio.cp;
        document.getElementById('auxColDFShipping').value = data.cliente.datosE.domicilio.colonia;
        document.getElementById('ciudadDFShipping').value = data.cliente.datosE.domicilio.ciudad;
        document.getElementById('estadoDFShipping').value = data.cliente.datosE.domicilio.estado;
    } else {
        document.getElementById("checkAddAddress").checked = false;
        document.getElementById('calleInputShipping').value = "";
        document.getElementById('noExtInputShipping').value = "";
        document.getElementById('noIntInputShipping').value = "";
        document.getElementById('cpInputShipping').value = "";
        document.getElementById('colDFShipping').value = "";
        document.getElementById('ciudadDFShipping').value = "";
        document.getElementById('estadoDFShipping').value = "";
    }

    tipoNegocio = data.cliente.tipoNegocio;
    $('#inputGroupSelect01').val(data.cliente.tipoNegocio);
    $('#inputGroupSelect01').selectpicker("refresh");
    document.getElementById('antiguedad').value = data.cliente.tiempoConst;
    changeAntiguedad();
    if (data.cliente.contactos.length >= 1) {
        if (data.cliente.contactos[0].nombre != "" && data.cliente.contactos[0].phone != "0") {
            addContactDataCon(data.cliente.contactos);
            contactos = data.cliente.contactos;
        }
    } // else {
    //     addContactDataCon(data.cliente.contactos);
    //     contactos = data.cliente.contactos;
    // }


    var idTypeP = data.cliente.tipoPersona == true ? "typeMoral" : "typeFisica";
    document.getElementById(idTypeP).checked = true;
    let auxTypeP = idTypeP == "typeMoral" ? 'Moral' : 'Fisica';
    changeTipoPersona(auxTypeP);
    var idTypeL = data.cliente.tipoLocal == true ? "typePropio" : "typeRentado";
    document.getElementById(idTypeL).checked = true;
    let auxTypeL = idTypeL == "typePropio" ? 'Propio' : 'Rentado';
    changeTipoLocal(auxTypeL);

    addActaConstDataR(archivos);

    if (data.referencias.length > 0) {
        //referenciasSol = data.referencias;
        addRefDataR(data.referencias);
        document.getElementById("refSoliDatos").checked = true;
    } else if (archivos.filter(x => x.type == 10).length > 0) {
        document.getElementById("refSoliCaratula").checked = true;
    } else if (facturas.length > 0) {
        document.getElementById("refSoliFactura").checked = true;
        facturasSol = facturas;
        addFacturaDataR(facturas);
    }
    changeRef();
}

const cleanDetalleSol = () => {
    document.getElementById("alertDG").innerHTML = "";
    document.getElementById("alertDF").innerHTML = "";
    document.getElementById("alertDE").innerHTML = "";
    document.getElementById("alertNegocio").innerHTML = "";
    document.getElementById("alertCont").innerHTML = "";
    document.getElementById("alertCredit").innerHTML = "";
    document.getElementById("alertAC").innerHTML = "";
    document.getElementById("alertRef").innerHTML = "";
}

const cleanInfoSol = () => {
    //Credito
    document.getElementById("typeLEdit").value = "";
    document.getElementById("typePEdit").value = "";

    flagCliente = false;
    flagDatosF = false;
    flagDomE = false;
    flagDomF = false;
    //disable
    // console.log(document.getElementById("folioInf").innerHTML);
    // console.log(document.getElementById("typeFormInf").value);
    //DatosFiscales
    document.getElementById("rfcEdit").disabled = true;
    document.getElementById("rzEdit").disabled = true;
    document.getElementById("nomComEdit").disabled = true;
    //direccion fiscal
    document.getElementById("calleFEdit").disabled = true;
    document.getElementById("noFEdit").disabled = true;
    document.getElementById("noIntFEdit").disabled = true;
    document.getElementById("cityFEdit").disabled = true;
    document.getElementById("estadoFEdit").disabled = true;
    document.getElementById("coloniaFEdit").disabled = true;
    document.getElementById("cpFEdit").disabled = true;
    //Direccion de entrega
    document.getElementById("calleEEdit").disabled = true;
    document.getElementById("noEEdit").disabled = true;
    document.getElementById("noIntEEdit").disabled = true;
    document.getElementById("cityEEdit").disabled = true;
    document.getElementById("estadoEEdit").disabled = true;
    document.getElementById("coloniaEEdit").disabled = true;
    document.getElementById("cpEEdit").disabled = true;
    //Negocio
    document.getElementById("metPagoEdit").disabled = true;
    document.getElementById('giroEdit2').classList.add('d-none');
    document.getElementById('giroEdit1').classList.remove('d-none');

    document.getElementById("antiguedadEdit").disabled = true;
    document.getElementById("typeLEdit").disabled = true;
    document.getElementById("typePEdit").disabled = true;
}

function cargarArchivos(archivos) {
    if (archivos.length > 0) {
        for (let i = 0; i < archivos.length; i++) {
            archivosBase64.push(archivos[i].fileStr);
            var temp = {
                type: archivos[i].type,
                subtype: archivos[i].subType,
            };
            archivosType.push(temp);
        }
    }
}


function compareDir(datosF, datosE) {
    if (datosF.calle == datosE.calle && datosF.noInt == datosE.noInt && datosF.colonia == datosE.colonia && datosE.ciudad == datosF.ciudad && datosF.estado == datosE.estado && datosF.cp == datosE.cp)
        return true;
    else
        return false;
}

function addContactDataCon(conCon) {
    // console.log(conCon);
    if (conCon != null) {
        for (var i = 0; i < conCon.length; i++) {
            var data = {
                "tipo": conCon[i].tipo,
                "nombre": conCon[i].nombre,
                "phone": conCon[i].phone,
                "celular": conCon[i].celular,
                "email": conCon[i].email
            };
            let tipo = "";

            switch (conCon[i].tipo) {
                case 1:
                    tipo = "PRINCIPAL";
                    break;
                case 2:
                    tipo = "PAGOS";
                    break;
                case 3:
                    tipo = "COMPRAS";
                    break;
                case 4:
                    tipo = "ADMON";
                    break;
                case 5:
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
            cell3.innerHTML = tipo;
            cell4.innerHTML = "<i class='fas fa-pencil-alt' onclick='editContactRow(this)'></i>Editar /<i class='fas fa-user-times' onclick='deleteContactRow(this)'></i> Eliminar";
        }
    }
}


function addRefDataR(dataRef) {
    if (dataRef != null) {
        for (var i = 0; i < dataRef.length; i++) {
            var data = {
                "rzRef": dataRef[i].nombre,
                "contRef": dataRef[i].celular,
                "cityRef": dataRef[i].city,
                "telRef": dataRef[i].phone
            };

            referenciasSol.push(data);

            var table = document.getElementById('refData');
            var row = table.insertRow(table.rows.length);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            cell1.innerHTML = dataRef[i].nombre;
            cell2.innerHTML = dataRef[i].celular;
            cell3.innerHTML = dataRef[i].city;
            cell4.innerHTML = dataRef[i].phone;
            cell5.innerHTML = "<i class='fas fa-pencil-alt' onclick='editRefRow(this)'></i>/<i class='fas fa-trash-alt' onclick='deleteRefRow(this)'></i>";
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


/*EDIT REFERENCES*/

const editReferences = () => {
    referenciasSolE = [];
    caratulaE = null;
    facturasSolE = [];
    fileFE = '';
    fileFIE = '';
    $('#editRefDatos').prop('checked', true);
    changeRefEdit();
    cleanAllEditReferences();
    $('#editReferences').modal('show');
}

const cleanAllEditReferences = () => {
    clearInfoFacturasEdit();
    cleanDatosRefDataEdit();
    document.getElementById("label-editCaratulaInput").innerHTML = "Seleccionar archivo ...";
}

const changeRefEdit = () => {
    let ref = $('input[name="editRef"]:checked').val();
    if (ref == "datos") {
        document.getElementById("refGroupEdit").style.display = 'flex';
        document.getElementById("cartGroupEdit").style.display = 'none';
        document.getElementById("factGroupEdit").style.display = 'none';
        clearInfoFacturasEdit();
        clearTableDatos("facturaDataEdit");
        document.getElementById("label-editCaratulaInput").innerHTML = "Seleccionar archivo ...";
        caratulaE = null;
        facturasSolE = [];
        fileFE = '';
        fileFIE = '';
    } else if (ref == "caratula") {
        document.getElementById("refGroupEdit").style.display = 'none';
        document.getElementById("cartGroupEdit").style.display = 'flex';
        document.getElementById("factGroupEdit").style.display = 'none';
        referenciasSolE = [];
        facturasSolE = [];
        fileFE = '';
        fileFIE = '';
        clearTableDatos("refDataEdit");
        clearTableDatos("facturaDataEdit");
    } else if (ref == "facturas") {
        document.getElementById("refGroupEdit").style.display = 'none';
        document.getElementById("cartGroupEdit").style.display = 'none';
        document.getElementById("factGroupEdit").style.display = 'flex';
        referenciasSolE = [];
        caratulaE = null;
        cleanDatosRefDataEdit();
        clearTableDatos("refDataEdit");
        document.getElementById("label-editCaratulaInput").innerHTML = "Seleccionar archivo ...";
    }
}

const addRefDataEdit = () => {
    let rzRef = document.getElementById('razonSocialRefEdit').value.toUpperCase();
    let contRef = document.getElementById('contactoRefEdit').value.toUpperCase();
    let cityRef = document.getElementById('ciudadRefEdit').value.toUpperCase();
    let telRef = document.getElementById('telefonoRefEdit').value;
    if (validarDataDatosFEdit(rzRef, contRef, cityRef, telRef)) {
        let temp = {
            id: 0,
            tipo: 1,
            nombre: rzRef,
            email: null,
            celular: contRef,
            phone: telRef,
            city: cityRef,
        };

        referenciasSolE.push(temp);

        let table = document.getElementById('refDataEdit');
        let row = table.insertRow(table.rows.length);

        let cell1 = row.insertCell(0);
        let cell2 = row.insertCell(1);
        let cell3 = row.insertCell(2);
        let cell4 = row.insertCell(3);
        let cell5 = row.insertCell(4);

        cell1.innerHTML = rzRef;
        cell2.innerHTML = contRef;
        cell3.innerHTML = cityRef;
        cell4.innerHTML = telRef;
        cell5.innerHTML = "<i class='fas fa-pencil-alt' onclick='editRefRowEdit(this)'></i>/<i class='fas fa-trash-alt' onclick='deleteRefRowEdit(this)'></i>";
        cleanDatosRefDataEdit();
    }
}

const deleteRefRowEdit = (t) => {
    let row = t.parentNode.parentNode;
    let table = document.getElementById('refDataEdit');
    let index = row.rowIndex;
    table.deleteRow(index);
    referenciasSolE.splice(index - 1, 1);
}


const editRefRowEdit = (t) => {
    let row = t.parentNode.parentNode;
    let table = document.getElementById('refDataEdit');
    let index = row.rowIndex;
    document.getElementById('razonSocialRefEdit').value = referenciasSolE[index - 1].nombre;
    document.getElementById('contactoRefEdit').value = referenciasSolE[index - 1].celular;
    document.getElementById('ciudadRefEdit').value = referenciasSolE[index - 1].city;
    document.getElementById('telefonoRefEdit').value = referenciasSolE[index - 1].phone;
    table.deleteRow(index);
    referenciasSolE.splice(index - 1, 1);
}

const cleanDatosRefDataEdit = () => {
    document.getElementById('razonSocialRefEdit').value = "";
    document.getElementById('contactoRefEdit').value = "";
    document.getElementById('ciudadRefEdit').value = "";
    document.getElementById('telefonoRefEdit').value = "";
}

const validarDataDatosFEdit = (rz, cont, city, phone) => {
    let auxR = validacionText("#razonSocialRefEdit", rz);
    let auxC = validacionText("#contactoRefEdit", cont);
    let auxCt = validacionText("#ciudadRefEdit", city);
    let auxT = validarPhoneCell("#telefonoRefEdit", phone);
    if (auxR && auxC && auxCt && auxT) {
        return true;
    } else {
        return false;
    }
}

const addFacturaDataEdit = () => {
    if (fileFE != '' && fileFIE != '' && document.getElementById('importFacturaEdit').value != "") {
        let fact1 = document.getElementById('label-editFacturaInput').innerHTML;
        let fact2 = document.getElementById('label-editFacturaInputImp').innerHTML;
        let importFact = parseInt(document.getElementById('importFacturaEdit').value);

        let data = {
            Id: 0,
            FileStr: fileFE,
            FileTwoStr: fileFIE,
            Importe: importFact
        };

        facturasSolE.push(data);

        let table = document.getElementById('facturaDataEdit');
        let row = table.insertRow(table.rows.length);

        let cell1 = row.insertCell(0);
        let cell2 = row.insertCell(1);
        let cell3 = row.insertCell(2);
        let cell4 = row.insertCell(3);

        cell1.innerHTML = fact1;
        cell2.innerHTML = fact2;
        cell3.innerHTML = importFact;
        cell4.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteFactRowE(this)'></i>";
        clearInfoFacturasEdit();
    } else {
        alert("Ingresa importe y/o facturas");
    }
}

const deleteFactRowE = (t) => {
    let row = t.parentNode.parentNode;
    let table = document.getElementById('facturaDataEdit');
    let index = row.rowIndex;
    table.deleteRow(index);
    facturasSolE.splice(index - 1, 1);
}

const clearInfoFacturasEdit = () => {
    document.getElementById('label-editFacturaInput').innerHTML = "Seleccionar archivo...";
    document.getElementById('label-editFacturaInputImp').innerHTML = "Seleccionar archivo...";
    document.getElementById('importFacturaEdit').value = "";
}

const saveReferences = () => {
    $('#cargaModal').modal('show');
    let referencesJson = getJsonReferences();
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "MisSolicitudes/UpdateReferences",
        'type': 'POST',
        'dataType': 'json',
        'data': referencesJson,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            if (Number.isInteger(data)) {
                $('#cargaModal').modal('hide');
                $('#editReferences').modal('hide');
                $('#infoModal').modal('hide');
                detalleSol(referencesJson.Folio);
            } else {
                console.log(data);
                alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                $('#cargaModal').modal('hide');
            }
        },
        error: function(error) {
            console.log(error);
            alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
            $('#cargaModal').modal('hide');
        }
    });
}

const getJsonReferences = () => {
    let auxFol = document.getElementById('folioInf').innerHTML;
    let referencesJson = {
        Folio: auxFol,
        Referencias: referenciasSolE.length > 0 ? referenciasSolE : null,
        Facturas: facturasSolE.length > 0 ? facturasSolE : null,
        Caratula: caratulaE
    }
    return referencesJson;
}

/*EDIT ACTA CONSTITUTIVA*/
const editActaConst = () => {
    $('#actaConstEditModal').modal('show');
    clearActaConstEdit();
    actaConstList = [];
    actaConstitutivaEdit = '';
    clearTableDatos("actaConsDataEdit");
}

const addActaConstDataEdit = () => {
    let subTypeActa = parseInt(document.getElementById('inputTypeActa').value);
    let nameFile = document.getElementById('label-inputFileActaEdit').innerHTML;
    if (subTypeActa != -1 && actaConstitutivaEdit != '') {
        toBase64ActaConst(actaConstitutivaEdit, 9, subTypeActa);

        var table = document.getElementById('actaConsDataEdit');
        var row = table.insertRow(table.rows.length);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        let auxName = getTypeConst(subTypeActa);

        cell1.innerHTML = auxName;
        cell2.innerHTML = nameFile;
        cell3.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteActaRowEdit(this)'></i>";
        clearActaConstEdit();
        $('#inputTypeActa').removeClass("warningText");
    } else {
        $('#inputTypeActa').addClass("warningText");
    }
}

const clearActaConstEdit = () => {
    document.getElementById('label-inputFileActaEdit').innerHTML = "Seleccionar Archivo ...";
    document.getElementById('inputFileActaEdit').value = "";
    document.getElementById('inputTypeActa').value = '-1';
}

const getTypeConst = (id) => {
    let nameTC = "";
    switch (id) {
        case 1:
            nameTC = "RAZON SOCIAL";
            break;
        case 2:
            nameTC = "FECHA DE CONSTITUCION";
            break;
        case 3:
            nameTC = "GIRO DE LA EMPRESA";
            break;
        case 4:
            nameTC = "TRANSITORIOS";
            break;
        case 5:
            nameTC = "ACCIONISTAS";
            break
        default:
            nameTC = "ERROR";
            break;
    }
    return nameTC;
}

const deleteActaRowEdit = (t) => {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('actaConsDataEdit');
    var index = row.rowIndex;
    table.deleteRow(index);
    actaConstList.splice(index - 1, 1);
}

const saveActaConst = () => {
    $('#cargaModal').modal('show');
    let actaConstJson = getJsonActaConst();
    if (actaConstJson != null) {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "MisSolicitudes/UpdateConstAct",
            'type': 'POST',
            'dataType': 'json',
            'data': actaConstJson,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(data) {
                if (Number.isInteger(data)) {
                    $('#cargaModal').modal('hide');
                    $('#actaConstEditModal').modal('hide');
                    $('#infoModal').modal('hide');
                    detalleSol(actaConstJson.Folio);
                } else {
                    console.log(data);
                    alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                    $('#cargaModal').modal('hide');
                }
            },
            error: function(error) {
                console.log(error);
                alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
                $('#cargaModal').modal('hide');
            }
        });
    }
}

const getJsonActaConst = () => {
    let auxFol = document.getElementById('folioInf').innerHTML;
    if (actaConstList.length > 0) {
        let actaConstJson = {
            Folio: auxFol,
            ConsActs: actaConstList,
        }
        return actaConstJson;
    } else {
        alert("Error al crear las constancias");
        return null;
    }
}

const getTipoFormM = () => {
    var tipo = "";
    switch (tipoForm) {
        case "cash":
            tipo = "CONTADO";
            break;
        case "credit":
            tipo = "CREDITO";
            break;
        case "creditAB":
            tipo = "CREDITO AB";
            break;
        case "changeRS":
            tipo = "CARTA RESPONSIVA";
            break;
    }
    return tipo;

}

const enviarMail = () => {
    let codigo = prompt("Codigo");
    if (codigo == 862479315) {
        let status = parseInt(prompt("Status"));
        let cliente = {
            clave: "Ptest",
            datosF: {
                razonSocial: "PruebaMail",
                rfc: "XAXX010101000",
            }
        }
        sendMail(-1, 1, cliente, status);
    }

}

const sendMail = (fol, tps, cli, status) => {
    let zona = document.getElementById("zoneP").value;
    let auxStatus = "";
    let auxTps = "";
    switch (status) {
        case 1:
            auxStatus = "Nueva Solicitud";
            break;
        case 2:
            auxStatus = "Reenvio de solicitud";
            break;
        case 3:
            auxStatus = "Guardado de Solicitud";
            break;
    }

    switch (tps) {
        case null:
            auxTps = "CARTA RESPONSIVA";
            break;
        case 0:
            auxTps = "CONTADO";
            break;
        case 1:
            auxTps = "CREDITO";
            break;
        case 2:
            auxTps = "CREDITO AB";
            break;
    }
    let mailJson = {
        folio: fol,
        tipoSol: auxTps,
        cliente: cli.clave,
        razonSocial: cli.datosF.razonSocial,
        rfc: cli.datosF.rfc,
        zona: zona,
        emails: emailList,
        status: auxStatus,
    };
    // console.log(mailJson);
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmailSolicitud",
        'type': 'POST',
        'dataType': 'json',
        'data': mailJson,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            console.log(data);
            alert(data.success);
        },
        error: function(error) {
            console.log(error);
            alert("Solicitud Guardada, pero no se enviaron los correos...");
            $('#cargaModal').modal('hide');
            $('#solicitudModal').modal('hide');
            document.getElementById('infoModalR').innerHTML = `Solicitud guardada correctamente No. ${data}`;
            $('#respuestaForm').modal('show');
        }
    });
}


const validaCPEdit = () => {
    numbers = /^[0-9]+$/;
    var cp = document.getElementById("cpFEdit").value;
    if (cp.match(numbers) && cp.length > 3) {
        $('#cpFEdit').removeClass("warningText");
    } else {
        $('#cpFEdit').addClass("warningText");
    }
    changeFlag(3);
}


const editarContactos = () => {
    $('#contactosEdit').modal('show');
}