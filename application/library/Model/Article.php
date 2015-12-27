<?php

/**
 * 文章模型
 *
 * @package Model
 * @author  chengxuan <i@chengxuan.li>
 */
namespace Model;
class Article extends Abs {
    
    /**
     * 数据表
     * 
     * @var string
     */
    protected static $_table = 'article';
    
    /**
     * 发布状态
     * 
     * @var array
     */
    protected static $_state_alias = array(
        -1 => '未更新',
        0  => '未发布',
        1  => '已发布',
    );
    
    //uid, category_id, title, content, state, create_time, publish_time
    
    /**
     * 创建一篇文章
     * 
     * @param int    $category_id 分类ID
     * @param string $title       标题
     * @param string $content     内容
     * 
     * @throws \Exception\Nologin
     * @throws \Exception\Msg
     * 
     * @return int
     */
    static public function create($category_id, $title, $content) {
        $uid = \Yaf_Registry::get('current_uid');
        $title = trim($title);
        $content = trim($content);

        //获取分类信息
        $category = Category::show($category_id);
        
        if(!$uid) {
            throw new \Exception\Nologin();
        }
        if(!$category || ($category['uid'] && $category['uid'] != $uid)) {
            throw new \Exception\Msg('指定分类不存在');
        }
        if(!$title || !$content) {
            throw new \Exception\Msg('标题和内容不能为空');
        }
        
        $data = array(
            'category_id' => $category_id,
            'title'       => $title,
            'content'     => $content,
            'state'       => 0,
            'uid'         => $uid,
            'create_time' => date('Y-m-d H:i:s'),
        );
        $db = self::db();
        $db->insert($data);
        $id = $db->lastId();
        if(!$id) {
            throw new \Exception\Msg('文章发表失败');
        }
        
        //计数器+1
        Counter\Article::incr($category_id);
        Counter\Article::incr(0);
        
        //发布至Github中
        $data['id'] = $id;
        Publish::article($data);
        
        return $id;
    }

    /**
     * 更新数据
     * 
     * @param array  $data          原始数据
     * @param array  $new_data      新数据
     * @param string $validate_auth 是否验证权限
     * @throws \Exception\Msg
     * 
     * @return \void
     */
    static public function update(array $data, array $new_data, $validate_auth = true) {
        if(!$data || empty($data['uid']) || empty($data['id'])) {
            throw new \Exception\Msg('原始数据异常');
        }
        $validate_auth && User::validateAuth($data['uid']);
        
        //不是发布更新数据，更新状态为未发布
        if(empty($new_data['publish_time'])) {
            $new_data['state'] = -1;
        }
       
        self::db()->wAnd(['id' => $data['id']])->upadte($new_data);
    }

    /**
     * 根据主键ID删除用户的一篇或者多篇文章
     * 
     * @param mixed  $id   ID或ID集
     * @param string $uid  用户UID
     * 
     * @return \int
     */
    static public function destroyByUser($id, $uid = false) {
        !$uid && $uid = \Yaf_Registry::get('current_uid');

        $where = array(static::$_primary_key => $id, 'uid' => $uid);
        return self::db()->wAnd($where)->delete(true);
    }

    /**
     * 获取用户发表的文章
     * 
     * @param \Comm\Pager $pager        分页对对象
     * @param int         $uid          当前用户UID
     * 
     * @return \array
     */
    static public function showUserList(\Comm\Pager $pager, $uid = false) {
        $last_page = $pager->last_page;
        /**
         * 本期不考虑since_id翻页
         */
        $next_since_id = 0;
        $prev_since_id = 0;
        $page = $pager->page;
        $limit = $pager->count;
        if(!$last_page || !$next_since_id || !$prev_since_id || $page == 1) {
            //没有偏移翻页参数，或者前往第一页直接按PAGE、COUNT取
            $offset = ($page - 1) * $limit;
            $result = self::showUserListNext($offset, $limit, false, $uid);
        } elseif($page == $last_page) {
            //刷新当页
            $result = self::showUserListNext(0, $limit, $prev_since_id, $uid);
        } elseif($page < $last_page) {
            //前翻
            $offset = ($last_page - $page - 1) * $limit;
            $result = self::showUserListPrev($offset, $limit, $prev_since_id, $uid);
        } else {
            //后翻
            $offset = ($page - $last_page - 1) * $limit;
            $result = self::showUserListNext($offset, $limit, $next_since_id, $uid);
        }
        

        return $result;        
    }

    /**
     * 获取用户发表的文章（下翻）
     * 
     * @param int $offset   从第几条开始获取数据
     * @param int $limit    获取多少条数据
     * @param int $since_id 上一页最后一条数据
     * @param int $uid      UID
     * 
     * @return \array
     */
    static public function showUserListNext($offset, $limit, $since_id = false, $uid = false) {
        !$uid && $uid = \Yaf_Registry::get('current_uid');
        $db = self::db();
        $db->wAnd(array('uid' => $uid));
        if($since_id) {
            $db->wAnd(['since_id' => $since_id], '<');
        }
        
        $db->order('id', SORT_DESC)->limit($offset, $limit);
        $result = $db->fetchAll();
        
        return self::_formatResult($result);
    }
    
    /**
     * 获取用户发表的文章（上翻）
     *
     * @param int $offset   从第几条开始获取数据
     * @param int $limit    获取多少条数据
     * @param int $since_id 上一页第一条数据
     * @param int $uid      UID
     *
     * @return array
     */
    static public function showUserListPrev($offset, $limit, $since_id = false, $uid = false) {
        !$uid && $uid = \Yaf_Registry::get('current_uid');
        $db = self::db();
        $db->wAnd(array('uid' => $uid));
        if($since_id) {
            $db->wAnd(['since_id' => $since_id], '>');
        }
        
        $db->order('id', SORT_ASC)->limit($offset, $limit);
        $result = $db->fetchAll();
        \Comm\Arr::sortByCol($result, 'id', SORT_DESC);
        
        return self::_formatResult($result);
    }
    
    /**
     * 通过Since_id下翻页获取某一分类的数据
     * 
     * @param int $category_id
     * @param int $since_id
     * @param int $limit
     * 
     * @return \array
     */
    static public function showByCategorySince($category_id, $since_id, $limit) {
        $limit = (int)$limit;
        $db = self::db()->wAnd(['category_id' => $category_id]);
        $db->wAnd(['id' => $since_id], '<');
        $result = $db->order('id', SORT_DESC)->limit($limit)->fetchAll();
        return $result;
    }
    
    /**
     * 获取状态别名
     * 
     * @param int $state 状态码
     * 
     * @return \string
     */
    static public function showStateName($state) {
        if(isset(self::$_state_alias[$state])) {
            $result = self::$_state_alias[$state];
        } else {
            $result = '';
        }
        return $result;
    }
    
    /**
     * 格式化列表数据
     * 
     * @param array $data
     * 
     * @return array
     */
    static protected function _formatResult(array $data) {
        $result = array(
            'result' => $data,
            'next_since_id' => 0,
            'prev_since_id' => 0,
        );
        if($data) {
            $result['next_since_id'] = end($data)['id'];
            $result['prev_since_id'] = reset($data)['id'];
        }
        return $result;
    }
}
