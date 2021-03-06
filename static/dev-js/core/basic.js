(function($) {
	
	/**
	 * 展示一个弹层
	 */
	function showAlertDialog(msg, title, callback, btn_string, btn_string_cancel) {
		var dialog = $('<div class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>');
		var dialog_config = {buttons:{}};
		
		if(typeof title === "undefined" || !title) {
			title = "提示";
		}
		if(!callback) {
			callback = function() {
				dialog.modal("hide");
			};
		}
		if(!btn_string && btn_string !== false) {
			btn_string = "确定";
		}
		if(!btn_string_cancel && btn_string_cancel !== false) {
			btn_string_cancel = "取消";
		}
		if(btn_string) {
			dialog.find(".modal-footer").append('<button type="button" class="btn btn-primary" action-type="btn-action">' + btn_string + '</button>');
			dialog.delegate("[action-type=btn-action]", "click", callback);
		}
		if(btn_string_cancel) {
			dialog.find(".modal-footer").append('<button type="button" class="btn btn-default" action-type="btn-cancle">' + btn_string_cancel + '</button>');
			dialog.delegate("[action-type=btn-cancle]", "click", function() {
				dialog.modal("hide");
			});
		}
		
		//添加标题内容
		dialog.find(".modal-title").html(title);
		dialog.find(".modal-body").html("<p>" + msg + "</p>");
		
		//隐藏后销毁对象
		dialog.on("hidden.bs.modal", function() {
			$(this).remove();
		});
		
		//显示弹窗
		$("body").append(dialog);
		dialog.modal("show");
	}
	
	/**
	 * 静态方法插件
	 */
	$.extend({
		/**
		 * 提示弹层
		 */
		"alert" : function(msg, title, callback, btn_string) {
			showAlertDialog(msg, title, callback, btn_string, false);
		},
		
		/**
		 * 确认弹层
		 */
		"confirm" : function(msg, title, callback, btn_string, btn_string_cancel) {
			showAlertDialog(msg, title, function(){
				$(this).parents(".modal:first").modal("hide");
				callback();
			}, btn_string, btn_string_cancel);
		},
		

	});
	

})(jQuery);




