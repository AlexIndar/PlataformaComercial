function addPedido(){
    $("#formNuevo").submit();
}

function editarPedido(id, companyId){
    $("#id").val(id);
    $("#companyId").val(companyId);
    $("#formEditar").submit();
} 

function activarEliminarModal(id){
    $("#idCotizacion").val(id);
    //type indica si se quiere  borrar una cotización que ya estaba guardada o una cotización que se estaba realizando pero nunca se guardó
    $('#confirmDeleteModal').modal('show');
}

function closeModalDelete(){
    $('#confirmDeleteModal').modal('hide');
}

function eliminarCotizacion(){
    $("#formDelete").submit();
} 