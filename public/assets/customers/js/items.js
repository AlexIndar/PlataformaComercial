
$('document').ready(function(){
    /* 
 Demo for jQuery AnythingZoomer Plugin
 https://github.com/CSS-Tricks/AnythingZoomer
 */
$(function() {
    $("#zoom").anythingZoomer({
        // content areas
        smallArea   : 'small',    // class of small content area; the element with this class name must be inside of the wrapper
        largeArea   : 'large',    // class of large content area; this class must exist inside of the wrapper. When the clone option is true, it will add this automatically
        clone       : false,      // Make a clone of the small content area, use css to modify the style
      
        // appearance
        overlay     : false,      // set to true to apply overlay class "az-overlay"; false to not apply it
        speed       : 100,        // fade animation speed (in milliseconds)
        edge        : 30,         // How far outside the wrapped edges the mouse can go; previously called "expansionSize"
        offsetX     : 0,          // adjust the horizontal position of the large content inside the zoom window as desired
        offsetY     : 0,          // adjust the vertical position of the large content inside the zoom window as desired
      
        // functionality
        switchEvent : 'dblclick', // event that allows toggling between small and large elements - default is double click
      
        // edit mode
        edit        : false,      // add x,y coordinates into zoom window to make it easier to find coordinates
      
        // callbacks
        initialzied : function(event, zoomer){}, // AnythingZoomer done initializing
        zoom        : function(event, zoomer){}, // zoom window visible
        unzoom      : function(event, zoomer){}  // zoom window hidden
      
      });
  });
  
});







function detailsProduct(id){
    id.replace(/\s/g, "_");
    window.location.href = "detallesProducto/"+id;
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

