<?php

/**
 * Github认证抽象类
 *
 * @package Github
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Api\Github;
abstract class Abs extends \Api\Abs {
    
    //Github接口地址
    protected static $_url_basic = 'https://api.github.com/';
    
    
    /**
     * AccessToken在SESSION中的名称
     * 
     * @var string
     */
    const ACCESS_TOKEN_SESSION = 'github-access-token';
    
    /**
     * (non-PHPdoc)
     * @see \Api\Abs::_prepareRequest()
     */
    protected function _prepareRequest(\Comm\Request\Single $request) {
        $access_token = self::showAccessToken();
        $request->appendHeader(["Authorization: token {$access_token}"]);
    }
    
    /**
     * 获取AccessToken
     * 
     * @return \mixed
     */
    static public function showAccessToken() {
        return \Comm\Arg::session('github-access-token');
    }
    
    /**
     * (non-PHPdoc)
     * @see \Api\Abs::_process()
     */
    protected function _process($result, \Comm\Request\Single $request) {
        $result = json_decode($result);
        return $result;
    }
}
