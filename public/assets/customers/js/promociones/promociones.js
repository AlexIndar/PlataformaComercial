function addPromocion(){
    window.location.href = "promociones/nueva";
} 

function addPaquete(){
    window.location.href = "promociones/paquete"; 
} 

function editarPromo(id){
    $("#id").val(id);
    $("#form").submit();
}

function activarEliminarModal(id, type){
    if(type == 'promo'){
        document.getElementById('h4-modalEliminar').innerText = 'Eliminar Promoción';
        document.getElementById('h5-modalEliminar').innerText = '¿Desea eliminar esta promoción?';
    }
    else{
        document.getElementById('h4-modalEliminar').innerText = 'Eliminar Paquete';
        document.getElementById('h5-modalEliminar').innerText = '¿Desea eliminar este paquete?';
    }
    $("#idPromo").val(id);
    $('#confirmDeleteModal').modal('show');
}

function activarDuplicarModal(id, type){
    if(type == 'promo'){
        document.getElementById('h4-modalDuplicar').innerText = 'Duplicar Promoción';
        document.getElementById('h5-modalDuplicar').innerText = 'Indique un nombre para la nueva promoción';
    }
    else{
        document.getElementById('h4-modalDuplicar').innerText = 'Duplicar Paquete';
        document.getElementById('h5-modalDuplicar').innerText = 'Indique un nombre para el nuevo paquete';
    }
    $("#idDuplicar").val(id);
    $('#confirmDuplicarModal').modal('show');
}

function closeModalDelete(){
    $('#confirmDeleteModal').modal('hide');
}

function closeModalDuplicar(){
    $('#confirmDuplicarModal').modal('hide');
}

function eliminarPromo(){
    $("#formDelete").submit();
} 

function duplicarPromo(editar){
    var nombre = document.getElementById('nombrePromoDuplicar').value;
    var id = document.getElementById('idDuplicar').value;
    if(nombre!=''){
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/promociones/getEventById/" + id,
            'type': 'GET',
            'enctype': 'multipart/form-data',
            'timeout': 2*60*60*1000,
            success: function(data){
                    var json = data;
                    json['nombrePromo'] = nombre;
                    json['id'] = 0;
                    for(var x = 0; x < json['pedidoPromoRulesD'].length; x++){
                        json['pedidoPromoRulesD'][x]['idPedidoPromo'] = 0;
                        json['pedidoPromoRulesD'][x]['idPedidoPromoD'] = 0;
                    }

                    var cuotasList = [];
                    var cuotasObj = {
                        'customer': '',
                        'importeCuota': 0,
                        'p1': '0',
                        'p2': '0',
                        'p3': '0',
                    };
                    cuotasList.push(cuotasObj);

                    json['cuotasPersonalizadas'] = cuotasList;
                    
                    $.ajax({
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'url': "/promociones/storePromo",
                        'type': 'POST',
                        'dataType': 'json', 
                        'data': json,
                        'enctype': 'multipart/form-data',
                        'timeout': 2*60*60*1000,
                        success: function(data){
                                if(editar){
                                    $("#id").val(data);
                                    $("#form").submit();
                                }
                                else{
                                    window.location.href = '/promociones';
                                } 
                        }, 
                        error: function(error){
                                window.location.href = '/promociones';
                         }
                    });
            }, 
            error: function(error){
             }
        });
    }
    else{
        alert('Ingresa un nombre para la nueva promoción');
    }
   
}