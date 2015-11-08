<?php
/**
 * 博客模板资源
 *
 * @author chengxuan <i@chengxuan.li>
 */
namespace Model\Tpl;
class Resource extends \Model\Abs {

    /**
     * 表名
     *
     * @var string
     */
    protected static $_table = 'tpl_resource';

    /**
     * 通过模板ID和名称获取资源
     * 
     * @param int    $tpl_id 模板ID
     * @param string $name   资源名称
     * 
     * @return array
     */
    static public function showByName($tpl_id, $name) {
        $where = ['tpl_id' => $tpl_id, 'resource_name' => $name];
        return self::db()->wAnd($where)->fetchRow();
    }

}
