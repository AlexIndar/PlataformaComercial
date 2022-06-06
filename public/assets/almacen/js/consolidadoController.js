$(document).ready(function(){
    setInterval(consolidadoController.reloadData, 8000);
});

let consolidadoController = {
    reloadData:() => {
        $.ajax({
            url:'/almacen/getConsolidado',
            type: 'GET',
            dataType: 'json',
            success: function(data)
            {
                $('#table-content-consolidado').empty();
                for(let a=0; a < data.length; a++){
                    let color = '';
                    let fletera = data[a].fletera;
                    let id = data[a].id;
                    let procesarTarima = data[a].procesarTarima;
                    if(id == 1)
                    {
                        id='<td><img src="/assets/almacen/img/pallet.png" height=70 width=75></td>';
                    }else{
                        id = '<td></td>';
                    }
                    if(procesarTarima >= 15)
                    {
                        procesarTarima = '<td><img src="/assets/almacen/img/mesa14.png" height=70 width=75></td>'
                    }else{
                        procesarTarima = '<td></td>';
                    }
                    if(data[a].avance == 100)
                    {
                        color = "btn-success";
                    }
                    if(data[a].avance<100)
                    {
                        color = "btn-warning";
                    }
                    if(data[a].avance == 100 && fletera.indexOf("CCI CLIENTE RECOGE") != -1)
                    {
                        color = "btn-danger";
                    }
                    if(data[a].avance == 100 && fletera.indexOf("CCI Cliente Recoge") != -1)
                    {
                        color = "btn-danger";
                    }
                    if(data[a].avance == 100 && fletera.indexOf("CCO CLIENTE ESTA AQUI") != -1)
                    {
                        color = "btn-danger";
                    }
                    $('#table-content-consolidado').append(
                        '<tr class="'+color+'">'
                        +'<td><center><b>'+data[a].ubicaciones+'</center></td>'
                        +'<td><center><b>'+data[a].pedido+'</center></td>'
                        +'<td><center><b>'+data[a].fletera+'</center></td>'
                        +id
                        +procesarTarima
                        +'<td><center><b>'+data[a].cajas+'</center></td>'
                        +'<td><center><b>'+data[a].avance+'</center></td>'
                        +'</tr>'
                    );
                }
            }
        })
        
    },
}