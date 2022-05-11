$(document).ready(function(){
    //Se inicializa validando en que vista se encuentra para ejecutar ciertas funciones
    switch(window.location.pathname)
    {
        case '/logistica/distribucion/capturaGastoFletera':
            //Se inicializan los selectores que se encuentran en la vista 
            logisticaController.initSelect2();

            $('.select2-selection').css('height','39px');
            $('.select2-selection').css('width','100%');
            //Se agrega la mascara para decimales
            $("#prontoPago").inputmask({
                alias:"decimal",
                integerDigits:3,
                digits:2,
                allowMinus:false,        
                digitsOptional: false,
                placeholder: "0.00"
            });
            break;
        case '/logistica/mesaControl/planeador':
            //Se iniciliaza la tabla 
            logisticaController.initDataTable();
            break;
    }
});
var Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    timer: 8000,
    timerProgressBar: false
});
let porcentajeGlobal = 1,contShowguia = 1,autorizadoUsuario = '';
let arraytable2 = new Array();
const logisticaController = {
    initDataTable: () => {
         $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'colvis',
                    text: "Visibilidad de columna",
                    postfixButtons: [ 'colvisRestore' ]
                }
            ],
            "paging": false
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    },
    initSelect2: ()=>{
        //Initialize Select2 Elements
        $('.select2').select2();
        $('#agregarGuiaAcreedor').select2();
        $('#agregarGuiaDepartamento').select2();
        $('#agregarGuiaDepartamento').select2();
        $('#agregarGuiaMunicipio').select2();
        $('#agregarGuiaClasificador').select2();
    },
    showGuias: () => {
        arraytable2 = new Array();
        $('#btnAgregarGuia').prop('disabled',false);
        $('#cargaXML').prop('disabled',false);
        $('#dataTable2GastoFletera').empty();
        $('#dataTableGastoFletera').empty();
        let paqueteriaID = $('#acreedor').val();
        let esOficina = $('#acreedor option:selected').data('esoficina');
        let acreedor = $('#acreedor option:selected').text();
        $('#agregarGuiaAcreedor').append('<option value="'+paqueteriaID+'" selected>'+acreedor+'</option>');
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/getGuias',
            type: 'GET',
            data: {paqueteriaID:paqueteriaID},
            datatype: 'json',
            success: function (data) { 
                if(data != []){
                    contShowguia = 1;
                    $.each( data, function( key, value ) {
                        let fecha = value['fecha'].split('T');
                        let idNumeroGuia = value['idNumeroGuia'];
                        let numeroGuia = value['numeroGuia'];
                        let importeTotal=0;
                        value['costoTotal'] == 0 ? (importeTotal = 0):(importeTotal=value['costoTotal']);
                        $('#dataTableGastoFletera').append(
                            '<tr class="text-center">'
                            +'<td><input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias(this)" data-idnumeroguia="'+idNumeroGuia+'" data-numeroguia="'+numeroGuia+'" data-importetotal="'+importeTotal+'"></td>'
                            +'<td>'+numeroGuia+'</td>'
                            +'<td>'+logisticaController.replaceNumberWithCommas(importeTotal.toFixed(2))+'</td>'
                            +'<td>'+fecha[0]+'</td>'
                            +'</tr>'
                        );
                      });
                }else{
                    contShowguia = 0;
                    $('#dataTableGastoFletera').append(
                         '<tr class="text-center">'
                        + '<td colspan="4"><strong>No se encontrar resultados</strong></td>'
                        +'</tr>'
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    },
    checkBoxSelectedListaGuias: (e) => {
        let idNumeroGuia = $(e).data('idnumeroguia');
        let numeroGuia = $(e).data('numeroguia');
        let importeTotal = $(e).data('importetotal');
        let data = {
            idNumeroGuia: idNumeroGuia,
            numeroGuia: numeroGuia,
            importeTotal: importeTotal
        };
        if( $(e).prop('checked') ) {
            $('#prontoPago').prop('disabled',false);
            logisticaController.requestGuiaSelected(data);
        }else{
            delete arraytable2[idNumeroGuia];
            logisticaController.construction();
            let contArray= 0;
            arraytable2.forEach(function(){
                contArray++;
            });
            contArray == 0 ? $('#prontoPago').prop('disabled',true) : '';

        }
    },
    requestGuiaSelected: (data) => {
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/guiaSelected',
            type: 'GET',
            data: data,
            datatype: 'json',
            success: function (data) {
                data = data[0];
                logisticaController.acomodeData(data);
                logisticaController.construction();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    },
    checkBoxSelectedListaGuias2: (e) => {
        let idNumeroGuia = $(e).data('idnumeroguia');
        if( $(e).prop('checked') ) {
            logisticaController.modificateArrayGuiasSelected(idNumeroGuia,true);
            $('#'+idNumeroGuia).css('background-color','#44f344');
        }else{
            logisticaController.modificateArrayGuiasSelected(idNumeroGuia,false);
            $('#'+idNumeroGuia).css('background-color','white');
        }
    },
    modificateArrayGuiasSelected: (idNumeroGuia,selected) => {
        arraytable2[idNumeroGuia]["selected"] = selected;
        let checkSelected = 0;
        arraytable2.forEach(function(value, key){
            if(value['selected'])
            {
                checkSelected = 1;
                return false;
            }
        });
        if($('#retencionIva').prop('checked'))
        {
            if(arraytable2[idNumeroGuia]["selected"]){
                let importe = arraytable2[idNumeroGuia]['importeSinIva'] * 1.12;
                arraytable2[idNumeroGuia]['importe'] = importe.toFixed(2);
                arraytable2[idNumeroGuia]['retencion'] = 1.12;
                logisticaController.construction();
            }else{
                let importe = arraytable2[idNumeroGuia]['importeSinIva'] * 1.16;
                arraytable2[idNumeroGuia]['importe'] = importe.toFixed(2);
                arraytable2[idNumeroGuia]['retencion'] = 1.16;
                logisticaController.construction();
            }
        }
        if(checkSelected == 0)
        {
            $('#retencionIva').prop('disabled',true);
            $('#retencionIva').prop('checked',false);
        }else{
            $('#retencionIva').prop('disabled',false);
        }
    },
    retentionIVA: (e) => {
        let prontoPago = $('#prontoPago').val();
        let porcentajeFinal = (100 -prontoPago) / 100;
        if($(e).prop('checked'))
        {
            arraytable2.forEach(function(value, key){
                if(value['selected'])
                {
                    let importe = porcentajeFinal * 1.12 * value['importeSinIva'];
                    value['importe'] = importe.toFixed(2);
                    value['retencion'] = 1.12;
                }
            });
            logisticaController.construction();
        }else{
            arraytable2.forEach(function(value, key){
                if(value['selected'])
                {
                    let importe = porcentajeFinal * 1.16 * value['importeSinIva'];
                    value['importe'] = importe.toFixed(2);
                    value['retencion'] = 1.16;
                }
            });
            logisticaController.construction();
        }
        
        
    },
    construction: () => {
        $('#dataTable2GastoFletera').empty();
        let importeTotal=0;
        let importeSinIvaTotal=0;
        arraytable2.forEach(function(values, key)
        {
            let atado = values['atado'];
            let bultos = values['bultos'];
            let cajas = values['cajas'];
            let cliente = values['cliente'];
            let comentario = values['comentario'];
            let facturas = values['facturas'];
            let idNumeroGuia = values['idNumeroGuia'];
            let importe = values['importe'];
            let importeSinIva = values['importeSinIva'];
            let metodo = values['metodo'];
            let numeroGuia = values['numeroGuia'];
            let paqueteria = values['paqueteria'];
            let pp = values['pp'];
            let retencion = values['retencion'];
            let tarima = values['tarima'];
            let checkedBox = '';
            if(values['selected'])
            {
                checkedBox = '<input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias2(this)" data-idnumeroguia="'+idNumeroGuia+'" checked>';
            }else{
                checkedBox = '<input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias2(this)" data-idnumeroguia="'+idNumeroGuia+'" false>';
            }
            $('#dataTable2GastoFletera').append(
            '<tr class="text-center" id="'+idNumeroGuia+'">'
            +'<td>'+checkedBox+'</td>'
            +'<td>'+numeroGuia+'</td>'
            +'<td>'+logisticaController.replaceNumberWithCommas(importe)+'</td>'
            +'<td>'+comentario+'</td>'
            +'<td>'+logisticaController.replaceNumberWithCommas(importeSinIva.toFixed(2))+'</td>'
            +'<td>'+retencion+'</td>'
            +'<td>'+pp+'</td>'
            +'</tr>');
            if(values['selected']){
                $('#'+idNumeroGuia).css('background-color','#44f344');
            }else{
                $('#'+idNumeroGuia).css('background-color','white');
            }
            importeTotal += parseFloat(importe);
            importeSinIvaTotal += parseFloat(importeSinIva);
        });
        if(parseFloat(importeSinIvaTotal) == parseFloat($('#importeSinIva').val())){
            $('#importeGuias').css('background-color','rgb(40 167 69)');
            $('#importeGuias').css('color','white');
            if($('#autorizado').prop('checked')){
                $('#btnRegistrarNet').prop('disabled',false);
            }else{
                $('#btnRegistrarNet').prop('disabled',true);
            }
        }else if(parseFloat(importeSinIvaTotal) > parseFloat($('#importeSinIva').val())){
            $('#importeGuias').css('background-color','rgb(229 81 81)');
            $('#importeGuias').css('color','white');
            $('#btnRegistrarNet').prop('disabled',true);
        }else if(parseFloat(importeSinIvaTotal) < parseFloat($('#importeSinIva').val())){
            $('#importeGuias').css('background-color','#e9ecef');
            $('#importeGuias').css('color','#495057');
            $('#btnRegistrarNet').prop('disabled',true);
        }
        $('#importeGuias').empty();
        $('#importeGuias').val(logisticaController.replaceNumberWithCommas(importeSinIvaTotal.toFixed(2)));
        $('#totalImporte').empty();
        $('#totalImporte').append('Total: $'+logisticaController.replaceNumberWithCommas(importeTotal.toFixed(2)));
    },
    acomodeData: (data) =>{
        let atado = data['atado'];
        let bultos = data['bultos'];
        let cajas = data['cajas'];
        let cliente = data['cliente'];
        let comentario = data['comentario'];
        let facturas = data['facturas'];
        let idNumeroGuia = data['idNumeroGuia'];
        let importeSinIva = data['importeSinIVA'];
        let metodo = data['metodo'];
        let numeroGuia = data['numeroGuia'];
        let paqueteria = data['paqueteria'];
        let pp = porcentajeGlobal;
        let retencion = data['retencion'];
        let tarima = data['tarima'];
        let importe = porcentajeGlobal * retencion * importeSinIva ;
        arraytable2[idNumeroGuia] = {
            atado:atado,
            bultos:bultos,
            cajas:cajas,
            cliente:cliente,
            comentario:comentario,
            facturas:facturas,
            idNumeroGuia:idNumeroGuia,
            importeSinIva:importeSinIva,
            metodo:metodo,
            numeroGuia:numeroGuia,
            paqueteria:paqueteria,
            pp:pp,
            retencion:retencion,
            tarima:tarima,
            importe:importe.toFixed(2),
            selected: false
        }; 
    },
    replaceNumberWithCommas: (numero) => {
        //Seperates the components of the number
        var n= numero.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    },
    formAutho: () => { 
        if($('#usuarioSAI').val() == '' || $('#contrasenaSAI').val() == '')
        {
            $('#divMessage').empty();
            $('#divMessage').removeAttr('hidden');
            $('#divMessage').append('<strong style="color:red">Ingrese los datos que se piden</strong>');
        }else{
            $('#divMessage').empty();
            $('#divMessage').attr('hidden');
            let data = {
                user: $('#usuarioSAI').val(),
                password : $('#contrasenaSAI').val()
            };
            autorizadoUsuario = data.user;
            $.ajax({
                url: '/logistica/distribucion/capturaGastoFletera/getAutorizacion',
                type: 'GET',
                data: data,
                datatype: 'json',
                success: function (data) {
                    data = data[0];
                    if(data['usuario'] == 'Usuario invalido'){
                        $('#divMessage').empty();
                        $('#divMessage').removeAttr('hidden');
                        $('#divMessage').append('<strong style="color:#dc3545">'+data['usuario']+'</strong>');
                    }else if(data['pass'] == 'Contraseña invalida')
                    {
                        $('#divMessage').empty();
                        $('#divMessage').removeAttr('hidden');
                        $('#divMessage').append('<strong style="color:#dc3545">'+data['pass']+'</strong>');
                    }else{
                        $('#divMessage').empty();
                        $('#divMessage').removeAttr('hidden');
                        $('#autorizado').prop('checked',true);
                        $('#modal-autorizacion').modal('toggle');
                        Toast.fire({
                            icon: 'success',
                            title: 'Petición para autorización: ¡Exitosa!'
                        });
                        if($('#importeGuias').val() == $('#importeSinIva').val())
                        {
                            $('#btnRegistrarNet').prop('disabled',false);
                        }
                        $('.btn-aut').prop('disabled',true);
                        $('#acreedor').prop('disabled',false);
                        $('#btnAgregarGuia').prop('disabled',false);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);     
                }
            });
        }
    },
    validateFormAddGuia: () => {
        if($('#agregarGuiaAcreedor').val() == null || $('#agregarGuiaAcreedor').val() == "")
        {
            logisticaController.formMessageAlert();
        }else if($('#agregarGuiaDepartamento').val() == null || $('#agregarGuiaAcreedor').val() == "")
        {
            logisticaController.formMessageAlert();
        }else if($('#agregarGuiaNumeroGuia').val() == null || $('#agregarGuiaNumeroGuia').val() == "")
        {
            logisticaController.formMessageAlert();
        }else if($('#agregarGuiaMunicipio').val() == null || $('#agregarGuiaMunicipio').val() == "")
        {
            logisticaController.formMessageAlert();
        }else if($('#agregarGuiaImporte').val() == null || $('#agregarGuiaImporte').val() == "")
        {
            logisticaController.formMessageAlert();
        }else if($('#agregarGuiaClasificador').val() == null || $('#agregarGuiaClasificador').val() == "")
        {
            logisticaController.formMessageAlert();
        }else{
            $('#divMessageFormAddGuia').empty();
            logisticaController.addGuia();
        }
    },
    addGuia: () => {
        let inputMunicipio = $('#agregarGuiaMunicipio').val();
        let municipio = inputMunicipio.split('-')[0];
        let estado = inputMunicipio.split('-')[1];
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookie = decodedCookie.split(';')[3];
        let usuario = cookie.split('=')[1];
        let dato = {
            numguia: $('#agregarGuiaNumeroGuia').val(),
            importe: $('#agregarGuiaImporte').val(),
            vendor: $('#agregarGuiaDepartamento').val(),
            department: $('#agregarGuiaDepartamento').val(),
            municipio: municipio,
            estado: estado,
            clasificador: $('#agregarGuiaClasificador').val(),
            paqueteriaID: $('#agregarGuiaAcreedor').val(),
            usuario: usuario
        };
        logisticaController.token();
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/registroGuia',
            type: 'POST',
            data: dato,
            datatype: 'json',
            ResponseType: 'json',
            success: function (data,status) {
                data = data[0];
                if(status=='success')
                {
                    if(data == "Registro Exitoso")
                    {
                        $('#modal-agregar-guia').modal('toggle');
                        Toast.fire({
                            animation: true,
                            icon: 'success',
                            title: 'Creación de guia valido : ¡Registro exitoso!'
                        });
                        logisticaController.requestGetGuia(dato['numguia']);
                    }else if(data = "Ya existe la guia")
                    {
                        Toast.fire({
                            animation: true,
                            icon: 'error',
                            title: 'Creación de guia invalido : ¡Ya existe la guia!'
                        });
                    }
                }else{
                    Toast.fire({
                        animation: true,
                        icon: 'error',
                        title: 'Creación de guia invalido : ¡Internal Error Server!'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR,textStatus,errorThrown);     
            }
        });
    },
    requestGetGuia: (numeroGuia) => {
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/getGuia',
            type: 'GET',
            data: {numeroGuia:numeroGuia},
            datatype: 'json',
            success: function (data) {
                data = data[0];
                let importeTotal = data['importeTotal'];
                let fecha = data['fecha'];
                contShowguia == 0 ?  $('#dataTableGastoFletera').empty() : '';
                $('#dataTableGastoFletera').append(
                    '<tr class="text-center">'
                    +'<td><input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias(this)" data-idnumeroguia="'+data['idNumeroGuia']+'" data-numeroguia="'+data['numeroGuia']+'" data-importetotal="'+data['importeTotal']+'" checked></td>'
                    +'<td>'+data['numeroGuia']+'</td>'
                    +'<td>'+logisticaController.replaceNumberWithCommas(importeTotal.toFixed(2))+'</td>'
                    +'<td>'+fecha.split('T')[0]+'</td>'
                    +'</tr>'
                );
                let dato = {
                    idNumeroGuia: data['idNumeroGuia'],
                    numeroGuia: data['numeroGuia'],
                    importeTotal: importeTotal
                };
                $('#prontoPago').prop('disabled',false);
                logisticaController.requestGuiaSelected(dato);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    },
    token:() =>{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },
    formMessageAlert: () => {
        $('#divMessageFormAddGuia').empty();
        $('#divMessageFormAddGuia').removeAttr('hidden');
        $('#divMessageFormAddGuia').append('<strong style="color:#dc3545">Ingrese los campos que se piden</strong>');
    },
    pagoPronto: () => {
        let prontoPago = $('#prontoPago').val();
        prontoPago > 100 ? ($('#prontoPago').val(100.00), logisticaController.setValImport(100)) :(logisticaController.setValImport(prontoPago));
    },
    setValImport: (porcentaje) => {
        porcentajeGlobal = (100 -porcentaje) / 100;
        arraytable2.forEach(function(value, key){
            if(value['selected'])
            {
                let importe = porcentajeGlobal * 1.12 * value['importeSinIva'];
                value['importe'] = importe.toFixed(2);
                value['pp'] = porcentajeGlobal;
            }else{
                let importe = porcentajeGlobal * 1.16 * value['importeSinIva'];
                value['importe'] = importe.toFixed(2);
                value['pp'] = porcentajeGlobal;
            }
        });
        logisticaController.construction();
    },
    showModalAddGuia: () => {
        $('#modal-agregar-guia').modal('show');
        $("#agregarGuiaImporte").inputmask({
            alias: 'currency',
            prefix: '',
            radixPoint: '.',
            groupSeparator: ',',
            autoGroup: true,
            placeholder: '0.00'
        });
        logisticaController.cleanFormAddGuia();
    },
    cleanFormAddGuia: () => {
        $('#agregarGuiaDepartamento').val('').trigger("change");
        $('#agregarGuiaMunicipio').val('').trigger("change");
        $('#agregarGuiaClasificador').val('').trigger("change");
        $('#agregarGuiaNumeroGuia').val('');
        $('#agregarGuiaImporte').val('');
    },
    readFileXML: () => {
        $('formXML').submit();
        let token = $('#token').val();
        var formData = new FormData();
        formData.append("file", $("#cargaXML")[0].files[0]);
        logisticaController.token();
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/readFileXML',
            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            type: 'POST',
            success: function (data) {
                $('#uuid').val(data['uuid'][0]);
                $('#numFactura').val(data['numFactura'][0]);
                $('#importeSinIva').val(data['subTotal'][0]);
                $('#importeTotal').val(data['total'][0]);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR,textStatus, errorThrown);     
            }
        });
    },
    registerNet: () => {
        let arrayFinalGuias = new Array();
        arraytable2.forEach(element => {
            let dataArray = {
              'atados'       :  element['atado'],
              'bultos'       :  element['bultos'],
              'cajas'        :  element['cajas'],
              'cliente'      :  element['cliente'],
              'cliente'      :  element['comnetario'],
              'facturas'     :  element['facturas'],
              'idNumeroGuia' :  element['idNumeroGuia'],
              'importe'      :  element['importe'],
              'importeSinIva':  element['importeSinIva'],
              'metodo'       :  element['metodo'],
              'numeroGuia'   :  element['numeroGuia'],
              'paqueteria'   :  element['paqueteria'],
              'pp'           :  element['pp'],
              'retencion'    :  element['retencion'],
              'selected'     :  element['selected'],
              'tarima'       :  element['tarima']
            };
            arrayFinalGuias.push(
                dataArray
            );
        });
        let data = {
            'checkRetencion': $('#retencionIva').prop('checked'),
            'idVendor': $('#acreedor').val(),
            'importeFactura': $('#importeTotal').val(),
            'numFactura' : $('#numFactura').val(),
            'uuid': $('#uuid').val(),
            'vendor': $('#acreedor option:selected').text(),
            'usuario': $('#usuario').val(),
            'autorizado': $('#autorizado').prop('checked'),
            'autorizadoUsuario' : autorizadoUsuario,
            'guias':arrayFinalGuias
        };
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/registerNet',
            type: 'POST',
            data: data,
            datatype: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    }
} 