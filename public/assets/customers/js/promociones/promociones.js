var subreglas = []; //EN CASO DE QUE SE DUPLIQUE UN PAQUETE
var packageHeader;


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
    $("#tipoDuplicar").val(type);
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
    document.getElementById("btnSpinner").style.display = "block";
    var nombre = document.getElementById('nombrePromoDuplicar').value;
    var id = document.getElementById('idDuplicar').value;
    var tipo = document.getElementById('tipoDuplicar').value;
    if(nombre!=''){
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/promociones/getEventById/" + id,
            'type': 'GET',
            'async': false,
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

                    if(tipo == 'paquete'){
                        $.ajax({ // ------------------------------------------------------------ OBTENER CUOTAS DEL PAQUETE A DUPLICAR -----------------
                            'headers': {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            'url': "/promociones/getCuotasPersonalizadas/" + id,
                            'type': 'GET',
                            'async': false,
                            'enctype': 'multipart/form-data',
                            'timeout': 2*60*60*1000,
                            success: function(data){
                                if(data.length > 0 && data[0]['customer']!= null){
                                    var cuotasPromo = [];
                                    for(var x=0; x<data.length; x++){
                                        var jsonCuotas = {
                                            'CompanyId': data[x]['customer'],
                                            'Cuota': data[x]['cuota'].toString(),
                                            'P1': data[x]['p1'],
                                            'P2': data[x]['p2'],
                                            'P3': data[x]['p3'],
                                        };
                                        cuotasPromo.push(jsonCuotas);
                                    }
                                    json['cuotasPersonalizadas'] = cuotasPromo;
                                    packageHeader = json;
                                }
                                
                            }, 
                            error: function(error){
                                console.log(error);
                                alert('Error obteniendo cuotas');
                             }
                        }); // ------------------------------------------------------------ FIN OBTENER CUOTAS DEL PAQUETE A DUPLICAR -----------------

                        $.ajax({ // ------------------------------------------------------------ OBTENER REGLAS DEL PAQUETE A DUPLICAR -----------------
                            'headers': {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            'url': "/promociones/getReglasPaquete/" + id,
                            'type': 'GET',
                            'async': false,
                            'enctype': 'multipart/form-data',
                            'timeout': 2*60*60*1000,
                            success: function(data){
                                console.log(data);
                                subreglas = data;
                            }, 
                            error: function(error){
                                console.log(error);
                                alert('Error obteniendo subreglas');
                             }
                        }); // ------------------------------------------------------------ FIN OBTENER REGLAS DEL PAQUETE A DUPLICAR -----------------

                        storeHeader(editar);
                        
                    }
                    else{
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
                        alert('No es paquete');
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
                    }

                    
                    
            }, 
            error: function(error){
             }
        });
    }
    else{
        alert('Ingresa un nombre para la nueva promoción');
    }
   
}

function storeHeader(editar){
    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "/promociones/storePromo",
        'type': 'POST',
        'async': false,
        'dataType': 'json', 
        'data': packageHeader,
        'enctype': 'multipart/form-data',
        'timeout': 2*60*60*1000,
        success: function(data){
            var idPaquete = data;
            console.log(data);
            alert('Encabezado duplicado correctamente. Copiando subreglas...');
            setTimeout(storeSubreglas(editar, idPaquete), 2000);
        }, 
        error: function(error){
            alert('Error al guardar encabezado de paquete');
         }
    });
}

function storeSubreglas(editar, idPaquete){
    for(var y = 0; y < subreglas.length; y++){
        
        for(var x = 0; x < subreglas[y]['pedidoPromoRulesD'].length; x++){
            subreglas[y]['pedidoPromoRulesD'][x]['idPedidoPromo'] = 0;
            subreglas[y]['pedidoPromoRulesD'][x]['idPedidoPromoD'] = 0;
        }

        var listaVaciaCuotas = [];
        var cuotasObj = {
            'customer': '',
            'importeCuota': 0,
            'p1': '0',
            'p2': '0',
            'p3': '0',
        };
        listaVaciaCuotas.push(cuotasObj);
                
                var json = {
                    id: 0,
                    nombrePromo: subreglas[y]['nombrePromo'],
                    descuento: subreglas[y]['descuento'],
                    descuentoWeb: subreglas[y]['descuentoWeb'],
                    puntosIndar: subreglas[y]['puntosIndar'],
                    plazosIndar: subreglas[y]['plazosIndar'],
                    regalosIndar: subreglas[y]['regalosIndar'] == null ? "" : subreglas[y]['regalosIndar'],
                    categoriaClientes: subreglas[y]['categoriaClientes'],
                    categoriaClientesIncluye: subreglas[y]['categoriaClientesIncluye'],
                    gruposclientesIds: subreglas[y]['gruposclientesIds'],
                    gruposclientesIncluye: subreglas[y]['gruposclientesIncluye'],
                    clientesId: subreglas[y]['clientesId'],
                    clientesIncluye: subreglas[y]['clientesIncluye'],
                    plazo: subreglas[y]['plazo'],
                    montoMinCash: subreglas[y]['montoMinCash'],
                    montoMinQty: subreglas[y]['montoMinQty'],
                    fechaInicio: subreglas[y]['fechaInicio'],
                    fechaFin: subreglas[y]['fechaFin'],
                    paquete: false,
                    idPaquete: idPaquete,
                    pedidoPromoRulesD: subreglas[y]['pedidoPromoRulesD'],
                    cuotasPersonalizadas: listaVaciaCuotas,
                }
                console.log(JSON.stringify(json));
                $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url': "/promociones/storePromo",
                    'type': 'POST',
                    'async': false,
                    'dataType': 'json', 
                    'data': json,
                    'enctype': 'multipart/form-data',
                    'timeout': 2*60*60*1000,
                    success: function(data){
                            // document.getElementById(idRow).classList.add('success-sub');
                    }, 
                    error: function(error){
                            alert('Error guardando subregla');
                            // document.getElementById(idRow).classList.add('error-sub');
                     }
                });

    }
    
    if(editar){
        $("#id").val(idPaquete);
        $("#form").submit();
    }
    else{
        window.location.href = '/promociones';
    } 
   
}