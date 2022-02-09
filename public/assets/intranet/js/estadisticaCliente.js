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
            console.log(seeR);
            console.log(showR);
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
    console.log(zona);
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
            console.log(report);
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
            console.log(report);
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
            console.log(report);
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
            console.log(report);
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
            console.log(report);
        },
        error: function(error) {
            console.log(error + "Error");
        }
    });
}

function iniciarB(report) {
    document.getElementById("donutShow").style.display = 'block';
    document.getElementById("barCharShow").style.display = 'none';
    if (report.length != 0) {
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

        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
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
    }
}

function graficaSol(report) {
    document.getElementById("donutShow").style.display = 'none';
    document.getElementById("barCharShow").style.display = 'block';
    var areaChartData = {
        labels: ['Casa', 'CDMX', 'Centro', 'Centro Norte', 'Guadalajara', 'Jalisco', 'NorEste', 'Pacifico', 'Telefono'],
        datasets: [{
                label: 'Aceptadas',
                backgroundColor: 'rgba(0,40,104,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [28, 48, 40, 19, 86, 27, 90, 22, 12]
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
                data: [65, 59, 80, 81, 56, 55, 40, 30, 25]
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
}