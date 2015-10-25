$(function(){
	
	//绑定全选事件
	$("#form-manage-category-result").selectAll("#category-batch-all", "[name='category-batch[]']");
	
	//绑定创建表单AJAX提交事件
	$("#form-manage-category-create").ajaxSubmit();
	
});