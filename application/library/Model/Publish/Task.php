<?php
/**
 * 发布任务管理器
 *
 * @package Model
 * @author chengxuan <i@chengxuan.li>
 */
namespace Model\Publish;
class Task extends \Model\Abs {


    /**
     * 继承后设置表名可直接通过self::db获取数据库操作对象
     *
     * @var string
     */
    protected static $_table = 'publish_task';
    
    /**
     * 主键ID
     *
     * @var string
     */
    protected static $_primary_key = 'uid';

    /**
     * 发布首页
     *
     * @var integer
     */
    const TYPE_HOME = 1;

    /**
     * 发布分类下的文章列表
     *
     * @var integer
     */
    const TYPE_CATEGORY_ARTILE_LIST = 2;
    
    /**
     * 创建发布任务
     * 
     * @param int   $type     类别
     * @param array $metadata 元数据
     * 
     * @return \mixed
     */
    static public function create($type, $connection_id, array $metadata = array()) {
        $uid = \Model\User::validateLogin();
        $data = array(
            'uid'           => $uid,
            'type'         => $type,
            'connection_id' => $connection_id,
            'metadata' => \Comm\Json::encode($metadata),
        );
        return self::db()->insert($data);
    }
    
    /**
     * 批量创建发布任务
     * 
     * @param array $datas
     * 
     * @throws \Exception\Msg
     * 
     * @return \boolean
     */
    static public function createBatch(array $datas) {
        $uid = \Model\User::validateLogin();
        $fields = array('uid', 'type', 'connection_id', 'metadata');
        
        $bath_datas = array();
        foreach($datas as $value) {
            if(empty($value['type'])) {
                throw new \Exception\Msg('类型错误');
            }
            $connection_id = isset($value['connection_id']) ? $value['connection_id'] : 0;
            $metadata = isset($value['metadata']) ? $value['metadata'] : '';
            $bath_datas[] = array(
                $uid, $value['type'], $connection_id, $metadata,
            );
        }
        
        return self::db()->insertBatch($fields, $bath_datas, true);
    }
    
    /**
     * 根据用户获取一堆数据
     * 
     * @param int $uid   用户UID
     * @param int $limit 限制获取多少条
     */
    static public function showListByUser($uid, $limit) {
        $db = self::db()->wAnd(['uid' => $uid])->order('id', SORT_ASC);
        $result = $db->limit($limit)->fetchAll();
        foreach($result as $key => $value) {
            $metadata = new \Entity\Tarr(json_decode($value['metadata']));
            $result[$key]['metadata'] = $metadata;
        }
        return $result;
    }
    
    /**
     * 执行发布任务
     * 
     * @throws \Exception\Msg
     * 
     * @return \mixed true执行完成，array需要继续执行
     */
    static public function execute() {
        $uid = \Model\User::validateLogin();
        $tasks = self::showListByUser($uid, 1);
        if(empty($tasks)) {
            throw new \Exception\Msg(_('发布任务为空'));
        }
        $task = reset($tasks);
        unset($tasks);
        
        switch($task) {
            //全部列表
            case self::TYPE_ALL_LIST :
                $execute_result = self::_executeAllList($task);
                break;
                
            //分类文章列表
            case self::TYPE_CATEGORY_ARTICLE_LIST :
                $execute_result = self::_executeCategoryArticleList($task);
                break;
                
            //首页
            case self::TYPE_HOME:
                $execute_result = self::_executeHome($task);
                break;
            //其它情况，异常
            default :
                self::destory($uid);
                throw new \Exception\Msg(_('发布任务异常')); 
        }
        
        
        if($execute_result === true) {
            //彻底完成了
            self::destory($uid);
        } elseif (is_array($execute_result)) {
            //还需要继续执行
            $update_data = array(
                'metadata' => \Comm\Json::encode($execute_result['metadata']),
            );
            self::db()->wAnd([self::$_primary_key => $uid])->upadte($update_data);
        } else {
            //异常
            throw new \Exception\Msg(_('执行任务异常'));
        }
        $result = $execute_result;
        return $result;
    }
    
    /**
     * 执行分类下文章列表发布任务
     * 
     * @param array $task
     * 
     * @return \mixed true执行完成，array需要继续执行
     */
    static protected function _executeCategoryArticleList(array $task) {
        $category_id = $task['connection_id'];
        $since_id = $task['metadata']['since_id'];
        
        \Model\Article::Show();
    }
    
    /**
     * 执行首页发布任务
     *
     * @param array $task
     *
     * @return \mixed true执行完成，array需要继续执行
     */
    static protected function _executeHome(array $task) {
        
    }
    
    
}