var zonasFile = '';
$(document).ready(function () {
    $('#inputZonasFile').change(function (e) {
        var fileN = e.target.files[0].name;
        toBase64(e.target.files[0]);
        $('#label-inputZonasFile').html(fileN);
    });
});

const toBase64 = (file) => {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (subtype) {
        zonasFile = reader.result.split(',')[1];
    };
    reader.onerror = function (error) {
        return "Error"
    };
}

document.getElementById("inputZonasFile").addEventListener("change", function (e) {
    document.getElementById("btnSuccesFile").style.display = "flex";
});

const updateZonesCyc = () => {
    if (zonasFile != '') {
        let zonaFile = {
            Id: 1,
            Description: zonasFile
        }
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/AsignacionZonas/UpdateZonesCyc",
            'type': 'POST',
            'dataType': 'json',
            'data': zonaFile,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function(report) {
                if (report != null) {
                    console.log(report);
                    zonasFile = '';
                    $('#label-inputZonasFile').html("Ingresar archivo ...");
                    const blob = new Blob([s2ab(atob(report.description))], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    const url = URL.createObjectURL(blob);
                    const enlace = document.createElement("a");
                    enlace.href = url;
                    enlace.download = "StatusCyc.xlsx";
                    enlace.click();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
}

const getTemplate = () => {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/AsignacionZonas/GetTemplate",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (result) {
            console.log(result);
            if (result != null) {
                console.log(result);
                const blob = new Blob([s2ab(atob(result.description))], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = URL.createObjectURL(blob);
                const enlace = document.createElement("a");
                enlace.href = url;
                enlace.download = "TemplateCyC.xlsx";
                enlace.click();
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

const s2ab = (s) => {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i != s.length; ++i) { view[i] = s.charCodeAt(i) & 0xFF; }
    return buf;
}