function addPedido(){
    window.open('/pedido/nuevo', '_blank');
}

function editarPedido(id, companyId){

    $("#id").val(id);
    $("#companyId").val(companyId);
    $("#form").submit();

}