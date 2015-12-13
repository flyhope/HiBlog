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
     * 全部列表发布
     *
     * @var integer
     */
    const TYPE_ALL_LIST = 1;

    /**
     * 发布首页
     *
     * @var integer
     */
    const TYPE_HOME = 2;

    /**
     * 发布分类下的文章列表
     *
     * @var integer
     */
    const TYPE_CATEGORY_ARTILE_LIST = 3;
    
    /**
     * 创建发布任务
     * 
     * @param int   $type     类别
     * @param array $metadata 元数据
     * 
     * @return \mixed
     */
    static public function create($type, array $metadata = array()) {
        $uid = \Model\User::validateLogin();
        $data = array(
            'uid'      => $uid,
            'typpe'    => $type,
            'metadata' => \Comm\Json::encode($metadata),
        );
        return self::db()->insert($data);
    }
    
    /**
     * 获取解码后的任务数据
     * 
     * @param int $uid 用户UID
     * 
     * @return \array
     */
    static public function showDecoded($uid) {
        $result = self::show($uid);
        if(!empty($result['metadata'])) {
            $result['metadata'] = json_decode($result['metadata'], true);
        }
        return $result;
    }
    
    
    //执行发布任务
    static public function execute() {
        $uid = \Model\User::validateLogin();
        $task = self::show($uid);
        if(empty($task)) {
            throw new \Exception\Msg(_('发布任务为空'));
        }
        
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
     * 
     * @param unknown $task
     */
    static protected function _executeAllList(array $task) {
        
    }
    
    static protected function _executeCategoryArticleList(array $task) {
        
    }
    
    static protected function _executeHome(array $task) {
        
    }
    
    
}