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

// NEGOCIO

var giro = '';
var antiguedad = '';
var negocioFrente = '';
var negocioLeft = '';
var negocioRight = '';

// DATOS DE CONTACTO

var contactos = [];

// CREDITO

var local = '';
var tipoPersona = '';
var pagare = '';
var ineRep = '';
var ineRepBack = '';
var ineAval = '';
var ineAvalBack = '';

// ACTA CONSTITUTIVA

var contactos = [];

var docsActa = [];
var referenciasSol = [];
var facturasSol = [];

$(document).ready(function() {

    $('#inputGroupFile01').change(function(e) {
        var fileName = e.target.files[0].name;
        constanciaSituacionFiscal = toBase64(e.target.files[0]);
        $('#label-inputGroupFile01').html(fileName);
    });

    $('#inputGroupFile02').change(function(e) {
        var fileName = e.target.files[0].name;
        constanciaSituacionFiscalBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile02').html(fileName);
    });

    $('#inputGroupFile03').change(function(e) {
        var fileName = e.target.files[0].name;
        fotoSolicitud = toBase64(e.target.files[0]);
        $('#label-inputGroupFile03').html(fileName);
    });

    $('#inputGroupFile04').change(function(e) {
        var fileName = e.target.files[0].name;
        comprobanteDomicilio = toBase64(e.target.files[0]);
        $('#label-inputGroupFile04').html(fileName);
    });

    $('#inputGroupFile05').change(function(e) {
        var fileName = e.target.files[0].name;
        comprobanteDomicilioBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile05').html(fileName);
    });

    $('#inputGroupFile04-2').change(function(e) {
        var fileName = e.target.files[0].name;
        comprobanteDomicilioShipping = toBase64(e.target.files[0]);
        $('#label-inputGroupFile04-2').html(fileName);
    });

    $('#inputGroupFile05-2').change(function(e) {
        var fileName = e.target.files[0].name;
        comprobanteDomicilioShippingBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile05-2').html(fileName);
    });

    $('#inputGroupFile06').change(function(e) {
        var fileName = e.target.files[0].name;
        negocioFrente = toBase64(e.target.files[0]);
        $('#label-inputGroupFile06').html(fileName);
    });

    $('#inputGroupFile07').change(function(e) {
        var fileName = e.target.files[0].name;
        negocioLeft = toBase64(e.target.files[0]);
        $('#label-inputGroupFile07').html(fileName);
    });

    $('#inputGroupFile08').change(function(e) {
        var fileName = e.target.files[0].name;
        negocioRight = toBase64(e.target.files[0]);
        $('#label-inputGroupFile08').html(fileName);
    });

    $('#inputGroupFile09').change(function(e) {
        var fileName = e.target.files[0].name;
        pagare = toBase64(e.target.files[0]);
        $('#label-inputGroupFile09').html(fileName);
    });

    $('#inputGroupFile10').change(function(e) {
        var fileName = e.target.files[0].name;
        ineRep = toBase64(e.target.files[0]);
        $('#label-inputGroupFile10').html(fileName);
    });

    $('#inputGroupFile11').change(function(e) {
        var fileName = e.target.files[0].name;
        ineRepBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile11').html(fileName);
    });

    $('#inputGroupFile12').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAval = toBase64(e.target.files[0]);
        $('#label-inputGroupFile12').html(fileName);
    });

    $('#inputGroupFile13').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAvalBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile13').html(fileName);
    });

    $('#inputGroupFile14').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAvalBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile14').html(fileName);
    });

    $('#inputGroupFile15').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAvalBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile15').html(fileName);
    });

    $('#inputGroupFile16').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAvalBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile16').html(fileName);
    });

    $('#inputGroupFile17').change(function(e) {
        var fileName = e.target.files[0].name;
        ineAvalBack = toBase64(e.target.files[0]);
        $('#label-inputGroupFile17').html(fileName);
    });
})

function toBase64(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    var result = "";
    reader.onload = function() {
        result = reader.result;
        console.log(result);
    };
    reader.onerror = function(error) {
        result = "Error";
    };
    return result;
}

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

function addContactData() {

    var nombre = document.getElementById('nombreContacto').value;
    var telefono = document.getElementById('telefonoContacto').value;
    var celular = document.getElementById('celularContacto').value;
    var email = document.getElementById('emailContacto').value;
    var tipo = document.getElementById('tipoContacto').value;

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
    cell4.innerHTML = "<i class='fas fa-user-times' onclick='deleteContactRow(this)'></i>";
}

function deleteContactRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('contactData');
    var index = row.rowIndex;
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
    console.log(tipoPersona);
}


function addActaConstData() {

    var typeConst = document.getElementById('inputGroupSelect14').value;
    var file = document.getElementById('label-inputGroupFile14').innerHTML;

    var data = {
        "tipo": typeConst,
        "file": file,
    };

    docsActa.push(data);


    var table = document.getElementById('actaConsData');
    var row = table.insertRow(table.rows.length);

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.innerHTML = typeConst;
    cell2.innerHTML = file;
    cell3.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteActaRow(this)'></i>";
}

function deleteActaRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('actaConsData');
    var index = row.rowIndex;
    table.deleteRow(index);
    docsActa.splice(index - 1, 1);
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
    var rzRef = document.getElementById('razonSocialRef').value;
    var contRef = document.getElementById('contactoRef').value;
    var cityRef = document.getElementById('ciudadRef').value;
    var telRef = document.getElementById('telefonoRef').value;

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
    cell5.innerHTML = "<i class='fas fa-trash-alt' onclick='deleteRefRow(this)'></i>";
}

function deleteRefRow(t) {
    var row = t.parentNode.parentNode;
    var table = document.getElementById('refData');
    var index = row.rowIndex;
    table.deleteRow(index);
    referenciasSol.splice(index - 1, 1);
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
    if (activoFijo == "cash") {
        document.getElementById("amountSol").style.display = 'none';
        document.getElementById("credSol").style.display = 'none';
        document.getElementById("actaConst").style.display = 'none';
        document.getElementById("referenciaSol").style.display = 'none';
    } else {
        document.getElementById("amountSol").style.display = 'flex';
        document.getElementById("credSol").style.display = 'flex';
        document.getElementById("actaConst").style.display = 'flex';
        document.getElementById("referenciaSol").style.display = 'flex';
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

var solicitud = [];

function detalleSol(item) {
    if (item != null) {
        getInfoDetalleSol(item);
    }
    // if (solicitud.length < 0) {
    //     console.log("llegamos");
    //     $('#infoModal').modal('show');
    // }

}

function getInfoDetalleSol(item) {
    let data = { Item: item };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getInfoSol",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            // solicitud = data;
            // console.log("MSG");
            showInfoModal(data);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function getGiro(id) {
    return id;
}

function showInfoModal(data) {
    if (data != null) {
        console.log(data);
        //DATOS GENERALES
        document.getElementById("rfcEdit").value = data.cliente.datosF.rfc;
        document.getElementById("rzEdit").value = data.cliente.datosF.razonSocial;
        //DIRECCION FISCAL
        document.getElementById("calleFEdit").value = data.cliente.datosF.domicilio.calle;
        document.getElementById("noFEdit").value = data.cliente.datosF.domicilio.noExt;
        document.getElementById("cityFEdit").value = data.cliente.datosF.domicilio.ciudad;
        document.getElementById("estadoFEdit").value = data.cliente.datosF.domicilio.estado;
        document.getElementById("coloniaFEdit").value = data.cliente.datosF.domicilio.colonia;
        document.getElementById("cpFEdit").value = data.cliente.datosF.domicilio.cp;
        //DIRECCION DE ENTREGA
        document.getElementById("calleEEdit").value = data.cliente.datosE.domicilio.calle;
        document.getElementById("noEEdit").value = data.cliente.datosE.domicilio.noExt;
        document.getElementById("cityEEdit").value = data.cliente.datosE.domicilio.ciudad;
        document.getElementById("estadoEEdit").value = data.cliente.datosE.domicilio.estado;
        document.getElementById("coloniaEEdit").value = data.cliente.datosF.domicilio.colonia;
        document.getElementById("cpEEdit").value = data.cliente.datosE.domicilio.cp;
        //NEGOCIO
        document.getElementById("metPagoEdit").value = data.cliente.metodoPago;
        document.getElementById("giroEdit").value = getGiro(data.cliente.tipoNegocio);
        document.getElementById("antiguedadEdit").value = data.cliente.tiempoConst;
        //DATOS CONTACTO

        $('#infoModal').modal('show');
    }
}


function SendForm() {
    $('#solicitudModal').modal('hide');
    $('#respuestaForm').modal('show');
    document.getElementById()
}