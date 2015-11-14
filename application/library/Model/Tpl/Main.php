<?php
/**
 * 博客模板
 *
 * @author chengxuan <i@chengxuan.li>
 */
namespace Model\Tpl;
class Main extends \Model\Abs {
    
    /**
     * 表名
     *
     * @var string
     */
    protected static $_table = 'tpl_main';
    
    /**
     * 获取指定用户的主题 
     * 
     * @param int     $uid          要操作的UID
     * @param boolean $show_default 是否获取默认模板
     * 
     * @return \array
     */
    public function userTpls($uid = false, $show_default = true) {
        $uid || $uid = \Yaf_Registry::get('current_uid');
        $where_uid = $show_default ? [$uid, 0] : $uid;
        $db = self::db()->wAnd(['user_id'=>$where_uid])->order('id', SORT_DESC);
        return $db->limit()->fetchAll();
    }
    
}
