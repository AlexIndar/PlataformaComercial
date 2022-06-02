$(document).ready(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        autoUpdateInput: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: 'Aplicar',
            daysOfWeek: [
                'Do',
                'Lu',
                'Ma',
                'Mi',
                'Ju',
                'Vi',
                'Sa'
            ],
            monthNames: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ]
        }
    }, function(start, end, label) {
        // console.log("ITEM");
        // console.log(start.format('YYYY-MM-DD'));
        // console.log(end.format('YYYY-MM-DD'));
        getEstadisticaTiempo();
        // startDate = start.format('YYYY-MM-DD');
        // endDate = end.format('YYYY-MM-DD');
    });
});

document.getElementById("typeForms").addEventListener("change", function(e) {
    getEstadisticaTiempo();
});



const getEstadisticaTiempo = () => {
    var fecha = $('#reservation').daterangepicker()[0].value;
    var dateIF = fecha.split('-').map(s => s.trim());
    let typeFol = document.getElementById("typeForms").value;
    console.log(typeFol);
    console.log(dateIF[0]);
    console.log(dateIF[1]);
    document.getElementById("exportFileBtn").disabled = false;
}

const alterb = () =>{
    alert("HOLA");
}