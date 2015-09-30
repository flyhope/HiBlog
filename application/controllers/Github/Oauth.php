<?php

/**
 * OAuth回调
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
class Github_OAuthController extends Yaf_Controller_Abstract {
    
    //OAuth登录页
    public function indexAction() {
        $code = \Comm\Arg::get('code', FILTER_DEFAULT, null, true);
        
        $config = \Model\Config::showBatch(['github_client_secret', 'github_client_id']);
        
        $api = \Api\Github\Oauth::init();
        $result = $api->accessToken($config['github_client_id'], $config['github_client_secret'], $code);
        var_dump($result);
        return false;
        
        
    }
    
}
