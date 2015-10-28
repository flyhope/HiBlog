(function($) {
	
	/**
	 * 添加JQuery editor方法绑定编辑器
	 */
	$.fn.extend({
		/**
		 * 加载CKEditor
		 */
		"editor" : function() {
			//加载本地Plugin
			CKEDITOR.plugins.addExternal( 'pbckcode', '/static/lib/ckeditor_plugin/pbckcode/', 'plugin.js' );
			
			$(this).each(function() {
				CKEDITOR.replace( $(this)[0], {
					"extraPlugins" : "pbckcode",
					"pbckcode" : {
						"highlighter" : "SYNTAX_HIGHLIGHTER",
						"tab_size" : "4",
						"modes" :  [
				            ['HTML', 'html'],
				            ['CSS', 'css'],
				            ['PHP', 'php'],
				            ['JS', 'javascript']
			            ]
					},
					
					"font_defaultLabel" : "Simsun",
					"font_names" : "Simsun;SimHei;KaiTi;Microsoft Yahei;Arial;Times New Roman;Verdana;",
					"fontSize_defaultLabel" : "14px",
					"toolbar" :        [
				        ["Styles", "Format", "Font", "FontSize"],
				        ["Bold", "Italic", "Underline", "Strike", "-", 'TextColor','BGColor'],
				        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', "-", 'NumberedList', 'BulletedList', '-', 'Link', "Unlink"],
				        ["Image", "Flash", "Table", "HorizontalRule", "SpecialChar", "Iframe", "pbckcode"],
				        ["Maximize", "-" ,"Source"]
				    ]
				} );
			})

		}

	});
})(jQuery);
