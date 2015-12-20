$(function() {

	function resizeSides() {
	    if ($(window).width() < 992) {
	        $("#sides").removeClass("in");
	        $("body").removeClass("md");
	        
	    } else {
	    	$("#sides").collapse("show");
	    	$("body").addClass("md");
	    };
	}
	$(window).bind("resize", resizeSides);
	resizeSides();
});