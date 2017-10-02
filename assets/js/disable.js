$(document).keydown(function(e) {
  if (e.ctrlKey)
  {
    e.preventDefault();
    alert( "This key is disabled on this system" );
   
    
  }
  if (e.keyCode>=112 && e.keyCode<=123)
  {
    e.preventDefault();
    alert( "This key is disabled on this system" );
    
  }
  if (e.keyCode==18)
  {
    e.preventDefault();
    alert( "This key is disabled on this system" );
    
  }
  //console.log(e.which);
});
 $(document).on("mousedown",function(e) {
  if (e.button == 2)
  {
    alert( "This key is disabled on this system" );    
  } 
});
document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);