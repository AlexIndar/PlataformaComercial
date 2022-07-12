const repairReferences = ()=>{
    let folio = document.getElementById("refRepSol").value;
    if(folio != ""){
        $("#cargaModal").modal('show');
        let jsonFolio = {
            Folio: folio
        }
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': "/SoporteIndarnet/RepairReferences",
            'type': 'POST',
            'dataType': 'json',
            'data': jsonFolio,
            'enctype': 'multipart/form-data',
            'timeout': 2 * 60 * 60 * 1000,
            success: function (data) {
                $("#cargaModal").modal('hide');
                if(data == true){
                    document.getElementById("refRepSol").value = "";
                    document.getElementById("infoModalR").innerHTML = "Referencia actualizada";
                }else{
                    document.getElementById("infoModalR").innerHTML = "Error al intentar reparar";
                }
                $("#infoReport").modal('show');
            },
            error: function (error) {
                document.getElementById("infoModalR").innerHTML = "Error en el servidor";
                $("#infoReport").modal('show');
            }
        });
    }else{
        document.getElementById("infoModalR").innerHTML = "Campo vacio"
        $("#infoReport").modal('show');
    }
}