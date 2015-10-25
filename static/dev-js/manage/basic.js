$(function(){
	
	//分页设置以按钮组方式展示
	$("#input-page_count-radioset").buttonset();
	
	//绑定表单AJAX提交事件
	$("#form-manage-basic").ajaxSubmit();
	
});