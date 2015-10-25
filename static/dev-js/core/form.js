(function($) {
	
	/**
	 * 静态方法插件
	 */
	$.extend({
		/**
		 * AJAX回调处理，默认有错误自动弹出
		 */
		"ajaxCallback" : function(rv, success_cb, fail_cb) {
			var auto_alert_error = true;
			try {
				var data = $.parseJSON(rv);
				if (data.code != 100000) {
					//失败
					if (typeof fail_cb !== "undefined") {
						auto_alert_error = fail_cb(data);
					}
	
					if (auto_alert_error) {
						$.alert(data.msg);
					}
	
				} else {
					//成功
					if (typeof success_cb !== "undefined") {
						success_cb(data);
					} else {
						$.alert("操作成功", false, function() {
							location.reload();
						});
					}
					
				}
				
			} catch (e) {
				console.log("aaa");
				$.alert(rv);
			}


		},

		/**
		 * AJAX默认回调，成功刷页，失败弹错
		 */
		"ajaxCallbackDefault" : function(response) {
			$.ajaxCallback(response, function() {
				location.reload();
			});
		}
	});
	
	
	/**
	 * 原型链插件
	 */
	$.fn.extend({
		
		/**
		 * 表单进行AJAX提交
		 * 
		 * @param {Object}
		 *            success_cb
		 * @param {Object}
		 *            fail_cb
		 */
		"ajaxSubmit" : function(success_cb, fail_cb) {
			var form_jq = $(this);
			form_jq.submit(function(){
				var method = form_jq.attr("method");
				var action = form_jq.attr("action");
				var data = form_jq.serialize();
				
				$.ajax(action, {
					"cache" : false,
					"data" : data,
					"type" : method,
					"success" : function(o) {
						$.ajaxCallback(o, success_cb, fail_cb);
					}
				});
			});
		}
	});
})(jQuery);

