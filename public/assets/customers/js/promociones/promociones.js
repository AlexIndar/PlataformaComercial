function addPromocion(){
    window.location.href = "promociones/nueva";
} 

function editarPromo(id){
    $("#id").val(id);
    $("#form").submit();
}