<?php

/**
 * Github Oauth接口
 *
 * @package Api
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Api\Github;
class Oauth extends \Api\Abs{
    
    protected static $_url_basic = 'https://github.com/login/oauth/';
    
    /**
     * 获取操作对象
     * 
     * @param unknown $test_param
     * 
     * @return \Api\Github\Oauth
     */
    static public function init($test_param = false) {
        return new self();
    }
    
    /**
     * 通过Code获取AccessToken
     * 
     * @param string $client_id
     * @param string $client_secret
     * @param string $code
     * 
     * @return array
     */
    public function accessToken($client_id, $client_secret, $code) {
        return $this->_post('access_token', array(
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'code'          => $code,
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see \Api\Abs::_process()
     */
    protected function _process($result) {
        $result = json_decode($result);
        return $result;
    }
    
    
} 
