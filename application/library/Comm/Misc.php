<?php

/**
 * 未归类函数
 *
 * @package Comm
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Comm;
abstract class Misc {
    
    /**
     * 判断是否是生产环境
     * 
     * @return boolean
     */
    static public function isProEnv() {
        return ini_get('display_errors');
    }
    
} 
