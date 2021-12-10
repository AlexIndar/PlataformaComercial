$(document).ready(function (){
    var table = $('#datatable').DataTable({
        'processing': true,
        'serverSide': true,
        'ajax':{
            "url": "getDataInfo",
            "type": "GET"
        },
        'columns': [
            {'data': 'nombre'},
            {'data': 'apellido'},
            {'data': 'email'},
        ],
    });

    $('.filter-input').keyup(function(){
        table.column( $(this).data('column'))
        .search($(this).val())
        .draw();
    });

    $('.filter-select').change(function(){
        table.column( $(this).data('column'))
        .search($(this).val())
        .draw();
    });
});