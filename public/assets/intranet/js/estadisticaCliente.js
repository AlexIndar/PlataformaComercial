function search(zona) {
    var fecha = $('#reservation').daterangepicker()[0].value;
    var aunx = fecha.split('-').map(s => s.trim());
    var typeR = document.getElementById("typeForms").value;
    if (typeR == "SELECCIONAR") {
        $('#infoReport').modal('show');
        document.getElementById("infoModalR").innerHTML = "Verifica el tipo de solicitud";
    } else {
        getEmployeeReport(zona, typeR, aunx[0], aunx[1]);
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


function iniciarB(report) {
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