$(document).ready(function () {
    //Se inicializa validando en que vista se encuentra para ejecutar ciertas funciones
    switch (window.location.pathname) {
        case '/logistica/distribucion/numeroGuia':
            logisticaController.initNumGuia();
            break;
        case '/logistica/distribucion/validarSad':
            logisticaController.consultValidateSAD();
            break;
        case '/logistica/distribucion/reporteSad':
            $('#table-reporte-sad').DataTable({
                paging: true,
                responsive: true,
                searching: true,
                processing: true,
                bSortClasses: false,
                fixedHeader: true,
                // scrollY:        400,
                deferRender: true,
                scroller: true,
                columns: [
                    { data: 'name', visible: true },
                    { data: 'companyID', visible: true },
                    { data: 'zona', visible: true },
                    { data: 'pedido', visible: true },
                    { data: 'usuario', visible: true },
                    { data: 'fecha', visible: true },
                    { data: 'excepcion', visible: true },
                    { data: 'comentario', visible: true },
                    { data: 'factura', visible: true },
                    { data: 'cxcMonto', visible: true },
                    { data: 'cxcAgente', visible: true },
                    { data: 'cxcFecha', visible: true },
                    { data: 'cxcComentario', visible: true },
                    { data: 'validaAgente', visible: true },
                    { data: 'validaFecha', visible: true }
                ],
                language: {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Documentos",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            logisticaController.reportSad();
            break;
        case '/logistica/distribucion/reporteEmbarque':
            $('#table-reporte-embarque').DataTable({
                paging: true,
                responsive: true,
                searching: true,
                processing: true,
                bSortClasses: false,
                fixedHeader: true,
                // scrollY:        400,
                deferRender: true,
                scroller: true,
                columns: [
                    { data: 'diEmbarque', visible: true },
                    { data: 'fecha', visible: true },
                    { data: 'paqueteria', visible: true },
                    { data: 'comentarios', visible: true },
                    { data: 'estatus', visible: true },
                    { data: 'asignado', visible: true },
                    { data: 'factura', visible: true },
                    { data: 'estado', visible: true },
                    { data: 'persona', visible: true },
                    { data: 'fechaHora', visible: true },
                    { data: 'comentariosFactura', visible: true },
                    { data: 'usuarioConfirma', visible: true },
                    { data: 'fechaConfirmaPostVenta', visible: true }
                ],
                language: {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Documentos",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            logisticaController.reportShipment();
            break;
        case '/logistica/distribucion/capturaGastoFletera':
            //#region captura gasto fletera
            //Se inicializan los selectores que se encuentran en la vista 
            logisticaController.initSelect2();

            $('.select2-selection').css('height', '39px');
            $('.select2-selection').css('width', '100%');
            //Se agrega la mascara para decimales
            $("#prontoPago").inputmask({
                alias: "decimal",
                integerDigits: 3,
                digits: 2,
                allowMinus: false,
                digitsOptional: false,
                placeholder: "0.00"
            });
            //#endregion
            break;
        case '/logistica/mesaControl/planeador':
            //#region planeador
            logisticaController.getPlaneador();
            //#endregion
            break;
        case '/logistica/reportes/facturasXEmbarque':
            //#region facturas x embarque
            $('#fechas').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                fechaInicio = start.format('YYYY-MM-DD');
                fechaFin = end.format('YYYY-MM-DD');
            });
            $('#table-facturas-embarque').DataTable({
                // paging: true,
                responsive: true,
                // searching: true,
                processing: true,
                bSortClasses: false,
                fixedHeader: true,
                scrollY: 400,
                deferRender: true,
                scroller: true,
                columns: [
                    { data: 'pedido' },
                    { data: 'cotizacion' },
                    { data: 'consolidado' },
                    { data: 'movimiento' },
                    { data: 'fechaIngreso' },
                    { data: 'factura' },
                    { data: 'ubicacion' },
                    { data: 'fechaFactura' },
                    { data: 'cliente' },
                    { data: 'zona' },
                    { data: 'nota' },
                    { data: 'condicionPago' },
                    { data: 'importe' },
                    { data: 'formaEnvio' },
                    { data: 'fletera' },
                    { data: 'totalEmbarques' },
                    { data: 'embarque' },
                    { data: 'fechaEmbarque' },
                    { data: 'estadoEmbarque' },
                    { data: 'comentarioEmbarque' },
                    { data: 'estadoFactura' },
                    { data: 'comentarioFactura' },
                    { data: 'fechaFleteXConfirmar' },
                    { data: 'fechaEntrega' },
                    { data: 'usuario' },
                    { data: 'chofer' },
                    { data: 'dias' },
                    { data: 'responsable' },
                    { data: 'diasPermitidos' },
                    { data: 'estatus' }
                ],
                language: {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Documentos",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            //#endregion
            break;
        case '/logistica/reportes/gastoFleteras':
            //#region gastoFleteras
            $('#table-gasto-fleteras').DataTable({
                paging: true,
                responsive: true,
                searching: true,
                processing: true,
                bSortClasses: false,
                fixedHeader: true,
                // scrollY:        400,
                deferRender: true,
                scroller: true,
                columns: [
                    { data: 'numDoc', visible: true },
                    { data: 'vendor', visible: true },
                    { data: 'numFactura', visible: true },
                    { data: 'importeFactura', visible: true },
                    { data: 'checkRetencion', visible: true },
                    { data: 'uuid', visible: true },
                    { data: 'usuario', visible: true },
                    { data: 'comentario', visible: true },
                    { data: 'autorizado', visible: true },
                    { data: 'autorizadoUsuario', visible: true },
                    { data: 'numGuia', visible: true },
                    { data: 'importeGuia', visible: true },
                    { data: 'facturas', visible: true },
                    { data: 'comentarioGuia', visible: true }
                ],
                language: {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Documentos",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            logisticaController.consultFreightExpense();
            //#endregion
            break;
        case '/logistica/reportes/interfazRecibo':
            //#region Interfaz recibo
            $('#fechas').daterangepicker({
                singleDatePicker: true,
            }, function (start, end, label) {
                fechaInicio = start.format('YYYY-MM-DD');
            });
            //#endregion
            break;
        case '/logistica/reportes/interfazFacturacion':
            //#region interfaz facturacion
            $('#fechas').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                fechaInicio = start.format('YYYY-MM-DD');
                fechaFin = end.format('YYYY-MM-DD');
            });
            //   $('#table-interfaz-facturacion').DataTable({
            //     paging: true,
            //     responsive: true,
            //     searching: true,
            //     processing: true,
            //     bSortClasses: false,
            //     fixedHeader: true,
            //     scrollY:        400,
            //     deferRender:    true,
            //     scroller:       true,
            //     columns: [
            //         { data:'MOV'},
            //         { data:'cotizacion'},
            //         { data:'consolidado'},
            //         { data:'movimiento'},
            //         { data:'fechaIngreso'},
            //         { data:'factura'},
            //         { data:'ubicacion'},
            //         { data:'fechaFactura'},
            //         { data:'cliente'},
            //         { data:'zona'},
            //         { data:'nota'},
            //         { data:'condicionPago'},
            //         { data:'importe'},
            //         { data:'formaEnvio'},
            //         { data:'fletera'},
            //         { data:'totalEmbarques'},
            //         { data:'embarque'},
            //         { data:'fechaEmbarque'},
            //         { data:'estadoEmbarque'},
            //         { data:'comentarioEmbarque'},
            //         { data:'estadoFactura'},
            //         { data:'comentarioFactura'},
            //         { data:'fechaFleteXConfirmar'},
            //         { data:'fechaEntrega'},
            //         { data:'usuario'},
            //         { data:'chofer'},
            //         { data:'dias'},
            //         { data:'responsable'},
            //         { data:'diasPermitidos'}
            //     ],
            //     language: {
            //         "emptyTable": "No hay información",
            //         "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
            //         "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
            //         "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            //         "infoPostFix": "",
            //         "thousands": ",",
            //         "lengthMenu": "Mostrar _MENU_ Documentos",
            //         "loadingRecords": "Cargando...",
            //         "processing": "Procesando...",
            //         "search": "Buscar:",
            //         "zeroRecords": "Sin resultados encontrados",
            //         "paginate": {
            //           "first": "Primero",
            //           "last": "Ultimo",
            //           "next": "Siguiente",
            //           "previous": "Anterior"
            //         }
            //       }
            // });
            $('#fechas').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                fechaInicio = start.format('DD/MM/YYYY');
                fechaFin = end.format('DD/MM/YYYY');
            });
            //#endregion
            break;
    }
});
//#region VARIABLES GLOBALES
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 8000,
    timerProgressBar: false
});
let d = new Date();
let mount = d.getMonth() + 1;
mount = mount >= 10 ? mount : '0' + mount;
let dNow = d.getFullYear() + '-' + mount + '-' + d.getDate();
let porcentajeGlobal = 1, contShowguia = 1, autorizadoUsuario = '', fechaInicio = dNow, fechaFin = dNow, link = '';
let arrayRowTableType = new Array(), arraytable2 = new Array(), arrayResultFacturas = new Array(), arrayFacturasSelected = new Array(), arrayRowsEmbarques = new Array(), arrayPlaneador = new Array(), ReporteFacturasPorEmbarcar = new Array(), ReporteGastoFleteras = new Array(), ReporteSad = new Array();
let contRowTypeTable = 0, contRowEmbarqueTable = 0, contRowFacturasSelected = 0, contTable = 0, contArea1 = 0, contArea2 = 0, contArea3 = 0, contArea4 = 0, contArea5 = 0, contArea6 = 0, contArea7 = 0, contArea8 = 0, contArea9 = 0, contArea10 = 0, contArea11 = 0, contArea12 = 0;
//#endregion

const logisticaController = {
    //#region SCRIPTS LOGISTICA

    //#region SCRIPTS DISTRIBUCION
    //#region NUMERO GUIA
    initNumGuia: () => {
        $('#fletera').select2();
            $('#chofer').select2();
            $('#fleteraImporte').select2();
            $('#estadoImporte').select2();
            $('.select2-selection').css('height', '39px');
            $('.select2-selection').css('width', '100%');
            $('[data-toggle="tooltip"]').tooltip();
        $("#importeTotal").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $("#importeSeguro").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $("#cajaUpdate").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $("#atadoUpdate").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $("#bultoUpdate").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $("#cubetaUpdate").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $("#tarimaUpdate").inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        $('#fletera').on('change', function () {
            $('#chofer').prop('disabled', true);
        });
        $('#chofer').on('change', function () {
            $('#fletera').prop('disabled', true);
        });
        $('#table-importe').DataTable({
            paging: true,
            responsive: true,
            searching: true,
            processing: false,
            bSortClasses: false,
            fixedHeader: false,
            scrollY: 350,
            scrollCollapse: true,
            deferRender: true,
            scroller: true,
            columns: [
                { data: 'id', visible:false },
                { data: 'cp', visible: true },
                { data: 'fletera', visible: true },
                { data: 'estado', visible: true },
                { data: 'municipio', visible: true },
                { data: 'zona', visible: true },
                { data: 'caja', visible: true },
                { data: 'atado', visible: true },
                { data: 'bulto', visible: true },
                { data: 'cubeta', visible: true },
                { data: 'tarima', visible: true },
                { data: 'fechaInicio', visible: true },
                { data: 'fechaFin', visible: true },
                { data: 'id', render: function(data){
                    return '<button class="btn btn-warning mt-2" style="color:white" data-id="'+data+'" onclick="logisticaController.openModalUpdateNumGuia(this)"><i class="fa-solid fa-pen-to-square"></i></button>'
                }}
            ],
            language: {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
                "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Documentos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Exportar Template',
                    action: function ( e, dt, node, config ) {
                        let url = '/Templates/Template_Importes_NumeroGuia.xlsx';
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'Template_Importes_NumeroGuia';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }
                },
                {
                    text: 'Importar Template',
                    action: function(e,dt,node,config){

                    }
                }
            ]
        });
    },
    openModalUpdateNumGuia: (e) => {
        let idImport = $(e).data('id');
        logisticaController.token();
        $.ajax({
            url: '/logisitica/distribucion/numeroGuia/getImportsByFreighter',
            type: 'GET',
            data: {id:idImport},
            datatype: 'json',
            success: function(data){
                if(data.length != 0)
                {
                    let importes = data[0];
                    $('#fleteraImporteUpdate').empty();
                    $('#fleteraImporteUpdate').append(
                        '<option value="'+importes.fletera+'" selected disabled>'+importes.fletera+'</option>'
                    );
                    $('#codigoPostalUpdate').val(importes.cp);
                    $('#cajaUpdate').val(importes.caja);
                    $('#atadoUpdate').val(importes.atado);
                    $('#bultoUpdate').val(importes.bulto);
                    $('#cubetaUpdate').val(importes.cubeta);
                    $('#tarimaUpdate').val(importes.tarima);
                    $('#fechaInicioUpdate').val(importes.fechaInicio);
                    $('#fechaFinUpdate').val(importes.fechaFin);
                    $('#idImporteFactura').val(importes.id);
                    $('#zonaUpdate').val(importes.zona);
                }
            },
            error: function(error){

            },
            complete: function(){
                $('#modal-importes-fleteras').modal('toggle');
                $('#modal-editar-importes').modal({backdrop: 'static', keyboard: false});
                $('#modal-editar-importes').modal('show');
            }
        });
    },
    updateImport: () => {
        let data = {
            id: $('#idImporteFactura').val(),
            cp: $('#codigoPostalUpdate').val(),
            fletera: $('#fleteraImporteUpdate option:selected').val(),
            zona: $('#zonaUpdate').val(),
            caja: $('#cajaUpdate').val(),
            atado: $('#atadoUpdate').val(),
            bulto: $('#bultoUpdate').val(),
            cubeta: $('#cubetaUpdate').val(),
            tarima: $('#tarimaUpdate').val(),
            fechaInicio: $('#fechaInicioUpdate').val(),
            fechaFin: $('#fechaFinUpdate').val()
        };
        $.ajax({
            url: '/logistica/distribucion/numeroGuia/updateImportsByFreighter',
            type: 'PUT',
            data: data,
            datatype: 'json',
            success: function(data){
                console.log(data);
                if(data)
                {
                    Toast.fire({
                        icon: 'success',
                        title: '¡Se actualizaron correctamente los importes de la fletera!'
                    });
                    $('#modal-editar-importes').modal('toggle');
                    $('#modal-importes-fleteras').modal({backdrop: 'static', keyboard: false});
                    $('#modal-importes-fleteras').modal('show');
                    logisticaController.consultFreighterImport();
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: '¡Hubo un error al actualizar los importes de la fletera!'
                    });
                }
            },
            error: function(error){

            },
            complete: function(){

            }
        });
        console.log(data);
    },
    importDataNumGuia: () => {  
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
        /*Checks whether the file is a valid excel file*/  
        if (regex.test($("#fileTempleteImport").val().toLowerCase())) {  
            var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/  
            if ($("#fileTempleteImport").val().toLowerCase().indexOf(".xlsx") > 0) {  
                xlsxflag = true;  
            }  
            /*Checks whether the browser supports HTML5*/  
            if (typeof (FileReader) != "undefined") {  
                var reader = new FileReader();  
                reader.onload = function (e) {  
                    var data = e.target.result;  
                    /*Converts the excel data in to object*/  
                    if (xlsxflag) {  
                        var workbook = XLSX.read(data, { type: 'binary' });  
                    }  
                    else {  
                        var workbook = XLS.read(data, { type: 'binary' });  
                    }  
                   //  console.log(workbook);
                    
                    /*Gets all the sheetnames of excel in to a variable*/  
                    var sheet_name_list = workbook.SheetNames;  
     
                    var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/  
                    let  exceljson = new Array();
                    sheet_name_list.forEach(function (y) { /*Iterate through all sheets*/  
                        /*Convert the cell value to Json*/  
                        if (xlsxflag) {  
                           exceljson.push(XLSX.utils.sheet_to_json(workbook.Sheets[y]));  
                        }  
                        else {  
                           exceljson.push(XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]));  
                        }  
                    });
                    logisticaController.asyncRequestNumGuia(exceljson);
                   
                }  
                if (xlsxflag) {/*If excel file is .xlsx extension than creates a Array Buffer from excel*/  
                    reader.readAsArrayBuffer($("#fileTempleteImport")[0].files[0]);  
                }  
                else {  
                    reader.readAsBinaryString($("#fileTempleteImport")[0].files[0]);  
                }  
            }  
            else {  
                alert("Sorry! Your browser does not support HTML5!");  
            }  
        }  
        else {  
            alert("Please upload a valid Excel file!");  
        }  
    },
    asyncRequestNumGuia: async (exceljson) => {
        console.log(exceljson);
        await logisticaController.acomodeDataImport(exceljson);
        await logisticaController.CaptureInvoices();
        await logisticaController.acomodateFacturasSelectedImport(exceljson);
        
    },
    acomodateFacturasSelectedImport: (exceljson) => {
        return new Promise((resolve,reject)=> {
            setTimeout(()=>{
                console.log(arrayResultFacturas);
                let facturasSelected = exceljson[2];
                for(let a=0; a < facturasSelected.length; a++)
                {
                    $('#searchFactura').val(facturasSelected[a].Factura);
                    logisticaController.searchBills();
                }
            },2000);
            resolve();
        });
    },
    acomodeDataImport: (exceljson) => {
        return new Promise ((resolve,reject) => {
            let datos = exceljson[0];
            let fletera = datos[0].Fletera == undefined ? '' : datos[0].Fletera;
            let chofer = datos[0].Chofer == undefined ? '' : datos[0].Chofer;
            let numGuia = datos[0].NumGuia == undefined ? '' : datos[0].NumGuia;
            if(fletera != '')
            {
                $('#fletera').prop('disabled', true);
                $('#chofer').prop('disabled', true);
                $('#fletera').empty();
                $('#fletera').append(
                    '<option value="" selected>'+fletera+'</option>'
                );
                
            }
            if(chofer != '')
            {
                $('#chofer').prop('disabled', true);
                $('#fletera').prop('disabled', true);
                $('#chofer').empty();
                $('#chofer').append(
                    '<option value="" selected>'+chofer+'</option>'
                );
            } 
            if(numGuia != '')
            {
                $('#NumGuia').val('');
                $('#NumGuia').val(numGuia);
            }
            let embarques = exceljson[1];
            for(let a=0; a  < embarques.length; a++)
            {
                contRowEmbarqueTable++;
                $('#table-content-embarque').append(
                    '<tr id="rowEmbarque' + contRowEmbarqueTable + '">'
                    + '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" onchange="logisticaController.onChangeRowEmbarque(this)" id="embarque' + contRowEmbarqueTable + '" data-idembarque="' + contRowEmbarqueTable + '" type="text" style="width: 100%;" value="'+embarques[a].Embarque+'"></td>'
                    + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-row="' + contRowEmbarqueTable + '" data-table="embarques" data-idrow="rowEmbarque' + contRowEmbarqueTable + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
                    + '</tr>'
                );
                let idembarque = 'embarque'+contRowEmbarqueTable;
                let embarque = embarques[a].Embarque;
                logisticaController.existShipment(contRowEmbarqueTable,idembarque,embarque);   
            }
            setTimeout(()=>{
                resolve();
            },1500);
        });
    },
    addNumGuia: () => {
        let tablaTipo = arrayRowTableType;
        let facturasSelected = arrayFacturasSelected;
        let fletera = $('#fletera').val();
        let numGuia = $('#NumGuia').val();
        let importeTotal = $('#importeTotal').val();
        let chofer = $('#chofer').val();
        let importeSeguro = 0.00;
        let bandera = 0, bandera2 = 0;
        for (let a = 0; a < tablaTipo.length; a++) {
            if (tablaTipo[a] != undefined) {
                bandera = 1;
                break;
            }
        }
        for (let a = 0; a < facturasSelected.length; a++) {
            if (facturasSelected[a] != undefined) {
                bandera2 = 1;
                break;
            }
        }

        if (bandera == 0 || bandera2 == 0 || fletera == "" || numGuia == "" || importeTotal == "0.00") {
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        } else {
            let data = {
                fletera: fletera,
                numGuia: numGuia,
                importeTotal: importeTotal,
                importeSeguro: importeSeguro,
                tablaTipo: tablaTipo,
                facturasSelected: facturasSelected,
                chofer: chofer
            };
            $.ajax({
                url: '/logistica/distribucion/numeroGuia/saveGuiaNumber',
                type: 'POST',
                data: data,
                datatype: 'json',
                success: function (data) {
                    if (data) {
                        Toast.fire({
                            icon: 'success',
                            title: '¡Se guardo el numero de guia exitosamente!'
                        });
                        arrayRowTableType = new Array();
                        arrayRowsEmbarques = new Array();
                        arrayEmbarquesFinal = new Array();
                        arrayResultFacturas = new Array()
                        arrayFacturasSelected = new Array();
                        let fletera = $('#fletera').val('');
                        let numGuia = $('#NumGuia').val('');
                        $('#table-content-guia-type').empty();
                        $('#table-content-embarque').empty();
                        $('#table-content-embarque-factura').empty();
                        $('#table-content-facturas-selected').empty();
                        $('#importeTotal').val('0.00');
                        $('#fletera').prop('disabled', false);
                        $('#chofer').prop('disabled', false);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Hubo un error al guard el numero de guia!'
                        });
                    }
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: '¡Hubo un error al guard el numero de guia!'
                    });
                },
                complete: function () {

                }
            })
        }

    },
    addTypeRowTable: () => {
        contRowTypeTable++;
        $('#table-content-guia-type').append(
            '<tr id="rowType' + contRowTypeTable + '">'
            + '<td></td>'
            + '<td style="padding: 10px 0px 0px 0px;">'
            + '<select class="form-control" id="tipo' + contRowTypeTable + '" style="width: 100%;" data-row="' + contRowTypeTable + '" onchange="logisticaController.changeTypeSelect(this)">'
            + '<option value="BULTO" selected>BULTO</option>'
            + '<option value="CAJA">CAJA</option>'
            + '<option value="TARIMA">TARIMA</option>'
            + '<option value="ATADO">ATADO</option>'
            + '<option value="PESO">PESO</option>'
            + '<option value="VOLUMEN">VOLUMEN</option>'
            + '</select>'
            + '</td>'
            + '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="cantidad' + contRowTypeTable + '" data-row="' + contRowTypeTable + '" onkeyup="logisticaController.changeTypeSelect(this)" type="number" style="width: 100%;"></td>'
            + '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="importe' + contRowTypeTable + '" data-importe="0" data-row="' + contRowTypeTable + '" onkeyup="logisticaController.changeTypeSelect(this)" type="text" style="width: 100%;"></td>'
            + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-row="' + contRowTypeTable + '" data-table="tipos" data-idrow="rowType' + contRowTypeTable + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
            + '</tr>'
        );
        $('#importe' + contRowTypeTable).inputmask({
            alias: "decimal",
            radixPoint: ".",
            autoGroup: true,
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            digitsOptional: false,
            placeholder: "0.00"
        });
        arrayRowTableType.push({
            'tipo': '',
            'cantidad': '',
            'importe': '',
            'row': contRowTypeTable,
            'idOrdenEmbarque': '',
            'consolidado': ''
        });
    },
    changeTypeSelect: (e) => {
        let row = $(e).data('row');
        let tipo = $('#tipo' + row).val();
        let cantidad = $('#cantidad' + row).val();
        let importe = $('#importe' + row).val();
        for (let a = 0; a < arrayRowTableType.length; a++) {
            if (arrayRowTableType[a] != undefined) {
                if (arrayRowTableType[a].row == row) {
                    arrayRowTableType[a].tipo = tipo;
                    arrayRowTableType[a].cantidad = cantidad;
                    arrayRowTableType[a].importe = importe;
                }
            }
        }
        logisticaController.calculateImportTotal();
    },
    calculateImportTotal: () => {
        let importeTotal = 0.00;
        let bandera = 0;
        for (let a = 0; a < arrayRowTableType.length; a++) {
            if (arrayRowTableType[a] != undefined) {
                importeTotal += parseFloat(arrayRowTableType[a].importe);
                $('#importeTotal').val(importeTotal);
                bandera++;
            }
        }
        if (bandera == 0) {
            $('#importeTotal').val(0.00);
        }
    },
    deleteRowTable: (e) => {
        let idrow = $(e).data('idrow');
        let table = $(e).data('table');
        let row = $(e).data('row');
        let embarque = $('#embarque' + row).val();
        $('#' + idrow).remove();
        if (table == 'facturasSelected') {
            let factura = $(e).data('factura');
            //BORRAR BULTO DE LA TABLA DE BULTOS EN ARRAY Y EN ROW
            for (let a = 0; a < arrayRowTableType.length; a++) {
                if (arrayRowTableType[a] != undefined) {
                    if (arrayRowTableType[a].factura == factura) {
                        $('#rowType' + arrayRowTableType[a].row).remove();
                        delete arrayRowTableType[a];
                    }
                }
            }
            //BORRAR FACTURA DE LA TABLA FACTURAS SELECTED
            for (let a = 0; a < arrayFacturasSelected.length; a++) {
                if (arrayFacturasSelected[a] != undefined) {
                    if (arrayFacturasSelected[a].factura == factura) {
                        for (let b = 0; b < arrayResultFacturas.length; b++) {
                            if (arrayResultFacturas[b] != undefined) {
                                if (arrayResultFacturas[b].factura == factura) {
                                    arrayResultFacturas[b].check = "0";
                                    logisticaController.acomodateTableEmbarqueFactura();
                                }
                            }
                        }
                        delete arrayFacturasSelected[a];
                        break;
                    }
                }
            }
            logisticaController.calculateImportTotal();
        }
        if (table == 'embarques') {
            for (let a = 0; a < arrayRowsEmbarques.length; a++) {
                if (arrayRowsEmbarques[a] != undefined) {
                    if (arrayRowsEmbarques[a].row == row) {
                        delete arrayRowsEmbarques[a];
                        break;
                    }
                }
            }
            for (let b = 0; b < arrayResultFacturas.length; b++) {
                if (arrayResultFacturas[b] != undefined) {
                    if (arrayResultFacturas[b].embarque == embarque) {
                        for (let c = 0; c < arrayFacturasSelected.length; c++) {
                            if (arrayFacturasSelected[c] != undefined) {
                                if (arrayFacturasSelected[c].factura == arrayResultFacturas[b].factura) {

                                    delete arrayFacturasSelected[c];
                                }
                            }
                        }
                        for (let d = 0; d < arrayRowTableType.length; d++) {
                            if (arrayRowTableType[d] != undefined) {
                                if (arrayRowTableType[d].factura == arrayResultFacturas[b].factura) {
                                    $('#rowType' + arrayRowTableType[d].row).remove();
                                    delete arrayRowTableType[d];
                                }
                            }
                        }
                        delete arrayResultFacturas[b];
                    }
                }
            }
            logisticaController.acomodateTableEmbarqueFactura();
            logisticaController.acomodateTableFacturasSelected();
            logisticaController.calculateImportTotal();
        }
        if (table == 'tipos') {
            for (let a = 0; a < arrayRowTableType.length; a++) {
                if (arrayRowTableType[a] != undefined) {
                    if (arrayRowTableType[a].row == row) {
                        delete arrayRowTableType[a];
                    }
                }
            }
            logisticaController.calculateImportTotal();
        }
    },
    acomodateTableEmbarqueFactura: () => {
        $('#table-content-embarque-factura').empty();
        for (let c = 0; c < arrayResultFacturas.length; c++) {
            let check = '';
            if (arrayResultFacturas[c] != undefined) {
                if (arrayResultFacturas[c].check == '1' || arrayResultFacturas[c].guia != '') {
                    check = 'background-color:#50ff50';
                }
                $('#table-content-embarque-factura').append(
                    '<tr id="rowFactura' + arrayResultFacturas[c].factura + '" style="' + check + '">'
                    + '<td>' + arrayResultFacturas[c].factura + '</td>'
                    + '<td>' + arrayResultFacturas[c].cliente + '</td>'
                    + '<td>' + arrayResultFacturas[c].embarque + '</td>'
                    + '</tr>'
                );
            }
        }
    },
    acomodateTableFacturasSelected: () => {
        $('#table-content-facturas-selected').empty();
        for (let b = 0; b < arrayFacturasSelected.length; b++) {
            if (arrayFacturasSelected[b] != undefined) {
                $('#rowFactura' + arrayFacturasSelected[b].factura).css('background-color', '#50ff50');
                $('#table-content-facturas-selected').append(
                    '<tr>'
                    + '<td>' + arrayFacturasSelected[b].factura + '</td>'
                    + '<td>' + arrayFacturasSelected[b].embarque + '</td>'
                    // +'<td><input class="form-control" value="'+arrayFacturasSelected[b].autorizado+'" /></td>'
                    + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-factura="' + arrayFacturasSelected[b].factura + '" data-row="' + contRowFacturasSelected + '" data-table="facturasSelected" data-idrow="rowFacturaSelected' + contRowFacturasSelected + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
                    + '</tr>'
                );
            }
        }
    },
    addEmbarqueRowTable: () => {
        contRowEmbarqueTable++;
        $('#table-content-embarque').append(
            '<tr id="rowEmbarque' + contRowEmbarqueTable + '">'
            + '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" onchange="logisticaController.onChangeRowEmbarque(this)" id="embarque' + contRowEmbarqueTable + '" data-idembarque="' + contRowEmbarqueTable + '" type="text" style="width: 100%;"></td>'
            + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-row="' + contRowEmbarqueTable + '" data-table="embarques" data-idrow="rowEmbarque' + contRowEmbarqueTable + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
            + '</tr>'
        );
    },
    onChangeRowEmbarque: (e) => {
        let rowembarque = $(e).data('idembarque');
        let idembarque = 'embarque' + rowembarque;
        let embarque = $('#' + idembarque).val();
        // console.log(rowembarque,idembarque,embarque);
        
        logisticaController.existShipment(rowembarque,idembarque,embarque);
    },
    existShipment: (rowembarque,idembarque,embarque) => {
        $.ajax({
            url: '/logistica/distribucion/numeroGuia/existShipment',
            type: 'GET',
            data: { embarque: embarque },
            datatype: 'json',
            success: function (data) {
                let repetido = 0;
                let modificado = 0;
                if (data != 0) {
                    Toast.fire({
                        icon: 'success',
                        title: '¡Embarque agregado!'
                    });
                    for (let a = 0; a < arrayRowsEmbarques.length; a++) {
                        if (arrayRowsEmbarques[a] != undefined) {
                            if (arrayRowsEmbarques[a].embarque == embarque) {
                                //validamos si el renglon agregado ya esta repetido
                                repetido = 1;
                                break;
                            } else {
                                //validamos si quieren modificar el mismo renglon
                                if (arrayRowsEmbarques[a].row == rowembarque) {
                                    arrayRowsEmbarques[a].embarque = embarque;
                                    arrayRowsEmbarques[a].disponible = true;
                                    arrayRowsEmbarques[a].row = rowembarque;
                                    modificado = 1;
                                    break;
                                }
                            }
                        }
                    }
                    if (!repetido) {
                        if (!modificado) {
                            arrayRowsEmbarques.push({
                                'embarque': embarque,
                                'disponible': true,
                                'row': rowembarque
                            });
                        }
                    } else {
                        $('#rowEmbarque' + rowembarque).remove();
                        Toast.fire({
                            icon: 'error',
                            title: '¡No se pueden repetir los embarques!'
                        });
                    }
                    $('#' + idembarque).css('background-color', '#fffff');
                    $('#' + idembarque).css('color', 'gray');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: '¡Embarque no existe o concluida!'
                    });
                    for (let a = 0; a < arrayRowsEmbarques.length; a++) {
                        if (arrayRowsEmbarques[a] != undefined) {
                            if (arrayRowsEmbarques[a].embarque == embarque) {
                                //validamos si el renglon agregado ya esta repetido
                                repetido = 1;
                                break;
                            } else {
                                //validamos si quieren modificar el mismo renglon
                                if (arrayRowsEmbarques[a].row == rowembarque) {
                                    arrayRowsEmbarques[a].embarque = embarque;
                                    arrayRowsEmbarques[a].disponible = false;
                                    arrayRowsEmbarques[a].row = rowembarque;
                                    modificado = 1;
                                    break;
                                }
                            }
                        }
                    }
                    if (!repetido) {
                        if (!modificado) {
                            arrayRowsEmbarques.push({
                                'embarque': embarque,
                                'disponible': false,
                                'row': rowembarque
                            });
                        }
                    } else {
                        $('#rowEmbarque' + rowembarque).remove();
                        Toast.fire({
                            icon: 'error',
                            title: '¡No se pueden repetir los embarques!'
                        });
                    }
                    $('#' + idembarque).css('background-color', '#f73737');
                    $('#' + idembarque).css('color', 'white');
                }
            },
            complete: function () {

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    CaptureInvoices: () => {
        return new Promise ((resolve,reject)=>{
            let data = '';
            let arrayEmbarquesFinal = new Array()
            if (arrayRowsEmbarques.length != 0) {
                for (let a = 0; a < arrayRowsEmbarques.length; a++) {
                    if (arrayRowsEmbarques[a] != undefined) {
                        if (arrayRowsEmbarques[a].disponible) {
                            data += arrayRowsEmbarques[a].embarque + ',';
                        }
                    }
                }
                arrayEmbarquesFinal.push(data.substring(0, data.length - 1));
                logisticaController.token();
                $.ajax({
                    url: '/logistica/distribucion/numeroGuia/captureInvoice',
                    type: 'POST',
                    data: { embarques: arrayEmbarquesFinal },
                    datatype: 'json',
                    success: function (data) {
                        $('#table-content-embarque-factura').empty();
                        if (data == "") {
                            $('#table-content-embarque-factura').append(
                                '<tr>'
                                + '<td class="text-center" colspan="3">No se encontraron resultados</td>'
                                + '</tr>'
                            );
                        } else {
                            if (arrayResultFacturas.length == 0) {
                                arrayResultFacturas = data;
                            } else {
                                for (let b = 0; b < data.length; b++) {
                                    let bandera = 0;
                                    for (let c = 0; c < arrayResultFacturas.length; c++) {
                                        if (arrayResultFacturas[c] != undefined) {
                                            if (data[b].factura == arrayResultFacturas[c].factura) {
                                                bandera = 1;
                                                break;
                                            }
                                        }
                                    }
                                    if (bandera == 0) {
                                        arrayResultFacturas.push(data[b]);
                                    }
                                }
                            }
                            for (let a = 0; a < arrayResultFacturas.length; a++) {
                                let check = '';
                                if (arrayResultFacturas[a] != undefined) {
                                    if (arrayResultFacturas[a].check == '1' || arrayResultFacturas[a].guia != '') {
                                        check = 'background-color:#50ff50';
                                    }
                                    $('#table-content-embarque-factura').append(
                                        '<tr id="rowFactura' + arrayResultFacturas[a].factura + '" style="' + check + '">'
                                        + '<td>' + arrayResultFacturas[a].factura + '</td>'
                                        + '<td>' + arrayResultFacturas[a].cliente + '</td>'
                                        + '<td>' + arrayResultFacturas[a].embarque + '</td>'
                                        + '</tr>'
                                    );
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
    
                    },
                    complete: function () {
    
                    }
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: '¡Ingrese al menos un embarque para la captura de facturas!'
                });
            }
            resolve();
        })
    },
    searchBills: () => {
        let factura = $('#searchFactura').val();
        let fletera = $('select[name="fletera"] option:selected').text();
        fletera = fletera == 'Seleccione una fletera' ? "" : fletera;
        $.ajax({
            url: '/logistica/distribucion/numeroGuia/cuentaBultosWMSManager',
            type: 'GET',
            data: { factura: factura, fletera: fletera },
            datatype: 'json',
            success: function(data){
                console.log(data);
                if(data != "" || data != [] || data.length != 0)
                {
                    //OBTENER EL EMBARQUE PARA AGREGARLO AL ARRAY DE LOS BULTOS QUE REGRESA
                    let embarque = '';
                    for (let a = 0; a < arrayResultFacturas.length; a++) {
                        if (arrayResultFacturas[a] != undefined) {
                            if (arrayResultFacturas[a].factura == factura) {
                                embarque = arrayResultFacturas[a].embarque;
                                break;
                            }
                        }
                    }
                    let lasRow = 0;
                    if (arrayRowTableType.length != 0) {
                        for (let a = 0; a < arrayRowTableType.length; a++) {
                            if (arrayRowTableType[a] != undefined) {
                                lasRow = arrayRowTableType[a].row;
                            }
                        }
                        let validacion = 0;
                        for (let a = 0; a < arrayRowTableType.length; a++) {
                            for (let b = 0; b < data.length; b++) {
                                if (arrayRowTableType[a] != undefined) {
                                    if (data[b].idOrdenEmbarque != "") {
                                        if (arrayRowTableType[a].idOrdenEmbarque == data[b].idOrdenEmbarque) {
                                            //Validamos que no venga repetido el idOrdenEmbarque o Consolidado
                                            validacion = 1;
                                            break;
                                        }
                                    }
                                    if (data[b].consolidado != "") {
                                        if (arrayRowTableType[a].consolidado == data[b].consolidado) {
                                            //Validamos que no venga repetido el idOrdenEmbarque o Consolidado
                                            validacion = 1;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        if (validacion == 0) {
                            for (let a = 0; a < data.length; a++) {
                                lasRow++
                                //IR ACTUALIZANDO LA VARIABLE CONTROWTYPETABLE PARA CUANDO LO USE OTRA FUNCION MANTENGA EL RENGLON CORRECTO QUE CORRESPONDE
                                contRowTypeTable = lasRow;
                                let select = '';
                                switch (data[a].tipoAtado) {
                                    case 'Bulto':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Bulto" selected>Bulto</option>'
                                            + '</select>';
                                        break;
                                    case 'Caja':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Caja" selected>Caja</option>'
                                            + '</select>';
                                        break;
                                    case 'Tarima':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Tarima" selected>Tarima</option>'
                                            + '</select>';
                                        break;
                                    case 'Atado':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Atado" selected>Atado</option>'
                                            + '</select>';
                                        break;
                                    case 'Peso':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Peso" selected>Peso</option>'
                                            + '</select>';
                                        break;
                                    case 'Volumen':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Volumen" selected>Volumen</option>'
                                            + '</select>';
                                        break;
                                    case 'Cubeta':
                                        select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                            + '<option value="Cubeta" selected>Cubeta</option>'
                                            + '</select>';
                                        break;
                                }
                                let importeLock = '';
                                let importeXcantidad = data[a].cantidad * data[a].importe;
                                if(fletera == "" || data[a].importe == 0)
                                {
                                    let importeXcantidad = 0;
                                    importeLock = '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="importe'+lasRow+'" data-row="'+lasRow+'" onkeyup="logisticaController.changeTypeSelect(this)" type="text" style="width: 100%;" data-importe="'+importeXcantidad+'" ></td>';
                                }else{
                                    importeLock = '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="importe'+lasRow+'" data-row="'+lasRow+'" onkeyup="logisticaController.changeTypeSelect(this)" type="text" style="width: 100%;" data-importe="'+importeXcantidad+'" value="'+importeXcantidad+'" disabled></td>';
                                }
                                $('#table-content-guia-type').append(
                                    '<tr id="rowType' + lasRow + '">'
                                    + '<td>' + factura + '</td>'
                                    + '<td style="padding: 10px 0px 0px 0px;">'
                                    + select
                                    + '</td>'
                                    + '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="cantidad' + lasRow + '" data-row="' + lasRow + '" onkeyup="logisticaController.changeTypeSelect(this)" type="number" style="width: 100%;" value="' + data[a].cantidad + '" disabled></td>'
                                    + importeLock
                                    + '<td>'+data[a].cp+'</td>'
                                    + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-row="' + lasRow + '" data-table="tipos" data-idrow="rowType' + lasRow + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
                                    + '</tr>'
                                );
                                $('#importe' + lasRow).inputmask({
                                    alias: "decimal",
                                    radixPoint: ".",
                                    autoGroup: true,
                                    groupSeparator: ".",
                                    digits: 2,
                                    allowMinus: false,
                                    digitsOptional: false,
                                    placeholder: "0.00"
                                });
                                arrayRowTableType.push({
                                    'tipo': data[a].tipoAtado,
                                    'cantidad':data[a].cantidad,
                                    'importe': importeXcantidad,
                                    'row': lasRow,
                                    'idOrdenEmbarque': data[a].idOrdenEmbarque,
                                    'consolidado': data[a].consolidado,
                                    'factura': factura,
                                    'embarque': embarque
                                });
                                logisticaController.calculateImportTotal();
                            }
                        }
                    } else {
                        for (let a = 0; a < data.length; a++) {
                            let select = '';
                            switch (data[a].tipoAtado) {
                                case 'Bulto':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Bulto" selected>Bulto</option>'
                                        + '</select>';
                                    break;
                                case 'Caja':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Caja" selected>Caja</option>'
                                        + '</select>';
                                    break;
                                case 'Tarima':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Tarima" selected>Tarima</option>'
                                        + '</select>';
                                    break;
                                case 'Atado':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Atado" selected>Atado</option>'
                                        + '</select>';
                                    break;
                                case 'Peso':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Peso" selected>Peso</option>'
                                        + '</select>';
                                    break;
                                case 'Volumen':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Volumen" selected>Volumen</option>'
                                        + '</select>';
                                    break;
                                case 'Cubeta':
                                    select = '<select class="form-control" id="tipo' + lasRow + '" style="width: 100%;" data-row="' + lasRow + '" onchange="logisticaController.changeTypeSelect(this)" disabled>'
                                        + '<option value="Cubeta" selected>Cubeta</option>'
                                        + '</select>';
                                    break;
                            }
                            let importeLock = '';
                            let importeXcantidad = data[a].cantidad * data[a].importe;
                            if(fletera == "" || data[a].importe == 0)
                            {
                                importeXcantidad = 0;
                                importeLock = '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="importe'+contRowTypeTable+'" data-row="'+contRowTypeTable+'" onkeyup="logisticaController.changeTypeSelect(this)" type="text" style="width: 100%;" data-importe="'+importeXcantidad+'" ></td>';
                            }else{
                                importeLock = '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="importe'+contRowTypeTable+'" data-row="'+contRowTypeTable+'" onkeyup="logisticaController.changeTypeSelect(this)" type="text" style="width: 100%;" data-importe="'+importeXcantidad+'" value="'+importeXcantidad+'" disabled></td>';
                            }
                            $('#table-content-guia-type').append(
                                '<tr id="rowType' + contRowTypeTable + '">'
                                + '<td>' + factura + '</td>'
                                + '<td style="padding: 10px 0px 0px 0px;">'
                                + select
                                + '</td>'
                                + '<td style="padding: 10px 0px 0px 0px;"><input class="form-control" id="cantidad' + contRowTypeTable + '" data-row="' + contRowTypeTable + '" onkeyup="logisticaController.changeTypeSelect(this)" type="number" style="width: 100%;" value="' + data[a].cantidad + '" disabled></td>'
                                + importeLock
                                + '<td>'+data[a].cp+'</td>'
                                + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-row="' + contRowTypeTable + '" data-table="tipos" data-idrow="rowType' + contRowTypeTable + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
                                + '</tr>'
                            );
                            $('#importe' + contRowTypeTable).inputmask({
                                alias: "decimal",
                                radixPoint: ".",
                                autoGroup: true,
                                groupSeparator: ".",
                                digits: 2,
                                allowMinus: false,
                                digitsOptional: false,
                                placeholder: "0.00"
                            });
                            arrayRowTableType.push({
                                'tipo': data[a].tipoAtado,
                                'cantidad':data[a].cantidad,
                                'importe': importeXcantidad,
                                'row': contRowTypeTable++,
                                'idOrdenEmbarque': data[a].idOrdenEmbarque,
                                'consolidado': data[a].consolidado,
                                'factura': factura,
                                'embarque': embarque
                            });
                            logisticaController.calculateImportTotal();
                        }
                    }
                }
            },
            error: function () {

            },
            complete: function () {

            }
        })
        let bandera = 0;
        if (arrayResultFacturas.length != 0) {
            for (let a = 0; a < arrayResultFacturas.length; a++) {
                if (arrayResultFacturas[a] != undefined) {
                    if (arrayResultFacturas[a].factura == factura) {
                        bandera = 1;
                        if (arrayFacturasSelected.length != 0) {
                            let bandera2 = 0;
                            for (let c = 0; c < arrayFacturasSelected.length; c++) {
                                if (arrayFacturasSelected[c] != undefined) {
                                    //VALIDAR QUE NO ESTE REPETIDO LA MISMA FACTURA EN LA ULTIMA TABLA
                                    if (arrayFacturasSelected[c].factura == factura) {
                                        bandera2 = 1;
                                        break;
                                    }
                                }
                            }
                            if (bandera2 == 1) {
                                Toast.fire({
                                    icon: 'error',
                                    title: '¡Ya esta seleccionada esta factura!'
                                });
                            } else {
                                arrayResultFacturas[a].check = "1";
                                arrayFacturasSelected.push({
                                    'factura': arrayResultFacturas[a].factura,
                                    'autorizado': arrayResultFacturas[a].guia,
                                    'embarque': arrayResultFacturas[a].embarque
                                });
                            }
                        } else {
                            arrayResultFacturas[a].check = "1";
                            arrayFacturasSelected.push({
                                'factura': arrayResultFacturas[a].factura,
                                'autorizado': arrayResultFacturas[a].guia,
                                'embarque': arrayResultFacturas[a].embarque
                            });
                        }
                        break;
                    }
                }
            }
            if (bandera == 0) {
                $.ajax({
                    url: '/logistica/distribucion/numeroGuia/existAnyBillsInAnyShipment',
                    type: 'GET',
                    data: { factura: factura },
                    datatype: 'json',
                    success: function (data) {
                        if (data) {
                            arrayFacturasSelected.push({
                                'factura': factura,
                                'autorizado': 'No pertenece a los embarques',
                                'embarque': ''
                            });
                            Toast.fire({
                                icon: 'error',
                                title: '¡Esta Factura no Pertence a los embarques señalados!'
                            });
                        } else {
                            arrayFacturasSelected.push({
                                'factura': factura,
                                'autorizado': 'No esta embarcada aún',
                                'embarque': ''
                            });
                            Toast.fire({
                                icon: 'error',
                                title: '¡Esta factura nunca a sido embarcada!'
                            });
                        }
                        $('#table-content-facturas-selected').empty();
                        for (let b = 0; b < arrayFacturasSelected.length; b++) {
                            if (arrayFacturasSelected[b] != undefined) {
                                contRowFacturasSelected++
                                $('#rowFactura' + arrayFacturasSelected[b].factura).css('background-color', '#50ff50');
                                $('#table-content-facturas-selected').append(
                                    '<tr id="rowFacturaSelected' + contRowFacturasSelected + '">'
                                    + '<td>' + arrayFacturasSelected[b].factura + '</td>'
                                    + '<td>' + arrayFacturasSelected[b].embarque + '</td>'
                                    + '<td>' + arrayFacturasSelected[b].autorizado + '</td>'
                                    // +'<td><input class="form-control" id="autorizado'+contRowFacturasSelected+'" data-factura="'+arrayFacturasSelected[b].factura+'" data-row="'+contRowFacturasSelected+'" onkeyup="logisticaController.changeAuthoriceBills(this)" value="'+arrayFacturasSelected[b].autorizado+'" /></td>'
                                    + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-factura="' + arrayFacturasSelected[b].factura + '" data-row="' + contRowFacturasSelected + '" data-table="facturasSelected" data-idrow="rowFacturaSelected' + contRowFacturasSelected + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
                                    + '</tr>'
                                );
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    },
                    complete: function () {

                    }
                })
            } else {
                $('#table-content-facturas-selected').empty();
                for (let b = 0; b < arrayFacturasSelected.length; b++) {
                    if (arrayFacturasSelected[b] != undefined) {
                        contRowFacturasSelected++
                        $('#rowFactura' + arrayFacturasSelected[b].factura).css('background-color', '#50ff50');
                        $('#table-content-facturas-selected').append(
                            '<tr id="rowFacturaSelected' + contRowFacturasSelected + '">'
                            + '<td>' + arrayFacturasSelected[b].factura + '</td>'
                            + '<td>' + arrayFacturasSelected[b].embarque + '</td>'
                            + '<td>' + arrayFacturasSelected[b].autorizado + '</td>'
                            // +'<td><input class="form-control" id="autorizado'+contRowFacturasSelected+'" data-factura="'+arrayFacturasSelected[b].factura+'" data-row="'+contRowFacturasSelected+'" onkeyup="logisticaController.changeAuthoriceBills(this)" value="'+arrayFacturasSelected[b].autorizado+'" /></td>'
                            + '<td><button type="button" class="btn btn-block btn-danger btn-sm" data-factura="' + arrayFacturasSelected[b].factura + '" data-row="' + contRowFacturasSelected + '" data-table="facturasSelected" data-idrow="rowFacturaSelected' + contRowFacturasSelected + '"onclick="logisticaController.deleteRowTable(this)"><i class="fa-solid fa-xmark"></i></button></td>'
                            + '</tr>'
                        );
                    }
                }
            }
        } else {
            Toast.fire({
                icon: 'error',
                title: '¡Ingrese algun embarque para posterior obtener una captura de facturas!'
            });
        }
        $('#searchFactura').val('');
    },
    changeAuthoriceBills: (e) => {
        let row = $(e).data('row');
        let autorizado = $('#autorizado' + row).val();
        let factura = $(e).data('factura');
        for (let a = 0; a < arrayFacturasSelected.length; a++) {
            if (arrayFacturasSelected[a] != undefined) {
                if (arrayFacturasSelected[a].factura == factura) {
                    arrayFacturasSelected[a].autorizado = autorizado;
                    break;
                }
            }
        }
    },
    showModalLogin: () => {
        $('#modal-autorizacion').modal({backdrop: 'static', keyboard: false});
        $('#modal-autorizacion').modal('show');
    },
    consultFreighterImport: () => {
        let fletera = $('#fleteraImporte').val();
        let estado = $('#estadoImporte').val();
        let data = {
            fletera:fletera,
            estado:estado
        };
        $.ajax({
            url: '/logistica/distribucion/numeroGuia/getFreightersImports',
            type: 'GET',
            data: data,
            datatype: 'json',
            success: function(data){
                console.log(data);
                $('#table-importe').DataTable().clear().draw();
                $('#table-importe').DataTable().rows.add(data).draw();
            },
            error: function(error){

            },
            complete: function(){

            }
        });
    },
    exitModalImportUpdate: () => {
        $('#modal-editar-importes').modal('toggle');
        $('#modal-importes-fleteras').modal({backdrop: 'static', keyboard: false});
        $('#modal-importes-fleteras').modal('show');
    },
    //#endregion
    //#region VALIDAR SAD
    consultValidateSAD: () => {
        $('.btn-consultar-validar-sad').prop('disabled', true);
        $('.btn-consultar-validar-sad').empty();
        $('.btn-consultar-validar-sad').append('<i class="fa-solid fa-spin fa-cog mr-1"></i> Consultando');
        $.ajax({
            url: '/logistica/distribucion/validarSad/consultValidateSAD',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                let rows = '';
                $('.btn-consultar-validar-sad').prop('disabled', false);
                $('.btn-consultar-validar-sad').empty();
                $('.btn-consultar-validar-sad').append('<i class="fa-solid fa-cog mr-1"></i> Consultar');
                $.each(data, function (key, value) {
                    rows += '<tr id="rowsadID' + value.sadID + '">' +
                        +'<td>' + value.pedido + '</td>'
                        + '<td>' + value.pedido + '</td>'
                        + '<td>' + value.importePedido + '</td>'
                        + '<td>' + value.cliente + '</td>'
                        + '<td>' + value.nombre + '</td>'
                        + '<td>' + value.fechaFactura + '</td>'
                        + '<td>' + value.factura + '</td>'
                        + '<td>' + value.importeFactura + '</td>'
                        + '<td>' + value.descuentoTotalPP + '</td>'
                        + '<td>' + value.importePP + '</td>'
                        + '<td>' + value.excepcion + '</td>'
                        + '<td>' + value.comentario + '</td>'
                        + '<td>' + value.cxcComentario + '</td>'
                        + '<td>' + value.cxcMonto + '</td>'
                        + '<td>'
                        + '<a class="btn  bg-success" data-sadid="' + value.sadID + '" onclick="logisticaController.authoriceSad(this)">'
                        + '<i class="fa-solid fa-check"></i>'
                        + '</a>'
                        + '</td>'
                        + '</tr>';

                });
                if (contTable != 0) {
                    $('#table-validar-sad').DataTable().destroy();
                    $('#content-table-validar-sad').empty();
                }
                $('#content-table-validar-sad').append(rows);
                $('#table-validar-sad').DataTable({
                    // paging: true,
                    responsive: true,
                    // searching: true,
                    processing: true,
                    bSortClasses: false,
                    fixedHeader: true,
                    scrollY: 470,
                    deferRender: true,
                    scroller: true,
                    language: {
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Documentos",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    }
                });
                contTable = 1;

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            },
            complete: function () {

            }
        })
    },
    authoriceSad: (e) => {
        let sadID = $(e).data('sadid');
        logisticaController.token();
        $.ajax({
            url: '/logistica/distribucion/validarSad/authoriceSad',
            type: 'POST',
            data: { sadID: sadID },
            datatype: 'json',
            success: function (data) {
                Toast.fire({
                    icon: 'success',
                    title: '¡Terminado!'
                });
                $('#rowsadID' + sadID).remove();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Toast.fire({
                    icon: 'error',
                    title: '¡Hubo un error en la consulta!'
                });
            },
            complete: function () {
                console.log(textStatus);
            }
        })
    },
    //#endregion
    //#region REPORTE SAD
    reportSad: () => {
        $('.btn-consultar-reporte-sad').empty();
        $('.btn-consultar-reporte-sad').append('<i class="fa-solid fa-cog fa-spin mr-1"></i> Consultando');
        $('.btn-consultar-reporte-sad').prop('disabled', true);
        $('.btn-excel').prop('disabled', true);
        if (contTable != 0) {
            $('#table-reporte-sad').DataTable().clear().draw();
        }
        $.ajax({
            url: '/logistica/distribucion/getReportSad',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                console.time();
                ReporteSad = data;
                $('#table-reporte-sad').DataTable().clear().draw();
                $('#table-reporte-sad').DataTable().rows.add(data).draw();
                $('.btn-consultar-reporte-sad').prop('disabled', false);
                $('.btn-excel').prop('disabled', false);
                $('.btn-consultar-reporte-sad').empty();
                $('.btn-consultar-reporte-sad').append('<i class="fa-solid fa-cog mr-1"></i> Consultar');
                contTable++;
            },
            complete: () => {
                console.timeEnd();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    exportExcelreportSad: () => {
        $('.btn-excel').empty();
        $('.btn-excel').prop('disabled', true);
        $('.btn-excel').append('<i class="fa-solid fa-file-excel mr-1"></i>Exportando<i class="fa-solid fa-download fa-bounce ml-2"></i>');
        var arrayRows = [];
        arrayRows.push([
            'NAME',
            'COMPANY ID',
            'ZONA',
            'PEDIDO',
            'USUARIO',
            'FECHA',
            'EXCEPCION',
            'COMENTARIO',
            'FACTURA',
            'CXC MONTO',
            'CXC AGENTE',
            'CXC FECHA',
            'CXC COMENTARIO',
            'VALIDA AGENTE',
            'VALIDA FECHA'
        ]);
        $.each(ReporteSad, function (key, value) {
            let excepcion = value.excepcion == null ? '' : value.excepcion;
            excepcion = excepcion.replace(/,/g, '');
            excepcion = excepcion.replace(/[#]/g, '');
            let comentario = value.comentario == null ? '' : value.comentario;
            comentario = comentario.replace(/,/g, '');
            comentario = comentario.replace(/[#]/g, '');
            let cxcComentario = value.cxcComentario == null ? '' : value.cxcComentario;
            cxcComentario = cxcComentario.replace(/,/g, '');
            cxcComentario = cxcComentario.replace(/[#]/g, '');
            let data = [
                value.name,
                value.companyID,
                value.zona,
                value.pedido,
                value.usuario,
                value.fecha,
                excepcion.replace(/(\r\n|\n|\r)/gm, ""),
                comentario.replace(/(\r\n|\n|\r)/gm, ""),
                value.factura,
                value.cxcMonto,
                value.cxcAgente,
                value.cxcFecha,
                cxcComentario.replace(/(\r\n|\n|\r)/gm, ""),
                value.validaAgente,
                value.validaFecha
            ];
            arrayRows.push(data);
        });
        csvContent = "data:text/csv;charset=utf-8,";
        /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        arrayRows.forEach(function (rowArray) {
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Reporte_SAD.csv");
        document.getElementById('table-reporte-sad').appendChild(link);
        link.click();
        setTimeout(function () {
            $('.btn-excel').empty();
            $('.btn-excel').prop('disabled', false);
            $('.btn-excel').append('<i class="fa-solid fa-file-excel mr-1"></i>Exportar');
        }, 5000);
    },
    //#endregion
    //#region REPORTE EMBARQUE
    reportShipment: () => {
        $.ajax({
            url: '/logistica/distribucion/reportShipment',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function () {

            },
            complete: function () {

            }
        });
    },
    //#endregion
    //#region CAPTURA GASTO FLETERA
    initSelect2: () => {
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
        $('#btnAgregarGuia').prop('disabled', false);
        $('#cargaXML').prop('disabled', false);
        $('#dataTable2GastoFletera').empty();
        $('#dataTableGastoFletera').empty();
        let paqueteriaID = $('#acreedor').val();
        let esOficina = $('#acreedor option:selected').data('esoficina');
        let acreedor = $('#acreedor option:selected').text();
        $('#agregarGuiaAcreedor').append('<option value="' + paqueteriaID + '" selected>' + acreedor + '</option>');
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/getGuias',
            type: 'GET',
            data: { paqueteriaID: paqueteriaID },
            datatype: 'json',
            success: function (data) {
                if (data != []) {
                    contShowguia = 1;
                    $.each(data, function (key, value) {
                        let fecha = value['fecha'].split('T');
                        let idNumeroGuia = value['idNumeroGuia'];
                        let numeroGuia = value['numeroGuia'];
                        let importeTotal = 0;
                        value['costoTotal'] == 0 ? (importeTotal = 0) : (importeTotal = value['costoTotal']);
                        $('#dataTableGastoFletera').append(
                            '<tr class="text-center">'
                            + '<td><input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias(this)" data-idnumeroguia="' + idNumeroGuia + '" data-numeroguia="' + numeroGuia + '" data-importetotal="' + importeTotal + '"></td>'
                            + '<td>' + numeroGuia + '</td>'
                            + '<td>' + logisticaController.replaceNumberWithCommas(importeTotal.toFixed(2)) + '</td>'
                            + '<td>' + fecha[0] + '</td>'
                            + '</tr>'
                        );
                    });
                } else {
                    contShowguia = 0;
                    $('#dataTableGastoFletera').append(
                        '<tr class="text-center">'
                        + '<td colspan="4"><strong>No se encontrar resultados</strong></td>'
                        + '</tr>'
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
        if ($(e).prop('checked')) {
            $('#prontoPago').prop('disabled', false);
            logisticaController.requestGuiaSelected(data);
        } else {
            delete arraytable2[idNumeroGuia];
            logisticaController.construction();
            let contArray = 0;
            arraytable2.forEach(function () {
                contArray++;
            });
            contArray == 0 ? $('#prontoPago').prop('disabled', true) : '';

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
        if ($(e).prop('checked')) {
            logisticaController.modificateArrayGuiasSelected(idNumeroGuia, true);
            $('#' + idNumeroGuia).css('background-color', '#44f344');
        } else {
            logisticaController.modificateArrayGuiasSelected(idNumeroGuia, false);
            $('#' + idNumeroGuia).css('background-color', 'white');
        }
    },
    modificateArrayGuiasSelected: (idNumeroGuia, selected) => {
        arraytable2[idNumeroGuia]["selected"] = selected;
        let checkSelected = 0;
        arraytable2.forEach(function (value, key) {
            if (value['selected']) {
                checkSelected = 1;
                return false;
            }
        });
        if ($('#retencionIva').prop('checked')) {
            if (arraytable2[idNumeroGuia]["selected"]) {
                let importe = arraytable2[idNumeroGuia]['importeSinIva'] * 1.12;
                arraytable2[idNumeroGuia]['importe'] = importe.toFixed(2);
                arraytable2[idNumeroGuia]['retencion'] = 1.12;
                logisticaController.construction();
            } else {
                let importe = arraytable2[idNumeroGuia]['importeSinIva'] * 1.16;
                arraytable2[idNumeroGuia]['importe'] = importe.toFixed(2);
                arraytable2[idNumeroGuia]['retencion'] = 1.16;
                logisticaController.construction();
            }
        }
        if (checkSelected == 0) {
            $('#retencionIva').prop('disabled', true);
            $('#retencionIva').prop('checked', false);
        } else {
            $('#retencionIva').prop('disabled', false);
        }
    },
    retentionIVA: (e) => {
        let prontoPago = $('#prontoPago').val();
        let porcentajeFinal = (100 - prontoPago) / 100;
        if ($(e).prop('checked')) {
            arraytable2.forEach(function (value, key) {
                if (value['selected']) {
                    let importe = porcentajeFinal * 1.12 * value['importeSinIva'];
                    value['importe'] = importe.toFixed(2);
                    value['retencion'] = 1.12;
                }
            });
            logisticaController.construction();
        } else {
            arraytable2.forEach(function (value, key) {
                if (value['selected']) {
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
        let importeTotal = 0;
        let importeSinIvaTotal = 0;
        arraytable2.forEach(function (values, key) {
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
            if (values['selected']) {
                checkedBox = '<input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias2(this)" data-idnumeroguia="' + idNumeroGuia + '" checked>';
            } else {
                checkedBox = '<input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias2(this)" data-idnumeroguia="' + idNumeroGuia + '" false>';
            }
            $('#dataTable2GastoFletera').append(
                '<tr class="text-center" id="' + idNumeroGuia + '">'
                + '<td>' + checkedBox + '</td>'
                + '<td>' + numeroGuia + '</td>'
                + '<td>' + logisticaController.replaceNumberWithCommas(importe) + '</td>'
                + '<td>' + comentario + '</td>'
                + '<td>' + logisticaController.replaceNumberWithCommas(importeSinIva.toFixed(2)) + '</td>'
                + '<td>' + retencion + '</td>'
                + '<td>' + pp + '</td>'
                + '</tr>');
            if (values['selected']) {
                $('#' + idNumeroGuia).css('background-color', '#44f344');
            } else {
                $('#' + idNumeroGuia).css('background-color', 'white');
            }
            importeTotal += parseFloat(importe);
            importeSinIvaTotal += parseFloat(importeSinIva);
        });
        if (parseFloat(importeSinIvaTotal) == parseFloat($('#importeSinIva').val())) {
            $('#importeGuias').css('background-color', 'rgb(40 167 69)');
            $('#importeGuias').css('color', 'white');
            if ($('#autorizado').prop('checked')) {
                $('#btnRegistrarNet').prop('disabled', false);
            } else {
                $('#btnRegistrarNet').prop('disabled', true);
            }
        } else if (parseFloat(importeSinIvaTotal) > parseFloat($('#importeSinIva').val())) {
            $('#importeGuias').css('background-color', 'rgb(229 81 81)');
            $('#importeGuias').css('color', 'white');
            $('#btnRegistrarNet').prop('disabled', true);
        } else if (parseFloat(importeSinIvaTotal) < parseFloat($('#importeSinIva').val())) {
            $('#importeGuias').css('background-color', '#e9ecef');
            $('#importeGuias').css('color', '#495057');
            $('#btnRegistrarNet').prop('disabled', true);
        }
        $('#importeGuias').empty();
        $('#importeGuias').val(logisticaController.replaceNumberWithCommas(importeSinIvaTotal.toFixed(2)));
        $('#totalImporte').empty();
        $('#totalImporte').append('Total: $' + logisticaController.replaceNumberWithCommas(importeTotal.toFixed(2)));
    },
    acomodeData: (data) => {
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
        let importe = porcentajeGlobal * retencion * importeSinIva;
        arraytable2[idNumeroGuia] = {
            atado: atado,
            bultos: bultos,
            cajas: cajas,
            cliente: cliente,
            comentario: comentario,
            facturas: facturas,
            idNumeroGuia: idNumeroGuia,
            importeSinIva: importeSinIva,
            metodo: metodo,
            numeroGuia: numeroGuia,
            paqueteria: paqueteria,
            pp: pp,
            retencion: retencion,
            tarima: tarima,
            importe: importe.toFixed(2),
            selected: false
        };
    },
    replaceNumberWithCommas: (numero) => {
        //Seperates the components of the number
        var n = numero.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    },
    formAutho: () => {
        if ($('#usuarioSAI').val() == '' || $('#contrasenaSAI').val() == '') {
            $('#divMessage').empty();
            $('#divMessage').removeAttr('hidden');
            $('#divMessage').append('<strong style="color:red">Ingrese los datos que se piden</strong>');
        } else {
            $('#divMessage').empty();
            $('#divMessage').attr('hidden');
            let data = {
                user: $('#usuarioSAI').val(),
                password: $('#contrasenaSAI').val()
            };
            autorizadoUsuario = data.user;
            $.ajax({
                url: '/logistica/distribucion/capturaGastoFletera/getAutorizacion',
                type: 'GET',
                data: data,
                datatype: 'json',
                success: function (data) {
                    data = data[0];
                    if (data['usuario'] == 'Usuario invalido') {
                        $('#divMessage').empty();
                        $('#divMessage').removeAttr('hidden');
                        $('#divMessage').append('<strong style="color:#dc3545">' + data['usuario'] + '</strong>');
                    } else if (data['pass'] == 'Contraseña invalida') {
                        $('#divMessage').empty();
                        $('#divMessage').removeAttr('hidden');
                        $('#divMessage').append('<strong style="color:#dc3545">' + data['pass'] + '</strong>');
                    } else {
                        $('#divMessage').empty();
                        $('#divMessage').removeAttr('hidden');
                        $('#autorizado').prop('checked', true);
                        $('#modal-autorizacion').modal('toggle');
                        Toast.fire({
                            icon: 'success',
                            title: 'Petición para autorización: ¡Exitosa!'
                        });
                        let pathWeb = window.location.pathname;
                        if (pathWeb == '/logistica/distribucion/numeroGuia') {
                            //Mostrar modal y llamar el array global de los costos por fletera
                            $('#modal-importes-fleteras').modal({backdrop: 'static', keyboard: false});
                            $('#modal-importes-fleteras').modal('show');
                        } else {
                            if ($('#importeGuias').val() == $('#importeSinIva').val()) {
                                $('#btnRegistrarNet').prop('disabled', false);
                            }
                            $('.btn-aut').prop('disabled', true);
                            $('#acreedor').prop('disabled', false);
                            $('#btnAgregarGuia').prop('disabled', false);
                        }

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        }
    },
    validateFormAddGuia: () => {
        if ($('#agregarGuiaAcreedor').val() == null || $('#agregarGuiaAcreedor').val() == "") {
            logisticaController.formMessageAlert();
        } else if ($('#agregarGuiaDepartamento').val() == null || $('#agregarGuiaAcreedor').val() == "") {
            logisticaController.formMessageAlert();
        } else if ($('#agregarGuiaNumeroGuia').val() == null || $('#agregarGuiaNumeroGuia').val() == "") {
            logisticaController.formMessageAlert();
        } else if ($('#agregarGuiaMunicipio').val() == null || $('#agregarGuiaMunicipio').val() == "") {
            logisticaController.formMessageAlert();
        } else if ($('#agregarGuiaImporte').val() == null || $('#agregarGuiaImporte').val() == "") {
            logisticaController.formMessageAlert();
        } else if ($('#agregarGuiaClasificador').val() == null || $('#agregarGuiaClasificador').val() == "") {
            logisticaController.formMessageAlert();
        } else {
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
            success: function (data, status) {
                data = data[0];
                if (status == 'success') {
                    if (data == "Registro Exitoso") {
                        $('#modal-agregar-guia').modal('toggle');
                        Toast.fire({
                            animation: true,
                            icon: 'success',
                            title: 'Creación de guia valido : ¡Registro exitoso!'
                        });
                        logisticaController.requestGetGuia(dato['numguia']);
                    } else if (data = "Ya existe la guia") {
                        Toast.fire({
                            animation: true,
                            icon: 'error',
                            title: 'Creación de guia invalido : ¡Ya existe la guia!'
                        });
                    }
                } else {
                    Toast.fire({
                        animation: true,
                        icon: 'error',
                        title: 'Creación de guia invalido : ¡Internal Error Server!'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    },
    requestGetGuia: (numeroGuia) => {
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/getGuia',
            type: 'GET',
            data: { numeroGuia: numeroGuia },
            datatype: 'json',
            success: function (data) {
                data = data[0];
                let importeTotal = data['importeTotal'];
                let fecha = data['fecha'];
                contShowguia == 0 ? $('#dataTableGastoFletera').empty() : '';
                $('#dataTableGastoFletera').append(
                    '<tr class="text-center">'
                    + '<td><input type="checkbox" onchange="logisticaController.checkBoxSelectedListaGuias(this)" data-idnumeroguia="' + data['idNumeroGuia'] + '" data-numeroguia="' + data['numeroGuia'] + '" data-importetotal="' + data['importeTotal'] + '" checked></td>'
                    + '<td>' + data['numeroGuia'] + '</td>'
                    + '<td>' + logisticaController.replaceNumberWithCommas(importeTotal.toFixed(2)) + '</td>'
                    + '<td>' + fecha.split('T')[0] + '</td>'
                    + '</tr>'
                );
                let dato = {
                    idNumeroGuia: data['idNumeroGuia'],
                    numeroGuia: data['numeroGuia'],
                    importeTotal: importeTotal
                };
                $('#prontoPago').prop('disabled', false);
                logisticaController.requestGuiaSelected(dato);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    token: () => {
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
        prontoPago > 100 ? ($('#prontoPago').val(100.00), logisticaController.setValImport(100)) : (logisticaController.setValImport(prontoPago));
    },
    setValImport: (porcentaje) => {
        porcentajeGlobal = (100 - porcentaje) / 100;
        arraytable2.forEach(function (value, key) {
            if (value['selected']) {
                let importe = porcentajeGlobal * 1.12 * value['importeSinIva'];
                value['importe'] = importe.toFixed(2);
                value['pp'] = porcentajeGlobal;
            } else {
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
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    },
    registerNet: () => {
        let arrayFinalGuias = new Array();
        arraytable2.forEach(element => {
            let dataArray = {
                'atados': element['atado'],
                'bultos': element['bultos'],
                'cajas': element['cajas'],
                'cliente': element['cliente'],
                'cliente': element['comnetario'],
                'facturas': element['facturas'],
                'idNumeroGuia': element['idNumeroGuia'],
                'importe': element['importe'],
                'importeSinIva': element['importeSinIva'],
                'metodo': element['metodo'],
                'numeroGuia': element['numeroGuia'],
                'paqueteria': element['paqueteria'],
                'pp': element['pp'],
                'retencion': element['retencion'],
                'selected': element['selected'],
                'tarima': element['tarima']
            };
            arrayFinalGuias.push(
                dataArray
            );
        });
        let data = {
            'checkRetencion': $('#retencionIva').prop('checked'),
            'idVendor': $('#acreedor').val(),
            'importeFactura': $('#importeTotal').val(),
            'numFactura': $('#numFactura').val(),
            'uuid': $('#uuid').val(),
            'vendor': $('#acreedor option:selected').text(),
            'usuario': $('#usuario').val(),
            'autorizado': $('#autorizado').prop('checked'),
            'autorizadoUsuario': autorizadoUsuario,
            'guias': arrayFinalGuias
        };
        $.ajax({
            url: '/logistica/distribucion/capturaGastoFletera/registerNet',
            type: 'POST',
            data: data,
            datatype: 'json',
            success: function (data) {
                // console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    //#endregion
    //#endregion

    //#region SCRIPTS REPORTES
    //#region FACTURAS X EMBARQUE
    consultBillsXShipments: () => {
        $('.btn-consultar-factura').prop('disabled', true);
        $('.btn-consultar-factura').empty();
        $('.btn-consultar-factura').append('<i class="fa-solid fa-spin fa-cog mr-1"></i> Consultando');
        let row = '';
        contTable != 0 ? (
            $('#table-facturas-embarque').DataTable().clear().draw()
        ) : '';
        $.ajax({
            url: '/logistica/reportes/facturasXEmbarque/consultBillsXShipments',
            type: 'GET',
            data: { fechaInicio: fechaInicio, fechaFin: fechaFin },
            datatype: 'json',
            success: function (data) {
                console.time();
                ReporteFacturasPorEmbarcar = data;
                $('#table-facturas-embarque').DataTable().clear().draw();
                $('#table-facturas-embarque').DataTable().rows.add(data).draw();
                $('.btn-consultar-factura').prop('disabled', false);
                $('.btn-consultar-factura').empty();
                $('.btn-consultar-factura').append('<i class="fa-solid fa-cog mr-1"></i> Consultar');
                contTable++;
            },
            complete: () => {
                $('.card-body').attr('hidden', false);
                $('.btn-excel').prop('disabled', false);
                console.timeEnd();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    exportExcelBillsXShipments: () => {
        $('.btn-excel').empty();
        $('.btn-excel').prop('disabled', true);
        $('.btn-excel').append('<i class="fa-solid fa-file-excel mr-1"></i>Exportando<i class="fa-solid fa-download fa-bounce ml-2"></i>');
        var arrayRows = [];
        arrayRows.push([
            'PEDIDO',
            'COTIZACION',
            'CONSOLIDADO',
            'MOVIMIENTO',
            'FECHA INGRESO',
            'FACTURA',
            'ENVIA A',
            'FECHA FACTURA',
            'CLIENTE',
            'ZONA',
            'NOTA',
            'CONDICION PAGO',
            'IMPORTE',
            'FORMA ENVIO',
            'FLETERA',
            'TOTAL EMBARQUES',
            'EMBARQUE',
            'FECHA EMBARQUE',
            'ESTADO EMBARQUE',
            'COMENTARIO EMBARQUE',
            'ESTADO FACTURA',
            'COMENTARIO FACTURA',
            'FECHA FLETE X CONFIRMAR',
            'FECHA ENTRAGA',
            'USUARIO',
            'CHOFER',
            'DIAS',
            'RESPONSABLE',
            'DIAS PERMITIDOS'
        ]);
        $.each(ReporteFacturasPorEmbarcar, function (key, value) {
            let nota = value.nota.replace(/,/g, '.');
            let comentarioEmbarque = value.comentarioEmbarque.replace(/,/g, '.');
            let comentarioFactura = value.comentarioFactura.replace(/,/g, '.');
            let condicionPago = value.condicionPago;
            let cliente = value.cliente.replace(/,/g, '.');
            let formaEnvio = value.formaEnvio;
            let fletera = value.fletera;
            nota = nota.replace(/[#]/g, '');
            comentarioEmbarque = comentarioEmbarque.replace(/[#]/g, '');
            comentarioFactura = comentarioFactura.replace(/[#]/g, '');
            let data = [
                value.pedido,
                value.cotizacion,
                value.consolidado,
                value.movimiento,
                value.fechaIngreso,
                value.factura,
                value.ubicacion,
                value.fechaFactura,
                cliente.normalize('NFD').replace(/[\u0300-\u036f]/g, ""),
                value.zona,
                nota.replace(/(\r\n|\n|\r)/gm, ""),
                condicionPago.normalize('NFD').replace(/[\u0300-\u036f]/g, ""),
                value.importe,
                formaEnvio.normalize('NFD').replace(/[\u0300-\u036f]/g, ""),
                fletera.normalize('NFD').replace(/[\u0300-\u036f]/g, ""),
                value.totalEmbarques,
                value.embarque,
                value.fechaEmbarque,
                value.estadoEmbarque,
                comentarioEmbarque.replace(/(\r\n|\n|\r)/gm, ""),
                value.estadoFactura,
                comentarioFactura.replace(/(\r\n|\n|\r)/gm, ""),
                value.fechaFleteXConfirmar,
                value.fechaEntrega,
                value.usuario,
                value.chofer,
                value.dias,
                value.responsable,
                value.diasPermitidos
            ];
            arrayRows.push(data);
        });
        csvContent = "data:text/csv;charset=utf-8,";
        /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        arrayRows.forEach(function (rowArray) {
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Reporte_FacturasPorEmbarcar.csv");
        document.getElementById('table-facturas-embarque').appendChild(link);
        link.click();
        setTimeout(function () {
            $('.btn-excel').empty();
            $('.btn-excel').prop('disabled', false);
            $('.btn-excel').append('<i class="fa-solid fa-file-excel mr-1"></i>Exportar');
        }, 5000);
    },
    //#endregion
    //#region GASTO FLETERAS
    consultFreightExpense: () => {
        contTable != 0 ? (
            $('.btn-consultar-gasto-fletera').empty(),
            $('.btn-consultar-gasto-fletera').append('<i class="fa-solid fa-spin fa-cog mr-1"></i> Consultando'),
            $('#table-gasto-fleteras').DataTable().clear().draw()
        ) : '';
        $.ajax({
            url: '/logistica/reportes/gastoFleteras/consultFreightExpense',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                console.time();
                ReporteGastoFleteras = data;
                $('#table-gasto-fleteras').DataTable().clear().draw();
                $('#table-gasto-fleteras').DataTable().rows.add(data).draw();
                $('.btn-consultar-gasto-fletera').empty();
                $('.btn-consultar-gasto-fletera').append('<i class="fa-solid fa-cog mr-1"></i> Consultar');
                contTable++;
            },
            complete: () => {
                console.timeEnd();
                $('.btn-excel').prop('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    exportExcelFreightExpense: () => {
        $('.btn-excel').empty();
        $('.btn-excel').prop('disabled', true);
        $('.btn-excel').append('<i class="fa-solid fa-file-excel mr-1"></i>Exportando<i class="fa-solid fa-download fa-bounce ml-2"></i>');
        var arrayRows = [];
        arrayRows.push([
            'NUM DOC',
            'VENDOR',
            'NUM FACTURA',
            'IMPORTE FACTURA',
            'CHECK RETENCION',
            'UUID',
            'USUARIO',
            'COMENTARIO',
            'AUTORIZADO',
            'AUTORIZADO USUARIO',
            'NUM GUIA',
            'IMPORTE GUIA',
            'FACTURAS',
            'COMENTARIO GUIA'
        ]);
        $.each(ReporteGastoFleteras, function (key, value) {
            let facturas = value.facturas;
            let checkRetencion = value.checkRetencion;
            checkRetencion = checkRetencion == "<input type='checkbox' disabled>" ? 0 : 1;
            let autorizado = value.autorizado;
            autorizado = autorizado == "<input type='checkbox' disabled>" ? 0 : 1;
            let vendor = value.vendor;
            let comentario = value.comentario;
            let comentarioGuia = value.comentarioGuia;
            let data = [
                value.numDoc,
                vendor.replace(/,/g, ''),
                value.numFactura,
                value.importeFactura,
                checkRetencion,
                value.uuid,
                value.usuario,
                comentario.replace(/,/g, ''),
                autorizado,
                value.autorizadoUsuario,
                value.numGuia,
                value.importeGuia,
                facturas.replace(/,/g, '.'),
                comentarioGuia.replace(/,/g, '')
            ];
            arrayRows.push(data);
        });
        csvContent = "data:text/csv;charset=utf-8,";
        /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        arrayRows.forEach(function (rowArray) {
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Reporte_GastoFleteras.csv");
        document.getElementById('table-gasto-fleteras').appendChild(link);
        link.click();
        setTimeout(function () {
            $('.btn-excel').empty();
            $('.btn-excel').prop('disabled', false);
            $('.btn-excel').append('<i class="fa-solid fa-file-excel mr-1"></i>Exportar');
        }, 5000);
    },
    //#endregion
    //#region INTERFAZ RECIBO 
    consultReceiptInterface: () => {
        // console.log(fechaInicio);
    },
    //#endregion
    //#region INTERFAZ FACTURACION
    consultBillingInterface: () => {
        contTable != 0 ? (
            $('.btn-consultar-interfaz-facturacion').empty(),
            $('.btn-consultar-interfaz-facturacion').append('<i class="fa-solid fa-spin fa-cog mr-1"></i> Consultando'),
            $('#table-interfaz-facturacion').DataTable().clear().draw()
        ) : '';
        $.ajax({
            url: '/logistica/reportes/interfazFacturacion/consultBillingInterface',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                console.time();
                $('#table-interfaz-facturacion').DataTable().clear().draw();
                $('#table-interfaz-facturacion').DataTable().rows.add(data).draw();
                $('.btn-consultar-interfaz-facturacion').empty();
                $('.btn-consultar-interfaz-facturacion').append('<i class="fa-solid fa-cog mr-1"></i> Consultar');
                contTable++;
            },
            complete: () => {
                console.timeEnd();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    //#endregion
    //#endregion



    //#region SCRIPTS MESA CONTROL
    //#region PLANEADOR
    slopesBoxes: () => {
        $.ajax({
            url: '/logistica/mesaControl/planeador/getCajasPendientes',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                $('#content-cajas-pendientes').empty();
                $('#modal-cajas-pendientes').modal('show');
                $.each(data, function (index, val) {
                    let fechaSurtido = val.fechaSurtido;
                    $('#content-cajas-pendientes').append('<tr>'
                        + '<td>' + val.pedidoConsolidado + '</td>'
                        + '<td>' + val.formaEnvio + '</td>'
                        + '<td>' + val.prioridad + '</td>'
                        + '<td>' + val.caja + '</td>'
                        + '<td>' + val.articulo + '</td>'
                        + '<td>' + val.cantidad + '</td>'
                        + '<td>' + val.ubicacionOrigen + '</td>'
                        + '<td>' + val.usuario + '</td>'
                        + '<td>' + val.nombre + '</td>'
                        + '<td>' + fechaSurtido.split('T')[0] + '</td>'
                        + '<td>' + val.tiempoEspera + '</td>'
                        + '</tr>');
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    },
    reloadTable: () => {
        $('.fa-cog').addClass('fa-spin');
        logisticaController.getPlaneador();
    },
    getArrayPlaneador: () => {
        $.ajax({
            url: '/logistica/mesaControl/planeador/getArrayPlaneador',
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                contArea1 = 0, contArea2 = 0, contArea3 = 0, contArea4 = 0, contArea5 = 0, contArea6 = 0, contArea7 = 0, contArea8 = 0, contArea9 = 0, contArea10 = 0, contArea11 = 0, contArea12 = 0;
                arrayPlaneador = new Array();
                arrayPlaneador = data;
                for (let a = 0; a < arrayPlaneador.length; a++) {
                    switch (arrayPlaneador[a].area) {
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
                    + '<td colspan="4" class="text-right"><strong>Total: </strong></td>'
                    + '<td><strong>' + contArea1 + '</strong></td>'
                    + '<td><strong>' + contArea2 + '</strong></td>'
                    + '<td><strong>' + contArea3 + '</strong></td>'
                    + '<td><strong>' + contArea4 + '</strong></td>'
                    + '<td><strong>' + contArea5 + '</strong></td>'
                    + '<td><strong>' + contArea6 + '</strong></td>'
                    + '<td><strong>' + contArea7 + '</strong></td>'
                    + '<td><strong>' + contArea8 + '</strong></td>'
                    + '<td><strong>' + contArea9 + '</strong></td>'
                    + '<td><strong>' + contArea10 + '</strong></td>'
                    + '<td><strong>' + contArea11 + '</strong></td>'
                    + '<td><strong>' + contArea12 + '</strong></td>'
                    + '</tr>');
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
                let rows = '';
                let area1 = '', area2 = '', area3 = '', area4 = '', area5 = '', area6 = '', area7 = '', area8 = '', area9 = '', area10 = '', area11 = '', area12 = '';
                let styleA1 = '', styleA2 = '', styleA3 = '', styleA4 = '', styleA5 = '', styleA6 = '', styleA7 = '', styleA8 = '', styleA9 = '', styleA10 = '', styleA11 = '', styleA12 = '';
                let functionA1 = '', functionA2 = '', functionA3 = '', functionA4 = '', functionA5 = '', functionA6 = '', functionA7 = '', functionA8 = '', functionA9 = '', functionA10 = '', functionA11 = '', functionA12 = '';
                for (let a = 0; a < data.length; a++) {
                    let areas = data[a].areas;
                    $.each(areas, function (index, val) {
                        switch (val.name) {
                            case 'SECTOR 1':
                                area1 = val.porsurtir;
                                styleA1 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA1 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'SECTOR 2':
                                area2 = val.porsurtir;
                                styleA2 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA2 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'SECTOR 3':
                                area3 = val.porsurtir;
                                styleA3 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA3 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'SECTOR 4':
                                area4 = val.porsurtir;
                                styleA4 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA4 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'SECTOR 5':
                                area5 = val.porsurtir;
                                styleA5 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA5 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'VALIDANDO':
                                area6 = val.porsurtir;
                                styleA6 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA6 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'Z_BULK1':
                                area7 = val.porsurtir;
                                styleA7 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA7 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'Z_BULK2':
                                area8 = val.porsurtir;
                                styleA8 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA8 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'Z_BULKIN1':
                                area9 = val.porsurtir;
                                styleA9 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA9 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'Z_INF1':
                                area10 = val.porsurtir;
                                styleA10 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA10 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'Z_VOL1':
                                area11 = val.porsurtir;
                                styleA11 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA11 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                            case 'Z_VOL2':
                                area12 = val.porsurtir;
                                styleA12 = val.style;
                                typeof val.porsurtir !== 'undefined' ? functionA12 = 'onclick="logisticaController.showPlaneadorDetail(this)"' : '';
                                break;
                        }
                    })
                    rows += '<tr>'
                        + '<td>' + data[a].prioridad + '</td>'
                        + '<td>' + data[a].formaEnvio + '</td>'
                        + '<td>' + data[a].cliente + '</td>'
                        + '<td>' + data[a].numPedido + '</td>'
                        + '<td class="' + styleA1 + '" ' + functionA1 + ' data-numpedido="' + data[a].numPedido + '" data-area="SECTOR 1">' + area1 + '</td>'
                        + '<td class="' + styleA2 + '" ' + functionA2 + ' data-numpedido="' + data[a].numPedido + '" data-area="SECTOR 2">' + area2 + '</td>'
                        + '<td class="' + styleA3 + '" ' + functionA3 + ' data-numpedido="' + data[a].numPedido + '" data-area="SECTOR 3">' + area3 + '</td>'
                        + '<td class="' + styleA4 + '" ' + functionA4 + ' data-numpedido="' + data[a].numPedido + '" data-area="SECTOR 4">' + area4 + '</td>'
                        + '<td class="' + styleA5 + '" ' + functionA5 + ' data-numpedido="' + data[a].numPedido + '" data-area="SECTOR 5">' + area5 + '</td>'
                        + '<td class="' + styleA6 + '" ' + functionA6 + ' data-numpedido="' + data[a].numPedido + '" data-area="VALIDANDO">' + area6 + '</td>'
                        + '<td class="' + styleA7 + '" ' + functionA7 + ' data-numpedido="' + data[a].numPedido + '" data-area="Z_BULK1">' + area7 + '</td>'
                        + '<td class="' + styleA8 + '" ' + functionA8 + ' data-numpedido="' + data[a].numPedido + '" data-area="Z_BULK2">' + area8 + '</td>'
                        + '<td class="' + styleA9 + '" ' + functionA9 + ' data-numpedido="' + data[a].numPedido + '" data-area="Z_BULKIN1">' + area9 + '</td>'
                        + '<td class="' + styleA10 + '" ' + functionA10 + ' data-numpedido="' + data[a].numPedido + '" data-area="Z_INF1">' + area10 + '</td>'
                        + '<td class="' + styleA11 + '" ' + functionA11 + ' data-numpedido="' + data[a].numPedido + '" data-area="Z_VOL1">' + area11 + '</td>'
                        + '<td class="' + styleA12 + '" ' + functionA12 + ' data-numpedido="' + data[a].numPedido + '" data-area="Z_VOL2">' + area12 + '</td>'
                        + '</tr>';
                    area1 = '', area2 = '', area3 = '', area4 = '', area5 = '', area6 = '', area7 = '', area8 = '', area9 = '', area10 = '', area11 = '', area12 = '';
                    styleA1 = '', styleA2 = '', styleA3 = '', styleA4 = '', styleA5 = '', styleA6 = '', styleA7 = '', styleA8 = '', styleA9 = '', styleA10 = '', styleA11 = '', styleA12 = '';
                    functionA1 = '', functionA2 = '', functionA3 = '', functionA4 = '', functionA5 = '', functionA6 = '', functionA7 = '', functionA8 = '', functionA9 = '', functionA10 = '', functionA11 = '', functionA12 = '';
                }
                $('#content-table-planeador').prepend(rows);
                $('.fa-cog').removeClass('fa-spin');
                logisticaController.getArrayPlaneador();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            },
        });
    },
    showPlaneadorDetail: (e) => {
        let numPedido = $(e).data('numpedido');
        let area = $(e).data('area');
        let pedidos = new Array();
        $.each(arrayPlaneador, function (index, val) {
            if (val.numPedido == numPedido && val.area == area) {
                pedidos.push({
                    'mov': val.mov,
                    'numPedido': val.numPedido,
                    'prioridad': val.prioridad,
                    'formaEnvio': val.formaEnvio,
                    'cliente': val.cliente,
                    'clave': val.clave,
                    'nombre': val.nombre,
                    'area': val.area,
                    'porsurtir': val.porsurtir,
                    'surtido': val.surtido
                });
            }
        });
        $('#content-planeador-detail').empty();
        $('#modal-planeador-detail').modal('show');
        let rows = '';
        for (var a = 0; a < pedidos.length; a++) {
            rows += '<tr>'
                + '<td>' + pedidos[a].mov + '</td>'
                + '<td>' + pedidos[a].numPedido + '</td>'
                + '<td>' + pedidos[a].prioridad + '</td>'
                + '<td>' + pedidos[a].formaEnvio + '</td>'
                + '<td>' + pedidos[a].cliente + '</td>'
                + '<td>' + pedidos[a].clave + '</td>'
                + '<td>' + pedidos[a].nombre + '</td>'
                + '<td>' + pedidos[a].area + '</td>'
                + '<td>' + pedidos[a].porsurtir + '</td>'
                + '<td>' + pedidos[a].surtido + '</td>'
                + '</tr>';
        }
        $('#content-planeador-detail').append(rows);
    }
    //#endregion
    //#endregion

    //#endregion
} 
