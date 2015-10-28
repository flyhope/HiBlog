$(function() {

	//加载本地Plugin
	CKEDITOR.plugins.addExternal( 'pbckcode', '/static/lib/ckeditor_plugin/pbckcode/', 'plugin.js' );
	
//	CKEDITOR.editorConfig = function( config ) {
//	     // CKEDITOR TOOLBAR CUSTOMIZATION
//	     // I only set the needed buttons, so feel frey to add those you want in the array
//	     config.toolbarGroups = [
//	         { name: 'pbckcode' } ,
//	         // your other buttons here
//	         // get information about available buttons here: bhttp://docs.ckeditor.com/?mobile=/guide/dev_toolbar
//	     ];
//
//	     // CKEDITOR PLUGINS LOADING
//	     config.extraPlugins = 'pbckcode'; // add other plugins here (comma separated)
//
//	     // ADVANCED CONTENT FILTER (ACF)
//	     // ACF protects your CKEditor instance of adding unofficial tags
//	     // however it strips out the pre tag of pbckcode plugin
//	     // add this rule to enable it, useful when you want to re edit a post
//	     // only needed on v1.1.x
//	     config.allowedContent= 'pre[*]{*}(*)'; // add other rules here
//
//
//	     // PBCKCODE CUSTOMIZATION
//	     config.pbckcode = {
//	         // An optional class to your pre tag.
//	         cls : '',
//
//	         // The syntax highlighter you will use in the output view
//	         highlighter : 'PRETTIFY',
//
//	         // An array of the available modes for you plugin.
//	         // The key corresponds to the string shown in the select tag.
//	         // The value correspond to the loaded file for ACE Editor.
//	         modes :  [ ['HTML', 'html'], ['CSS', 'css'], ['PHP', 'php'], ['JS', 'javascript'] ],
//
//	         // The theme of the ACE Editor of the plugin.
//	         theme : 'textmate',
//
//	         // Tab indentation (in spaces)
//	         tab_size : '4'
//	     };
//	 };
	
	CKEDITOR.replace( 'editor1', {
		"extraPlugins" : "pbckcode",
//		"pbckcode" : {"highlighter" : "SYNTAX_HIGHLIGHTER"},
		
		
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
