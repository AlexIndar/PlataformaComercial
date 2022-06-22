
// VARIABLES GLOBALES ENCABEZADO ---------------------------------------------------------------------------------------------------------------------------------------
var num_lote = '00090'; //DE PRUEBA, EN REALIDAD ES AUTOINCREMENTABLE Y LO RETORNA EL BACK
var num_secuencia = 1; //padStart(5, "0");
var now = new Date();
var fec_aplicacion = moment(now).format('YYYYMMDD');
var num_movtos = 0; //padStart(5, "0");

var tpo_registro = "01";
var cve_bco_ord = "00021";
var ord_tpo_cta = "01";
var ord_num_cta = "4050561075".padStart(20, '0');
var ord_nombre = "FERRETERIA INDAR, S.A. DE C.V.".padEnd(40, ' ');
var ord_curp_rfc = "FIN870710Q40".padEnd(18, ' ');
var cve_proceso = "00003";
var cve_producto = "00002";
var cod_instruccion = "01";
var cod_moneda = "01";
var leyenda_cargo = "".padEnd(40, ' ');
var imp_total = ""; //padStart(17, "0");
var cve_canal = "BUZONES ";
var cod_rechazo = "00000";
var des_rechazo = "".padEnd(50, ' ');
var tp_code = "FERREINDARSIP1".padEnd(15, ' ');
var uso_futuro = "".padEnd(391, ' ');


// HSBC_SPEI_detalle
var detalle = [];




function addRowNewPago(){
    num_movtos ++;
    var container = document.getElementById('pagos');

    var hr = document.createElement('hr');
    var br = document.createElement('br');
    var br2 = document.createElement('br');
    var br3 = document.createElement('br');

    var h2LeyendaPago = document.createElement('h2');
    h2LeyendaPago.setAttribute('class', 'w-100 text-center');
    h2LeyendaPago.innerText = 'Pago '+ num_movtos;

    // ------------------------------------------------------------------------------------- ROW 1 (CONCEPTO) ----------------------------------------------------------

    var row1 = document.createElement('div');
    row1.setAttribute('class', 'row text-center');

    // CONCEPTO 

    var leyendCol1Row1 = document.createElement('div');
    leyendCol1Row1.setAttribute('class', 'col-lg-2 col-md-3 col-sm-12 col-12');

    var h5Concepto = document.createElement('h5');
    h5Concepto.innerText = 'Concepto:';

    leyendCol1Row1.appendChild(h5Concepto);

    var inputCol1Row1 = document.createElement('div');
    inputCol1Row1.setAttribute('class', 'col-lg-10 col-md-9 col-sm-12 col-12');

    var inputConcepto = document.createElement('input');
    inputConcepto.setAttribute('class', 'input-promociones');
    inputConcepto.setAttribute('type', 'text');
    inputConcepto.setAttribute('id', 'leyenda_abono'+num_movtos);
    inputConcepto.setAttribute('name', 'leyenda_abono'+num_movtos);
    inputConcepto.setAttribute('maxlength', '30');
    inputConcepto.setAttribute('placeholder', 'Alfanumérico. Máximo 30 caracteres.');
    inputConcepto.setAttribute('required', '');
    inputCol1Row1.appendChild(inputConcepto);

    row1.appendChild(leyendCol1Row1);
    row1.appendChild(inputCol1Row1);

    // -------------------------------------------------------------------------------- ROW 2 (REFERENCIA E IMPORTE) ----------------------------------------------------------


    var row2 = document.createElement('div');
    row2.setAttribute('class', 'row text-center');

    // REFERENCIA

    var leyendCol1Row2 = document.createElement('div');
    leyendCol1Row2.setAttribute('class', 'col-lg-2 col-md-3 col-sm-12 col-12');

    var h5Referencia = document.createElement('h5');
    h5Referencia.innerText = 'Referencia numérica:';

    leyendCol1Row2.appendChild(h5Referencia);

    var inputCol1Row2 = document.createElement('div');
    inputCol1Row2.setAttribute('class', 'col-lg-4 col-md-3 col-12');

    var inputReferencia = document.createElement('input');
    inputReferencia.setAttribute('class', 'input-promociones');
    inputReferencia.setAttribute('type', 'text');
    inputReferencia.setAttribute('id', 'ref_numerica'+num_movtos);
    inputReferencia.setAttribute('name', 'ref_numerica'+num_movtos);
    inputReferencia.setAttribute('maxlength', '7');
    inputReferencia.setAttribute('placeholder', '0000000');
    inputReferencia.setAttribute('required', '');
    inputCol1Row2.appendChild(inputReferencia);

    // IMPORTE

    var leyendCol2Row2 = document.createElement('div');
    leyendCol2Row2.setAttribute('class', 'col-lg-2 col-md-3 col-sm-12 col-12');

    var h5Importe = document.createElement('h5');
    h5Importe.innerText = 'Importe:';

    leyendCol2Row2.appendChild(h5Importe);

    var inputCol2Row2 = document.createElement('div');
    inputCol2Row2.setAttribute('class', 'col-lg-4 col-md-3 col-12');

    var inputImporte = document.createElement('input');
    inputImporte.setAttribute('class', 'input-promociones');
    inputImporte.setAttribute('type', 'text');
    inputImporte.setAttribute('id', 'importe_orden'+num_movtos);
    inputImporte.setAttribute('name', 'importe_orden'+num_movtos);
    inputImporte.setAttribute('maxlength', '15');
    inputImporte.setAttribute('required', '');
    inputImporte.setAttribute('onfocusout', 'formatImporte(this)');
    inputCol2Row2.appendChild(inputImporte);

    row2.appendChild(leyendCol1Row2);
    row2.appendChild(inputCol1Row2);
    row2.appendChild(leyendCol2Row2);
    row2.appendChild(inputCol2Row2);



    container.appendChild(hr);
    container.appendChild(br);
    container.appendChild(h2LeyendaPago);
    container.appendChild(br2);
    container.appendChild(row1);
    container.appendChild(br3);
    container.appendChild(row2);

    document.getElementById('btn-download').removeAttribute('disabled');

}

function formatImporte(input){
    if(input.value == '' || input.value == null || input.value == undefined){
        input.value = parseFloat('0.00');
    }
    else{
        const value = input.value.replace(/,/g, '');
        input.value = parseFloat(value).toLocaleString('en-US', {
          style: 'decimal',
          maximumFractionDigits: 2,
          minimumFractionDigits: 2
        });
    }   
}

function generateFile(){
    console.log(fec_aplicacion);
    var encabezado = '';
    var fileText = '';
    if (validarCampos()){
        generaEncabezado(num_secuencia);
        // si todo está correcto, aquí !!! se debe de cambiar el número de lote por el que retornen del back
        encabezado += tpo_registro+''+num_lote+''+num_secuencia.toString().padStart(5, "0")+''+fec_aplicacion+''+cve_bco_ord+''+ord_tpo_cta+''+ord_num_cta+''+ord_nombre+''+ord_curp_rfc+''+cve_proceso+''+cve_producto+''+cod_instruccion+''+cod_moneda+''+leyenda_cargo+''+num_movtos.toString().padStart(5, "0")+''+imp_total.toString().padStart(17, "0")+''+cve_canal+''+cod_rechazo+''+des_rechazo+''+tp_code+''+uso_futuro+'|';
        fileText += encabezado;
        num_secuencia ++;
        for(var x=0; x < num_movtos; x++){
            obtenerPago(num_secuencia);
            num_secuencia ++ ;
        }
        for(var x=0; x < detalle.length; x++){
            var detalleLine = '';
            // si todo está correcto, aquí !!! se debe de cambiar el número de lote por el que retornen del back
            detalleLine += detalle[x]['tpo_registro'] + detalle[x]['num_lote'].toString().padStart(5, '0') + detalle[x]['num_secuencia'] + detalle[x]['fec_aplicacion'] + detalle[x]['cve_bco_ord'] + detalle[x]['ord_tpo_cta'] + detalle[x]['ord_num_cta'] + detalle[x]['ord_nombre'] + detalle[x]['ord_curp_rfc'] + detalle[x]['cve_bco_ben'] + detalle[x]['ben_tpo_cta'] + detalle[x]['ben_num_cta'] + detalle[x]['ben_nombre'] + detalle[x]['ben_curp_rfc'] + detalle[x]['vos_tpo_cta'] + detalle[x]['vos_num_cta'] + detalle[x]['vos_nombre'] + detalle[x]['vos_curp_rfc'] + detalle[x]['cod_movto'] + detalle[x]['tpo_pago'] + detalle[x]['leyenda_abono'] + detalle[x]['importe_orden'] + detalle[x]['importe_iva'] + detalle[x]['ref_numerica'] + detalle[x]['ref_cobranza'] + detalle[x]['cve_pago'] + detalle[x]['tpo_operacion'] + detalle[x]['ref_unica_cliente'] + detalle[x]['ref_servicio_emisor'] + detalle[x]['nom_titular_servicio'] + detalle[x]['fec_expiracion'] + detalle[x]['cod_status'] + detalle[x]['cod_usuario'] + detalle[x]['num_serial'] + detalle[x]['num_folio'] + detalle[x]['cod_servicio'] + detalle[x]['uso_futuro'] + detalle[x]['cve_rastreo'] + detalle[x]['cod_rechazo'] + detalle[x]['des_rechazo'] + detalle[x]['uso_futuro_resp'];
            fileText += "\n"+detalleLine;
        }

        console.log(detalle);

        downloadFile('MXFERREINDARSIP-'+fec_aplicacion+'-'+num_lote+'.txt', fileText);
    }
}

function validarCampos(){
    var bodyValidations = '';
    var save = true;

    // VALIDACIÓN ENCABEZADO (DATOS ORDENANTE)

    if (document.getElementById('ord_nombre').value == '') {
        save = false;
        document.getElementById('ord_nombre').classList.add('invalid-input');
        bodyValidations += '<h5>Ordenante: Ingresa Razón Social</h5>';
    }
    else {
        document.getElementById('ord_nombre').classList.remove('invalid-input');
        document.getElementById('ord_nombre').classList.add('valid-input');
    }

    if (document.getElementById('ord_num_cta').value == '') {
        save = false;
        document.getElementById('ord_num_cta').classList.add('invalid-input');
        bodyValidations += '<h5>Ordenante: Ingresa Número de Cuenta</h5>';
    }
    else {
        document.getElementById('ord_num_cta').classList.remove('invalid-input');
        document.getElementById('ord_num_cta').classList.add('valid-input');
    }

    if (document.getElementById('ord_curp_rfc').value == '') {
        save = false;
        document.getElementById('ord_curp_rfc').classList.add('invalid-input');
        bodyValidations += '<h5>Ordenante: Ingresa RFC</h5>';
    }
    else {
        document.getElementById('ord_curp_rfc').classList.remove('invalid-input');
        document.getElementById('ord_curp_rfc').classList.add('valid-input');
    }

    // VALIDACIÓN DETALLE (BENEFICIARIO)


    if (document.getElementById('ben_nombre').value == '') {
        save = false;
        document.getElementById('ben_nombre').classList.add('invalid-input');
        bodyValidations += '<h5>Beneficiario: Ingresa Razón Social</h5>';
    }
    else {
        document.getElementById('ben_nombre').classList.remove('invalid-input');
        document.getElementById('ben_nombre').classList.add('valid-input');
    }

    if (document.getElementById('ben_num_cta').value == '') {
        save = false;
        document.getElementById('ben_num_cta').classList.add('invalid-input');
        bodyValidations += '<h5>Beneficiario: Ingresa Número de Cuenta</h5>';
    }
    else {
        document.getElementById('ben_num_cta').classList.remove('invalid-input');
        document.getElementById('ben_num_cta').classList.add('valid-input');
    }

    for(var x = 1; x <= num_movtos; x++){
        if (document.getElementById('leyenda_abono'+x).value == '') {
            save = false;
            document.getElementById('leyenda_abono'+x).classList.add('invalid-input');
            bodyValidations += '<h5>Pago '+x+': Ingresa Concepto</h5>';
        }
        else {
            document.getElementById('leyenda_abono'+x).classList.remove('invalid-input');
            document.getElementById('leyenda_abono'+x).classList.add('valid-input');
        }

        if (document.getElementById('ref_numerica'+x).value == '') {
            save = false;
            document.getElementById('ref_numerica'+x).classList.add('invalid-input');
            bodyValidations += '<h5>Pago '+x+': Ingresa Referencia Numérica</h5>';
        }
        else {
            document.getElementById('ref_numerica'+x).classList.remove('invalid-input');
            document.getElementById('ref_numerica'+x).classList.add('valid-input');
        }

        if (document.getElementById('importe_orden'+x).value == '') {
            save = false;
            document.getElementById('importe_orden'+x).classList.add('invalid-input');
            bodyValidations += '<h5>Pago '+x+': Ingresa Referencia Numérica</h5>';
        }
        else {
            document.getElementById('importe_orden'+x).classList.remove('invalid-input');
            document.getElementById('importe_orden'+x).classList.add('valid-input');
        }
    }

    // ACTIVAR MODAL SI HAY CAMPOS POR VALIDAR

    // if (!save) {
    //     document.getElementById('bodyValidations').innerHTML = bodyValidations;
    //     var modal = document.getElementById('validateModal');
    //     modal.style.opacity = 1;
    //     modal.style.zIndex = 1000;
    //     modal.classList.add("active-modal");
    //     return false;
    // }
    return true;
}

function closeModal(){
    var activeModal = document.getElementsByClassName("active-modal");
    if (activeModal.length > 1)
        activeModal = activeModal[1];
    else
        activeModal = activeModal[0];
    activeModal.style.opacity = 0;
    activeModal.style.zIndex = -1000;
    activeModal.classList.remove("active-modal");
}


function generaEncabezado(num_secuencia){

    var importeTotal = 0;

    for(var x=1; x <= num_movtos; x++){
        var importe = document.getElementById('importe_orden'+x).value;
        importe = importe.replace(',', ''); //quitar coma del importe
        importe = importe.replace('.', ''); //quitar punto del importe
        importeTotal += parseInt(importe);
    }

    var jsonEncabezado = {
        tpo_registro: tpo_registro,
        num_secuencia: num_secuencia.toString().padStart(5, "0"),
        fec_aplicacion: fec_aplicacion,
        cve_bco_ord: cve_bco_ord,
        ord_tpo_cta: ord_tpo_cta,
        ord_num_cta: ord_num_cta,
        ord_nombre: ord_nombre,
        ord_curp_rfc: ord_curp_rfc,
        cve_proceso: cve_proceso,
        cve_producto: cve_producto,
        cod_instruccion: cod_instruccion,
        cod_moneda: cod_moneda,
        leyenda_cargo: leyenda_cargo,
        num_movtos: num_movtos.toString().padStart(5, "0"),
        imp_total: importeTotal.toString().padStart(17, '0'),
        cve_canal: cve_canal,
        cod_rechazo: cod_rechazo,
        des_rechazo: des_rechazo,
        tp_code: tp_code,
        uso_futuro: uso_futuro
    };

    imp_total = importeTotal;

    console.log(jsonEncabezado);
}

function obtenerPago(num_secuencia){

    console.log('Generar linea de pago '+num_secuencia);

    var num_abono = num_secuencia - 1;
    var importe = document.getElementById('importe_orden'+num_abono).value;
    importe = importe.replace(',', ''); //quitar coma del importe
    importe = importe.replace('.', ''); //quitar punto del importe

    var jsonDetalle = {
        num_lote: '00090', //cambiar después de que se inserte el encabezado
        tpo_registro: "02",
        num_secuencia: num_secuencia.toString().padStart(5, '0'),
        fec_aplicacion: fec_aplicacion,
        cve_bco_ord: cve_bco_ord,
        ord_tpo_cta: ord_tpo_cta,
        ord_num_cta: ord_num_cta,
        ord_nombre: ord_nombre,
        ord_curp_rfc: ord_curp_rfc,
        cve_bco_ben: $('#cve_bco_ben option:selected').val().padStart(5, '0'),
        ben_tpo_cta: $('#ben_tpo_cta option:selected').val(),
        ben_num_cta: document.getElementById('ben_num_cta').value.padStart(20, '0'),
        ben_nombre: document.getElementById('ben_nombre').value.padEnd(40, ' '),
        ben_curp_rfc: "".padEnd(18, ' '),
        vos_tpo_cta: "00",
        vos_num_cta: "".padStart(20, '0'),
        vos_nombre: "".padEnd(40, ' '),
        vos_curp_rfc: "".padEnd(18, ' '),
        cod_movto: "01",
        tpo_pago: $('#cve_bco_ben option:selected').text() == 'HSBC' ? "00" : "01", //00 CUENTAS HSBC 01 OTROS BANCOS
        leyenda_abono: document.getElementById('leyenda_abono'+num_abono).value.padEnd(40, ' '),
        importe_orden: importe.padStart(15, '0'),
        importe_iva: "".padStart(15, '0'),
        ref_numerica: document.getElementById('ref_numerica'+num_abono).value.padStart(7, '0'),
        ref_cobranza: "".padEnd(40, ' '), 
        cve_pago: "".padEnd(10, ' '),
        tpo_operacion: "00",
        ref_unica_cliente: document.getElementById('leyenda_abono'+num_abono).value.padEnd(30, ' '),
        ref_servicio_emisor: document.getElementById('leyenda_abono'+num_abono).value.padEnd(40, ' '),
        nom_titular_servicio:  "".padEnd(40, ' '),
        fec_expiracion: "00000000",
        cod_status: "00",
        cod_usuario: "".padEnd(8, ' '),
        num_serial: "".padStart(10, '0'),
        num_folio: "".padStart(7, '0'),
        cod_servicio: "00",
        uso_futuro: "".padEnd(10, ' '),
        cve_rastreo: "".padEnd(30, ' '),
        cod_rechazo: "00000",
        des_rechazo: "".padEnd(50, ' '),
        uso_futuro_resp: "".padEnd(5, ' ')
    };

    detalle.push(jsonDetalle);

    console.log(jsonDetalle);
}

function downloadFile(filename, text) {
    var element = document.createElement('a');
    console.log(filename);
    console.log(text);
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);
  
    element.style.display = 'none';
    document.body.appendChild(element);
  
    element.click();
  
    document.body.removeChild(element);
  }
  
