var map, heatmap;

$(document).ready(function () {
    // $.ajax({
    //     'headers': {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     'url': "/HeatMap/GetItemSearchMap",
    //     'type': 'GET',
    //     'dataType': 'json',
    //     'enctype': 'multipart/form-data',
    //     'timeout': 2 * 60 * 60 * 1000,
    //     success: function(data) {
    //         console.log(data);
    //     },
    //     error: function(error) {        
    //         console.log(error);
    //     }
    // });
});

function initMap() {
    document.getElementById("floating-panel").style.display = "flex";
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: { lat: 20.587359621011093, lng: -103.28472328263824 },
        mapTypeId: "roadmap",
    });
    heatmap = new google.maps.visualization.HeatmapLayer({
        data: getPoints(),
        map: map,
    });
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
    heatmap.set("radius", heatmap.get("radius") ? null : 20);
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
    console.log(document.getElementById("periodIni").value);
}


function getCustomerList() {
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
    else{
        document.getElementById("alertDate").style.display = "none";
        console.log("item");
        initMap();
    }
}