$(document).ready(function(){
    $('#cover-spin').show(0);
    exportaController.initAll();
    exportaController.pages();
    var table = $('#table-precios').DataTable({
        paging: true,
        responsive: true,
        searching: true,
        processing: true,
        bSortClasses: false,
        fixedHeader: true,
        // scrollY:        400,
        deferRender:    true,
        scroller:       true,
        columns: [
            { data:'claveFabricante', visible:true},
            { data:'articulo', visible:true},
            { data:'descripcion', visible:true},
            { data:'precio', visible:true},
            { data:'moneda', visible:true},
            { data:'promocion', visible:true},
            { data:'unidad', visible:true},
            { data:'existencias', visible:true},
            { data:'categoria', visible:true},
            { data:'multiplo', visible:true},
            { data:'iva', visible:true},
            { data:'proveedor', visible:true},
            { data:'familia', visible:true},
            { data:'claveFabricante', visible:true},
            { data:'empaque', visible:true},
            { data:'precio7', visible:true},
            { data:'precio8', visible:true},
            { data:'precio10', visible:true},
            { data:'precio2', visible:true},
            { data:'precio3', visible:true},
            { data:'precio2', visible:true}
        ],
        language: {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Documentos",
            "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Documentos",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
            }
        }
    });
});
var Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    timer: 8000,
    timerProgressBar: false
});
let arrayPrecios = new Array(), arrayPedidos = new Array();
let contRows=0;
let exportaController = {
    addRow: () => {
        contRows++
        $('#table-content-pedidos').append(
            '<tr id="row'+contRows+'">'
                +'<td>'+contRows+'</td>'
                +'<td style="background-color: #04d1db" id="prod'+contRows+'" class="inputProd" data-row="'+contRows+'" onclick="exportaController.showInputProd(this)" width="10%">'
                +'<input type="text" id="inputProd'+contRows+'" style="width: 100%;height: 24px;" class="form-control" data-row="'+contRows+'" onchange="exportaController.changeProducto(this)" onkeyup="this.value = this.value.toUpperCase()" style="width: 100%;height: 24px;" hidden>'
                +'</td>'
                +'<td style="background-color: #04d1db" id="cant'+contRows+'" class="inputCant" data-row="'+contRows+'" onclick="exportaController.showInputCant(this)" width="5%">'
                    +'<input type="number" id="inputCant'+contRows+'" data-row="'+contRows+'" onchange="exportaController.changeCant(this)"  class="form-control" style="width: 100%!important;height: 24px;" hidden>'
                +'</td>'
                +'<td id="unidad'+contRows+'"></td>'
                +'<td id="emp'+contRows+'"></td>'
                +'<td id="existencia'+contRows+'"></td>'
                +'<td id="descripcion'+contRows+'"></td>'
                +'<td id="precioLista'+contRows+'">0.00</td>'
                +'<td style="background-color: blanchedalmond" id="promo'+contRows+'">0.00</td>'
                +'<td style="background-color: #db0404; color: white" id="precioventa'+contRows+'">0.00</td>'
                +'<td id="importe'+contRows+'">0.00</td>'
                +'<td id="iva'+contRows+'">0.00</td>'
                +'<td id="pp'+contRows+'">0.00</td>'
                +'<td id="observaciones'+contRows+'"></td>'
                +'<td>'
                    +'<button type="button" class="btn btn-danger" data-row="'+contRows+'" onclick="exportaController.deleteRow(this)">X</button>'
                +'</td>'
            +'</tr>'
        );
        arrayPedidos.push({
            'row':contRows,
            'producto':'',
            'cantidad':'',
            'unidad':'',
            'emp':'',
            'existencia':'',
            'descrpcion':'',
            'precioLista':'0.00',
            'promo':'0.00',
            'precioVenta':'0.00',
            'importe':'0.00',
            'iva':'0.00',
            'pp':'0.00',
            'observaciones':''
        });
    },
    deleteRow: (e) => {
        let row = $(e).data('row');
        $('#row'+row).remove();
        for(let a=0; a < arrayPedidos.length; a++)
        {
            if(arrayPedidos[a] != undefined)
            {
                if(arrayPedidos[a].row == row)
                {
                    delete arrayPedidos[a];
                }
            } 
        }
        contRows--;
    },
    initAll: () => {
        exportaController.preciosPage();
        arrayPedidos.push({
            'row':0,
            'producto':'',
            'cantidad':'',
            'unidad':'',
            'emp':'',
            'existencia':'',
            'descrpcion':'',
            'precioLista':'0.00',
            'promo':'0.00',
            'precioVenta':'0.00',
            'importe':'0.00',
            'iva':'0.00',
            'pp':'0.00',
            'observaciones':''
        });
    },
    pages: () => {
        $('.page').on('click', function(){
            let page = $(this).text();
            switch(page)
            {
                case 'Pedido':
                    $('#'+page).prop('hidden',false);
                    $('#Precios').prop('hidden',true);
                    $('#Clientes').prop('hidden',true);
                    $('#O.C Pendientes').prop('hidden',true);
                    $('#Paquetes').prop('hidden',true);
                    break;
                case 'Precios':
                    $('#'+page).prop('hidden',false);
                    $('#Pedido').prop('hidden',true);
                    $('#Clientes').prop('hidden',true);
                    $('#O.C Pendientes').prop('hidden',true);
                    $('#Paquetes').prop('hidden',true);
                    break;
                case 'Clientes':
                    $('#'+page).prop('hidden',false);
                    $('#Precios').prop('hidden',true);
                    $('#Pedido').prop('hidden',true);
                    $('#O.C Pendientes').prop('hidden',true);
                    $('#Paquetes').prop('hidden',true);
                    break;
                case 'O.C Pendientes':
                    $('#'+page).prop('hidden',false);
                    $('#Precios').prop('hidden',true);
                    $('#Clientes').prop('hidden',true);
                    $('#Pedido').prop('hidden',true);
                    $('#Paquetes').prop('hidden',true);
                    break;
                case 'Paquetes':
                    $('#'+page).prop('hidden',false);
                    $('#Precios').prop('hidden',true);
                    $('#Clientes').prop('hidden',true);
                    $('#O.C Pendientes').prop('hidden',true);
                    $('#Pedido').prop('hidden',true);
                    break;
            }
        });
    },
    changeProducto: (e) => {
        let row = $(e).data('row');
        let articulo = $('#inputProd'+row).val();
        $('#prod'+row).empty();
        $('#prod'+row).append(
            '<strong id="textProd'+row+'">'+articulo+'</strong>'
            +'<input type="text" id="inputProd'+row+'" style="width: 100%;height:100%;" class="form-control" data-row="'+row+'" onchange="exportaController.changeProducto(this)" style="width: 100%;height: 24px;" value="'+articulo+'" hidden>'
        );
        let categoria='',importe='',claveFabricante='',descripcion='',empaque='',existencias='',familia='',iva='',moneda='',multiplo='',precioLista='',precio2='',precio3='',precio4='',precio7='',precio8='',promocion='',proveedor='',unidad='';
        bandera = 0;
        arrayPrecios.forEach(element => {
            if(element.articulo == articulo)
            {
                articulo = element.articulo;
                categoria = element.categoria;
                claveFabricante = element.claveFabricante;
                descripcion = element.descripcion;
                empaque = element.empaque;
                existencias = element.existencias;
                familia = element.familia;
                iva = element.iva;
                moneda = element.moneda;
                multiplo = element.multiplo;
                precioLista = element.precio;
                precio2 = element.precio2;
                precio3 = element.precio3;
                precio4 = element.precio4;
                precio7 = element.precio7;
                precio8 = element.precio8;
                promocion = element.promocion;
                proveedor = element.proveedor;
                unidad = element.unidad;

                
                let precioVenta = precioLista - promocion;
                let cantidad = $('#inputCant'+row).val();
                if(cantidad == ''){
                    cantidad = 0;
                }
                importe = precioVenta * cantidad;
                arrayPedidos.forEach(element => {
                    if(element.row == row)
                    {
                        element.cantidad = '';
                        element.descripcion = descripcion;
                        element.emp= empaque;
                        element.existencia = existencias;
                        element.importe = importe;
                        element.iva = iva;
                        element.observaciones = '';
                        element.pp = '';
                        element.precioLista = precioVenta;
                        element.precioVenta = precio2;
                        element.producto = articulo;
                        element.promo = promocion;
                        element.unidad = unidad;
                    }
                });
                $('#unidad'+row).empty();
                $('#emp'+row).empty();
                $('#existencia'+row).empty();
                $('#descripcion'+row).empty();
                $('#precioLista'+row).empty();
                $('#promo'+row).empty();
                $('#precioventa'+row).empty();
                $('#importe'+row).empty();
                $('#iva'+row).empty();
                $('#pp'+row).empty();
                $('#observaciones'+row).empty();
                
                $('#unidad'+row).append('<strong>'+unidad+'</strong>');
                $('#emp'+row).append('<strong>'+empaque+'</strong>');
                $('#existencia'+row).append('<strong>'+existencias+'</strong>');
                $('#descripcion'+row).append('<strong>'+descripcion+'</strong>');
                $('#precioLista'+row).append('<strong>'+precioLista.toFixed(2)+'</strong>');
                $('#promo'+row).append('<strong>'+promocion+'</strong>');
                $('#precioventa'+row).append('<strong>'+precioVenta.toFixed(2)+'</strong>');
                $('#importe'+row).append('<strong>'+importe+'</strong>');
                $('#iva'+row).append('<strong>'+iva+'</strong>');
                $('#pp'+row).append('<strong>0.00</strong>');
                $('#observaciones'+row).append('<strong></strong>');
                bandera = 1;
                return;
            }
        });
        if(bandera == 0)
        {
            Toast.fire({
                icon: 'error',
                title: '¡Este producto no existe!'
            });
            $('#inputProd'+row).val('');
            $('#inputProd'+row).prop('hidden', true);
            $('#textProd'+row).empty();
            $('#textProd'+row).prop('hidden',false);
        }
    },
    changeCant: (e) => {
        let row =  $(e).data('row');
        let cantidad = $('#inputCant'+row).val();
        let articulo = $('#inputProd'+row).val();
        if(articulo != '' || 0)
        {
            $('#cant'+row).empty();
            $('#cant'+row).append(
                '<strong id="textCant'+row+'">'+cantidad+'</strong>'
                +'<input type="text" id="inputCant'+row+'" style="width: 100%;height: 100%;" class="form-control" data-row="'+row+'" onchange="exportaController.changeCant(this)" style="width: 100%;height: 24px;" value="'+cantidad+'" hidden>'
            );
            for(let a=0; a < arrayPedidos.length; a++)
            {
                if(arrayPedidos[a] != undefined)
                {
                    if(arrayPedidos[a].row == row)
                    {
                        $('#unidad'+row).empty();
                        $('#emp'+row).empty();
                        $('#existencia'+row).empty();
                        $('#descripcion'+row).empty();
                        $('#precioLista'+row).empty();
                        $('#promo'+row).empty();
                        $('#precioventa'+row).empty();
                        $('#importe'+row).empty();
                        $('#iva'+row).empty();
                        $('#pp'+row).empty();
                        $('#observaciones'+row).empty();
                        let precioLista = arrayPedidos[a].precioLista;
                        let precioVenta = arrayPedidos[a].precioVenta;
                        cantidad = cantidad == '' ? 0 : cantidad;
                        let importe = precioVenta * cantidad;
                        let updateExistencias = arrayPedidos[a].existencia - cantidad;
                        $('#unidad'+row).append('<strong>'+arrayPedidos[a].unidad+'</strong>');
                        $('#emp'+row).append('<strong>'+arrayPedidos[a].emp+'</strong>');
                        $('#existencia'+row).append('<strong>'+updateExistencias+'</strong>');
                        $('#descripcion'+row).append('<strong>'+arrayPedidos[a].descripcion+'</strong>');
                        $('#precioLista'+row).append('<strong>'+precioLista.toFixed(2)+'</strong>');
                        $('#promo'+row).append('<strong>'+arrayPedidos[a].promo+'</strong>');
                        $('#precioventa'+row).append('<strong>'+precioVenta.toFixed(2)+'</strong>');
                        $('#importe'+row).append('<strong>'+exportaController.replaceNumberWithCommas(importe.toFixed(2))+'</strong>');
                        $('#iva'+row).append('<strong>'+arrayPedidos[a].iva+'</strong>');
                        $('#pp'+row).append('<strong>0.00</strong>');
                        $('#observaciones'+row).append('<strong></strong>');
                        arrayPedidos[a].importe = importe;
                        break;
                    }
                }
            }
        }else{
            Toast.fire({
                icon: 'error',
                title: '¡Ingrese primero un producto!'
            });
            $('#inputCant'+row).val('');
            $('#inputCant'+row).prop('hidden', true);
            $('#textCant'+row).prop('hidden',false);
        }
        
    },
    replaceNumberWithCommas: (numero) => {
        //Seperates the components of the number
        var n= numero.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    },
    contTotal: () => {
        let suma = 0;
        let sumaTotal = 0;
        for(let a=0; a < arrayPedidos.length; a++)
        {
            if(arrayPedidos[a] != undefined)
            {
                suma += arrayPedidos[a].importe;
            }
        }
        $('#Suma').empty();
        $('#Suma').append(exportaController.replaceNumberWithCommas(suma.toFixed(2)));//A0 MN1400 - W2 520396-OUT
    },
    preciosPage: (page) => {
        $.ajax({
            url: '/exporta/precios',
            type: 'GET',
            datatype: 'json',
            success: function(data){
                arrayPrecios = data;
                $('#table-content-pedidos').prop('hidden',false); //Se habilita la tabla de pedidos hasta que los precios se hayan cargado
                $('#table-precios').DataTable().clear().draw();
                $('#table-content-precios').empty();
                $('#table-precios').DataTable().rows.add(data).draw();
            },
            error: function(){

            },
            complete: function(){
                $('#cover-spin').prop('hidden',true);
            }
        })
    },
    showInputProd: (e) => {
        
        let row = $(e).data('row');
        $('#textProd'+row).prop('hidden',true);
        $('#inputProd'+row).prop('hidden',false);
        $('#inputCant'+row).prop('hidden',true);
        $('#textCant'+row).prop('hidden',false);
    },
    showInputCant: (e) => {
        let row = $(e).data('row');

        $('#textCant'+row).prop('hidden',true);
        $('#inputCant'+row).prop('hidden',false);

        $('#textProd'+row).prop('hidden',false);
        $('#inputProd'+row).prop('hidden',true);
    }
}