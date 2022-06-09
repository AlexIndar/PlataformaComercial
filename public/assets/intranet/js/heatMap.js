var map, heatmap;
var zonasList = '';

var itemCoord = [];
$(document).ready(function () {
    const GERENCIAS = {
        4: '100',
        5: '200',
        6: '300',
        7: '500',
        8: '600',
        9: '900',
        10: '000',
        1012: '700',
        2012: '400',
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/HeatMap/GetItemSearchMap",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            //AGREGAR GERENCIAS
            let itemGerencia = [];
            for (let i = 0; i < data.gerenciaList.length; i++) {
                let auxItem = GERENCIAS[data.gerenciaList[i].id] + " " + data.gerenciaList[i].descripcion;
                itemGerencia.push(auxItem);
            }
            itemGerencia.sort();
            addSelectListItems(itemGerencia, "#inputGroupGerencia");

            //AGREGAR ZONAS
            addSelectListItems(data.zonasList, "#inputGroupZonas");
            zonasList = data.zonasList;

            //AGREGAR ENVIO
            let itemOpcSel = $('#inputGroupEnvio option');
            itemOpcSel.remove();
            $('#inputGroupEnvio').append('<option value="">Todas</option>');
            for (let j = 0; j < data.shippingWayList.length; j++) {
                $('#inputGroupEnvio').append('<option value="' + data.shippingWayList[j].listId + '">' + data.shippingWayList[j].listItemName + '</option>');
            }
            $('#inputGroupEnvio').val('');
            $('#inputGroupEnvio').selectpicker("refresh");
        },
        error: function (error) {
            console.log(error);
        }
    });
});

function addSelectListItems(data, idItem) {
    let itemSelectorOption = $(idItem + ' option');
    itemSelectorOption.remove();
    $(idItem).append('<option value="">Todas</option>');
    for (let i = 0; i < data.length; i++) {
        $(idItem).append('<option value="' + data[i] + '">' + data[i] + '</option>');
    }
    $(idItem).val('');
    $(idItem).selectpicker("refresh");
}

function changeGerencia() {
    let itemSelect = document.getElementById("inputGroupGerencia").value;
    if (itemSelect != "") {
        let auxZonas = zonasList.filter(x => x[1] == itemSelect[0]);
        addSelectListItems(auxZonas, "#inputGroupZonas");
    } else {
        addSelectListItems(zonasList, "#inputGroupZonas");
    }
    getCustomerList();
}

function initMap() {
    document.getElementById("floating-panel").style.display = "flex";
    // $('#cargaModal').modal('hide');
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: { lat: 20.587359621011093, lng: -103.28472328263824 },
        mapTypeId: "roadmap",
    });
    heatmap = new google.maps.visualization.HeatmapLayer({
        data: itemCoord,
        map: map,
    });
    console.log(heatmap.data);
    document
        .getElementById("toggle-heatmap")
        .addEventListener("click", toggleHeatmap);
    document
        .getElementById("change-gradient")
        .addEventListener("click", changeGradient);
    document
        .getElementById("change-opacity")
        .addEventListener("click", changeOpacity);
    document
        .getElementById("change-radius")
        .addEventListener("click", changeRadius);
}

function toggleHeatmap() {
    heatmap.setMap(heatmap.getMap() ? null : map);
}

function changeGradient() {
    const gradient = [
        "rgba(0, 255, 255, 0)",
        "rgba(0, 255, 255, 1)",
        "rgba(0, 191, 255, 1)",
        "rgba(0, 127, 255, 1)",
        "rgba(0, 63, 255, 1)",
        "rgba(0, 0, 255, 1)",
        "rgba(0, 0, 223, 1)",
        "rgba(0, 0, 191, 1)",
        "rgba(0, 0, 159, 1)",
        "rgba(0, 0, 127, 1)",
        "rgba(63, 0, 91, 1)",
        "rgba(127, 0, 63, 1)",
        "rgba(191, 0, 31, 1)",
        "rgba(255, 0, 0, 1)",
    ];

    heatmap.set("gradient", heatmap.get("gradient") ? null : gradient);
}

function changeRadius() {
    heatmap.set("radius", heatmap.get("radius") ? null : 50);
}

function changeOpacity() {
    heatmap.set("opacity", heatmap.get("opacity") ? null : 0.2);
}

// Heatmap data: 500 Points
function getPoints() {
    return [
        new google.maps.LatLng(20.59182468845927, -103.28489825073832),
        new google.maps.LatLng(20.59182468845927, -103.28489825073832),
        new google.maps.LatLng(20.59182468845927, -103.28489825073832),
        new google.maps.LatLng(20.59182468845927, -103.28489825073832),
        new google.maps.LatLng(20.59182468845927, -103.28489825073832),
    ];
}

function search() {
    initMap();
}

function prueba() {
    // moment( new Date(this.periodEnd)).format('DD/MMM/YYYY');
    // $('#cargaModal').modal('show');
    let fechaIni = document.getElementById("periodIni").value;
    fechaIni = fechaIni == "" ? "" : moment( new Date(fechaIni)).format('DD/MMM/YYYY');
    let fechaEnd = document.getElementById("periodEnd").value;
    fechaEnd = fechaEnd == "" ? "" : moment( new Date(fechaEnd)).format('DD/MMM/YYYY');

    let objSearch = {
        FechaIni: fechaIni,
        FechaEnd: fechaEnd,
        IdGerencia: document.getElementById("inputGroupGerencia").value,
        Zona: document.getElementById("inputGroupZonas").value,
        IdShippingWay: document.getElementById("inputGroupEnvio").value
    }
    console.log(objSearch);
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/HeatMap/GetListCustomer",
        'type': 'POST',
        // 'async': false,
        'dataType': 'json',
        'data': objSearch,
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            console.log(data);
            if (data.length > 0) {
                itemCoord = [];
                for (let i = 0; i < data.length; i++) {
                    itemCoord.push(new google.maps.LatLng(data[i].latitud, data[i].longitud));
                }
                initMap();
                console.log(itemCoord);
            }else{
                $("#infoReport").modal('show');
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function getCustomerList() {
    document.getElementById("floating-panel").style.display = "none";
    document.getElementById("alertDate").innerHTML = "";
    let dateIni = document.getElementById("periodIni").value;
    let dateEnd = document.getElementById("periodEnd").value;
    if (dateIni != "" && dateEnd == "")
        document.getElementById("alertDate").innerHTML = "Ingresa la Fecha Final";
    else if (dateIni == "" && dateEnd != "")
        document.getElementById("alertDate").innerHTML = "Ingresa la Fecha Inicial";
    else if (dateIni > dateEnd) {
        document.getElementById("alertDate").innerHTML = "No se puede ser una fecha menor";
    }
    if (document.getElementById("alertDate").innerHTML != "")
        document.getElementById("alertDate").style.display = "flex";
    else {
        document.getElementById("alertDate").style.display = "none";
        // initMap();
        prueba();
    }
}