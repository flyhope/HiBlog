$(function() {
	
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
});
