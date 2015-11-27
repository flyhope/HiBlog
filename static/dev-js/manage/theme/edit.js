$(function() {
	
	/**
	 * 主题HTML编辑器
	 */
	var theme_editor = ace.edit("theme-content");
	theme_editor.getSession().setMode("ace/mode/html");
	
	/**
	 * 绑定主题解锁点击事件
	 */
	$("#theme-unlock").click(function() {
		var href = $CONFIG.path + "aj/manage/theme/unlock";
		var theme_id = $(this).data("id");
		$.post(href, {"id":theme_id}, function(o) {
			$.ajaxCallback(o, location.reload);
		});
	});
	
	/**
	 * 代理显示源代码事件
	 */
	$("#resource-result").delegate("[action-type=show-resource]", "click", function() {
		var $tr = $(this).parents("tr:first");
		var href = $CONFIG.path + "aj/manage/theme/showresource";
		var theme_id = $tr.find("[node-type=id]").html();
		$.get(href, {"id":theme_id}, function(o) {
			$.ajaxCallback(o, function(o) {
				var $modal = $("#modal-show-resource");
				var resource_name = $tr.find("[node-type=resource_name]").html();
				$modal.find("[node-type=title]").html(resource_name);
				try {
					theme_editor.setValue(o.data.content);
					theme_editor.setReadOnly(o.data.readonly);
				} catch(e) {
					console.log(e);
				}
				
				$modal.modal();
				
			});
		});
	});
	
	/**
	 * 保存源代码
	 */
	
	
});
