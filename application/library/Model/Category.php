<?php

/**
 * 分类管理
 *
 * @package Model
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Model;
class Category extends Abs {
    
    /**
     * 数据表名
     * 
     * @var string
     */
    protected static $_table = 'category';
    
    
    /**
     * 根据主键ID获取一条分类数据
     * 
     * @param int $id
     * @return mixed
     */
    static public function show($id) {
        return self::db()->wAnd(['id'=>$id])->fetchRow();
    }
    
    /**
     * 根据UID和分类别名获取一条数据
     * 
     * @param int    $uid   
     * @param string $alias
     * 
     * @return array
     */
    static public function showByUidAlias($uid, $alias) {
        return self::db()->wAnd(['uid'=>$uid, 'alias'=>$alias])->fetchRow();
    }
    
    /**
     * 根据UID和分类名获取一条数据
     *
     * @param int    $uid
     * @param string $name
     *
     * @return array
     */
    static public function showByUidName($uid, $name) {
        return self::db()->wAnd(['uid'=>$uid, 'name'=>$name])->fetchRow();
    }
    
    /**
     * 创建分类
     * 
     * @param int    $uid
     * @param int    $parent_id
     * @param string $name
     * @param string $alias
     * @param int    $uid
     * 
     * @return \int
     */
    static public function create($parent_id, $name, $alias, $uid = false) {
        $uid === false && $uid = \Yaf_Registry::get('current_uid');
        if(!$uid) {
            throw new \Exception\Msg('系统异常，无法获取分类创建人');
        }
        
        $data = self::showByUidAlias($uid, $alias);
        if(!$data) {
            throw new \Exception\Msg('分类别名已存在');
        }
        $data = self::showByUidName($uid, $name);
        if(!$data) {
            throw new \Exception\Msg('分类名称已存在');
        }        
        
        $data = array(
            'uid'       => $uid,
            'parent_id' => $parent_id,
            'name'      => $name,
            'alias'     => $alias,
            'sort'      => '120',
        );
        
        $db = self::db();
        $db->insert($data, true);
        $id = $db->lastId();
        
        if(!$id) {
            throw new \Exception\Msg('创建分类失败');
        }
        
        return $id;
    }
    
    /**
     * 更新一条数据
     * 
     * @param array $data
     * @param array $new_data
     * @param int   $validate_auth
     * 
     * @throws \Exception\Program
     * @return \mixed
     */
    static public function update(array $data, array $new_data, $validate_auth = true) {
        if(!$data || empty($data['uid']) || empty($data['id'])) {
            throw new \Exception\Program('分类原始数据异常');
        }
        $validate_auth && User::validateAuth($data['uid']);
        return self::db()->wAnd(['id'=>$data['id']])->upadte($new_data, true);
    }

    /**
     * 更新排序
     * 
     * @param array $data 排好序的分类ID（一维数组）
     * 
     * @param string $uid
     * @param string $validate_auth
     * 
     * @return int 修改的数据条数
     */
    static public function updateSort(array $data, $uid = false, $validate_auth = true) {
        $uid === false && $uid = \Yaf_Registry::get('current_uid');
        $validate_auth && User::validateAuth($uid);
        
        $db = self::db();
        $sort = 0;
        foreach($data as $id) {
            $db->wAnd(['id'=>$id, 'uid'=>$uid])->upadte(['sort'=>++$sort]);
            $db->clean();
        }
        return $sort;
    }
    
    /**
     * 获取一个用户的所有分类
     * 
     * @param int $uid
     * 
     * @return array
     */
    static public function showUserAll($uid) {
        $where = ['uid'=>$uid];
        $order = [['sort', SORT_ASC], ['id', SORT_ASC]];
        $result = self::db()->wAnd($where)->order($order)->fetchAll();
        $result = \Comm\Arr::groupBy($result, 'parent_id');
        return $result;
    }
    
} 