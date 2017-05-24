function pokazt(id) {
   var e = document.getElementById(id);
  	e.style.visibility="visible";
}

function ukryjt(id) {
   var e = document.getElementById(id);
  	e.style.visibility="hidden";
}

$(document).ready(function(){
	$(".deactive").css("opacity", 0.2);
});
