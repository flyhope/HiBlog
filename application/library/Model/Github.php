<?php

/**
 * Github相关数据模型
 *
 * @package Model
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Model;
class Github extends Abs {
    
    /**
     * 获取登录页URL
     * 
     * @return string
     */
    static public function showLoginUrl() {
        $url = 'https://github.com/login/oauth/authorize?client_id=%s&scope=public_repo';
        $client_id = \Model\Config::show('github_client_id');
        $result = sprintf($url, $client_id);
        return $result;
    }
    
    
    
} 
