function pokazt(id) {
   var e = document.getElementById(id);
  	e.style.visibility="visible";
}

function ukryjt(id) {
   var e = document.getElementById(id);
  	e.style.visibility="hidden";
}

jQuery(document).ready(function(){
	jQuery(".deactive").css("opacity", 0.2);
});
