var idGerencia = '';
var auxListSolicitud = [];
$(document).ready(function () {
    if (document.getElementById("userR").value == "GERENTEVENTA") {
        let data = { User: document.getElementById("userP").value };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/EstadisticaSolicitudTiempo/GetGerencia",
            'type': 'POST',
            'dataType': 'json',
            'data': data,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (report) {
                idGerencia = report.id;
            },
            error: function (error) {
                idGerencia = '';
                console.log(error);
            }
        });
    }

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
        // console.log("ITEM");
        // console.log(start.format('YYYY-MM-DD'));
        // console.log(end.format('YYYY-MM-DD'));
        getEstadisticaTiempo();
        // console.log("SI");
        // console.log("Prueb");
        // startDate = start.format('YYYY-MM-DD');
        // endDate = end.format('YYYY-MM-DD');
    });

    $(function () {
        $("#tableCyc").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "buttons": ["csv", "excel", "pdf"],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
});

document.getElementById("typeForms").addEventListener("change", function (e) {
    getEstadisticaTiempo();
});

const getEstadisticaTiempo = () => {
    auxListSolicitud = [];
    var fecha = $('#reservation').daterangepicker()[0].value;
    var dateIF = fecha.split('-').map(s => s.trim());
    let typeFol = document.getElementById("typeForms").value;
    if (typeFol != "SELECCIONAR") {
        $('#cargaModal').modal('show');
        if (document.getElementById("userR").value != "GERENTEVENTA") {
            getTimeReport(typeFol, dateIF[0], dateIF[1]);
        } else {
            getManagementTimeReport(idGerencia, typeFol, dateIF[0], dateIF[1]);
        }
    } else {
        alert("Selecciona un tipo de formulario");
    }
    document.getElementById("exportFileBtn").disabled = false;
}

const getTimeReport = (typeRequest, ini, end) => {
    let jsonTimeReport = {
        TypeR: typeRequest,
        Ini: ini,
        End: end
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaSolicitudTiempo/GetTimeReport",
        'type': 'POST',
        'dataType': 'json',
        'data': jsonTimeReport,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (response) {
            cargarTableCyc(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

const getManagementTimeReport = (idArea, typeRequest, ini, end) => {
    let jsonTimeReport = {
        IdArea: idArea,
        TypeR: typeRequest,
        Ini: ini,
        End: end
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaSolicitudTiempo/GetManagementTimeReport",
        'type': 'POST',
        'dataType': 'json',
        'data': jsonTimeReport,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (response) {
            cargarTableCyc(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

const cargarTableCyc = (solicitudesList) => {
    auxListSolicitud = solicitudesList;
    let dataTableCyc = [];
    for (let i = 0; i < solicitudesList.length; i++) {
        let auxList = [];
        auxList.push(solicitudesList[i].businessName);
        auxList.push(solicitudesList[i].zone);
        auxList.push(dateTimeFilter(solicitudesList[i].total));
        auxList.push(dateTimeFilter(solicitudesList[i].seller));
        auxList.push(dateTimeFilter(solicitudesList[i].revision + solicitudesList[i].references + solicitudesList[i].authorization));
        if (document.getElementById("userR").value != "GERENTEVENTA") {
            auxList.push(dateTimeFilter(solicitudesList[i].revision));
            auxList.push(dateTimeFilter(solicitudesList[i].references));
            auxList.push(dateTimeFilter(solicitudesList[i].authorization));
            auxList.push(dateFilter(solicitudesList[i].date));
        } else {
            auxList.push(dateFilter(solicitudesList[i].dateAltaIntelisis));
            auxList.push(dateFilter(solicitudesList[i].datePCompra));
            auxList.push(solicitudesList[i].importePCompra == null ? "" : "$" + solicitudesList[i].importePCompra);
        }
        auxList.push(solicitudesList[i].status);
        if (solicitudesList[i].status == "Rechazada")
            auxList.push(`<button class="btn btn-danger btn-circle float-right" onclick="showInfo(` + i + `)"><i class="fas fa-times"></i></button>`);
        else
            auxList.push(`<button class="btn btn-success btn-circle float-right" onclick="showInfo(` + i + `)"><i class="fas fa-check"></i></button>`);


        dataTableCyc.push(auxList);
    }
    $('#cargaModal').modal('hide');
    $("#tableCyc").dataTable().fnClearTable();
    $("#tableCyc").dataTable().fnDraw();
    $("#tableCyc").dataTable().fnDestroy();
    // console.log(dataTableCyc);
    $("#tableCyc").DataTable({
        "data": dataTableCyc,
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
}

const dateTimeFilter = (time) => {
    // set minutes to seconds
    let seconds = time * 60
    // calculate (and subtract) whole days
    let days = Math.floor(seconds / 86400);
    seconds -= days * 86400;
    // calculate (and subtract) whole hours
    let hours = Math.floor(seconds / 3600) % 24;
    seconds -= hours * 3600;
    // calculate (and subtract) whole minutes
    let minutes = Math.floor(seconds / 60) % 60;
    let d = days > 0 ? days + 'd ' : '';
    let h = hours > 0 ? hours + 'h ' : '';
    let m = minutes > 0 ? minutes + 'm ' : '';
    let result = d + h + m;
    return result == '' ? '-' : result;
}

const dateTimeFilterDay = (time) => {    
    let seconds = time * 60
    return  Math.floor(seconds / 86400);
}


const dateTimeFilterHours = (time) => {
    let seconds = time * 60
    let days = Math.floor(seconds / 86400);
    seconds -= days * 86400;
    let hours = Math.floor(seconds / 3600) % 24;
    return hours;
}


const dateFilter = (date) => {
    if (date != null) {
        let dateIF = date.split('T').map(s => s.trim());
        let aux1 = dateIF[0].split('-').map(s => s.trim());
        let aux2 = dateIF[1].split(':').map(s => s.trim());
        return aux1[2] + "/" + aux1[1] + "/" + aux1[0] + " " + timeFilter(aux2);
    }
    else {
        return "";
    }
}

const timeFilter = (time) => {
    let one = time[0] > 12 ? time[0] - 12 : time[0];
    let ls = time[0] > 12 ? " pm" : " am";
    return one + ":" + time[1] + ":" + time[2].split('.').map(s => s.trim())[0] + ls;
}

const showInfo = (item) => {
    let historyList = "";
    if (document.getElementById("userR").value == "GERENTEVENTA") {
        if (auxListSolicitud[item].noC != null) {
            historyList += `<div class="row mb-3">
                                <div class="col-md-6 text-bold">No. Cliente</div>
                                <div class="col-md-6">` + auxListSolicitud[item].noC + `</div>
                            </div>`;
        } else
            historyList += `<div class="row mb-3"><div class="col-md-12 text-bold">No hay info</div></div>`;
    } else {
        if (auxListSolicitud[item].gerencia != null) {
            historyList += `<div class="row mb-3">
                                    <div class="col-md-6 text-bold">Gerencia</div>
                                    <div class="col-md-6">` + auxListSolicitud[item].gerencia + `</div>
                                </div>`;
        } else
            historyList += `<div class="row mb-3"><div class="col-md-12 text-bold">No hay info</div></div>`;
    }
    document.getElementById("infoClienteList").innerHTML = historyList;
    $('#infoClienteModal').modal('show');
}

const exportTableToExcel = () => {
    if (auxListSolicitud.length > 0) {
        let arrayRows = [];
        arrayRows.push([
            'Razón Social',
            'Zona',
            'Total',
            'Vendedor',
            'Revisión',
            'Referencias',
            'Autorización',
            'CyC',
            'D',
            'H',
            'Fecha de registro',
            'Status'
        ]);

        auxListSolicitud.forEach(x => {
            let totalCYC = x.revision + x.references + x.authorization;

            let data = [
                x.businessName.replaceAll(',', ' '),
                x.zone,
                dateTimeFilter(x.total),
                dateTimeFilter(x.seller),
                dateTimeFilter(x.revision),
                dateTimeFilter(x.references),
                dateTimeFilter(x.authorization),
                dateTimeFilter(totalCYC),
                dateTimeFilterDay(totalCYC),
                dateTimeFilterHours(totalCYC),
                dateFilter(x.date),
                x.status
            ];
            arrayRows.push(data);
        });

        let auxRows = "";

        arrayRows.forEach(x => {
            x.forEach(y => { auxRows += y + ',' });
            auxRows += "\r\n";
        });

        let x = document.createElement("A");
        x.setAttribute("href", 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(auxRows));
        x.setAttribute("download", "Reporte " + new Date().toISOString().split('T')[0] + '.csv');
        document.body.appendChild(x);
        x.click();
    } else
        $('#infoReport').modal('show');
}