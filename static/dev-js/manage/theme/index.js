$(function() {
	$("#theme-container").delegate("[action-type=copy]", "click", function() {
		//复制模板
		var theme_id = $(this).parents("[node-type=theme-node]").attr("id");
		var href = $CONFIG.path + "aj/theme/copy";
		$.post(href, {"id" : theme_id}, $.ajaxCallbackDefault);
		
		
	}).delegate("[action-type=use]", "click", function() {
		
	});
	
});