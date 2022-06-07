$(document).ready(function(){

});
var Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    timer: 8000,
    timerProgressBar: false
});
let capturaErroresController = {
    modalError: (e) => {
        let idError = $(e).data('iderror');
        console.log(idError);
        $('#titulo-incidencia').empty();
        $('#titulo-incidencia').text('Concluir incidencia #'+idError);
        $('#idErrorInput').val(idError);
        $('#modalError').modal('show');
    },
    requestLogin: () => {
        let comentario = $('#comentarios').val();
        let idError = $('#idErrorInput').val();
        let user = $('#user').val();
        let password = $('#password').val();
        let data = {
            idError:idError,
            user: user,
            comentario: comentario
        };
        if($('#user').val().length > 0 && $('#password').val().length > 0){
            if($('#user').val() == 'JLOZA' && $('#password').val() == '870710'){
                capturaErroresController.cerrarError(data);
            }
            else if($('#user').val() == 'ODELACRUZ' && $('#password').val() == 'ODELACRUZ123'){
                capturaErroresController.cerrarError(data);
            }
            else if($('#user').val() == 'MRIOS' && $('#password').val() == '011196'){
                capturaErroresController.cerrarError(data);
            }
            else if($('#user').val() == 'RMADERA' && $('#password').val() == '240392'){
                capturaErroresController.cerrarError(data);
            }
            else if($('#user').val() == 'GENERAL' && $('#password').val() == '12345'){
                capturaErroresController.cerrarError(data);
            }
            else{
                Toast.fire({
                    icon: 'error',
                    title: '¡Usuario o contraseña invalidos!'
                });
            }
        }
        else{
            Toast.fire({
                icon: 'error',
                title: '¡No has capturado usuario o contraseña!'
            });
        }
    },
    cerrarError: (data) => {
        capturaErroresController.token();
        $.ajax({
            url: '/almacen/capturaErrores/updateError',
            type: 'POST',
            data: data,
            datatype: 'json',
            success: function(data){
                if(data ="OK"){
                    Toast.fire({
                        icon: 'success',
                        title: '¡Incidente cerrado!'
                    });
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: '¡Hubo un error al cerrar el incidente, notificar a desarrollo!'
                    });
                }
                capturaErroresController.actualizar();
                $('#modalError').modal('toggle');
            },
            complete: function(){

            },
            error: function(error){
                console.log(error);
            }
        })
    },
    capturaError: () => {
        let articulo = $('#articulo').val();
        let cantidad = $('#cantidad').val();
        let pedido = $('#pedido').val();
        let surtidor = $('#surtidor').val();
        let tipoError = $('#tipoError').val();
        let mesa = $('#mesa').val();
        let usuario = $('#usuario').val();
        if(articulo == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }
        else if(cantidad == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }
        else if(pedido == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }
        else if(surtidor == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }
        else if(tipoError == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }
        else if(mesa == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }
        else if(usuario == ""){
            Toast.fire({
                icon: 'error',
                title: '¡Falta datos por llenar!'
            });
        }else{
            let data = {
                articulo: articulo,
                cantidad: cantidad,
                pedido : pedido,
                surtidor: surtidor,
                tipoError: tipoError,
                mesa : mesa,
                usuario: usuario
            };
            capturaErroresController.token();
            $.ajax({
                url: '/almacen/capturaErrores/createError',
                type: 'POST',
                data: data,
                datatype: 'json',
                success: function(data) {
                    console.log(data);
                    if(data == "SURTIDORNOEXISTE")
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Surtidor no existe!'
                        });
                    }
                    else if(data == "USUARIONOEXISTE"){
                        Toast.fire({
                            icon: 'error',
                            title: '¡Usuario no existe!'
                        });
                    }
                    else if(data == "ARTICULONOEXISTE")
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Articulo no existe!'
                        });
                    }else if(data == "PEDIDONOEXISTE")
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '¡Pedido no existe!'
                        });
                    }else{
                        Toast.fire({
                            icon: 'success',
                            title: '¡Captura Error exitosa!'
                        });
                        $(0)
                        
                        capturaErroresController.actualizar();
                    }
                },
                complete: function() {

                },
                error: function (error){
                    console.log(error);
                }
            });
        }
    },
    actualizar: () => {
        $.ajax({
            url:'/almacen/getErrores',
            type: 'GET',
            datatype: 'json',
            success: function(data){
                $('#table-content-captura-errores').empty();
                if(data != "")
                {
                    for(let a=0; a  < data.length; a++)
                    {
                        $('#table-content-captura-errores').append(
                            '<tr>'
                            +'<td class="text-center p-0">'+data[a].articulo+'</td>'
                            +'<td class="text-center p-0">'+data[a].cantidad+'</td>'
                            +'<td class="text-center p-0">'+data[a].pedido+'</td>'
                            +'<td class="text-center p-0">'+data[a].surtidor+'</td>'
                            +'<td class="text-center p-0">'+data[a].tipoError+'</td>'
                            +'<td class="text-center p-0">'+data[a].mesa+'</td>'
                            +'<td class="text-center p-0">'+data[a].usuario+'</td>'
                            +'<td class="text-center p-0"><button type="button " class="btn btn-block btn-primary btn-sm" data-iderror="'+data[a].idError+'" onclick="capturaErroresController.modalError(this)">Cerrar</button></td>'
                            +'</tr>'
                        );   
                    }
                }
            },
            complete: function(){

            },
            error: function(error){
                console.log(error);
            }
        })
    },
    consultaCaptura: () => {
        $.ajax({
            url:'/almacen/capturaErrores/consultaCaptura',
            type: 'GET',
            datatype: 'json',
            success: function(data){
                console.log(data);
                $('#table-content-consulta').empty();
                for(let a=0;a < data.length; a++)
                {
                    $('#table-content-consulta').append(
                        '<tr>'
                        +'<td class="text-center">'+data[a].idError+'</td>'
                        +'<td class="text-center">'+data[a].articulo+'</td>'
                        +'<td class="text-center">'+data[a].cantidad+'</td>'
                        +'<td class="text-center">'+data[a].pedido+'</td>'
                        +'<td class="text-center">'+data[a].surtidor+'</td>'
                        +'<td class="text-center">'+data[a].tipoError+'</td>'
                        +'<td class="text-center">'+data[a].mesa+'</td>'
                        +'<td class="text-center">'+data[a].usuario+'</td>'
                        +'<td class="text-center">'+data[a].facilitador+'</td>'
                        +'</tr>'
                    );
                }
                $('#ConsultaCaptura').modal('show');
            },
            complete: function(){

            },
            error: function(error){

            }
        })
    },
    token:() =>{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },
} 