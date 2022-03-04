function enviar(){
    var id = document.getElementById('idCotizacion').value;
    let data = { cotizacion: id };
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/pedido/forzarPedido",
        'type': 'POST',
        'dataType': 'json',
        'data': data,
		'enctype': 'multipart/form-data',
		'timeout': 2*60*60*1000,
		success: function(data){
				alert('success');
		}, 
		error: function(error){
				alert('error');
		 }
	});
}