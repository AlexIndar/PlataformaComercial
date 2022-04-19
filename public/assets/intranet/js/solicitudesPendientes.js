var cobUsernamesList = [];
var solicitudesList = [];
$(document).ready(function() {
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/SolicitudesPendientes/GetCobUsernames",
        'type': 'GET',
        'dataType': 'json',
        'enctype': 'multipart/form-data',
        'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            console.log(data);
            cobUsernamesList = data;
            let itemSelectorOption = $('#inputGroupSelect01 option');
            itemSelectorOption.remove();
            $('#inputGroupSelect01').selectpicker('refresh');

            for (var x = 0; x < cobUsernamesList.length; x++) {
                $('#inputGroupSelect01').append('<option value="' + cobUsernamesList[x]['id'] + '">' + cobUsernamesList[x]['nombre'] + '</option>');
                $('#inputGroupSelect01').val(cobUsernamesList[x]['id']);
                $('#inputGroupSelect01').selectpicker("refresh");
            }

            $('#inputGroupSelect01').append('<option value="-1">Selecciona un opcion</option>'); //Agregar Primera opción de inputGroupSelect01 en Blanco
            $('#inputGroupSelect01').val('-1');
            $('#inputGroupSelect01').selectpicker("refresh");

        },
        error: function(error) {
            console.log(error);
            alert("Error de Emails, enviar correo a adan.perez@indar.com.mx");
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
        success: function(data) {
            console.log(data);
            // cobUsernamesList = data;
            // let itemSelectorOption = $('#inputGroupSelect01 option');
            // itemSelectorOption.remove();
            // $('#inputGroupSelect01').selectpicker('refresh');

            // for (var x = 0; x < cobUsernamesList.length; x++) {
            //     $('#inputGroupSelect01').append('<option value="' + cobUsernamesList[x]['id'] + '">' + cobUsernamesList[x]['nombre'] + '</option>');
            //     $('#inputGroupSelect01').val(cobUsernamesList[x]['id']);
            //     $('#inputGroupSelect01').selectpicker("refresh");
            // }

            // $('#inputGroupSelect01').append('<option value="-1">Selecciona un opcion</option>'); //Agregar Primera opción de inputGroupSelect01 en Blanco
            // $('#inputGroupSelect01').val('-1');
            // $('#inputGroupSelect01').selectpicker("refresh");
        },
        error: function(error) {
            console.log(error);
        }
    });

    $(function() {
        $("#example1").DataTable({
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
});

const getSolicitudesPendientes = (user) => {
    console.log(user);
    let objUser = {
        User: user
    }
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/SolicitudesPendientes/GetCycTableView",
        'type': 'POST',
        'async': false,
        'dataType': 'json',
        'data': objUser,
        'enctype': 'multipart/form-data',
        // 'timeout': 2 * 60 * 60 * 1000,
        success: function(data) {
            solicitudesList = data;
        },
        error: function(error) {
            console.log(error);
        }
    });
}

document.getElementById("inputGroupSelect01").addEventListener("change", function(e) {
    getSolicitudesPendientes(e.target.value);
    console.log(solicitudesList);
});