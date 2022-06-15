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
                var lineRespuesta = 1;
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

                        console.log('-----------------------------------------------------------------------------');
                        // MOSTRAR RESPUESTA EN PANTALLA

                        var container = document.getElementById('respuesta');
                        var row = document.createElement('div');
                        row.setAttribute('class', 'row mt-2');

                        var div1 = document.createElement('div');
                        div1.setAttribute('class', 'col-lg-4 col-md-4 col-12');
                        var beneficiario = document.createElement('h5');
                        beneficiario.innerHTML = nombreBeneficiario.trim();
                        div1.appendChild(beneficiario);

                        var div2 = document.createElement('div');
                        div2.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-right');
                        var importeh5 = document.createElement('h5');
                        importeh5.innerHTML = importe;
                        div2.appendChild(importeh5);

                        var div3 = document.createElement('div');
                        div3.setAttribute('class', 'col-lg-2 col-md-2 col-12 text-center');
                        var codigo = document.createElement('h5');
                        codigo.innerHTML = codRechazo;
                        div3.appendChild(codigo);

                        var div4 = document.createElement('div');
                        div4.setAttribute('class', 'col-lg-3 col-md-3 col-12');
                        var div5 = document.createElement('div');
                        div5.setAttribute('class', 'col-lg-1 col-md-1 col-12 text-center');
                        div5.setAttribute('style', 'display: flex; justify-content: space-between;')

                        if (codRechazo != '00000') {
                            var descripcion = document.createElement('h5');
                            descripcion.innerHTML = descRechazo.trim();
                            div4.appendChild(descripcion);

                            var check = document.createElement('img');
                            check.src = '/assets/customers/img/png/cross.png';
                            check.setAttribute('style', 'width: 20px; height: 20px;')
                        }
                        else {
                            var cveRastreoh5 = document.createElement('h5');
                            cveRastreoh5.innerHTML = cveRastreo.trim();
                            div4.appendChild(cveRastreoh5);
                            var check = document.createElement('img');
                            check.src = '/assets/customers/img/png/check.png';
                            check.setAttribute('style', 'width: 20px; height: 20px;')
                        }

                        div5.appendChild(check);

                        row.appendChild(div1);
                        row.appendChild(div2);
                        row.appendChild(div3);
                        row.appendChild(div4);
                        row.appendChild(div5);

                        container.appendChild(row);
                        lineRespuesta++;
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
