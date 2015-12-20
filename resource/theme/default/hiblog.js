$(function() {

	//响应式设计交互
	function resizeSides() {
	    if ($(window).width() < 992) {
	        $("#sides").removeClass("in"); //右侧栏
	        $("body").removeClass("md");	//body右空白区域
	        
	    } else {
	    	$("#sides").collapse("show"); //右侧栏
	    	$("body").addClass("md");	//body右空白区域
	    };
	}
	$(window).bind("resize", resizeSides);
	
	//加载右侧栏
	$("#sidebar").load("./block/sidebar.html", resizeSides);
	

	
});
