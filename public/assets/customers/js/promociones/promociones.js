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