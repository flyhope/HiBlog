<?php
/**
 * 附近管理
 *
 * @package Model
 * @author  chengxuan <chengxuan@staff.sina.com.cn>
 */
namespace Model;
use Exception\Api;
use Comm\Db\Mysql;

class Near extends \Model\Abs {
    

    /**
     * 数据表
     *
     * @var string
     */
    protected static $_table = 'near';
    
    /**
     * 更新数据
     * 
     * @return void
     */
    static public function update() {
        
        //获取客户端IP
        $ip = $_SERVER['REMOTE_ADDR'];
        
        //获取当前用户信息
        $user = new \Api\Github\Users();
        $userinfo = $user->user();
        
        //获取位置
        $map = new \Api\Map();
        $location_data = $map->locationIp($ip);
        
        $table = self::db()->showTable();
        $location = "POINT({$location_data->content->point->x} {$location_data->content->point->y})";
        $sql = "INSERT INTO {$table} SET uid = :uid, ip = :ip, location = GeomFromText(:location), update_time = :update_time ON DUPLICATE KEY UPDATE ip = :ip, location = GeomFromText(:location), update_time = :update_time";
        
        $db = new Mysql();
        return $db->exec($sql, array(
            'uid'           => $userinfo->id,
            'ip'            => sprintf('%u', ip2long($ip)),
            'location'      => $location,
            'update_time'   => date('Y-m-d H:i:s'),
        ));
    }
    
}