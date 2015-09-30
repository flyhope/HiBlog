<?php

/**
 * 
 *
 * @package 
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Model;
abstract class Abs {
    
    /**
     * 继承后设置表名可直接通过self::db获取数据库操作对象
     * 
     * @var string
     */
    protected static $_table = '';
    
    /**
     * 获取数据库操作对象
     * 
     * @return \Comm\Db\Simple
     */
    static public function db() {
        return new \Comm\Db\Simple(selc::$_table);
    }
    
    /**
     * 禁止实例化该类，只能是静态调用
     */
    protected function __construct() {
    
    }
    
    /**
     * 禁止克隆
     * 
     * @return boolean
     */
    protected function __clone() {
        return false;
    }
} 