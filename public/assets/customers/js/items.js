

$(document).ready(function(){

	var native_width = 0;
	var native_height = 0;

	$(".magnify").mousemove(function(e){
		
		if(!native_width && !native_height)
		{
		
			var image_object = new Image();
			image_object.src = $(".small").attr("src"); 
			
		
			native_width = image_object.width;
			native_height = image_object.height;
		}
		else
		{
		
			var magnify_offset = $(this).offset();
		
			var mx = e.pageX - magnify_offset.left;
			var my = e.pageY - magnify_offset.top;
		
			if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
			{
				$(".large").fadeIn(100);
			}
			else
			{
				$(".large").fadeOut(100);
			}
			if($(".large").is(":visible"))
			{

				var rx = Math.round(mx/$(".small").width()*native_width - $(".large").width()/2)*-1;
				var ry = Math.round(my/$(".small").height()*native_height - $(".large").height()/2)*-1;
				var bgp = rx + "px " + ry + "px";
				
				var px = mx - $(".large").width()/2;
				var py = my - $(".large").height()/2;
			
				$(".large").css({left: px, top: py, backgroundPosition: bgp});
			}
		}
	})
})


function ver(e){
    var x, y, x1, x2, y1, y2;
    fact = 1;
    opp = 150;
    
    if(e == null) e = window.event;

    else{

        x = e.clientX;
        y = e.clientY;

        console.log(document.images.grande.style.clip);
    
        x1 =- opp + (x)*fact -250;
        y1 =- opp + (y)*fact - 100;
        x2 =+ opp + (x)*fact -250;
        y2 =+ opp + (y)*fact -100;
    
        document.images.grande.style.display = "inline";
        document.images.grande.style.left = (x) * (2-fact);
        document.images.grande.style.top = (y) * (2-fact);
        document.images.grande.style.clip = "rect("+y1+"px,"+x2+"px,"+y2+"px,"+x1+"px)";

        console.log(document.images.grande.style.clip);

    }

 

}



function detailsProduct(id){
	if(getCookie("laravel-token")){
		window.location.href = "detallesProducto/"+id;
	  }
	  else{
		activeModal(1);
	  }
}

function increaseQuantity(){
    var quantity = document.getElementById('quantity').innerHTML;
    var num = parseInt(quantity);
    num = num + 1;
    console.log(num);

    document.getElementById('quantity').innerHTML = num.toString();
}


function decreaseQuantity(){
    var quantity = document.getElementById('quantity').innerHTML;
    var num = parseInt(quantity);
    if(num != 0){
        num = num - 1;
    }
    document.getElementById('quantity').innerHTML = num.toString();
}



