var businessLines = [];
const TIPOSCONTACTOS = {
    1:'PRINCIPAL',
    2:'PAGOS',
    3:'COMPRAS',
    4:'ADMON',
    5:'EMERGENCIA'
}

const HISTORIALTRANS = {
    1:'Solicitud Guardada',
    2:'Solicitud Enviada',
    3:'Validación Guardada',
    4:'Aceptada Contado',
    5:'Aceptado Contado (Pendiente Credito)',
    6:'Aceptada Credito',
    7:'Rechazada',
    8:'Rechazada Credito (Aceptada Contado)',
    9:'Solicitud Reenviada',
    10:'Solicitud Cancelada',
    11:'Revisión Referencias',
    12:'Proceso autorizado'
}

$(document).ready(function () {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getBusinessLines",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            businessLines = data;
        },
        error: function (error) {
            console.log(error);
        }
    });

    let objUser = {
        User: document.getElementById("userName").value,
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/SolicitudesConsulta/GetCYCTableShow",
        'type': 'POST',
        'dataType': 'json',
        'data': objUser,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            reloadCycTable(data);
        },
        error: function (error) {
            console.log(error);
        }
    });

    $(function () {
        $("#tableCyc").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $('#inputGroupFile19').change(function (e) {
        var fileName = e.target.files[0].name;
        toBase64Edit(e.target.files[0]);
        $('#label-inputGroupFile19').html(fileName);
    });

    $('#ineValidationFile').change(function (e) {
        var fileN = e.target.files[0].name;
        toBase64IneValidation(e.target.files[0]);
        $('#label-ineValidationFile').html(fileN);
    });
});


const reloadCycTable = (data) => {
    let dataTableCyc = [];
    for (let i = 0; i < data.length; i++) {
        let aux = [];
        aux.push(data[i].claveP);
        aux.push(data[i].razonSocial);
        aux.push(dateFilter(data[i].fechaAlta));
        aux.push(HISTORIALTRANS[data[i].status]);
        aux.push(data[i].zona.description);
        let actions = ``;
        actions += `<div class="btn btn-info btn-circle" title="Validar" onclick="getInfoDetalleSol(` + data[i].folio + `)"><i class="fas fa-exclamation-circle"></i></div>`;
        actions += ` ` + `<div class="btn btn-outline-info btn-circle" title="Historial de Transacciones" onclick="getTransactionHistory(` + data[i].folio + `)"><i class="far fa-clock"></i></div>`;
        if (data[i].isCredit && !data[i].haveReferencesFile)
            actions += ` ` + `<div class="btn btn-outline-primary btn-circle" title="Subir Excel Referencias" onclick="openUpdateFile(` + data[i].folio + `)"><i class="fas fa-upload"></i></div>`;
        if (data[i].haveReferencesFile)
            actions += ` ` + `<div class="btn btn-outline-success btn-circle" title="Bajar Excel Referencias" onclick="getReferencesFile(` + data[i].folio + `)"><i class="fas fa-cloud-download-alt"></i></div>`;
        if (data[i].haveReferencesFile)
            actions += ` ` + `<div class="btn btn-outline-warning btn-circle" title="Reemplazar Excel Referencias" onclick="openUpdateFile(` + data[i].folio + `)"><i class="fas fa-retweet"></i></div>`;
        aux.push(actions);
        dataTableCyc.push(aux);
    }
    $("#tableCyc").dataTable().fnClearTable();
    $("#tableCyc").dataTable().fnDraw();
    $("#tableCyc").dataTable().fnDestroy();
    // console.log(dataTableCyc);
    $("#tableCyc").DataTable({
        "data": dataTableCyc,
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
}

const dateFilter = (date) => {
    let dateIF = date.split('T').map(s => s.trim());
    let aux1 = dateIF[0].split('-').map(s => s.trim());
    let aux2 = dateIF[1].split(':').map(s => s.trim());
    return aux1[2] + "/" + aux1[1] + "/" + aux1[0] + " " + timeFilter(aux2);
}

const timeFilter = (time) => {
    let one = time[0] > 12 ? time[0] - 12 : time[0];
    let ls = time[0] > 12 ? " pm" : " am";
    return one + ":" + time[1] + ":" + time[2].split('.').map(s => s.trim())[0] + ls;
}

const getInfoDetalleSol = (item) => {
    if (item != null) {
        let info = { Item: item };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/getInfoSol",
            'type': 'POST',
            'dataType': 'json',
            'data': info,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (data) {
                $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url': "/MisSolicitudes/getValidationRequest",
                    'type': 'POST',
                    'dataType': 'json',
                    'data': info,
                    'enctype': 'multipart/form-data',
                    'timeout': 2 * 60 * 60 * 1000,
                    success: function (data2) {
                        $.ajax({
                            'headers': {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            'url': "/MisSolicitudes/getValidacionContactos",
                            'type': 'POST',
                            'dataType': 'json',
                            'data': info,
                            'enctype': 'multipart/form-data',
                            'timeout': 2 * 60 * 60 * 1000,
                            success: function (valContac) {
                                $.ajax({
                                    'headers': {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    'url': "/MisSolicitudes/getFiles",
                                    'type': 'POST',
                                    'dataType': 'json',
                                    'data': info,
                                    'enctype': 'multipart/form-data',
                                    'timeout': 2 * 60 * 60 * 1000,
                                    success: function (filesList) {
                                        $.ajax({
                                            'headers': {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            'url': "/MisSolicitudes/getBills",
                                            'type': 'POST',
                                            'dataType': 'json',
                                            'data': info,
                                            'enctype': 'multipart/form-data',
                                            'timeout': 2 * 60 * 60 * 1000,
                                            success: function (factList) {
                                                showInfoModal(data, data2, valContac, filesList, factList);
                                            },
                                            error: function (error) {
                                                console.log(error);
                                            }
                                        });
                                    },
                                    error: function (error) {
                                        console.log(error);
                                    }
                                });
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}


const showInfoModal = (data, data2, valContac, filesList, factList) => {
    document.getElementById("refSection").style.display = "none";
    document.getElementById("crediSection").style.display = "none";
    document.getElementById("pagareSection").style.display = "none";
    document.getElementById("ifeASection").style.display = "none";
    document.getElementById("ifeARSection").style.display = "none";
    document.getElementById("aCSection").style.display = "none";
    document.getElementById("cRSection").style.display = "none";
    document.getElementById("cartSection").style.display = "none";
    document.getElementById("factSection").style.display = "none";
    cleanDetalleSol();
    cleanInfoSol();
    if (data != null) {
        //DATOS HEADER
        document.getElementById("folioInf").innerHTML = data.folio;
        document.getElementById("typeFormInf").innerHTML = data.tipo;
        //DATOS GENERALES
        document.getElementById("rfcEdit").value = data.cliente.datosF.rfc;
        document.getElementById("rfcButtons").innerHTML = getButtons(data2.rfc);

        document.getElementById("rzEdit").value = data.cliente.datosF.razonSocial;
        document.getElementById("rzButtons").innerHTML = getButtons(data2.razonSocial);

        document.getElementById("nomComEdit").value = data.cliente.nombreComercial;
        document.getElementById("nomComButtons").innerHTML = getButtons(data2.nombreComercial);

        document.getElementById("emailFactE").value = data.cliente.datosF.emailFacturacion;

        document.getElementById("csfButtons1").innerHTML = getButtons(data2.constanciaSituacion);
        document.getElementById("csfButtons2").innerHTML = getButtons(data2.constanciaSituacionReverso);
        document.getElementById("picSolButtons").innerHTML = getButtons(data2.firmaSolicitud);

        getAlert("alertDG", data.observations.datosGenerales);
        //DIRECCION FISCAL
        document.getElementById("calleFEdit").value = data.cliente.datosF.domicilio.calle;
        document.getElementById("callFEButtons").innerHTML = getButtons(data2.calle);

        document.getElementById("noFEdit").value = data.cliente.datosF.domicilio.noExt;
        document.getElementById("noFEButtons").innerHTML = getButtons(data2.numeroExterior);

        document.getElementById("noIntFEdit").value = data.cliente.datosF.domicilio.noInt;
        document.getElementById("noIntFEButtons").innerHTML = getButtons(data2.numeroExterior);

        document.getElementById("cityFEdit").value = data.cliente.datosF.domicilio.ciudad;
        document.getElementById("cityFEButtons").innerHTML = getButtons(data2.ciudad);

        document.getElementById("estadoFEdit").value = data.cliente.datosF.domicilio.estado;
        document.getElementById("estadoFEButtons").innerHTML = getButtons(data2.estado);

        document.getElementById("coloniaFEdit").value = data.cliente.datosF.domicilio.colonia;
        document.getElementById("coloniaFEButtons").innerHTML = getButtons(data2.colonia);

        document.getElementById("cpFEdit").value = data.cliente.datosF.domicilio.cp;
        document.getElementById("cpFEButtons").innerHTML = getButtons(data2.cp);

        if (data.tipo == 0) {
            document.getElementById('datFisCD').classList.add('d-none');
        } else {
            document.getElementById('datFisCD').classList.remove('d-none');
            document.getElementById("comDFEButtons").innerHTML = getButtons(data2.comprobanteDomicilio);
        }
        getAlert("alertDF", data.observations.direccionFiscal);

        //DIRECCION DE ENTREGA
        document.getElementById("calleEEdit").value = data.cliente.datosE.domicilio.calle;
        document.getElementById("calleEEButtons").innerHTML = getButtons(data2.calleEntrega);

        document.getElementById("noEEdit").value = data.cliente.datosE.domicilio.noExt;
        document.getElementById("noEEButtons").innerHTML = getButtons(data2.numeroExteriorEntrega);

        document.getElementById("noIntEEdit").value = data.cliente.datosE.domicilio.noInt;
        document.getElementById("noIntEButtons").innerHTML = getButtons(data2.numeroExteriorEntrega);

        document.getElementById("cityEEdit").value = data.cliente.datosE.domicilio.ciudad;
        document.getElementById("cityEEButtons").innerHTML = getButtons(data2.ciudadEntrega);

        document.getElementById("estadoEEdit").value = data.cliente.datosE.domicilio.estado;
        document.getElementById("estadoEEButtons").innerHTML = getButtons(data2.estadoEntrega);

        document.getElementById("coloniaEEdit").value = data.cliente.datosE.domicilio.colonia;
        document.getElementById("coloniaEEButtons").innerHTML = getButtons(data2.coloniaEntrega);

        document.getElementById("cpEEdit").value = data.cliente.datosE.domicilio.cp;
        document.getElementById("cpEEButtons").innerHTML = getButtons(data2.cpEntrega);
        getAlert("alertDE", data.observations.direccionEntrega);

        //NEGOCIO
        document.getElementById("metPagoEdit").value = (data.cliente.metodoPago == "pd") ? "Por Definir" : "Error";
        document.getElementById("metPagoButtons").innerHTML = getButtons(data2.metodoPago);

        tipoNegocio = data.cliente.tipoNegocio;
        document.getElementById("giroEditV").value = getGiro(data.cliente.tipoNegocio);
        // $('#giroEdit').val(data.cliente.tipoNegocio);
        // $('#giroEdit').selectpicker("refresh");
        document.getElementById("giroButtons").innerHTML = getButtons(data2.giroNegocio);

        document.getElementById("antiguedadEdit").value = data.cliente.tiempoConst;
        document.getElementById("antiguedadButtons").innerHTML = getButtons(data2.antiguedad);

        document.getElementById("picNegFButtons").innerHTML = getButtons(data2.fotoFrente);
        document.getElementById("picNegIButtons").innerHTML = getButtons(data2.fotoIzq);
        document.getElementById("picNegDButtons").innerHTML = getButtons(data2.fotoDer);

        getAlert("alertNegocio", data.observations.negocio);
        //DATOS CONTACTO
        var itemsC = "";
        for (var i = 0; i < data.cliente.contactos.length; i++) {
            var nom = getButtons(valContac[0].nombre);
            var tel = getButtons(valContac[0].telefono);
            var cel = getButtons(valContac[0].celular)
            itemsC += `<div class="row mb-3">
                                <div class="col-md-4">Tipo Contacto</div>
                                <div class="col-md-6"><input type="text" value="` + TIPOSCONTACTOS[data.cliente.contactos[i].tipo] + `" name="typeContCEdit` + i + `" id="typeContCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="typeContButtons` + i + `">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Nombre</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].nombre + `" name="nombreCEdit` + i + `" id="nombreCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="nombreCButtons` + i + `">` +
                nom + `
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Telefono</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].phone + `" name="phoneCEdit` + i + `" id="phoneCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="phoneCButtons` + i + `">` +
                tel + `
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Celular</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].celular + `" name="celCEdit` + i + `" id="celCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2" id="celCButtons` + i + `">` +
                cel + `
                                </div>
                            </div>
                            <hr>`;
        }

        document.getElementById("datContactos").innerHTML = itemsC;
        getAlert("alertCont", data.observations.contactoPrincipal);

        if (data.tipo != false) {
            //CREDITO
            document.getElementById("crediSection").style.display = "flex";
            document.getElementById("typeLEdit").value = data.cliente.tipoLocal == true ? "Propio" : "Rentado";
            document.getElementById("typeLButtons").innerHTML = getButtons(data2.tipoLocal);

            document.getElementById("typePEdit").value = data.cliente.tipoPersona == true ? "Moral" : "Fisica";
            document.getElementById("typePButtons").innerHTML = getButtons(data2.tipoPersona);
            document.getElementById("picIFERButtons").innerHTML = getButtons(data2.ineRepresentante);
            document.getElementById("picIFERRButtons").innerHTML = getButtons(data2.ineRepresentanteReverso);
            getAlert("alertCredit", data.observations.credito);

            if (data.cliente.tiempoConst < 2) {
                document.getElementById("pagareSection").style.display = "flex";
                document.getElementById("picPagAButtons").innerHTML = getButtons(data2.pagare);
            }
            if (data.cliente.tiempoConst < 2 || data.tipo == null) {
                document.getElementById("ifeASection").style.display = "flex";
                document.getElementById("ifeARSection").style.display = "flex";
                document.getElementById("picIFEAButtons").innerHTML = getButtons(data2.ineAval);
                document.getElementById("picIFERAButtons").innerHTML = getButtons(data2.ineAvalReverso);
            }

            if (filesList != null) {
                var actaList = filesList.filter(r => r.type == 9 && r.subType != -1).length > 0 ? filesList.filter(r => r.type == 9 && r.subType != -1) : null;
                if (actaList != null) {
                    document.getElementById("aCSection").style.display = "flex";
                    var fileActa = "";
                    for (var i = 0; i < actaList.length; i++) {
                        fileActa += `<div class="row mb-3">
                            <div class="col-md-4">Acta Constitutiva ` + actaList[i].subType + `</div>
                            <div class="col-md-4" id="imgAC` + i + `"> <button class="btn btn-warning" onclick="showIMG('` + actaList[i].fileStr + `')"><i class="far fa-eye"></i> Ver Archivo</button></div>
                            <div class="col-md-4" id="ActCButtons` + i + `">
                            </div>
                        </div>`;
                    }
                    document.getElementById("acRow").innerHTML = fileActa;
                }

                var responsiveList = filesList.filter(x => x.type == 12 && x.subType != -1).length > 0 ? filesList.filter(x => x.type == 12 && x.subType != -1) : null;
                if (responsiveList != null) {
                    document.getElementById("cRSection").style.display = "flex";
                    document.getElementById("cartRButtons").innerHTML = getButtons(data2.cartaResponsiva);
                    getAlert("alertAC", data.observations.actaConstitutiva);
                }
            }

            if (data.referencias.length > 0) {
                document.getElementById("refSection").style.display = "flex";
                var fileRef = "";
                for (var i = 0; i < data.referencias.length; i++) {
                    fileRef += `<div class="row mb-3">
                            <div class="col-md-4">` + data.referencias[i].nombre + `(` + data.referencias[i].city + `)</div>
                            <div class="col-md-4">` + data.referencias[i].phone + `</div>
                            <div class="col-md-4" id="refCheck` + i + `">
                            </div>
                        </div>`;
                }
                document.getElementById("refList").innerHTML = fileRef;
            }

            if (factList.length > 0) {
                document.getElementById("factSection").style.display = "flex";
                let objFactura = ``;
                for (let i = 0; i < factList.length; i++) {
                    objFactura += `<div class="row mb-3">
                            <div class="col-md-3">No. ${(i + 1)} - Importe: ${factList[i].importe}</div>
                            <div class="col-md-3">
                            <button class="btn btn-warning" onclick="showIMG('` + factList[i].fileStr + `')"><i class="far fa-eye"></i> Ver Archivo</button>
                            </div>
                            <div class="col-md-3">
                            <button class="btn btn-warning" onclick="showIMG('` + factList[i].fileTwoStr + `')"><i class="far fa-eye"></i> Ver Archivo</button>
                            </div>
                            <div class="col-md-3">                            
                            </div>
                        </div>`
                }
                document.getElementById("factList").innerHTML = objFactura;
            }
            getAlert("alertRef", data.observations.referencias);
        }
        //CARGAR BOTONES CON IMAGENES
        for (var i = 0; i < filesList.length; i++) {
            switch (filesList[i].type) {
                case 1:
                    getButtonImg("imgCSFButton", filesList[i].fileStr);
                    break;
                case 2:
                    getButtonImg("imgCDButton", filesList[i].fileStr);
                    break;
                case 3:
                    getButtonImg("imgIfeR", filesList[i].fileStr);
                    break;
                case 4:
                    getButtonImg("imgFFN", filesList[i].fileStr);
                    break;
                case 5:
                    getButtonImg("imgFIN", filesList[i].fileStr);
                    break;
                case 6:
                    getButtonImg("imgFDN", filesList[i].fileStr);
                    break;
                case 7:
                    getButtonImg("imgPagA", filesList[i].fileStr);
                    break;
                case 8:
                    getButtonImg("imgIfeA", filesList[i].fileStr);
                    break;
                case 10:
                    document.getElementById("cartSection").style.display = "flex";
                    getButtonImg("imgCara", filesList[i].fileStr);
                    break;
                case 11:
                    getButtonImg("imgCSF2Button", filesList[i].fileStr);
                    break;
                case 12:
                    getButtonImg("imgCR", filesList[i].fileStr);
                    break;
                case 13:
                    getButtonImg("imgFSButton", filesList[i].fileStr);
                    break;
                case 21:
                    getButtonImg("imgCDRButton", filesList[i].fileStr);
                    break;
                case 31:
                    getButtonImg("imgIfeRR", filesList[i].fileStr);
                    break;
                case 81:
                    getButtonImg("imgIfeAR", filesList[i].fileStr);
                    break;
            }
        }
        $('#infoModal').modal('show');
    }
}

const cleanDetalleSol = () => {
    document.getElementById("alertDG").innerHTML = "";
    document.getElementById("alertDF").innerHTML = "";
    document.getElementById("alertDE").innerHTML = "";
    document.getElementById("alertNegocio").innerHTML = "";
    document.getElementById("alertCont").innerHTML = "";
    document.getElementById("alertCredit").innerHTML = "";
    document.getElementById("alertAC").innerHTML = "";
    document.getElementById("alertRef").innerHTML = "";
}

const cleanInfoSol = () => {
    //Credito
    document.getElementById("typeLEdit").value = "";
    document.getElementById("typePEdit").value = "";
    flagCliente = false;
    flagDatosF = false;
    flagDomE = false;
    flagDomF = false;
    //DatosFiscales
    document.getElementById("rfcEdit").disabled = true;
    document.getElementById("rzEdit").disabled = true;
    document.getElementById("nomComEdit").disabled = true;
    //direccion fiscal
    document.getElementById("calleFEdit").disabled = true;
    document.getElementById("noFEdit").disabled = true;
    document.getElementById("noIntFEdit").disabled = true;
    document.getElementById("cityFEdit").disabled = true;
    document.getElementById("estadoFEdit").disabled = true;
    document.getElementById("coloniaFEdit").disabled = true;
    document.getElementById("cpFEdit").disabled = true;
    //Direccion de entrega
    document.getElementById("calleEEdit").disabled = true;
    document.getElementById("noEEdit").disabled = true;
    document.getElementById("noIntEEdit").disabled = true;
    document.getElementById("cityEEdit").disabled = true;
    document.getElementById("estadoEEdit").disabled = true;
    document.getElementById("coloniaEEdit").disabled = true;
    document.getElementById("cpEEdit").disabled = true;
    //Negocio
    document.getElementById("metPagoEdit").disabled = true;
    document.getElementById('giroEdit2').classList.add('d-none');
    document.getElementById('giroEdit1').classList.remove('d-none');

    document.getElementById("antiguedadEdit").disabled = true;
    document.getElementById("typeLEdit").disabled = true;
    document.getElementById("typePEdit").disabled = true;
}

const getButtons = (dato) => {
    var buttons = ``;
    if (dato == null) {
        buttons += `<button class="btn btn-secondary btn-circle float-right"><i class="fas fa-minus"></i></button>`;
    } else if (dato == true) {
        buttons += `<button class="btn btn-success btn-circle float-right"><i class="fas fa-check"></i></button>`;
    } else {
        buttons += `<button class="btn btn-danger btn-circle float-right"><i class="fas fa-times"></i></button>`;
    }
    return buttons;
}

const getGiro = (id) => {
    let giro = businessLines.filter(x => x.id == id);
    return giro.length > 0 ? giro[0].description : "Error en giro";
}

const getAlert = (idAlert, msg) =>{
    if (msg != null && msg != "") {
        document.getElementById(idAlert).innerHTML = `<div class="alert alert-danger" role="alert" >` + msg + `</div>`;
    }
}

const getButtonImg = (idBtn, file) => {
    if (document.getElementById(idBtn))
        document.getElementById(idBtn).innerHTML = `<button class="btn btn-warning" onclick="showIMG('` + file + `')"><i class="far fa-eye"></i> Ver Archivo</button>`;
}

const showIMG = (itemIMG) =>{
    $('#showIMGModal').modal('show');
    var imgen = "data:image/jpg;base64," + itemIMG;
    var img = `<img src="` + imgen + `" alt="imagen muestra" class="imageModal">`
    document.getElementById("showIMGBody").innerHTML = img;
}

const getTransactionHistory = (folio) =>{
    if (folio != null) {
        let data = { Item: folio };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/getTransactionHistory",
            'type': 'POST',
            'dataType': 'json',
            'data': data,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (historyList) {
                showHistoryModal(historyList);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }    
}

const showHistoryModal = (data) => {
    if (data != null) {
        document.getElementById("titleHistory").innerHTML = "Historial de transacciones de la solicitud " + data[0].folioSol;
        let historyList = "";
        for (let i = 0; i < data.length; i++) {
            historyList += `<div class="row mb-3">
                                <div class="col-md-6 text-bold">` + data[i].fecha + `</div>
                                <div class="col-md-6">` + data[i].tipo + `</div>
                            </div>`;
        }
        document.getElementById("historyList").innerHTML = historyList;
        $('#historialModal').modal('show');
    }
}

const openUpdateFile = (item) => {
    fileEdit = '';
    document.getElementById("titleModalEdit").innerHTML = "Agregar Referencias";
    document.getElementById("titlePictureEdit").innerHTML = "Agregar Referencias";
    document.getElementById("label-inputGroupFile19").innerHTML = "Archivo de Referencias";
    // $('#label-inputGroupFile19').html("Archivo de Referencias");
    let buttons = `<button class="btn btn-success btn-circle" onclick="confirmUpdateFile('` + item + `')"><i class="fas fa-paper-plane"></i> Guardar Archivo</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelEditForm()" style="margin-left: 10px;"><i class="fas fa-times"></i> Cancelar Archivo</button>`;
    document.getElementById("editConfirButtons").innerHTML = buttons;
    $('#editImageModal').modal('show');
}

const confirmUpdateFile = (item) => {
    if (fileEdit != '') {
        $('#cargaModal').modal('show');
        let json = {
            Folio: item,
            File: {
                Id: 0,
                FileStr: fileEdit,
                Type: 14,
                Subtype: null,
            }
        }
        setFile(json);
    } else {
        console.log(fileEdit);
        alert("Seleccione un archivo");
    }
}

const setFile = (json) => {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "MisSolicitudes/UpdateFile",
        'type': 'POST',
        'dataType': 'json',
        'data': json,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            if (Number.isInteger(data)) {
                $('#cargaModal').modal('hide');
                document.getElementById("editConfirButtons").innerHTML = "Archivo Actualizado";
                $('#infoModal').modal('hide');
                realoadTableView();
            } else {
                console.log(data);
                alert("Ocurrió un problema en el servidor, informar a adan.perez@indar.com.mx");
                $('#cargaModal').modal('hide');
            }
        },
        error: function (error) {
            console.log(error);
            alert("Error de solicitud, enviar correo a adan.perez@indar.com.mx");
            $('#cargaModal').modal('hide');
        }
    });
}

const cancelEditForm = () =>{
    $('#editImageModal').modal('hide');
}

const getReferencesFile = (folio) => {
    let json = {
        Folio: folio,
        Type: 14
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/SolicitudesPendientes/getFile",
        'type': 'POST',
        'dataType': 'json',
        'data': json,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (result) {
            const blob = new Blob([s2ab(atob(result.fileStr))], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const url = URL.createObjectURL(blob);
            const enlace = document.createElement("a");
            enlace.href = url;
            enlace.download = "ReferenciasNo_"+folio+".xlsx";
            enlace.click();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

const s2ab = (s) =>{
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i != s.length; ++i) { view[i] = s.charCodeAt(i) & 0xFF; }
    return buf;
}