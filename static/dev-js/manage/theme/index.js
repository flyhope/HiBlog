$(function() {
	
	//复制模板弹层事件
	$("#modal-theme-copy").on("show.bs.modal", function(event) {
		//复制模板
		var button = $(event.relatedTarget);
		var theme_node = button.parents("[node-type=theme-node]");
		var theme_id = theme_node.data("theme-id");
		
		$(this).find("[name=alias_id]").val(theme_id);
	});
	
	//复制模板表单提交事件
	$("#form-theme-copy").ajaxSubmit();
	
	
	$("#theme-container").delegate("[action-type=use]", "click", function() {
		
	});
	
});