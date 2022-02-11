let isAdmin = true;
let zonaD = '';
$(document).ready(function() {
    let user = document.getElementById("userP").value;
    let data = { User: user };

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/Indarnet/getMyZone",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(zona) {
            document.getElementById("btnSearch").disabled = false;
            if (zona.description != undefined) {
                zonaD = zona;
                document.getElementById('seeByGroup').classList.add('d-none');
                document.getElementById('showByGroup').classList.add('d-none');
            } else {
                document.getElementById('seeByGroup').classList.remove('d-none');
                document.getElementById('showByGroup').classList.remove('d-none');
                $('#showStatusRadio').prop('checked', true);
                $('#generalRadio').prop('checked', true);
            }
        },
        error: function(error) {
            console.log(error + "Error");
            console.log("No tiene zona");
        }
    });
})

function seeBySol() {
    let activoFijo = $('input[name="seeBy"]:checked').val();
    $('#showStatusRadio').prop('checked', true);
    if (activoFijo != "general") {
        document.getElementById('gerenciaGroup').classList.remove('d-none');
        document.getElementById('showGerRadioD').innerHTML = `<input type="radio" name="showBy" value="false">Por Empleado`;
    } else {
        document.getElementById('showGerRadioD').innerHTML = `<input type="radio" name="showBy" value="false">Por Gerencia`;
        document.getElementById('gerenciaGroup').classList.add('d-none');
    }



}

function search() {
    let zona = zonaD.description;
    var fecha = $('#reservation').daterangepicker()[0].value;
    var dateIF = fecha.split('-').map(s => s.trim());
    var typeR = document.getElementById("typeForms").value;
    if (typeR == "SELECCIONAR") {
        $('#infoReport').modal('show');
        document.getElementById("infoModalR").innerHTML = "Verifica el tipo de solicitud";
    } else {
        if (zona != undefined) {
            getEmployeeReport(zona, typeR, dateIF[0], dateIF[1]);
        } else {
            let seeR = $('input[name="seeBy"]:checked').val();
            let showR = $('input[name="showBy"]:checked').val();
            let idGerencia = document.getElementById("gerencias").value;
            if (seeR == "general" && showR == "true") {
                getGeneralReport(typeR, dateIF[0], dateIF[1]);
            } else if (seeR == "general" && showR == "false") {
                getGeneralReportByManagement(typeR, dateIF[0], dateIF[1]);
            } else if (seeR == "gerencia" && showR == "true") {
                if (idGerencia != "SELECCIONAR")
                    getManagementReport(idGerencia, typeR, dateIF[0], dateIF[1]);
                else {
                    $('#infoReport').modal('show');
                    document.getElementById("infoModalR").innerHTML = "Verifica la gerencia seleccionada";
                }
            } else if (seeR == "gerencia" && showR == "false") {
                if (idGerencia != "SELECCIONAR")
                    getManagementReportByEmployee(idGerencia, typeR, dateIF[0], dateIF[1]);
                else {
                    $('#infoReport').modal('show');
                    document.getElementById("infoModalR").innerHTML = "Verifica la gerencia seleccionada";
                }
            } else {
                alert("Error, verifica los datos");
            }
        }
    }
}

function getEmployeeReport(zona, typeR, ini, fin) {
    let data = { Zona: zona, TypeR: typeR, Ini: ini, Fin: fin };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaCliente/getEmployeeReport",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(report) {
            iniciarB(report);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function getGeneralReport(typeS, ini, end) {
    let data = { TypeS: typeS, Ini: ini, End: end }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaCliente/getGeneralReport",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(report) {
            iniciarB(report);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function getGeneralReportByManagement(typeS, ini, end) {
    let data = { TypeS: typeS, Ini: ini, End: end }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaCliente/getGeneralReportByManagement",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(report) {
            graficaSol(report);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });

}

function getManagementReport(idGerencia, typeS, ini, end) {
    let data = { IdGerencia: idGerencia, TypeS: typeS, Ini: ini, End: end }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaCliente/getManagementReport",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(report) {
            iniciarB(report);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function getManagementReportByEmployee(idGerencia, typeS, ini, end) {
    let data = { IdGerencia: idGerencia, TypeS: typeS, Ini: ini, End: end }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/EstadisticaCliente/getManagementReportByEmployee",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(report) {
            graficaSol(report);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function iniciarB(report) {
    if (report.length != 0) {

        // donutChartCanvas.destroy();
        document.getElementById("donutShow").style.display = 'block';
        document.getElementById("barCharShow").style.display = 'none';
        document.getElementById('tabla1Es').classList.remove('d-none');
        document.getElementById('tablaInfo2').classList.add('d-none');
        var acceptadas = 0;
        var rechadaza = 0;
        var pendientes = 0;
        var status1 = 0;
        var status2 = 0;
        var status3 = 0;
        var status4 = 0;
        var status5 = 0;
        var status6 = 0;
        var status7 = 0;
        var status8 = 0;
        var status9 = 0;
        var status10 = 0;
        var status11 = 0;
        var status12 = 0;

        for (let i = 0; i < report.length; i++) {
            switch (report[i].tipo) {
                case 1:
                    status1++;
                    break;
                case 2:
                    status2++;
                    break;
                case 3:
                    status3++;
                    break;
                case 4:
                    status4++;
                    break;
                case 5:
                    status5++;
                    break;
                case 6:
                    status6++;
                    break;
                case 7:
                    status7++;
                    break;
                case 8:
                    status8++;
                    break;
                case 9:
                    status9++;
                    break;
                case 10:
                    status10++;
                    break;
                case 11:
                    status11++;
                    break;
                case 12:
                    status12++;
                    break;
                default:
                    console.log("Error en tipo" + report[i]);
                    break;
            }
        }

        document.getElementById("status1").innerHTML = status1 != 0 ? status1 : "-";
        document.getElementById("status2").innerHTML = status2 != 0 ? status2 : "-";
        document.getElementById("status3").innerHTML = status3 != 0 ? status3 : "-";
        document.getElementById("status4").innerHTML = status4 != 0 ? status4 : "-";
        document.getElementById("status5").innerHTML = status5 != 0 ? status5 : "-";
        document.getElementById("status6").innerHTML = status6 != 0 ? status6 : "-";
        document.getElementById("status7").innerHTML = status7 != 0 ? status7 : "-";
        document.getElementById("status8").innerHTML = status8 != 0 ? status8 : "-";
        document.getElementById("status10").innerHTML = status10 != 0 ? status10 : "-";
        document.getElementById("status11").innerHTML = status11 != 0 ? status11 : "-";
        document.getElementById("status12").innerHTML = status12 != 0 ? status12 : "-";

        pendientes = status1 + status2 + status3 + status5 + status9 + status11 + status12;
        rechadaza = status7 + status8;
        acceptadas = status4 + status6;

        var info = [];
        info.push(pendientes);
        info.push(acceptadas);
        info.push(rechadaza);


        // var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutChartCanvas = document.getElementById("donutChart").getContext("2d");
        console.log(donutChartCanvas);
        var donutData = {
            labels: [
                'Pendientes',
                'Aceptadas',
                'Rechazadas'
            ],
            datasets: [{
                data: info,
                backgroundColor: ['#FFC61E', '#002868', '#ff0000'],
            }]
        }
        var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        });
    } else {
        $('#infoReport').modal('show');
        document.getElementById("infoModalR").innerHTML = "No se encontraron resultados";
        document.getElementById('tabla1Es').classList.add('d-none');

    }
}

function graficaSol(report) {
    var table = document.getElementById('infoSolTab');
    document.getElementById('tablaInfo2').classList.remove('d-none');
    if (table.rows.length > 1) {
        for (var i = table.rows.length - 1; i >= 1; i--) {
            table.deleteRow(i);
        }
    }

    if (report.length > 0) {

        var aceptadasList = [];
        var rechazadasList = [];
        var pendientesList = [];
        var labelList = [];
        for (let i = 0; i < report.length; i++) {
            var acceptadas = 0;
            var rechadaza = 0;
            var pendientes = 0;
            var status1 = 0;
            var status2 = 0;
            var status3 = 0;
            var status4 = 0;
            var status5 = 0;
            var status6 = 0;
            var status7 = 0;
            var status8 = 0;
            var status9 = 0;
            var status10 = 0;
            var status11 = 0;
            var status12 = 0;
            for (let j = 0; j < report[i].requests.length; j++) {
                switch (report[i].requests[j].tipo) {
                    case 1:
                        status1++;
                        break;
                    case 2:
                        status2++;
                        break;
                    case 3:
                        status3++;
                        break;
                    case 4:
                        status4++;
                        break;
                    case 5:
                        status5++;
                        break;
                    case 6:
                        status6++;
                        break;
                    case 7:
                        status7++;
                        break;
                    case 8:
                        status8++;
                        break;
                    case 9:
                        status9++;
                        break;
                    case 10:
                        status10++;
                        break;
                    case 11:
                        status11++;
                        break;
                    case 12:
                        status12++;
                        break;
                    default:
                        console.log("Error en tipo" + report[i]);
                        break;
                }
            }

            pendientes = status1 + status2 + status3 + status5 + status9 + status11 + status12;
            rechadaza = status7 + status8;
            acceptadas = status4 + status6;

            labelList.push(report[i].name);
            pendientesList.push(pendientes);
            aceptadasList.push(acceptadas);
            rechazadasList.push(rechadaza);


            var table = document.getElementById('infoSolTab');
            var row = table.insertRow(table.rows.length);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);
            var cell9 = row.insertCell(8);
            var cell10 = row.insertCell(9);
            var cell11 = row.insertCell(10);
            var cell12 = row.insertCell(11);
            var cell13 = row.insertCell(12);
            var cell14 = row.insertCell(13);

            cell1.innerHTML = report[i].name;
            cell1.classList.add('bg-indarYellow');
            cell2.innerHTML = report[i].requests.length;
            cell2.classList.add('bg-info');
            cell3.innerHTML = status1;
            cell4.innerHTML = status2;
            cell5.innerHTML = status3;
            cell6.innerHTML = status4;
            cell6.classList.add('bg-success');
            cell7.innerHTML = status5;
            cell8.innerHTML = status6;
            cell8.classList.add('bg-success');
            cell9.innerHTML = status7;
            cell9.classList.add('bg-danger');
            cell10.innerHTML = status8;
            cell10.classList.add('bg-danger');
            cell11.innerHTML = status9;
            cell12.innerHTML = status10;
            cell13.innerHTML = status11;
            cell14.innerHTML = status12;
        }

        document.getElementById("donutShow").style.display = 'none';
        document.getElementById("barCharShow").style.display = 'block';
        document.getElementById('tabla1Es').classList.add('d-none');
        document.getElementById('tablaInfo2').classList.remove('d-none');
        var areaChartData = {
            labels: labelList,
            datasets: [{
                    label: 'Aceptadas',
                    backgroundColor: 'rgba(0,40,104,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: aceptadasList
                },
                {
                    label: 'Rechazadas',
                    backgroundColor: 'rgba(255, 0, 0, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: rechazadasList
                },
                {
                    label: 'Pendientes',
                    backgroundColor: 'rgba(255, 198, 30, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: pendientesList
                },
            ]
        }



        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    } else {
        $('#infoReport').modal('show');
        document.getElementById("infoModalR").innerHTML = "No se encontraron resultados";
        document.getElementById('tablaInfo2').classList.add('d-none');
    }
}