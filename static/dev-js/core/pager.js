/**
 * 分页JS
 */
(function($) {
	
	/**
	 * 注册jQuery分页插件
	 */
	$.fn.extend({
		
		"pager" : function() {
			console.log("aaa");
			var $pager_box = $(this);
			var next_since_id = $pager_box.attr("next_since_id");
			var prev_since_id = $pager_box.attr("prev_since_id");
			$pager_box.delegate("[action-type=pager-go]", "click", function() {
				var href = location.search
				href += (href ? "&" : "?") + "next_since_id=" + encodeURIComponent(next_since_id) + "&prev_since_id=" + encodeURIComponent(prev_since_id);
				href += "&p=" + $(this).attr("number");
				location.href = href;
			});
		}
	
	});
})(jQuery);


$(function(){
	$("[node-type=pager]").pager();
});