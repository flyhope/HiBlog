<?php
/**
 * 附近管理
 *
 * @package Model
 * @author  chengxuan <chengxuan@staff.sina.com.cn>
 */
namespace Model\Server;
use Exception\Api;

class Near extends \Model\Abs {
    
    static public function update() {
        
        //获取当前用户信息
        $user = new \Api\Github\Users();
        $userinfo = $user->user();
        
        //获取位置
        $map = new \Api\Map();
        $map->locationIp();
    }
    
}