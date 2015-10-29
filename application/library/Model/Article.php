<?php

/**
 * 文章模型
 *
 * @package Model
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Model;
class Article extends Abs {
    
    /**
     * 数据表
     * 
     * @var string
     */
    protected static $_table = 'article';
    
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
        if(!$category || $category['uid'] != $uid) {
            throw new \Exception\Msg('指定分类不存在');
        }
        if(!$title || !$content) {
            throw new \Exception\Msg('标题和内容不能为空');
        }
        
        
        $db = self::db();
        $db->insert(array(
            'category_id' => $category_id,
            'title'       => $title,
            'content'     => $content,
            'state'       => 0,
            'uid'         => $uid,
        ));
        $id = $db->lastId();
        if(!$id) {
            throw new \Exception\Msg('文章发表失败');
        }
        
        //计数器+1
        \Model\Counter\Article::incr($category_id);
        \Model\Counter\Article::incr(0);
        
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
        $new_data['state'] = -1;
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
    
    static public function publish() {
        
    }

    /**
     * 获取用户发表的文章
     * 
     * @param int $current_page  当前第几页
     * @param int $page          要翻到第几页
     * @param int $limit         每页多少项
     * @param int $next_since_id 来源页最后一个ID
     * @param int $prev_since_id 来源页第一个ID
     * @param int $uid           UID（没有取当前用户UID）
     * 
     * @return \array
     */
    static public function showUserList($current_page, $page, $limit, $next_since_id, $prev_since_id, $uid = false) {
        if(!$current_page || !$next_since_id || !$prev_since_id || $page == 1) {
            //没有偏移翻页参数，或者前往第一页直接按PAGE、COUNT取
            $offset = ($page - 1) * $limit;
            $result = self::showUserListNext($offset, $limit, false, $uid);
        } elseif($page == $current_page) {
            //刷新当页
            $result = self::showUserListNext(0, $limit, $prev_since_id, $uid);
        } elseif($page < $current_page) {
            //前翻
            $offset = ($current_page - $page - 1) * $limit;
            $result = self::showUserListPrev($offset, $limit, $prev_since_id, $uid);
        } else {
            //后翻
            $offset = ($page - $current_page - 1) * $limit;
            $result = self::showUserListNext($offset, $limit, $next_since_id, $uid);
        }
        
        $result['total_number'] = Counter\Article::get(0, $uid);
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
