$('document').ready(function () {
    document.getElementById('respuestaFile').onchange = function () {

        var files = this.files;
        console.log(files);

        var x = 0;
        while (x < files.length) {
            var reader = new FileReader();
            reader.onload = function (progressEvent) {
                // By lines
                var lines = this.result.split('\n');
                var cadenaRespuesta = '';
                for (var line = 0; line < lines.length - 1; line++) {
                    if (line == 0) {
                        console.log('-------------------------------- Encabezado ----------------------------------');
                        var codRechazo = lines[line].substring(189, 194);
                        var descRechazo = lines[line].substring(194, 244);
                        console.log('Código: ' + codRechazo);
                        console.log('Descripción: ' + descRechazo.trim());

                    }
                    else {
                        console.log('------------------------------- Transferencia ' + line + ' ----------------------------------');
                        var nombreBeneficiario = lines[line].substring(132, 171);
                        var importe = lines[line].substring(314, 329);
                        importe = [importe.slice(0, importe.length - 2), '.', importe.slice(importe.length - 2)].join('');
                        importe = Number(importe);
                        importe = (importe).toLocaleString('en-US', {
                            style: 'currency',
                            currency: 'USD',
                        });
                        var cveRastreo = lines[line].substring(560, 590);
                        var codRechazo = lines[line].substring(590, 595);
                        var descRechazo = lines[line].substring(595, 645);
                        console.log('Código: ' + codRechazo);
                        if (codRechazo != '00000') {
                            console.log('Descripción: ' + descRechazo.trim());
                        }
                        else {
                            console.log('Clave Rastreo: ' + cveRastreo.trim());
                        }
                        console.log('Beneficiario: ' + nombreBeneficiario.trim());
                        console.log('Importe: ' + importe);
                    }
                }
            };
            reader.readAsText(files[x]);
            x++;
        }
    };

});


function triggerInputFile(input) {
    document.getElementById(input + 'File').click();
}
