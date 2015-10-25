<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See https://github.com/mrclay/minify/blob/master/docs/CustomServer.wiki.md for other ideas
 **/

return array(
    //CSS
    'core/basic.css'   => ['core/basic'],	//基础数据
    'manage/index.css' => ['core/basic', 'manage/index'], //管理首页
		
	//JS
	'core/basic.js' => ['core/basic'],	//基础数据
	'manage/basic.js'      => ['core/form', 'manage/basic'],	//管理首页
	'manage/category.js'   => ['core/form', 'manage/category'],	//分类管理页
    
    
);