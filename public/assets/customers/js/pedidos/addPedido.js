var info = [];
var addresses = [];
var shippingWays = [];
var packageDeliveries = [];


indexCustomer = 0;
indexAddress = 0;
shippingWay = 0;
packageDelivery = 0;

$(document ).ready(function() {
    
	var entity = document.getElementById('entity').value;
	$.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            url: "getInfoHeatWeb/" + entity,
            data: FormData,
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data){
                    info = data;
            }, 
            error: function(error){
                  console.log(error);
             }
    }); 

	// UPDATE ADDRESSES AND DEFAULT SHIPPING WAT / PACKAGING WHEN CUSTOMER IS SELECTED ----------------------------------------------------------------

	$('#customerID').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var selected = clickedIndex - 1;
		indexCustomer = selected;
		addresses = info[selected]['addresses'];
		shippingWays = info[selected]['shippingWays'];
		packageDeliveries = info[selected]['packageDeliveries'];

		var itemSelectorOption = $('#sucursal option');
		itemSelectorOption.remove(); 
		$('#sucursal').selectpicker('refresh');

		for (var x = 0; x < addresses.length ; x++){
			$('#sucursal').append('<option value="'+addresses[x]['addressID']+'">'+addresses[x]['address']+'</option>');
			$('#sucursal').val(addresses[x]['addressID']);
			$('#sucursal').selectpicker("refresh");
		}

		$('#sucursal').val(addresses[0]['addressID']);
		$('#sucursal').selectpicker('refresh');

		$('#envio').val(info[selected]['shippingWayF']);
		$('#fletera').val(info[selected]['packgeDeliveryF']);
		$('#correo').val(info[selected]['email']);


	});

	// UPDATE DEFAULT SHIPPING WAT / PACKAGING WHEN ADDRESS IS CHANGED -------------------------------------------------------------------------------------

	$('#sucursal').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var selected = clickedIndex;
		if(info.length == 1){
			console.log(info);
			addresses = info[0]['addresses'];
			shippingWays = info[0]['shippingWays'];
			packageDeliveries = info[0]['packageDeliveries'];
		}
			$('#envio').val(shippingWays[selected]);
			$('#fletera').val(packageDeliveries[selected]);
		

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
				   console.log(tag.style.background);
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


                                