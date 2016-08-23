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
    
    /**
     * 获取附近的极客数据
     * 
     * @param int $page  第几页
     * @param int $limit 每页多少项
     * 
     * @return array
     */
    static public function showNear($page, $limit = 100) {
        $page = max(1, (int)$page);
        $limit = max(1, (int)$limit);
        $start = ($page - 1) * $limit;
        
        //获取客户端IP
        $ip = $_SERVER['REMOTE_ADDR'];
        
        //获取位置
        $map = new \Api\Map();
        $location_data = $map->locationIp($ip);
        
        $mysql = new Mysql();
        $location = "POINT({$location_data->content->point->x} {$location_data->content->point->y})";
        $mysql->exec('SET @center = GeomFromText(?);', [$location]);
        $mysql->exec('SET @radius = 50');
        $mysql->exec("SET @bbox = CONCAT('POLYGON((',
            X(@center) - @radius, ' ', Y(@center) - @radius, ',',
            X(@center) + @radius, ' ', Y(@center) - @radius, ',',
            X(@center) + @radius, ' ', Y(@center) + @radius, ',',
            X(@center) - @radius, ' ', Y(@center) + @radius, ',',
            X(@center) - @radius, ' ', Y(@center) - @radius, '))'
        )");
        $mysql->exec();
        
        $table = self::db()->showTable();
        $sql = "SELECT *, AsText(location) location_str, SQRT(POW( ABS( X(location) - X(@center)), 2) + POW( ABS(Y(location) - Y(@center)), 2 )) AS distance
            FROM {$table}
            WHERE Intersects( location, GeomFromText(@bbox) )
            AND SQRT(POW( ABS( X(location) - X(@center)), 2) + POW( ABS(Y(location) - Y(@center)), 2 )) < @radius
            ORDER BY distance LIMIT {$start}, {$limit}";
        $result = $mysql->fetchAll($sql);
        return $result;
    }
    
}