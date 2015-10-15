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
    //管理页
    'core/basic.css'   => ['core/basic'],
    'manage/index.css' => ['core/basic', 'manage/index'],
		
	//管理首页
	'core/basic.js' => ['core/basic'],
	'manage/index.js' => ['core/form', 'manage/index'],
    
    
);