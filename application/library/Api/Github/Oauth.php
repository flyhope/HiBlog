<?php

/**
 * Github OAuth授权类
 *
 * @package Api
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Api\Github;
class OAuth {
    
    /**
     * Github 接口基础地址
     * 
     * @var string
     */
    static protected $_url_basic = 'https://github.com/login/oauth/';

    /**
     * 超时时间
     * 
     * @var int
     */
    protected $_timeout = 20;
    
    static public function authorize($client_id, $scope, $redirect_uri = '', $state = '') {
        $url = self::$_url_basic . 'authorize';
        $request = new \Comm\Request\Single($url);
        $request->setTimeout($this->_timeout)->setHeader(['User-Agent']);
        
    }
    
}
