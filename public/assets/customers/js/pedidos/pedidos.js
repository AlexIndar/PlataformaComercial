var cotizaciones;

$(document).ready(function(){
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            url: "getPedidos",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data){
                    cotizaciones = data;
            }, 
            error: function(error){
                  console.log(error);
             }
    
        }); 
});

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

function filtrar(){
    var key = document.getElementById('filterKey').value;
    var value = document.getElementById('filterValue').value;
    var filtered = [];
    cotizaciones.forEach(cotizacion => {
        if(cotizacion[key] == value)
            filtered.push(cotizacion);
    });

    var row = document.getElementById('rowPedidos');

    while (row.firstChild) {
        row.removeChild(row.firstChild);
    }
    
    for(var x = 0; x < filtered.length; x++){
        var ordenCompra = filtered[x]['orderC'] != null ? filtered[x]['orderC'] : "";
        var container = document.createElement('div');
        container.classList = "promo"; 

        var div1 = document.createElement('div');
        div1.classList = "promo-header"; 

        var hheader = document.createElement('h4');
        hheader.innerHTML = "[#"+filtered[x]['idCotizacion']+" - "+filtered[x]['companyId'].toUpperCase()+"] "+ordenCompra;
        var actions = document.createElement('div');
        actions.classList = "actions";
        var btnGroup = document.createElement('div');
        btnGroup.classList = "btn-group";
        btnGroup.setAttribute('role', 'group');
        btnGroup.setAttribute('aria-label', 'Basic example');

        var btnEdit = document.createElement('button');
        btnEdit.setAttribute('type', 'button');
        btnEdit.setAttribute('class', 'btn btn-info');
        btnEdit.setAttribute('title', 'Editar');
        btnEdit.setAttribute('onclick', "editarPedido(\""+filtered[x]['idCotizacion']+"\",\""+filtered[x]['companyId']+"\")");
        var iEdit = document.createElement('i');
        iEdit.setAttribute('class', 'fas fa-edit');

        var btnDelete = document.createElement('button');
        btnDelete.setAttribute('type', 'button');
        btnDelete.setAttribute('class', 'btn btn-danger');
        btnDelete.setAttribute('title', 'Eliminar');
        btnDelete.setAttribute('onclick', "activarEliminarModal(\""+filtered[x]['idCotizacion']+"\")");
        var iDelete = document.createElement('i');
        iDelete.setAttribute('class', 'fas fa-trash');

        btnEdit.appendChild(iEdit);
        btnDelete.appendChild(iDelete);
        btnGroup.appendChild(btnEdit);
        btnGroup.appendChild(btnDelete);
        actions.appendChild(btnGroup);

        div1.appendChild(hheader);
        div1.appendChild(actions);

        var div2 = document.createElement('div');
        div2.classList = "cuerpo-promo"; 

        var hbody1 = document.createElement('h5');
        hbody1.innerHTML = "Forma Envío <span class='fecha'><i class='fas fa-truck-loading'></i> "+filtered[x]['shippingWay']+"</span> Fletera <span class='fecha'><i class='fas fa-shipping-fast'></i> "+filtered[x]['packageDelivery']+"</span> "
        var hbody2 = document.createElement('h5');
        hbody2.innerHTML = filtered[x]['addressName'];
        var hbody3 = document.createElement('h5');
        hbody3.innerHTML = filtered[x]['comments'];

        div2.appendChild(hbody1);
        div2.appendChild(hbody2);
        div2.appendChild(hbody3);

        container.appendChild(div1);
        container.appendChild(div2);

        row.appendChild(container);
        
    }




}