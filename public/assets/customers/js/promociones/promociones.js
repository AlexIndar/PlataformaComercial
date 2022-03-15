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

function closeModalDelete(){
    $('#confirmDeleteModal').modal('hide');
}

function eliminarPromo(){
    $("#formDelete").submit();
} 