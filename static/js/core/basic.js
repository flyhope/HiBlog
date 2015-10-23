(function($){function showAlertDialog(msg,title,callback,btn_string,btn_string_cancel){var dialog_html='<div id="dialog-alert"><p></p></div>';var dialog_config={buttons:{}};if(typeof title==="undefined"){title="提示";}
if(!callback){callback=function(){$(this).dialog("close");};}
if(!btn_string&&btn_string!==false){btn_string="确定";}
if(!btn_string_cancel&&btn_string_cancel!==false){btn_string_cancel="取消";}
if(btn_string){dialog_config.buttons[btn_string]=callback;}
if(btn_string_cancel){dialog_config.buttons[btn_string_cancel]=function(){$(this).dialog("close");};}
if(!$("#dialog-alert").size()){$("body").append(dialog_html);}
$("#dialog-alert").attr("title",title).find("p").html(msg);$("#dialog-alert").dialog(dialog_config);}
$.extend({"alert":function(msg,title,callback,btn_string){showAlertDialog(msg,title,callback,btn_string,false);},"confirm":function(msg,title,callback,btn_string,btn_string_cancel){showAlertDialog(msg,title,callback,btn_string,btn_string_cancel);},});})(jQuery);