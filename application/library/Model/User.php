<?php

/**
 * 用户Model
 *
 * @package Model
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Model;
class User extends Abs {
    
    /**
     * 用户数据表名
     * 
     * @var string
     */
    protected static $_table = 'user';

    /**
     * 创建一个用户
     * 
     * @param int    $id                  UID
     * @param string $github_access_token Github的AccessToken
     * @param array  $metadata            元数据
     * 
     * @return int
     */
    static public function create($id, $github_access_token, array $metadata = array()) {
        !$metadata && $metadata = new \stdClass();
        $data = array(
            'id' => $id,
            'github_access_token' => $github_access_token,
            'metadata'            => \Comm\Json::encode($metadata),
        );
        self::db()->insert($data);
        return $id;
    }
    
    /**
     * 更新一个用户信息
     * 
     * @param  int   $id   UID
     * @param  array $data 数据
     * 
     * @return \int
     */
    static public function update($id, array $data) {
        return self::db()->wAnd(['id'=>$id])->upadte($data, true);
    }
    
    /**
     * 验证权限
     * 
     * @param int $uid
     * 
     * @throws \Exception\Msg
     */
    static public function validateAuth($uid) {
        if(!$uid || $uid != \Yaf_Registry::get('current_uid')) {
            throw new \Exception\Msg('权限不足', 100403);
        }
    }
    
    /**
     * 更新最后一次登录状态
     * 
     * @param int    $uid                 GITHUB的UID
     * @param string $github_access_token GITHUB的AccessToken
     * 
     * @return int
     */
    static public function updateLogin($uid, $github_access_token) {
        $result = false;
        if($github_access_token) {
            $user = self::show($uid);
            if($user) {
                $result = self::update($uid, [
                    'github_access_token' => $github_access_token,
                    'login_time'          => date('Y-m-d H:i:s'),
                ]);
            }
            
            if(!$user || empty($result)) {
                $result = self::create($uid, $github_access_token);
            }
        }
        return $result;
    }    
    
    
}
