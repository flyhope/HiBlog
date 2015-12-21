$(function() {
	
	var $form_result = $("#form-manage-category-result");
	$form_result.delegate("[action-type=publish]", "click", function() {
		var $tr = $(this).parents("tr:first");
		var href = $CONFIG.path + "aj/manage/publish/article";
		$.post(href, {"id" : $tr.data("id")}, $.ajaxCallbackDefault);
	});
	
	
});
