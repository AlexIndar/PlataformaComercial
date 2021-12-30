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


function valiteTypeForm() {
    let activoFijo = $('input[name="typeSoli"]:checked').val();
    if (activoFijo == "cash") {
        document.getElementById("amountSol").style.display = 'none';
    } else {
        document.getElementById("amountSol").style.display = 'flex';
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
    let firm = document.getElementById("FirmCtrl").value;

    if (rfc == "" || razonSocial == "" || nameCome == "" || prospecto == "" || file1 == "" || file2 == "" || firm == "") {
        return false;
    } else {
        return true;
    }
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
    if (solicitud.length < 0) {
        $('#infoModal').modal('show');
        console.log(solicitud);
    }

}

function getInfoDetalleSol(item) {
    let data = { Item: item };
    console.log(data);
    console.log("INfo data");
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
            solicitud = data;
            console.log(data);
        },
        error: function(error) {
            console.log(error + "D");
        }
    });
}