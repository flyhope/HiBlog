$(function() {

	
	CKEDITOR.replace( 'editor1', {
		"font_defaultLabel" : "Simsun",
		"font_names" : "Simsun;SimHei;KaiTi;Microsoft Yahei;Arial;Times New Roman;Verdana;",
		"fontSize_defaultLabel" : "14px",
		"toolbar" :        [
	        ["Styles", "Format", "Font", "FontSize"],
	        ["Bold", "Italic", "Underline", "Strike", "-", 'TextColor','BGColor'],
	        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', "-", 'NumberedList', 'BulletedList', '-', 'Link', "Unlink"],
	        ["Image", "Flash", "Table", "HorizontalRule", "SpecialChar", "Iframe"],
	        ["Maximize", "-" ,"Source"]
	    ]
	} );
	
})
