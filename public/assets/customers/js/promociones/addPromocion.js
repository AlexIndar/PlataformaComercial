$('document').ready(function(){

    $(".chosen").chosen({
        no_results_text: "Sin resultados para",
        placeholder_text_single: "Buscar",
        placeholder_text_multiple: "Seleccione una o más opciones"
    });

    

    const fileArticulos = document.getElementById('articulosFile');
	fileArticulos.addEventListener('change', (event) => {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
	
			wb.SheetNames.forEach(function(sheetName){
			var rowObj =XLSX.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
			var jsonObj = JSON.stringify(rowObj);
			addTags(jsonObj, document.getElementById('articulos'));
			})
		};
		reader.readAsBinaryString(input.files[0]);
	});

    $('#fechas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-fechas').innerHTML = "Estas fechas <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-fechas').classList.remove('green');
            document.getElementById('mensaje-fechas').classList.add('red');
        }
        else{
            document.getElementById('mensaje-fechas').innerHTML = "<strong>Sólo estas fechas</strong> participan en la promoción";
            document.getElementById('mensaje-fechas').classList.add('green');
            document.getElementById('mensaje-fechas').classList.remove('red');
        }
    });

    $('#listaCategoriaClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-categorias').innerHTML = "Estas categorías de clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-categorias').classList.remove('green');
            document.getElementById('mensaje-categorias').classList.add('red');
        }
        else{
            document.getElementById('mensaje-categorias').innerHTML = "<strong>Sólo estas categorías de clientes</strong> participan en la promoción";
            document.getElementById('mensaje-categorias').classList.add('green');
            document.getElementById('mensaje-categorias').classList.remove('red');
        }
    });

    $('#listaGirosClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-giros').innerHTML = "Estos giros de clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-giros').classList.remove('green');
            document.getElementById('mensaje-giros').classList.add('red');
        }
        else{
            document.getElementById('mensaje-giros').innerHTML = "<strong>Sólo estos giros de clientes</strong> participan en la promoción";
            document.getElementById('mensaje-giros').classList.add('green');
            document.getElementById('mensaje-giros').classList.remove('red');
        }
    });

    $('#listaClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-clientes').innerHTML = "Estos clientes <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-clientes').classList.remove('green');
            document.getElementById('mensaje-clientes').classList.add('red');
        }
        else{
            document.getElementById('mensaje-clientes').innerHTML = "<strong>Sólo estos clientes</strong> participan en la promoción";
            document.getElementById('mensaje-clientes').classList.add('green');
            document.getElementById('mensaje-clientes').classList.remove('red');
        }
    });

    $('#listaProveedores').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-proveedores').innerHTML = "Estos proveedores <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-proveedores').classList.remove('green');
            document.getElementById('mensaje-proveedores').classList.add('red');
        }
        else{
            document.getElementById('mensaje-proveedores').innerHTML = "<strong>Sólo estos proveedores</strong> participan en la promoción";
            document.getElementById('mensaje-proveedores').classList.add('green');
            document.getElementById('mensaje-proveedores').classList.remove('red');
        }
    });

    $('#listaMarcas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-marcas').innerHTML = "Estas marcas <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-marcas').classList.remove('green');
            document.getElementById('mensaje-marcas').classList.add('red');
        }
        else{
            document.getElementById('mensaje-marcas').innerHTML = "<strong>Sólo estas marcas</strong> participan en la promoción";
            document.getElementById('mensaje-marcas').classList.add('green');
            document.getElementById('mensaje-marcas').classList.remove('red');
        }
    });

    $('#listaArticulos').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        if(clickedIndex == 1){
            document.getElementById('mensaje-articulos').innerHTML = "Estos artículos <strong>no participan</strong> en la promoción";
            document.getElementById('mensaje-articulos').classList.remove('green');
            document.getElementById('mensaje-articulos').classList.add('red');
        }
        else{
            document.getElementById('mensaje-articulos').innerHTML = "<strong>Sólo estos artículos</strong> participan en la promoción";
            document.getElementById('mensaje-articulos').classList.add('green');
            document.getElementById('mensaje-articulos').classList.remove('red');
        }
    });

    $('input[name="daterange"]').daterangepicker({
        opens: 'right',
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });


    $('#descuento').on('input', function() {
        var val = document.getElementById('descuento').value;
       document.getElementById('percent-disccount').innerHTML = val;
    });

});

function existingTag(text)
{
	var existing = false,
		text = text.toLowerCase();

	$(".tags").each(function(){
		if ($(this).text().toLowerCase() == text) 
		{
			existing = true;
			return "";
		}
	});

	return existing;
}



$(function(){
    $(".tags-new input").focus();
    
    $(".tags-new input").keyup(function(e){
  
          var tag = $(this).val().trim(),
          length = tag.length;
  
          if(e.key === "Enter" || e.keyCode === 13)
          {
              tag = tag.substring(0, length);
  
              if(!existingTag(tag))
              {
                  var last = document.querySelector('.last');
                  if(last!=null){
                      document.querySelector('.last').classList.remove('last');
                  }
                  $('<li class="tags last"><span>' + tag + '</span><i class="fa fa-times"></i></i></li>').insertBefore($(".tags-new"));
                  $(this).val("");	
              }
              else
              {
                  $(this).val(tag);
              }
          }
  
  
          if(e.key === "Backspace" || e.keyCode === 46){
                 var tag = document.querySelector('.last');
                 if(tag!=null){
                  if(tag.style.background == "rgb(250, 91, 91)"){
                      tag.remove();
                  }
                  else{
                          tag.style.background = "rgb(250, 91, 91)";
                  }
                 }
  
                 var lastTag = document.querySelectorAll(".tags");
              if(lastTag.length != 0){
                  lastTag[lastTag.length -1].classList.add('last');
              }
          }
  
  
      });
    
    $(document).on("click", ".tags i", function(){
      $(this).parent("li").remove();
    });
  
  });


function triggerInputFile(input){
	document.getElementById(input+'File').click();
}


function addTags(json, element){
    var jsonObj = JSON.parse(json);
    console.log(jsonObj);
    console.log(element);
    $('#articulos').val(["22", "25", "27"]).trigger('chosen:updated');
}