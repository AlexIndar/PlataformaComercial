
$(document).ready(function() {
    //Inicia Ajax
    $(document).ajaxStart(function() {
        document.getElementById("btnSpinner").style.display = "block";
        var btnActions = document.getElementsByClassName('btn-group-buttons');
        for(var x=0; x < btnActions.length; x++){
            btnActions[x].disabled = true;
        }
    });

    //Func Termina Ajax
    $(document).ajaxStop(function() {
        //Esconde y muestra DIVISORES
        document.getElementById("btnSpinner").style.display = "none";
        var btnActions = document.getElementsByClassName('btn-group-buttons');
        for(var x=0; x < btnActions.length; x++){
            btnActions[x].disabled = false;
        }
    } );
});

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
                document.getElementById('respuesta').classList.remove('d-none');
                document.getElementById('jsonPeticion').innerText = JSON.stringify(data['peticion'][0]);
                document.getElementById('internalId').innerText = data['response'][0]['internalId'];
                document.getElementById('jsonRespuesta').innerText = data['response'][0]['json'];
                document.getElementById('message').innerText = data['response'][0]['message'];
                document.getElementById('status').innerText = data['response'][0]['status'];
                if(data['response'][0]['status'] == 'NOK')
                    document.getElementById('status').setAttribute('style', 'color: red; font-weight: 700; display: inline-block;');
                else   
                    document.getElementById('status').setAttribute('style', 'color: green; font-weight: 700; display: inline-block;');
                document.getElementById('tranId').innerText = data['response'][0]['tranId'];
		}, 
		error: function(error){
				alert('Error'); 
		 }
	});
}  