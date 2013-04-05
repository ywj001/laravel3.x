
$(function(){
	$('.info').animate({opacity: 1.0}, 3000).fadeOut('slow'); 
	
});

function dump(myObject) {  
  var s = "";  
  for (var property in myObject) {  
   s = s + "\n "+property +": " + myObject[property] ;  
  }  
  alert(s);  
} 