(function($) {
	
	//展示一个弹层
	function showAlertDialog(msg, title, callback, btn_string, btn_string_cancel) {
		var dialog_html = '<div id="dialog-alert"><p></p></div>';
		var dialog_config = {buttons:{}};
		
		if(typeof title === "undefined") {
			title = "提示";
		}
		if(!callback) {
			callback = function() {
				$(this).dialog("close");
			};
		}
		if(!btn_string && btn_string !== false) {
			btn_string = "确定";
		}
		if(!btn_string_cancel && btn_string_cancel !== false) {
			btn_string_cancel = "取消";
		}
		if(btn_string) {
			dialog_config.buttons[btn_string] = callback;
		}
		if(btn_string_cancel) {
			dialog_config.buttons[btn_string_cancel] = function() {
				$(this).dialog("close");
			};
		}
		
		if(!$("#dialog-alert").size()) {
			$("body").append(dialog_html);
		}
		$("#dialog-alert").attr("title", title).find("p").html(msg);
		$("#dialog-alert").dialog(dialog_config);
	}
	
	$.extend({
		//弹层确认
		"alert" : function(msg, title, callback, btn_string) {
			showAlertDialog(msg, title, callback, btn_string, false);
		},
		
		//确认弹层
		"confirm" : function(msg, title, callback, btn_string, btn_string_cancel) {
			showAlertDialog(msg, title, callback, btn_string, btn_string_cancel);
		},
		
		//AJAX回调处理，默认有错误自动弹出
		"ajaxCallback" : function(rv, success_callback) {
	        try{
	            var data = $.parseJSON(rv);
	        } catch(e) {
	            $.alert(rv);
	        }
	        
	        if(data.code != 100000) {
	            $.alert(data.msg);
	        } else if(typeof success_callback !== false) {
	        	success_callback(data);
	        }
	        
		},
		
		//AJAX默认回调，成功刷页，失败弹错
		"ajaxCallbackDefault" : function(response) {
			$.ajaxCallback(response, function() {
	            location.reload();
		    });
		}
	});
})(jQuery);




