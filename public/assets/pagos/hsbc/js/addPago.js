
// VARIABLES GLOBALES ENCABEZADO ---------------------------------------------------------------------------------------------------------------------------------------

var tpo_registro = "01";
var num_lote = "01".padStart(5, '0');;
var num_secuencia = "00001";
var now = new Date();
var fec_aplicacion = moment(now).format('YYYYMMDD');
var cve_bco_ord = "00021";
var ord_tpo_cta = "01";
var ord_num_cta = "4050561075".padStart(20, '0'); // NUM CUENTA HSBC INDAR --------------------------------------------------------------------------------------------
var ord_nombre = "FERRETERIA INDAR, S.A. DE C.V.".padEnd(40, ' '); // RAZON SOCIAL INDAR ------------------------------------------------------------------------------
var ord_curp_rfc = "FIN870710Q40".padEnd(18, ' '); // RFC INDAR  ------------------------------------------------------------------------------------------------------
var cve_proceso = "00003"
var cve_producto = "00002"; 
var cod_instruccion = "01";
var cod_moneda = "01";
var leyenda_cargo = "".padEnd(40, ' ');
var num_movtos = 0; //ANTES DE GENERAR ARCHIVO HACER padStart(5, '0');
var imp_total = 0;
var cve_canal = "BUZONES ";
var cod_rechazo = "00000";
var des_rechazo = "".padEnd(50, ' ');
var tp_code = "FERREINDARSIP1".padEnd(15, ' ');
var uso_futuro = "".padEnd(391, ' ');


var pagos = [];




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

function downloadFile(){
    console.log(fec_aplicacion);
    var encabezado = '';
    if (validarCampos()){
        // si todo está correcto, aquí se debe de insertar el encabezado en la base de datos para que me retornen el número de lote que debe de llevar el detalle
        encabezado += tpo_registro;
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

    if (document.getElementById('ref_servicio_emisor').value == '') {
        save = false;
        document.getElementById('ref_servicio_emisor').classList.add('invalid-input');
        bodyValidations += '<h5>Ordenante: Ingresa Leyenda</h5>';
    }
    else {
        document.getElementById('ref_servicio_emisor').classList.remove('invalid-input');
        document.getElementById('ref_servicio_emisor').classList.add('valid-input');
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

    if (!save) {
        document.getElementById('bodyValidations').innerHTML = bodyValidations;
        var modal = document.getElementById('validateModal');
        modal.style.opacity = 1;
        modal.style.zIndex = 1000;
        modal.classList.add("active-modal");
    }
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