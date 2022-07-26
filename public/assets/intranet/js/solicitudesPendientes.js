var cobUsernamesList = [];
var solicitudesList = [];
var businessLines = [];

//Contadores Objetos
var contactosCount = 0;
var referenciasCount = 0;
var actaConstCount = 0;
var facturasCount = 0;
var cartaResponsivaCount = 0;
var caratulaCount = 0;
var permiso = '';


var fileEdit = '';

//Flags
var isSameAddrs = false;

//objValidacion
var valSolicitud = [];
var valContactos = [];
var valActaConst = [];
var valReferences = [];
var valFacturasList = [];
var valObser = [];

//INE validation
var fileIneValidation = '';

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

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/SolicitudesPendientes/GetCustomerCatalogs",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            addSelectListItems(data.shippingWays, "#shippingWaySelect");
            addSelectListItems(data.commercialTerms, "#commercialTermsSelect");
            addSelectListItems(data.priceList, "#priceListSelect");
            addSelectListItems(data.saleRoutes, "#saleRoutesSelect");
            addSelectListItems(data.routes, "#routeSelect");
            addSelectListItems(data.paqueteria, "#paqueteriaSelect");
            addSelectListItems(data.shippingWays, "#shippingWaySelect2");
            addSelectListItems(data.paqueteria, "#paqueteriaSelect2");
            addSelectListItems(data.shippingWays, "#shippingWaySelect3");
            //AcceptCredit

            addSelectListItems(data.shippingWays, "#shippingWaySelectCredit");
            addSelectListItems(data.paymentTerms, "#commercialPaySelectCredit");
            addSelectListItems(data.priceList, "#priceListSelectCredit");
        },
        error: function (error) {
            console.log(error);
        }
    });

    if (document.getElementById("userP").value != "CYC") {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/GetCobUsernames",
            'type': 'GET',
            'dataType': 'json',
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (data) {
                cobUsernamesList = data;
                let itemSelectorOption = $('#inputGroupSelect01 option');
                itemSelectorOption.remove();
                $('#inputGroupSelect01').selectpicker('refresh');
                $('#inputGroupSelect01').append('<option value="-1">Selecciona un opcion</option>'); //Agregar Primera opción de inputGroupSelect01 en Blanco
                for (let x = 0; x < cobUsernamesList.length; x++) {
                    $('#inputGroupSelect01').append('<option value="' + cobUsernamesList[x]['id'] + '">' + cobUsernamesList[x]['nombre'] + '</option>');
                    $('#inputGroupSelect01').val(cobUsernamesList[x]['id']);
                    $('#inputGroupSelect01').selectpicker("refresh");
                }

                $('#inputGroupSelect01').val('-1');
                $('#inputGroupSelect01').selectpicker("refresh");

            },
            error: function (error) {
                console.log(error);
                alert("Error de Emails, enviar correo a adan.perez@indar.com.mx");
            }
        });
    }
    // else {
    //     getSolicitudesPendientes(document.getElementById("userName").value);
    // }

    if (document.getElementById("userP").value == "CYC") {
        let objUser = {
            User: document.getElementById("userName").value,
        }
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/GetCycTableView",
            'type': 'POST',
            // 'async': false,
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
    }

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

const addSelectListItems = (data, idItem) => {
    let itemSelectorOption = $(idItem + ' option');
    itemSelectorOption.remove(); -
        $(idItem).selectpicker('refresh');
    $(idItem).append('<option value="-1">Selecciona un opcion</option>');
    for (let i = 0; i < data.length; i++) {
        $(idItem).append('<option value="' + data[i]['listId'] + '">' + data[i]['listItemName'] + '</option>');
        $(idItem).val(data[i]['listId']);
        $(idItem).selectpicker("refresh");
    }
    $(idItem).val('-1');
    $(idItem).selectpicker("refresh");
}

const getSolicitudesPendientes = (user) => {
    let objUser = {
        User: user
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/SolicitudesPendientes/GetCycTableView",
        'type': 'POST',
        // 'async': false,
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
}

const reloadCycTable = (data) => {
    let dataTableCyc = [];
    for (let i = 0; i < data.length; i++) {
        let aux = [];
        aux.push(data[i].claveP);
        aux.push(data[i].razonSocial);
        // aux.push(getDateF(data[i].fechaAlta) + " (" + getTimeOfDate(data[i].fechaAlta)+")");
        aux.push(getDateF(data[i].fechaAlta) + "<span class='text-danger'> (" + getTimeOfDate(data[i].fechaAlta) + ")</span>");
        aux.push(data[i].zona.description);
        let folioRfc = "'" + data[i].folio + "-" + data[i].rfc + "'";
        let actions = ``;
        if (data[i].tipo == "A")
            actions += `<div class="btn btn-success btn-circle" title="Validar" onclick="showInfoSol(` + data[i].folio + `)"><i class="fas fa-check"></i></div>`;
        else if (data[i].tipo == "B")
            actions += `<div class="btn btn-success btn-circle" title="Validar" onclick="showReferences(` + data[i].folio + `)"><i class="fas fa-check"></i></div>`;
        else if (data[i].tipo == "C")
            actions += `<div class="btn btn-success btn-circle" title="Validar" onclick="showAllSol(` + data[i].folio + `)"><i class="fas fa-check"></i></div>`;
        if (data[i].status != 4 && data[i].status != 5 && !data[i].wasCash)
            actions += ` ` + `<div class="btn btn-warning btn-circle" title="Aceptar Contado" onclick="acceptForCash(` + data[i].folio + `)"><i class="fas fa-dollar-sign"></i></div>`;
        let historyButton = `<div class="btn btn-info btn-circle" title="Historial de Transacciones" onclick="getTransactionHistory(` + data[i].folio + `)"><i class="far fa-clock"></i></div>`;
        actions += ` ` + historyButton;

        if (data[i].isOnIntelisis)
            actions += ` ` + `<div class="btn btn-danger btn-circle" title="Reactivación" onclick="showReact(` + folioRfc + `)"><i class="fas fa-skull"></i></div>`;
        if (data[i].isOnIntelisis && data[i].isCredit)
            actions += ` ` + `<div class="btn btn-outline-info btn-circle" title="Agregar Validación de INE" onclick="openUpdateIne(` + data[i].folio + `)"><i class="fas fa-id-card"></i></div>`;
        if (data[i].status == 11 || data[i].status == 12)
            actions += ` ` + `<div class="btn btn-secondary btn-circle" title="Regresar Solicitud" onclick="rollbackSol(` + data[i].folio + `)"><i class="fas fa-undo"></i></div>`;
        if (data[i].isCredit && !data[i].haveReferencesFile && data[i].status == 11)
            actions += ` ` + `<div class="btn btn-outline-primary btn-circle" title="Subir Excel Referencias" onclick="openUpdateFile(` + data[i].folio + `)"><i class="fas fa-upload"></i></div>`;
        if (data[i].haveReferencesFile && (data[i].status == 11 || data[i].status == 12))
            actions += ` ` + `<div class="btn btn-outline-success btn-circle" title="Bajar Excel Referencias" onclick="getReferencesFile(` + data[i].folio + `)"><i class="fas fa-cloud-download-alt"></i></div>`;
        if (data[i].haveReferencesFile && data[i].status == 11)
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

const getDateF = (date) => {
    let auxD = date.split('T')[0].split('-');
    let auxT = date.split('T')[1].split('.')[0].split(':');
    return auxD[0] + "/" + auxD[1] + "/" + auxD[2] + " " + timeFilter(auxT);
}

const timeFilter = (time) => {
    let ls = time[0] > 12 ? " pm" : " am";
    return time[0] + ":" + time[1] + ls;
}

const getTimeOfDate = (date) => {
    let dateRequest = +new Date(date);
    let dateNow = +new Date();
    let diff = (dateNow - dateRequest) / 3600000;
    let hours = Math.floor(diff);
    let min = Math.floor((diff - hours) * 60);
    return hours + ' Hrs ' + min + ' min';
}

const showInfoSol = (folio) => {
    let solObj = { Item: folio };
    getInfoSol(solObj, "A");
}

const showAllSol = (folio) => {
    let solObj = { Item: folio };
    getInfoSol(solObj, "C");
}

const showReferences = (folio) => {
    let solObj = { Item: folio };
    getInfoSol(solObj, "B");
}

const getInfoSol = (solObj, typeCyC) => {
    $('#cargaModal').modal('show');
    if (solObj != null) {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/MisSolicitudes/getInfoSol",
            'type': 'POST',
            'dataType': 'json',
            'data': solObj,
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
                    'data': solObj,
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
                            'data': solObj,
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
                                    'data': solObj,
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
                                            'data': solObj,
                                            'enctype': 'multipart/form-data',
                                            'timeout': 2 * 60 * 60 * 1000,
                                            success: function (factList) {
                                                showInfoModal(data, data2, valContac, filesList, factList, typeCyC);
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

document.getElementById("shippingWaySelect").addEventListener("change", function (e) {
    let val = e.target.value;
    $('#shippingWaySelect2').val(val);
    $('#shippingWaySelect2').selectpicker("refresh");
});


document.getElementById("inputGroupSelect01").addEventListener("change", function (e) {
    getSolicitudesPendientes(e.target.value);
});

function showInfoModal(data, data2, valContac, filesList, factList, typeCyC) {
    $('#cargaModal').modal('hide');
    valSolicitud = data2;
    valContactos = valContac;
    valObser = data.observations;
    valActaConst = null;
    valReferences = null;
    valFacturasList = null;

    caratulaCount = 0;
    facturasCount = 0;
    cartaResponsivaCount = 0;
    actaConstCount = 0;
    referenciasCount = 0;
    clearTextArea();
    permiso = typeCyC;
    document.getElementById("crediSection").style.display = "none";
    document.getElementById("pagareSection").style.display = "none";
    document.getElementById("ifeASection").style.display = "none";
    document.getElementById("ifeARSection").style.display = "none";
    document.getElementById("aCSection").style.display = "none";
    document.getElementById("cartaRespRef").style.display = "none";
    document.getElementById("cartSection").style.display = "none";
    document.getElementById("refSection").style.display = "none";
    document.getElementById("factSection").style.display = "none";
    document.getElementById("observRef").style.display = "none";
    document.getElementById("showIneValidationSection").style.display = "none";
    document.getElementById("moneySolT").hidden = true;
    document.getElementById("moneySol").innerHTML = "";

    // document.getElementById("datosGeneralesSection").style.display = "none";
    document.getElementById("direccionFiscalSection").style.display = "none";
    document.getElementById("direccionEntregaSection").style.display = "none";
    document.getElementById("NegocioSection").style.display = "none";
    document.getElementById("ContactoSection").style.display = "none";
    document.getElementById("crediSection").style.display = "none";

    // cleanInfoSol();
    if (data != null) {
        //DATOS HEADER
        document.getElementById("folioInf").innerHTML = data.folio;
        document.getElementById("folAcceptCredit").innerHTML = data.folio;
        document.getElementById("typeFormInf").value = data.tipo != null ? data.tipo : "X";
        document.getElementById("typeSol").innerHTML = getTypeSol(data.tipo);
        document.getElementById("typeSolAcceptCredit").innerHTML = getTypeSol(data.tipo);
        document.getElementById("zonaSol").innerHTML = data.zona.description;

        getValidationRadio("constData", "constData2", data2.constanciaSituacion);
        getValidationRadio("const2Data", "const2Data2", data2.constanciaSituacionReverso);
        getValidationRadio("picSolData", "picSolData2", data2.firmaSolicitud);
        setAlert("obsDatGen", data.observations.datosGenerales);
        if (typeCyC != "B") {
            //DATOS GENERALES
            document.getElementById("sectionDGOne").style.display = "flex";
            document.getElementById("rfcEdit").value = data.cliente.datosF.rfc;
            getValidationRadio("rfcData", "rfcData2", data2.rfc);

            document.getElementById("rzEdit").value = data.cliente.datosF.razonSocial;
            getValidationRadio("razData", "razData2", data2.razonSocial);

            document.getElementById("nomComEdit").value = data.cliente.nombreComercial;
            getValidationRadio("nomComData", "nomComData2", data2.nombreComercial);

            document.getElementById("emailFactE").value = data.cliente.datosF.emailFacturacion;
            // getValidationRadio("emailFData", "emailFData2", data2.razonSocial);

            // getValidationRadio("constData", "constData2", data2.constanciaSituacion);
            // getValidationRadio("const2Data", "const2Data2", data2.constanciaSituacionReverso);
            // getValidationRadio("picSolData", "picSolData2", data2.firmaSolicitud);
            // setAlert("obsDatGen", data.observations.datosGenerales);

            // //DIRECCION FISCAL
            document.getElementById("direccionFiscalSection").style.display = "flex";
            document.getElementById("calleFEdit").value = data.cliente.datosF.domicilio.calle;
            getValidationRadio("dirCalleData", "dirCalleData2", data2.calle);

            document.getElementById("noFEdit").value = data.cliente.datosF.domicilio.noExt;
            getValidationRadio("dirNoData", "dirNoData2", data2.numeroExterior);

            document.getElementById("noIntFEdit").value = data.cliente.datosF.domicilio.noInt;
            getValidationRadio("dirNoIntData", "dirNoIntData2", data2.numeroInterior);

            document.getElementById("cityFEdit").value = data.cliente.datosF.domicilio.ciudad;
            getValidationRadio("dirCityData", "dirCityData2", data2.ciudad);

            document.getElementById("estadoFEdit").value = data.cliente.datosF.domicilio.estado;
            getValidationRadio("dirEstData", "dirEstData2", data2.estado);

            document.getElementById("coloniaFEdit").value = data.cliente.datosF.domicilio.colonia;
            getValidationRadio("dirColData", "dirColData2", data2.colonia);

            document.getElementById("cpFEdit").value = data.cliente.datosF.domicilio.cp;
            getValidationRadio("dirCpData", "dirCpData2", data2.cp);

            if (data.tipo == 0) {
                document.getElementById('datFisCD').classList.add('d-none');
            } else {
                document.getElementById('datFisCD').classList.remove('d-none');
                getValidationRadio("dirDomData", "dirDomData2", data2.comprobanteDomicilio);
            }
            setAlert("obsFiscal", data.observations.direccionFiscal);

            //DIRECCION DE ENTREGA
            if (!isSameAddress(data.cliente.datosF.domicilio, data.cliente.datosE.domicilio)) {
                isSameAddrs = false;
                document.getElementById("direccionEntregaSection").style.display = "flex";
                document.getElementById("calleEEdit").value = data.cliente.datosE.domicilio.calle;
                getValidationRadio("dirEntData", "dirEntData2", data2.calleEntrega);

                document.getElementById("noEEdit").value = data.cliente.datosE.domicilio.noExt;
                getValidationRadio("dirEntNoData", "dirEntNoData2", data2.numeroExteriorEntrega);

                document.getElementById("noIntEEdit").value = data.cliente.datosE.domicilio.noInt;
                getValidationRadio("dirEntNoIntData", "dirEntNoIntData2", data2.numeroInteriorEntrega);

                document.getElementById("cityEEdit").value = data.cliente.datosE.domicilio.ciudad;
                getValidationRadio("entCityData", "entCityData2", data2.ciudadEntrega);

                document.getElementById("estadoEEdit").value = data.cliente.datosE.domicilio.estado;
                getValidationRadio("entEstData", "entEstData2", data2.estadoEntrega);

                document.getElementById("coloniaEEdit").value = data.cliente.datosE.domicilio.colonia;
                getValidationRadio("entColData", "entColData2", data2.coloniaEntrega);

                document.getElementById("cpEEdit").value = data.cliente.datosE.domicilio.cp;
                getValidationRadio("entCpData", "entCpData2", data2.cpEntrega);
                setAlert("obsEntrea", data.observations.direccionEntrga);
            } else {
                isSameAddrs = true;
            }


            // //NEGOCIO
            document.getElementById("NegocioSection").style.display = "flex";
            document.getElementById("metPagoEdit").value = (data.cliente.metodoPago == "pd") ? "Por Definir" : "Error";
            getValidationRadio("negPagData", "negPagData2", data2.metodoPago);

            document.getElementById("giroEdit").value = getGiro(data.cliente.tipoNegocio);
            getValidationRadio("negiroData", "negiroData2", data2.giroNegocio);

            document.getElementById("antiguedadEdit").value = data.cliente.tiempoConst;
            getValidationRadio("negAntData", "negAntData2", data2.antiguedad);

            getValidationRadio("negFotData", "negFotData2", data2.fotoFrente);
            getValidationRadio("negIzqData", "negIzqData2", data2.fotoIzq);
            getValidationRadio("negDerData", "negDerData2", data2.fotoDer);
            setAlert("obsNegocio", data.observations.negocio);

            // //DATOS CONTACTO
            document.getElementById("ContactoSection").style.display = "flex";
            let itemsC = "";
            for (let i = 0; i < data.cliente.contactos.length; i++) {
                itemsC += `<div class="row mb-3">
                                <div class="col-md-4">Tipo Contacto</div>
                                <div class="col-md-6"><input type="text" value="` + getTypeCont(data.cliente.contactos[i].tipo) + `" name="typeContCEdit` + i + `" id="typeContCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Nombre</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].nombre + `" name="nombreCEdit` + i + `" id="nombreCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2">
                                    <label class="mr-3 text-green"><input type="radio" name="contactName` + i + `" value="Aceptado" id="contactName` + i + `">SI</label>
                                    <label class="mr-3 text-red"><input type="radio" name="contactName` + i + `" value="Rechazado" id="contactName2` + i + `">NO</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Telefono</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].phone + `" name="phoneCEdit` + i + `" id="phoneCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2">
                                    <label class="mr-3 text-green"><input type="radio" name="contactPhone` + i + `" value="Aceptado" id="contactPhone` + i + `">SI</label>
                                    <label class="mr-3 text-red"><input type="radio" name="contactPhone` + i + `" value="Rechazado" id="contactPhone2` + i + `">NO</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">Celular</div>
                                <div class="col-md-6"><input type="text" value="` + data.cliente.contactos[i].celular + `" name="celCEdit` + i + `" id="celCEdit` + i + `" disabled class="form-control"></div>
                                <div class="col-md-2">
                                    <label class="mr-3 text-green"><input type="radio" name="contactCell` + i + `" value="Aceptado" id="contactCell` + i + `">SI</label>
                                    <label class="mr-3 text-red"><input type="radio" name="contactCell` + i + `" value="Rechazado" id="contactCell2` + i + `">NO</label>
                                </div>
                            </div>
                            <hr>`;
            }

            document.getElementById("datContactos").innerHTML = itemsC;
            for (let i = 0; i < valContac.length; i++) {
                getValidationRadio("contactName" + i, "contactName2" + i, valContac[i].nombre);
                getValidationRadio("contactPhone" + i, "contactPhone2" + i, valContac[i].telefono);
                getValidationRadio("contactCell" + i, "contactCell2" + i, valContac[i].celular);
            }
            setAlert("obsContacto", data.observations.contactoPrincipal);

            if (data.tipo != false) {
                document.getElementById("moneySol").innerHTML = `$${data.credito}`;
                document.getElementById("moneySolT").hidden = false;
                // CREDITO
                document.getElementById("crediSection").style.display = "flex";
                document.getElementById("typeLEdit").value = data.cliente.tipoLocal == true ? "Propio" : "Rentado";
                getValidationRadio("credLocData", "credLocData2", data2.tipoLocal);

                document.getElementById("typePEdit").value = data.cliente.tipoPersona == true ? "Moral" : "Fisica";
                getValidationRadio("credTypeData", "credTypeData2", data2.tipoPersona);

                getValidationRadio("credRepData", "credRepData2", data2.ineRepresentante);
                getValidationRadio("credRepRevData", "credRepRevData2", data2.ineRepresentanteReverso);
                setAlert("obsCredito", data.observations.credito);

                if (data.cliente.tiempoConst < 2) {
                    document.getElementById("pagareSection").style.display = "flex";
                    getValidationRadio("credPagData", "credPagData2", data2.pagare);
                }
                if (data.cliente.tiempoConst < 2 || data.tipo == null) {
                    document.getElementById("ifeASection").style.display = "flex";
                    document.getElementById("ifeARSection").style.display = "flex";
                    getValidationRadio("credIneData", "credIneData2", data2.ineAval);
                    getValidationRadio("credRevData", "credRevData2", data2.ineAvalReverso);
                } else {
                    document.getElementById("pagareSection").style.display = "none";
                    document.getElementById("ifeASection").style.display = "none";
                    document.getElementById("ifeARSection").style.display = "none";
                }
                if (filesList != null) {
                    let actaList = filesList.filter(r => r.type == 9 && r.subType != -1).length > 0 ? filesList.filter(r => r.type == 9 && r.subType != -1) : null;
                    if (actaList != null) {
                        document.getElementById("aCSection").style.display = "flex";
                        let fileActa = "";
                        actaConstCount = actaList.length;
                        for (let i = 0; i < actaList.length; i++) {
                            fileActa += `<div class="row mb-3">
                                <div class="col-md-4">Acta Constitutiva ` + actaList[i].subType + `</div>
                                <div class="col-md-6" id="imgAC` + i + `"> <button class="btn btn-warning" onclick="showIMG('` + actaList[i].fileStr + `')"><i class="far fa-eye"></i> Ver Archivo</button></div>
                                <div class="col-md-2">
                                <label class="mr-3 text-green"><input type="radio" name="actaConstId` + i + `" value="Aceptado" id="actaConstId` + i + `">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="actaConstId` + i + `" value="Rechazado" id="actaConstId2` + i + `">NO</label>
                                </div>
                            </div>`;
                        }
                        document.getElementById("acRow").innerHTML = fileActa;
                        getvalidacionActa(data.folio);
                        // valActaConst = getvalidacionActa(data.folio);
                        // console.log(valActaConst);
                        // for (let i = 0; i < valActaConst.length; i++) {
                        //     getValidationRadio("actaConstId" + i, "actaConstId2" + i, valActaConst[i].archivo);
                        // }
                        setAlert("obsActaConst", data.observations.actaConstitutiva);
                    }
                }
            }
        } else {
            document.getElementById("sectionDGOne").style.display = "none";
        }
        if (data.tipo != false && typeCyC != "A") {
            document.getElementById("moneySol").innerHTML = `$${data.credito}`;
            document.getElementById("moneySolT").hidden = false;
            document.getElementById("observRef").style.display = "flex";
            setAlert("obsReferencias", data.observations.referencias);
            if (filesList != null) {
                let responsiveList = filesList.filter(x => x.type == 12 && x.subType != -1).length > 0 ? filesList.filter(x => x.type == 12 && x.subType != -1) : null;
                if (responsiveList != null) {
                    cartaResponsivaCount = 1;
                    document.getElementById("cartaRespRef").style.display = "flex";
                    getValidationRadio("picCRRef", "picCRRef2", data2.cartaResponsiva);
                }
            }
            if (data.referencias.length > 0) {
                document.getElementById("refSection").style.display = "flex";
                let fileRef = "";
                referenciasCount = data.referencias.length;
                for (let i = 0; i < data.referencias.length; i++) {
                    fileRef += `<div class="row mb-3">
                            <div class="col-md-6">` + data.referencias[i].nombre + `<span style="color: #b8b6b5;"> (` + data.referencias[i].city + `)</span> "${data.referencias[i].celular}"</div>
                            <div class="col-md-4">` + data.referencias[i].phone + `</div>
                            <div class="col-md-2">
                                <label class="mr-3 text-green"><input type="radio" name="refStel` + i + `" value="Aceptado" id="refSectionR` + i + `">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="refStel` + i + `" value="Rechazado" id="refSectionR2` + i + `">NO</label>
                                </div>
                        </div>`;
                }
                document.getElementById("refList").innerHTML = fileRef;
                getValidacionReferencias(data.folio);
                // valReferences = getValidacionReferencias(data.folio);
                // for (let i = 0; i < valReferences.length; i++) {
                //     getValidationRadio("refSectionR" + i, "refSectionR2" + i, valReferences[i].telefono);
                // }
            }
            if (factList.length > 0) {
                document.getElementById("factSection").style.display = "flex";
                let objFactura = ``;
                facturasCount = factList.length;
                let totalFacturas = 0;
                for (let i = 0; i < factList.length; i++) {
                    totalFacturas += factList[i].importe;
                    objFactura += `<div class="row mb-3">
                            <div class="col-md-3">No. ${(i + 1)} - Importe: ${factList[i].importe}</div>
                            <div class="col-md-3">
                            <button class="btn btn-warning" onclick="showIMG('` + factList[i].fileStr + `')"><i class="far fa-eye"></i> Ver Archivo</button>
                            </div>
                            <div class="col-md-3">
                            <button class="btn btn-warning" onclick="showIMG('` + factList[i].fileTwoStr + `')"><i class="far fa-eye"></i> Ver Archivo</button>
                            </div>
                            <div class="col-md-3">
                                <label class="mr-3 text-green"><input type="radio" name="factRefId` + i + `" value="Aceptado" id="factRefId` + i + `">SI</label>
                                <label class="mr-3 text-red"><input type="radio" name="factRefId` + i + `" value="Rechazado" id="factRefId2` + i + `">NO</label>
                                </div>
                        </div>`;
                }
                document.getElementById("factList").innerHTML = objFactura;
                getValidacionFactura(data.folio);
                // valFacturasList = getValidacionFactura(data.folio);
                // console.log(valFacturasList);
                // for (let i = 0; i < valFacturasList.length; i++) {
                //     getValidationRadio("factRefId" + i, "factRefId2" + i, valFacturasList[i].archivo);
                // }
                document.getElementById("totalFacturas").innerHTML = `<div class="col-md-3"> Total de Facturas $${totalFacturas}</div>`;
            }
            // getAlert("alertRef", data.observations.referencias);
        }
        // //CARGAR BOTONES CON IMAGENES        
        for (let i = 0; i < filesList.length; i++) {
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
                    if (typeCyC != "A") {
                        caratulaCount = 1;
                        document.getElementById("cartSection").style.display = "flex";
                        getValidationRadio("picCaratulaRef", "picCaratulaRef2", data2.caratula);
                        getButtonImg("imgCaraRef", filesList[i].fileStr);
                    }
                    break;
                case 11:
                    getButtonImg("imgCSF2Button", filesList[i].fileStr);
                    break;
                case 12:
                    getButtonImg("imgCRRef", filesList[i].fileStr);
                    break;
                case 13:
                    getButtonImg("imgFSButton", filesList[i].fileStr);
                    break;
                case 15:
                    document.getElementById("showIneValidationSection").style.display = "flex";
                    getButtonImg("imgIneVal", filesList[i].fileStr);
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
        if (typeCyC != "C") {
            document.getElementById("acceptOne").style.display = "flex";
            document.getElementById("acceptTwo").style.display = "none";
        } else {
            document.getElementById("acceptOne").style.display = "none";
            document.getElementById("acceptTwo").style.display = "flex";
        }
        if (data.tipo == 0) {
            document.getElementById("acceptOne").style.display = "none";
        }
        $('#infoModal').modal('show');
    }
}

function setAlert(idAlert, msg) {
    if (msg != null && msg != "") {
        document.getElementById(idAlert).value = msg;
    }
}

function getButtonImg(idBtn, file) {
    if (document.getElementById(idBtn))
        document.getElementById(idBtn).innerHTML = `<button class="btn btn-warning" onclick="showIMG('` + file + `')"><i class="far fa-eye"></i> Ver Archivo</button>`;
}

function showIMG(itemIMG) {
    penNewWindow("data:image/jpg;base64," + itemIMG, "600px", "360px");
}

function penNewWindow(bigurl, width, height) {
    const newWindow = window.open("", "pictureViewer",
        "location=no, directories=no, fullscreen=no, " +
        "menubar=no, status=no, toolbar=no, width=" +
        width + ", height=" + height + ", scrollbars=no");
    newWindow.document.writeln("<html>");
    newWindow.document.writeln("<body style='margin: 5px 5px 5px 5px;'>");
    newWindow.document.writeln("<img src='" + bigurl +
        "' alt='Click to close' id='bigImage' style='width: 100%'/>");
    newWindow.document.writeln("</body></html>");
}

function getTypeSol(id) {
    let tipo = "";
    switch (id) {
        case 0:
            tipo = "Contado";
            break;
        case 1:
            tipo = "Credito";
            break;
        case 2:
            tipo = "Credito AB";
            break;
        case null:
            tipo = "Carta Responsiva";
            break;
    }
    return tipo;
}

function getTypeCont(id) {
    let typeCont = "";
    switch (id) {
        case 1:
            typeCont = "Principal";
            break;
        case 2:
            typeCont = "Pagos";
            break;
        case 3:
            typeCont = "Compras";
            break;
        case 4:
            typeCont = "Admon";
            break;
        case 5:
            typeCont = "Emergencia";
            break;
        default:
            typeCont = "ERROR";
    }
    return typeCont;
}

function getGiro(id) {
    let giro = businessLines.filter(x => x.id == id);
    return giro.length > 0 ? giro[0].description : "Error en giro";
}

function clearTextArea() {
    document.getElementById("obsDatGen").value = "";
    document.getElementById("obsFiscal").value = "";
    document.getElementById("obsEntrea").value = "";
    document.getElementById("obsNegocio").value = "";
    document.getElementById("obsContacto").value = "";
    document.getElementById("obsCredito").value = "";
    document.getElementById("obsActaConst").value = "";
    document.getElementById("obsReferencias").value = "";
}

function getValidationRadio(id1, id2, flag) {
    if (flag != null)
        flag ? document.getElementById(id1).checked = true : document.getElementById(id2).checked = true;
    else {
        document.getElementById(id1).checked = false;
        document.getElementById(id2).checked = false;
    }
}

function getTransactionHistory(folio) {
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
    $('#historialModal').modal('show');
}


function showHistoryModal(data) {
    if (data != null) {
        document.getElementById("titleHistory").innerHTML = "Historial de transacciones de la solicitud " + data[0].folioSol;
        let historyList = "";
        for (let i = 0; i < data.length; i++) {
            historyList += `<div class="row mb-3">
                                <div class="col-md-6 text-bold">` + getDateF(data[i].fecha) + `</div>
                                <div class="col-md-6">` + data[i].tipo + `</div>
                            </div>`;
        }
        document.getElementById("historyList").innerHTML = historyList;
        $('#historialModal').modal('show');
    }
}

function acceptForCash(folio) {
    let solObj = { Item: folio };
    document.getElementById("folAcceptCash").innerHTML = folio;
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getInfoSol",
        'type': 'POST',
        'dataType': 'json',
        'data': solObj,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (response) {
            showModalAcceptForCash(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function showModalAcceptForCash(item) {
    clearModalAcceptCredit();
    document.getElementById("typeSolAccept").innerHTML = getTypeSol(item.tipo);
    document.getElementById("typeSolCash").value = item.tipo != null ? item.tipo : "X";
    if (item.tipo != 0)
        document.getElementById("ineValidationSection").style.display = "flex";
    else
        document.getElementById("ineValidationSection").style.display = "none";
    let auxAddr = item.cliente.datosF.domicilio;
    // console.log(auxAddr);
    let noInt = auxAddr.NoInt == null ? '' : `Int. ${auxAddr.noInt}`;
    let address = `${auxAddr.calle} #${auxAddr.noExt} ${noInt}, ${auxAddr.colonia}, ${auxAddr.ciudad}, ${auxAddr.estado}, C.P. ${auxAddr.cp}`;
    // console.log(address);
    document.getElementById("dirF1").innerHTML = address;
    document.getElementById("dirF2").innerHTML = address;
    if (!isSameAddress(item.cliente.datosF.domicilio, item.cliente.datosE.domicilio)) {
        document.getElementById("sameDir").value = false;
        let auxAddrE = item.cliente.datosE.domicilio;
        let addressE = `${auxAddrE.calle} #${auxAddrE.noExt} ${auxAddrE.noInt != null ? 'Int. # ' + auxAddrE.noInt : ''}, ${auxAddrE.colonia}, ${auxAddrE.ciudad}, ${auxAddrE.estado}, C.P. ${auxAddrE.cp}`;
        document.getElementById("addresEntrega").style.display = "flex";
        document.getElementById("dirE").innerHTML = addressE;
    } else {
        document.getElementById("sameDir").value = true;
        document.getElementById("addresEntrega").style.display = "none";
    }

    $('#acceptForCashModal').modal('show');
}

function toBase64Edit(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (subtype) {
        fileEdit = reader.result.split(',')[1];
        // fileEdit = result;
    };
    reader.onerror = function (error) {
        return "Error"
    };
}

function toBase64IneValidation(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (subtype) {
        fileIneValidation = reader.result.split(',')[1];
    };
    reader.onerror = function (error) {
        return "Error"
    };
}

function isSameAddress(addr1, addr2) {
    if (addr1.calle == addr2.calle && addr1.cp == addr2.cp && addr1.colonia == addr2.colonia && addr1.noExt == addr2.noExt)
        return true;
    else return false;
}

function getvalidacionActa(folio) {
    let objFolio = { Item: folio };
    // let info = [];
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/getValidacionActConst",
        'type': 'POST',
        // 'async': false,
        'dataType': 'json',
        'data': objFolio,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            valActaConst = data;
            if (valActaConst != null) {
                for (let i = 0; i < valActaConst.length; i++) {
                    getValidationRadio("actaConstId" + i, "actaConstId2" + i, valActaConst[i].archivo);
                }
            } else {
                console.log("Ocurrio un problema en Val ActaConst");
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function getValidacionFactura(folio) {
    let objFolio = { Item: folio };
    // let info = [];
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/GetValidacionFacturas",
        'type': 'POST',
        // 'async': false,
        'dataType': 'json',
        'data': objFolio,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            valFacturasList = data;
            if (valFacturasList != null) {
                for (let i = 0; i < valFacturasList.length; i++) {
                    getValidationRadio("factRefId" + i, "factRefId2" + i, valFacturasList[i].archivo);
                }
            } else
                console.log("Error en validación facturas");
        },
        error: function (error) {
            console.log(error);
        }
    });
    // return info;
}

function getValidacionReferencias(folio) {
    let objFolio = { Item: folio };
    let info = [];
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/MisSolicitudes/GetValidacionReferencias",
        'type': 'POST',
        // 'async': false,
        'dataType': 'json',
        'data': objFolio,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            valReferences = data;
            for (let i = 0; i < valReferences.length; i++) {
                getValidationRadio("refSectionR" + i, "refSectionR2" + i, valReferences[i].telefono);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
    return info;
}

function getValueChecks() {
    let alertMsg = ``;
    if (permiso != "B") {
        //Datos Generales
        if ($('input[name="rfcData"]:checked').val() == undefined) alertMsg += `<p>Valida el RFC</p>`;
        if ($('input[name="razData"]:checked').val() == undefined) alertMsg += `<p>Valida la Razon Social</p>`;
        if ($('input[name="nomComData"]:checked').val() == undefined) alertMsg += `<p>Valida el Nombre Comercial</p>`;
        if ($('input[name="constData"]:checked').val() == undefined) alertMsg += `<p>Valida el R1 Frontal</p>`;
        if ($('input[name="const2Data"]:checked').val() == undefined) alertMsg += `<p>Valida el R1 Reverso</p>`;
        if ($('input[name="picSolData"]:checked').val() == undefined) alertMsg += `<p>Valida la fotografia de la solicitud</p>`;

        //Direccion Fiscal
        if ($('input[name="dirCalleData"]:checked').val() == undefined) alertMsg += `<p>Valida calle Fiscal</p>`;
        if ($('input[name="dirNoData"]:checked').val() == undefined) alertMsg += `<p>Valida No Exterior Fiscal</p>`;
        if ($('input[name="dirNoIntData"]:checked').val() == undefined) alertMsg += `<p>Valida No Interior Fiscal</p>`;
        if ($('input[name="dirCityData"]:checked').val() == undefined) alertMsg += `<p>Valida Ciudad Fiscal</p>`;
        if ($('input[name="dirEstData"]:checked').val() == undefined) alertMsg += `<p>Valida Estado Fiscal</p>`;
        if ($('input[name="dirColData"]:checked').val() == undefined) alertMsg += `<p>Valida Colonia Fiscal</p>`;
        if ($('input[name="dirCpData"]:checked').val() == undefined) alertMsg += `<p>Valida Codigo Postal Fiscal</p>`;
        if (document.getElementById("typeFormInf").value != 0 && $('input[name="dirDomData"]:checked').val() == undefined)
            alertMsg += `<p>Valida Comprobante Domicilio</p>`;

        //Direccion Entrega
        if (!isSameAddrs) {
            if ($('input[name="dirEntData"]:checked').val() == undefined) alertMsg += `<p>Valida calle Entrega</p>`;
            if ($('input[name="dirEntNoData"]:checked').val() == undefined) alertMsg += `<p>Valida No Exterior Entrega</p>`;
            if ($('input[name="dirEntNoIntData"]:checked').val() == undefined) alertMsg += `<p>Valida No Interior Entrega</p>`;
            if ($('input[name="entCityData"]:checked').val() == undefined) alertMsg += `<p>Valida Ciudad Entrega</p>`;
            if ($('input[name="entEstData"]:checked').val() == undefined) alertMsg += `<p>Valida Estado Entrega</p>`;
            if ($('input[name="entColData"]:checked').val() == undefined) alertMsg += `<p>Valida Colonia Entrega</p>`;
            if ($('input[name="entCpData"]:checked').val() == undefined) alertMsg += `<p>Valida Codigo Postal Entrega</p>`;
        }

        //Negocio
        if ($('input[name="negPagData"]:checked').val() == undefined) alertMsg += `<p>Valida el Metodo de Pago</p>`;
        if ($('input[name="negiroData"]:checked').val() == undefined) alertMsg += `<p>Valida el Giro del Negocio</p>`;
        if ($('input[name="negAntData"]:checked').val() == undefined) alertMsg += `<p>Valida la Antiguedad del Negocio</p>`;
        if ($('input[name="negFotData"]:checked').val() == undefined) alertMsg += `<p>Valida Foto Frontal</p>`;
        if ($('input[name="negIzqData"]:checked').val() == undefined) alertMsg += `<p>Valida Foto Izquierda</p>`;
        if ($('input[name="negDerData"]:checked').val() == undefined) alertMsg += `<p>Valida Foto Derecha</p>`;

        //DATOS DE CONTACTO 
        if ($('input[name="contactName0"]:checked').val() == undefined) alertMsg += `<p>Valida Nombre del contacto</p>`;
        if ($('input[name="contactPhone0"]:checked').val() == undefined) alertMsg += `<p>Valida Telefono del contacto</p>`;
        if ($('input[name="contactCell0"]:checked').val() == undefined) alertMsg += `<p>Valida Celular del contacto</p>`;

        //Credito
        if (document.getElementById("typeFormInf").value != 0) {
            if ($('input[name="credLocData"]:checked').val() == undefined) alertMsg += `<p>Valida Tipo Local</p>`;
            if ($('input[name="credTypeData"]:checked').val() == undefined) alertMsg += `<p>Valida Tipo Persona</p>`;
            if (document.getElementById("antiguedadEdit").value < 2) {
                if ($('input[name="credPagData"]:checked').val() == undefined) alertMsg += `<p>Valida el Pagare</p>`;
            }
            if (document.getElementById("antiguedadEdit").value < 2 || document.getElementById("typeFormInf").value == "X") {
                if ($('input[name="credIneData"]:checked').val() == undefined) alertMsg += `<p>Valida Ine Aval</p>`;
                if ($('input[name="credRevData"]:checked').val() == undefined) alertMsg += `<p>Valida Ine Aval Reverso</p>`;
            }
            if ($('input[name="credRepData"]:checked').val() == undefined) alertMsg += `<p>Valida la Ine Representante</p>`;
            if ($('input[name="credRepRevData"]:checked').val() == undefined) alertMsg += `<p>Valida Ine Representante Reverso</p>`;
            //Acta Constitutiva
            if (actaConstCount != 0) {
                for (let i = 0; i < actaConstCount; i++) {
                    if ($('input[name="actaConstId' + i + '"]:checked').val() == undefined) alertMsg += `<p>Valida la acta Const ${i + 1}</p>`;
                }
            }
        }
    }
    if (document.getElementById("typeFormInf").value != 0 && permiso != "A") {
        if (cartaResponsivaCount != 0) {
            if ($('input[name="picCRRef"]:checked').val() == undefined) alertMsg += `<p>Valida Carta Responsiva</p>`;
        } else if (referenciasCount != 0) {
            for (let i = 0; i < referenciasCount; i++) {
                if ($('input[name="refStel' + i + '"]:checked').val() == undefined) alertMsg += `<p>Valida la referencia ${i + 1}</p>`;
            }
        } else if (facturasCount != 0) {
            for (let i = 0; i < facturasCount; i++) {
                if ($('input[name="factRefId' + i + '"]:checked').val() == undefined) alertMsg += `<p>Valida la Factura No. ${i + 1}</p>`;
            }
        } else if (caratulaCount != 0) {
            if ($('input[name="picCaratulaRef"]:checked').val() == undefined) alertMsg += `<p>Valida la Caratula</p>`;
        }
    }

    if (alertMsg != ``) {
        $('#cargaModal').modal('hide');
        $('#alertModal').modal('show');
        document.getElementById("alertInfoModal").innerHTML = alertMsg;
        return false;
    } else {
        return true;
    }
}

function convertToBool(item) {
    if ($('input[name="' + item + '"]:checked').val() != undefined)
        return $('input[name="' + item + '"]:checked').val() == "Aceptado" ? true : false;
    else
        return null;
}

function getJsonValidation(flag) {
    valSolicitud.constanciaSituacion = convertToBool("constData");
    valSolicitud.constanciaSituacionReverso = convertToBool("const2Data");
    valSolicitud.firmaSolicitud = convertToBool("picSolData");
    valObser.datosGenerales = document.getElementById("obsDatGen").value;
    if (permiso != "B") {
        //DATOS GENERALES
        valSolicitud.rfc = convertToBool("rfcData");
        valSolicitud.razonSocial = convertToBool("razData");
        valSolicitud.nombreComercial = convertToBool("nomComData");

        //DIRECCION FISCAL
        valSolicitud.calle = convertToBool("dirCalleData");
        valSolicitud.numeroExterior = convertToBool("dirNoData");
        valSolicitud.numeroInterior = convertToBool("dirNoIntData");
        valSolicitud.ciudad = convertToBool("dirCityData");
        valSolicitud.estado = convertToBool("dirEstData");
        valSolicitud.colonia = convertToBool("dirColData");
        valSolicitud.cp = convertToBool("dirCpData");
        if (document.getElementById("typeFormInf").value != 0)
            valSolicitud.comprobanteDomicilio = convertToBool("dirDomData");
        valObser.direccionFiscal = document.getElementById("obsFiscal").value;

        //DIRECCION DE ENTREGA
        if (isSameAddrs) {
            valSolicitud.calleEntrega = convertToBool("dirCalleData");
            valSolicitud.numeroExeriorEntrega = convertToBool("dirNoData");
            valSolicitud.numeroInteriorEntrega = convertToBool("dirNoIntData");
            valSolicitud.ciudadEntrega = convertToBool("dirCityData");
            valSolicitud.estadoEntrega = convertToBool("dirEstData");
            valSolicitud.coloniaEntrega = convertToBool("dirColData");
            valSolicitud.cpentrega = convertToBool("dirCpData");
            valObser.direccionEntrga = document.getElementById("obsFiscal").value;
        } else {
            valSolicitud.calleEntrega = convertToBool("dirEntData");
            valSolicitud.numeroExteriorEntrega = convertToBool("dirEntNoData");
            valSolicitud.numeroInteriorEntrega = convertToBool("dirEntNoIntData");
            valSolicitud.ciudadEntrega = convertToBool("entCityData");
            valSolicitud.estadoEntrega = convertToBool("entEstData");
            valSolicitud.coloniaEntrega = convertToBool("entColData");
            valSolicitud.cpentrega = convertToBool("entCpData");
            valObser.direccionEntrga = document.getElementById("obsEntrea").value;
        }
        //NEGOCIO
        valSolicitud.metodoPago = convertToBool("negPagData");
        valSolicitud.giroNegocio = convertToBool("negiroData");
        valSolicitud.antiguedad = convertToBool("negAntData");
        valSolicitud.fotoFrente = convertToBool("negFotData");
        valSolicitud.fotoIzq = convertToBool("negIzqData");
        valSolicitud.fotoDer = convertToBool("negDerData");
        valObser.negocio = document.getElementById("obsNegocio").value;
        //Contacto Principal
        valContactos[0].nombre = convertToBool("contactName0");
        valContactos[0].telefono = convertToBool("contactPhone0");
        valContactos[0].celular = convertToBool("contactCell0");
        valObser.contactoPrincipal = document.getElementById("obsContacto").value;
        //CREDITO
        if (document.getElementById("typeFormInf").value != 0) {
            valSolicitud.tipoLocal = convertToBool("credLocData");
            valSolicitud.tipoPersona = convertToBool("credTypeData");
            if (document.getElementById("antiguedadEdit").value < 2) {
                valSolicitud.pagare = convertToBool("credPagData");
            }
            if (document.getElementById("antiguedadEdit").value < 2 || document.getElementById("typeFormInf").value == "X") {
                valSolicitud.ineaval = convertToBool("credIneData");
                valSolicitud.ineavalReverso = convertToBool("credRevData");
            }
            valSolicitud.ineRepresentante = convertToBool("credRepData");
            valSolicitud.ineRepresentanteReverso = convertToBool("credRepRevData");
            if (valActaConst != null) {
                for (let i = 0; i < valActaConst.length; i++) {
                    valActaConst[i].archivo = convertToBool("actaConstId" + i);
                }
                valObser.actaConstitutiva = document.getElementById("obsActaConst").value;
            }
            valObser.credito = document.getElementById("obsCredito").value;
        }
    }
    if (document.getElementById("typeFormInf").value != 0 && permiso != "A") {
        if (cartaResponsivaCount != 0) {
            valSolicitud.cartaResponsiva = convertToBool("picCRRef");
        } else if (valReferences != null) {
            for (let i = 0; i < valReferences.length; i++) {
                valReferences[i].telefono = convertToBool("refStel" + i);
            }
        } else if (valFacturasList != null) {
            for (let i = 0; i < valFacturasList.length; i++) {
                valFacturasList[i].archivo = convertToBool("factRefId" + i);
            }
        } else if (caratulaCount != 0) {
            valSolicitud.caratula = convertToBool("picCaratulaRef");
        }
        valObser.referencias = document.getElementById("obsReferencias").value;
    }

    let ValidationValues = {
        Solicitud: valSolicitud,
        Referencias: valReferences,
        ActasConst: valActaConst,
        Contacto: valContactos[0],
        Facturas: valFacturasList,
        Status: flag,
        Observaciones: valObser,
    }
    return ValidationValues;
}

function openUpdateFile(item) {
    fileEdit = '';
    document.getElementById("titleModalEdit").innerHTML = "Agregar Referencias";
    document.getElementById("titlePictureEdit").innerHTML = "Agregar Referencias";
    document.getElementById("label-inputGroupFile19").innerHTML = "Archivo de Referencias";
    // $('#label-inputGroupFile19').html("Archivo de Referencias");
    let buttons = `<button class="btn btn-success btn-circle" onclick="confirmUpdateFile('` + item + `')"><i class="fas fa-paper-plane"></i>Guardar Archivo</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelEditForm()" style="margin-left: 10px;"><i class="fas fa-times"></i>Cancelar Archivo</button>`;
    document.getElementById("editConfirButtons").innerHTML = buttons;
    $('#editImageModal').modal('show');
}

function openUpdateIne(item) {
    fileEdit = '';
    $('#titleModalEdit').html("Agregar Validacion de INE");
    $('#titlePictureEdit').html("Agregar Validacion de INE");
    $('#label-inputGroupFile19').html("Validación de INE");
    let buttons = `<button class="btn btn-success btn-circle" onclick="confirmUpdateIne('` + item + `')"><i class="fas fa-paper-plane"></i>Guardar Imagen</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelEditForm()" style="margin-left: 10px;"><i class="fas fa-times"></i>Cancelar Imagen</button>`;
    document.getElementById("editConfirButtons").innerHTML = buttons;
    $('#editImageModal').modal('show');
}

function confirmUpdateIne(item) {
    if (fileEdit != '') {
        $('#cargaModal').modal('show');
        let json = {
            Folio: item,
            File: {
                Id: 0,
                FileStr: fileEdit,
                Type: 15,
                Subtype: null,
            }
        }
        setFile(json);
    } else {
        console.log(fileEdit);
        alert("Seleccione un archivo");
    }
}

function confirmUpdateFile(item) {
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

function setFile(json) {
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
                alert("Error de solicitud, informar a adan.perez@indar.com.mx");
                $('#cargaModal').modal('hide');
            }
        },
        error: function (error) {
            console.log(error);
            alert("Ocurrió un problema en el servidor, enviar correo a adan.perez@indar.com.mx");
            $('#cargaModal').modal('hide');
        }
    });
}

function cancelEditForm() {
    $('#editImageModal').modal('hide');
}

function getReferencesFile(folio) {
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
            console.log(result);
            const blob = new Blob([s2ab(atob(result.fileStr))], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const url = URL.createObjectURL(blob);
            const enlace = document.createElement("a");
            enlace.href = url;
            enlace.download = "ReferenciasNo_" + folio + ".xlsx";
            enlace.click();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i != s.length; ++i) { view[i] = s.charCodeAt(i) & 0xFF; }
    return buf;
}


function saveValidation(flag) {
    $('#cargaModal').modal('show');
    let auxJson = '';
    if (flag != null) {
        if (getValueChecks())
            auxJson = getJsonValidation(flag);
    } else
        auxJson = getJsonValidation(flag);

    if (auxJson != '') {
        // console.log(auxJson);
        // console.log(JSON.stringify(auxJson));
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/SaveValidation",
            'type': 'POST',
            'dataType': 'json',
            'data': auxJson,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (result) {
                $('#cargaModal').modal('hide');
                if (result && flag == null) {
                    $('#infoModal').modal('hide');
                    realoadTableView();
                } else if (result.result && flag != null) {
                    sendMail(result);
                    realoadTableView();
                } else {
                    console.log("Error, enviar correo a adan.perez@indar.com.mx");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}

function sendMail(objMail) {
    $('#cargaModal').modal('show');
    let mailJson = {
        folio: objMail.folio,
        tipoSol: objMail.tipoSol,
        cliente: objMail.claveP,
        razonSocial: objMail.razonSocial,
        rfc: objMail.rfc,
        zona: objMail.zona,
        emails: objMail.emails,
        status: objMail.status,
    };
    //DatosPrueba
    // console.log(mailJson);
    // $('#infoModal').modal('hide');
    // $('#cargaModal').modal('hide');
    // realoadTableView();
    //EndDatos Prueba
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmailSolicitud",
        'type': 'POST',
        'dataType': 'json',
        'data': mailJson,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            console.log(data);
            $('#infoModal').modal('hide');
            $('#cargaModal').modal('hide');
            realoadTableView();
        },
        error: function (error) {
            alert("Error al enviar los correos");
            console.log(error);
            $('#cargaModal').modal('hide');
            $('#infoModal').modal('hide');
            realoadTableView();
            // document.getElementById('infoModalR').innerHTML = `Solicitud guardada correctamente No. ${data}`;
            // $('#respuestaForm').modal('show');
        }
    });
}

function rollbackSol(folio) {
    $('#confirModal').modal('show');
    document.getElementById("titleModalConfirm").innerHTML = `¿Desea regresar al proceso anterio la solicitud con folio. ${folio}?`;
    var buttons = `<button class="btn btn-success btn-circle" onclick="confirmRollback('` + folio + `')"><i class="fas fa-paper-plane"></i> Si, Reenviar</button>`;
    buttons += `<button class="btn btn-danger btn-circle" onclick="cancelRollback()" style="margin-left: 10px;"><i class="fas fa-times"></i> No, Cancelar</button>`;
    document.getElementById("bodyModalConfirm").innerHTML = buttons;
}

function confirmRollback(folio) {
    $('#confirModal').modal('hide');
    if (folio != null) {
        let data = { Item: folio };
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/RollBackRequest",
            'type': 'POST',
            'dataType': 'json',
            'data': data,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (response) {
                if (response) {
                    alert("Enviado Correctamente");
                    realoadTableView();
                } else {
                    alert("Error en el servidor");
                }

            },
            error: function (error) {
                alert(error + "Error");
            }
        });
    }
}

function realoadTableView() {
    if (document.getElementById("userP").value == "CYC") {
        getSolicitudesPendientes(document.getElementById("userName").value);
    } else {
        getSolicitudesPendientes(document.getElementById("inputGroupSelect01").value);
    }
}

function cancelRollback() {
    $('#confirModal').modal('hide');
}

function initialQuestionTrue(flag) {
    console.log(flag);
    clearModalAcceptCredit();
    $('#acceptForCreditModal').modal('show');
}

function valAcceptCredit() {
    let alertMsg = ``;
    if (document.getElementById("priceListSelectCredit").value == "-1") alertMsg += `<p>Ingresa la lista de precio</p>`;
    if (document.getElementById("commercialPaySelectCredit").value == "-1") alertMsg += `<p>Ingresa la condición de pago</p>`;
    if (document.getElementById("shippingWaySelectCredit").value == "-1") alertMsg += `<p>Ingresa la forma de envio</p>`;
    if (document.getElementById("limitCredit").value == "") alertMsg += `<p>Ingresa el limite de saldo</p>`;
    if (document.getElementById("maxDayOfCredit").value == "") alertMsg += `<p>Ingresa los dias maximos</p>`;

    if (alertMsg != ``) {
        $('#alertModal').modal('show');
        document.getElementById("alertInfoModal").innerHTML = alertMsg;
        return false;
    } else {
        return true;
    }
}

function valAcceptCash() {
    let alertMsg = ``;
    if (document.getElementById("saleRoutesSelect").value == "-1") alertMsg += `<p>Ingresa la ruta de venta</p>`;
    if (document.getElementById("limitCash").value == "") alertMsg += `<p>Ingresa el limite de saldo</p>`;
    if (document.getElementById("maxDayCash").value == "") document.getElementById("maxDayCash").value = 0;

    if (document.getElementById("commercialTermsSelect").value == "-1") alertMsg += `<p>Ingresa la condicion comercial</p>`;
    if (document.getElementById("priceListSelect").value == "-1") alertMsg += `<p>Ingresa la lista de precio</p>`;
    if (document.getElementById("userCash").value == "") alertMsg += `<p>Ingresa Tu usuario</p>`;

    if (document.getElementById("defaultCheck2").checked == false) alertMsg += `<p>Selecciona check de bono cliente Nuevo</p>`;

    if (document.getElementById("shippingWaySelect").value == "-1") alertMsg += `<p>Ingresa la forma de envio</p>`;
    if (document.getElementById("routeSelect").value == "-1") alertMsg += `<p>Ingresa la ruta</p>`;

    if (document.getElementById("shippingWaySelect2").value == "-1") alertMsg += `<p>Ingresa la forma de envio 2</p>`;
    if (document.getElementById("paqueteriaSelect").value == "-1") alertMsg += `<p>Ingresa la paqueteria 2</p>`;
    if (document.getElementById("sameDir").value == "false") {
        if (document.getElementById("shippingWaySelect3").value == "-1") alertMsg += `<p>Ingresa la forma de envio 3</p>`;
        if (document.getElementById("paqueteriaSelect2").value == "-1") alertMsg += `<p>Ingresa la paqueteria de Envio 3</p>`;
    } else {
        document.getElementById("shippingWaySelect3").value = document.getElementById("shippingWaySelect2").value;
        document.getElementById("paqueteriaSelect2").value = document.getElementById("paqueteriaSelect").value;
    }

    if (document.getElementById("montoPagare").value == "")
        document.getElementById("montoPagare").value = 0;

    if (document.getElementById("typeSolCash").value != "0") {
        if (fileIneValidation == '') alertMsg += `<p>Ingresa la imagen de la INE</p>`;
    }

    if (alertMsg != ``) {
        $('#alertModal').modal('show');
        document.getElementById("alertInfoModal").innerHTML = alertMsg;
        return false;
    } else {
        return true;
    }
}

function acceptCredit() {
    if (valAcceptCredit()) {
        $('#cargaModal').modal('show');
        let file = "";
        let jsonDatosIntelisis = {
            folioSolicitud: document.getElementById("folAcceptCredit").innerHTML,
            referenciaBancaria: null,
            condicionesComerciales: null,
            listaPrecios: document.getElementById("priceListSelectCredit").value,
            condicionPago: document.getElementById("commercialPaySelectCredit").value,
            formaEnvio: document.getElementById("shippingWaySelectCredit").value,
            limiteSaldo: document.getElementById("limitCredit").value,
            diasMaximos: document.getElementById("maxDayOfCredit").value,
            indarBonoCteNvo: false,
            indarRutaVenta: null,
            indarRuta: null,
            pagareMonto: 0,
            pagareNuevo: false,
            usuario: null,
            ineValidacion: {
                "Id": 0,
                "FileStr": null,
                "Type": 19,
                "SubType": null
            },
            status: 2,
            categoryId: document.getElementById("typeFormInf").value == 2 ? 8 : (document.getElementById("typeFormInf").value != 0 ? 7 : 9),
            indarFormaEnvioFiscal: null,
            indarPaqueteriaFiscal: null,
            indarFormaEnvio: null,
            indarPaqueteriaEnvio: null
        }
        // console.log(jsonDatosIntelisis);
        // console.log(JSON.stringify(jsonDatosIntelisis));
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/AcceptRequest",
            'type': 'POST',
            'dataType': 'json',
            'data': jsonDatosIntelisis,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (response) {
                if (response != "") {
                    $('#acceptForCreditModal').modal('hide');
                    $('#infoModal').modal('hide');
                    sendMail(response);
                    if (response.customerID != "YES") {
                        setReferenceModal(response.customerID, response.folio);
                    }
                } else {
                    $('#alertModal').modal('show');
                    let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`;
                    document.getElementById("alertInfoModal").innerHTML = alertMsg;
                }
            },
            error: function (error) {
                console.log(error);
                $('#alertModal').modal('show');
                let alertMsg = `<p>Error de servidor, intentelo mas tarde.</p>`;
                document.getElementById("alertInfoModal").innerHTML = alertMsg;
            }
        });
    }
}

function setReferenceModal(customerId, folio) {
    $('#setReferenceModal').modal('show');
    document.getElementById("referenceValue").value = "";
    document.getElementById("codCustomer").innerHTML = customerId;
    document.getElementById("folRef").value = folio;
}

function setReference() {
    $('#cargaModal').modal('show');
    let referencia = document.getElementById("referenceValue").value;
    let folio = document.getElementById("folRef").value;
    let customerId = document.getElementById("codCustomer").innerHTML;
    if (referencia != "") {
        if (customerId != "" && folio != "") {
            let jsonReference = {
                Folio: folio,
                CustomerID: customerId,
                Reference: referencia
            }
            // console.log(jsonReference);
            // console.log(JSON.stringify(jsonReference));
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': "/SolicitudesPendientes/SetReference",
                'type': 'POST',
                'dataType': 'json',
                'data': jsonReference,
                'enctype': 'multipart/form-data',
                'timeout': 2 * 60 * 60 * 1000,
                success: function (response) {
                    $('#cargaModal').modal('hide');
                    if (response) {
                        $('#setReferenceModal').modal('hide');
                        alert("Referencia agregada exitosamente");
                    } else {
                        $('#alertModal').modal('show');
                        let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`;
                        document.getElementById("alertInfoModal").innerHTML = alertMsg;
                    }
                    realoadTableView();
                },
                error: function (error) {
                    console.log(error);
                    $('#alertModal').modal('show');
                    let alertMsg = `<p>Error de serve, intentelo mas tarde.</p>`;
                    document.getElementById("alertInfoModal").innerHTML = alertMsg;
                }
            });
        }
    } else {
        alert("Agrega la referencia");
    }
}

function clearModalAcceptCredit() {
    fileIneValidation = '';
    $('#label-ineValidationFile').html("Ingresa archivo");
    document.getElementById("limitCash").value = "";
    document.getElementById("maxDayCash").value = "";
    document.getElementById("userCash").value = "";
    document.getElementById("montoPagare").value = "";
    document.getElementById("defaultCheck1").checked = false;
    document.getElementById("defaultCheck2").checked = false;
    clearList("#shippingWaySelect");
    clearList("#commercialTermsSelect");
    clearList("#priceListSelect");
    clearList("#saleRoutesSelect");
    clearList("#routeSelect");
    clearList("#paqueteriaSelect");
    clearList("#shippingWaySelect2");
    clearList("#paqueteriaSelect2");
    clearList("#shippingWaySelect3");
    //AcceptCredit
    document.getElementById("limitCredit").value = "";
    document.getElementById("maxDayOfCredit").value = "";
    clearList("#shippingWaySelectCredit");
    clearList("#commercialPaySelectCredit");
    clearList("#priceListSelectCredit");
}

function clearList(id) {
    $(id).val('-1');
    $(id).selectpicker("refresh");
}



function acceptContado() {
    if (valAcceptCash()) {
        $('#cargaModal').modal('show');
        let jsonDatosIntelisis = {
            folioSolicitud: document.getElementById("folAcceptCash").innerHTML,
            referenciaBancaria: null,
            condicionesComerciales: document.getElementById("commercialTermsSelect").value,
            listaPrecios: document.getElementById("priceListSelect").value,
            condicionPago: null,
            formaEnvio: document.getElementById("shippingWaySelect").value,
            limiteSaldo: document.getElementById("limitCash").value,
            diasMaximos: document.getElementById("maxDayCash").value,
            indarBonoCteNvo: document.getElementById("defaultCheck2").checked,
            indarRutaVenta: document.getElementById("saleRoutesSelect").value,
            indarRuta: document.getElementById("routeSelect").value,
            pagareMonto: parseInt(document.getElementById("montoPagare").value),
            pagareNuevo: document.getElementById("defaultCheck1").checked,
            usuario: document.getElementById("userCash").value,
            ineValidacion: {
                FileStr: fileIneValidation == '' ? null : fileIneValidation,
                Type: 15,
                Subtype: null,
            },
            status: 1,
            categoryId: document.getElementById("typeFormInf").value == 2 ? 8 : (document.getElementById("typeFormInf").value != 0 ? 7 : 9),
            indarFormaEnvioFiscal: document.getElementById("shippingWaySelect2").value,
            indarPaqueteriaFiscal: document.getElementById("paqueteriaSelect").value,
            indarFormaEnvio: document.getElementById("shippingWaySelect3").value,
            indarPaqueteriaEnvio: document.getElementById("paqueteriaSelect2").value
        }
        // console.log(jsonDatosIntelisis);
        // console.log(JSON.stringify(jsonDatosIntelisis));
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/AcceptRequest",
            'type': 'POST',
            'dataType': 'json',
            'data': jsonDatosIntelisis,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (response) {
                $('#cargaModal').modal('hide');
                // console.log(response);
                if (response != "") {
                    // console.log(response.result);
                    if (response.result != false) {
                        $('#acceptForCashModal').modal('hide');
                        sendMail(response);
                        if (response.customerID != "YES" && response.customerID != "")
                            setReferenceModal(response.customerID, response.folio);
                    } else {
                        $('#alertModal').modal('show');
                        let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`
                        document.getElementById("alertInfoModal").innerHTML = alertMsg;
                    }
                } else {
                    $('#alertModal').modal('show');
                    let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`
                    document.getElementById("alertInfoModal").innerHTML = alertMsg;
                }
            },
            error: function (error) {
                console.log(error);
                $('#alertModal').modal('show');
                $('#cargaModal').modal('hide');
                let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`
                document.getElementById("alertInfoModal").innerHTML = alertMsg;
            }
        });
    }
}

function showReact(folio) {
    $('#reactiveClieModal').modal('show');
    document.getElementById("folReact").innerHTML = folio.split('-')[0];
    document.getElementById("rfcReact").innerHTML = folio.split('-')[1];
    document.getElementById("reactiveClieValue").value = "";
}

function setReactCli() {
    if (document.getElementById("reactiveClieValue").value != "") {
        $('#cargaModal').modal('show');
        let jsonReactive = {
            NoC: document.getElementById("reactiveClieValue").value,
            Folio: document.getElementById("folReact").innerHTML,
            IsCredit: false
        }
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SolicitudesPendientes/ReactiveClient",
            'type': 'POST',
            'dataType': 'json',
            'data': jsonReactive,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (response) {
                $('#cargaModal').modal('hide');
                if (response) {
                    $('#reactiveClieModal').modal('hide');
                    realoadTableView();
                } else {
                    $('#alertModal').modal('show');
                    let alertMsg = `<p>Error en sistema, favor de reportarlo</p>`
                    document.getElementById("alertInfoModal").innerHTML = alertMsg;
                }
            },
            error: function (error) {
                console.log(error);
                $('#alertModal').modal('show');
                $('#cargaModal').modal('hide');
                let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`
                document.getElementById("alertInfoModal").innerHTML = alertMsg;
            }
        });
    } else {
        alert("ingresa el codigo de cliente");
    }

}

function envioMail2() {
    $('#cargaModal').modal('show');
    let mailJson = {
        folio: 27626,
        tipoSol: "PRUEBA",
        cliente: "P0PRUEBA",
        razonSocial: "PRUEBA",
        rfc: "MEHF770PRUEBA",
        zona: "Z656",
        emails: [
            "vrodriguez@indar.com.mx",
            "adan.perez@indar.com.mx",
            "salvador.cervantes@indar.com.mx",
            "mamartinez@indar.com.mx",
            "rlozano@indar.com.mx"
        ],
        customerID: "YES",
        status: "Aceptada Credito",
        result: false
    };

    /* mailJson = {
         folio: 27910, 
         tipoSol: "CREDITO", 
         cliente: "P030926", 
         razonSocial: "CRISPINA ARROYO DIAZ", 
         rfc: "AODC621205EW3", 
         zona: "Z415", 
         emails: [
             "vrodriguez@indar.com.mx",
             "adan.perez@indar.com.mx",
             "gregorio.salinas@indar.com.mx",
             "claudia.munoz@indar.com.mx",
             "jose.pavon@indar.com.mx"
         ], 
         status: "Aceptada Contado (Pendiente Credito)"        
     }*/
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/sendmailSolicitud",
        'type': 'POST',
        'dataType': 'json',
        'data': mailJson,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            alert(data.success);
            $('#infoModal').modal('hide');
            $('#cargaModal').modal('hide');
            realoadTableView();
        },
        error: function (error) {
            console.log(error);
            alert("Error al enviar los correos");
            $('#cargaModal').modal('hide');
            $('#infoModal').modal('hide');
            realoadTableView();
        }
    });
}

function envioMail() {
    alert("No tienes permisos");
}

function prueba() {
    if (document.getElementById("userP").value == "CYC") {
        getSolicitudesPendientes(document.getElementById("userName").value);
    } else {
        getSolicitudesPendientes(document.getElementById("inputGroupSelect01").value);
    }
}

function simularReferencia() {
    let response = {
        "folio": 27958,
        "tipoSol": "CONTADO",
        "claveP": "P031063",
        "razonSocial": "ARMANDO GARCIA NUÑEZ",
        "rfc": "GANA7005057U3",
        "zona": "Z145",
        "status": "Aceptada Contado",
        "emails": [
            "vrodriguez@indar.com.mx",
            "adan.perez@indar.com.mx",
            "andrea.leon@indar.com.mx",
            "claudia.munoz@indar.com.mx",
            "jramirez@indar.com.mx"
        ],
        "customerID": "C018999",
        "result": true
    }
    // console.log(response);
    if (response != "") {
        // console.log(response.result);
        if (response.result != false) {
            $('#acceptForCashModal').modal('hide');
            sendMail(response);
            if (response.customerID != "YES" && response.customerID != "")
                setReferenceModal(response.customerID, response.folio);
        } else {
            $('#alertModal').modal('show');
            let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`
            document.getElementById("alertInfoModal").innerHTML = alertMsg;
        }
    } else {
        $('#alertModal').modal('show');
        let alertMsg = `<p>Parace que algo salio mal, intentelo mas tarde.</p>`
        document.getElementById("alertInfoModal").innerHTML = alertMsg;
    }
}

function getDocumentoP() {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/GetExcelPrueba",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (result) {
            if (result != null) {
                const blob = new Blob([s2ab(atob(result.description))], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = URL.createObjectURL(blob);
                const enlace = document.createElement("a");
                enlace.href = url;
                enlace.download = "Reporte.xlsx";
                enlace.click();
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}