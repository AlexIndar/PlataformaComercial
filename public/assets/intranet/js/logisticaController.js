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
            logisticaController.getPlaneador();
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
let arraytable2 = new Array(), arrayPlaneador = new Array();
let contArea1=0,contArea2=0,contArea3=0,contArea4=0,contArea5=0,contArea6=0,contArea7=0,contArea8=0,contArea9=0,contArea10=0,contArea11=0,contArea12=0;
const logisticaController = {
    slopesBoxes: () => {
        $.ajax({
            url: '/logistica/mesaControl/planeador/getCajasPendientes',
            type: 'GET',
            datatype: 'json',
            success: function (data) { 
                $('#content-cajas-pendientes').empty();
                $('#modal-cajas-pendientes').modal('show');
                $.each(data,function(index,val){
                    let fechaSurtido = val.fechaSurtido;
                    $('#content-cajas-pendientes').append('<tr>'
                        +'<td>'+ val.pedidoConsolidado +'</td>'
                        +'<td>'+ val.formaEnvio +'</td>'
                        +'<td>'+ val.prioridad +'</td>'
                        +'<td>'+ val.caja +'</td>'
                        +'<td>'+ val.articulo +'</td>'
                        +'<td>'+ val.cantidad +'</td>'
                        +'<td>'+ val.ubicacionOrigen +'</td>'
                        +'<td>'+ val.usuario +'</td>'
                        +'<td>'+ val.nombre +'</td>'
                        +'<td>'+ fechaSurtido.split('T')[0] +'</td>'
                        +'<td>'+ val.tiempoEspera +'</td>'
                        +'</tr>');
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    },
    reloadTable: () => {
        logisticaController.getPlaneador();
    },
    getArrayPlaneador: () => {
        $.ajax({
            url: '/logistica/mesaControl/planeador/getArrayPlaneador',
            type: 'GET',
            datatype: 'json',
            success: function (data) { 
                contArea1=0,contArea2=0,contArea3=0,contArea4=0,contArea5=0,contArea6=0,contArea7=0,contArea8=0,contArea9=0,contArea10=0,contArea11=0,contArea12=0;
                arrayPlaneador = new Array();
                arrayPlaneador = data;
                for(let a=0; a < arrayPlaneador.length; a++){
                    switch(arrayPlaneador[a].area)
                    {
                        case 'SECTOR 1':

                                arrayPlaneador[a].porsurtir == 1 ? contArea1 += 1 : '';
                                break;
                            case 'SECTOR 2':
                                arrayPlaneador[a].porsurtir == 1 ? contArea2 += 1 : '';
                                break;
                            case 'SECTOR 3':
                                arrayPlaneador[a].porsurtir == 1 ? contArea3 += 1 : '';
                                break;
                            case 'SECTOR 4':
                                arrayPlaneador[a].porsurtir == 1 ? contArea4 += 1 : '';
                                break;
                            case 'SECTOR 5':
                                arrayPlaneador[a].porsurtir == 1 ? contArea5 += 1 : '';
                                break;
                            case 'VALIDANDO':
                                arrayPlaneador[a].porsurtir == 1 ? contArea6 += 1 : '';
                                break;
                            case 'Z_BULK1':
                                arrayPlaneador[a].porsurtir == 1 ? contArea7 += 1 : '';
                                break;
                            case 'Z_BULK2':
                                arrayPlaneador[a].porsurtir == 1 ? contArea8 += 1 : '';
                                break;
                            case 'Z_BULKIN1':
                                arrayPlaneador[a].porsurtir == 1 ? contArea9 += 1 : '';
                            break;
                            case 'Z_INF1':
                                arrayPlaneador[a].porsurtir == 1 ? contArea10 += 1 : '';
                                break;
                            case 'Z_VOL1':
                                arrayPlaneador[a].porsurtir == 1 ? contArea11 += 1 : '';
                                break;
                            case 'Z_VOL2':
                                arrayPlaneador[a].porsurtir == 1 ? contArea12 += 1 : '';
                                break;
                    }
                }
                $('#content-table-planeador').append('<tr>'
                    +'<td colspan="4" class="text-right"><strong>Total: </strong></td>'
                    +'<td><strong>'+ contArea1 +'</strong></td>'
                    +'<td><strong>'+ contArea2 +'</strong></td>'
                    +'<td><strong>'+ contArea3 +'</strong></td>'
                    +'<td><strong>'+ contArea4 +'</strong></td>'
                    +'<td><strong>'+ contArea5 +'</strong></td>'
                    +'<td><strong>'+ contArea6 +'</strong></td>'
                    +'<td><strong>'+ contArea7 +'</strong></td>'
                    +'<td><strong>'+ contArea8 +'</strong></td>'
                    +'<td><strong>'+ contArea9 +'</strong></td>'
                    +'<td><strong>'+ contArea10 +'</strong></td>'
                    +'<td><strong>'+ contArea11 +'</strong></td>'
                    +'<td><strong>'+ contArea12 +'</strong></td>'
                    +'</tr>');                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    },
    getPlaneador: () => {
        $('#content-table-planeador').empty();
        $.ajax({
            url: '/logistica/mesaControl/planeador/getPlaneador',
            type: 'GET',
            datatype: 'json',
            success: function (data) { 
                console.log(data);
                let area1='',area2='',area3='',area4='',area5='',area6='',area7='',area8='',area9='',area10='',area11='',area12='';
                let styleA1='',styleA2='',styleA3='',styleA4='',styleA5='',styleA6='',styleA7='',styleA8='',styleA9='',styleA10='',styleA11='',styleA12='';
                let functionA1='',functionA2='',functionA3='',functionA4='',functionA5='',functionA6='',functionA7='',functionA8='',functionA9='',functionA10='',functionA11='',functionA12='';
                for(let a=0; a< data.length; a++){
                    let areas = data[a].areas;
                    $.each(areas,function( index, val){
                        switch(val.name)
                        {
                            case 'SECTOR 1':
                                area1 = val.porsurtir;
                                styleA1 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA1 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'SECTOR 2':
                                area2 = val.porsurtir;
                                styleA2 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA2 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'SECTOR 3':
                                area3 = val.porsurtir;
                                styleA3 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA3 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'SECTOR 4':
                                area4 = val.porsurtir;
                                styleA4 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA4 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'SECTOR 5':
                                area5 = val.porsurtir;
                                styleA5 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA5 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'VALIDANDO':
                                area6 = val.porsurtir;
                                styleA6 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA6 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'Z_BULK1':
                                area7 = val.porsurtir;
                                styleA7 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA7 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'Z_BULK2':
                                area8 = val.porsurtir;
                                styleA8 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA8 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'Z_BULKIN1':
                                area9 = val.porsurtir;
                                styleA9 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA9 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                            break;
                            case 'Z_INF1':
                                area10 = val.porsurtir;
                                styleA10 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA10 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                            case 'Z_VOL1':
                                area11 = val.porsurtir;
                                styleA11 = val.style; 
                                typeof val.porsurtir !== 'undefined' ? functionA11 = 'onclick="logisticaController.showPlaneadorDetail(this)"':''; 
                                break;
                            case 'Z_VOL2':
                                area12 = val.porsurtir;
                                styleA12 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA12 = 'onclick="logisticaController.showPlaneadorDetail(this)"':'';
                                break;
                        }
                    })
                    
                    $('#content-table-planeador').append('<tr>' 
                        +'<td>'+ data[a].prioridad +'</td>'
                        +'<td>'+ data[a].formaEnvio +'</td>'
                        +'<td>'+ data[a].cliente +'</td>'
                        +'<td>'+ data[a].numPedido +'</td>'
                        +'<td class="'+ styleA1+'" '+ functionA1 +' data-numpedido="'+data[a].numPedido+'" data-area="SECTOR 1">'+ area1 +'</td>'
                        +'<td class="'+ styleA2+'" '+ functionA2 +' data-numpedido="'+data[a].numPedido+'" data-area="SECTOR 2">'+ area2 +'</td>'
                        +'<td class="'+ styleA3+'" '+ functionA3 +' data-numpedido="'+data[a].numPedido+'" data-area="SECTOR 3">'+ area3 +'</td>'
                        +'<td class="'+ styleA4+'" '+ functionA4 +' data-numpedido="'+data[a].numPedido+'" data-area="SECTOR 4">'+ area4 +'</td>'
                        +'<td class="'+ styleA5+'" '+ functionA5 +' data-numpedido="'+data[a].numPedido+'" data-area="SECTOR 5">'+ area5 +'</td>'
                        +'<td class="'+ styleA6+'" '+ functionA6 +' data-numpedido="'+data[a].numPedido+'" data-area="VALIDANDO">'+ area6 +'</td>'
                        +'<td class="'+ styleA7+'" '+ functionA7 +' data-numpedido="'+data[a].numPedido+'" data-area="Z_BULK1">'+ area7 +'</td>'
                        +'<td class="'+ styleA8+'" '+ functionA8 +' data-numpedido="'+data[a].numPedido+'" data-area="Z_BULK2">'+ area8 +'</td>'
                        +'<td class="'+ styleA9+'" '+ functionA9 +' data-numpedido="'+data[a].numPedido+'" data-area="Z_BULKIN1">'+ area9 +'</td>'
                        +'<td class="'+ styleA10+'" '+ functionA10 +' data-numpedido="'+data[a].numPedido+'" data-area="Z_INF1">'+ area10 +'</td>'
                        +'<td class="'+ styleA11+'" '+ functionA11 +' data-numpedido="'+data[a].numPedido+'" data-area="Z_VOL1">'+ area11 +'</td>'
                        +'<td class="'+ styleA12+'" '+ functionA12 +' data-numpedido="'+data[a].numPedido+'" data-area="Z_VOL2">'+ area12 +'</td>'
                        +'</tr>');  
                        area1='',area2='',area3='',area4='',area5='',area6='',area7='',area8='',area9='',area10='',area11='',area12='';
                        styleA1='',styleA2='',styleA3='',styleA4='',styleA5='',styleA6='',styleA7='',styleA8='',styleA9='',styleA10='',styleA11='',styleA12='';  
                        functionA1='',functionA2='',functionA3='',functionA4='',functionA5='',functionA6='',functionA7='',functionA8='',functionA9='',functionA10='',functionA11='',functionA12='';
                }
                logisticaController.getArrayPlaneador();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);     
            }
        });
    },
    showPlaneadorDetail: (e) => {
        let numPedido = $(e).data('numpedido');
        let area = $(e).data('area');
        let pedidos = new Array();
        console.log(arrayPlaneador);
        $.each(arrayPlaneador,function(index,val){
            if(val.numPedido == numPedido && val.area == area)
            {
                pedidos.push({
                    'mov'       : val.mov,
                    'numPedido' : val.numPedido,
                    'prioridad' : val.prioridad,
                    'formaEnvio': val.formaEnvio,
                    'cliente'   : val.cliente,
                    'clave'     : val.clave,
                    'nombre'    : val.nombre,
                    'area'      : val.area,
                    'porsurtir' : val.porsurtir,
                    'surtido'   : val.surtido
                });
            }
        });
        console.log(pedidos);
        $('#content-planeador-detail').empty();
        $('#modal-planeador-detail').modal('show');
        let rows = '';
        for(var a=0; a < pedidos.length; a++)
        {
            rows += '<tr>'
                    +'<td>'+ pedidos[a].mov +'</td>'
                    +'<td>'+ pedidos[a].numPedido +'</td>'
                    +'<td>'+ pedidos[a].prioridad +'</td>'
                    +'<td>'+ pedidos[a].formaEnvio +'</td>'
                    +'<td>'+ pedidos[a].cliente +'</td>'
                    +'<td>'+ pedidos[a].clave +'</td>'
                    +'<td>'+ pedidos[a].nombre +'</td>'
                    +'<td>'+ pedidos[a].area +'</td>'
                    +'<td>'+ pedidos[a].porsurtir +'</td>'
                    +'<td>'+ pedidos[a].surtido +'</td>'
                    +'</tr>'; 
        }
        $('#content-planeador-detail').append(rows);
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