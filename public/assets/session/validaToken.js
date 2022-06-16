function validarToken(){
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/validarToken",
        'type': 'GET',
        'enctype': 'multipart/form-data',
        'async': false,
        'timeout': 2 * 60 * 60 * 1000,
        success: function (data) {
            console.log(data);
        },
        error: function (error) {
            console.log(error);
            alert('Token invalido. Inicia sesión nuevamente.');
            window.location.href = '/logout';
        }
    });
}