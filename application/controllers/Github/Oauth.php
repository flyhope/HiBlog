<?php

/**
 * OAuth回调
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
class Github_OAuthController extends AbsController {
    
    /**
     * 登录回调页不需要用户登录就可以访问
     * 
     * @var boolean
     */
    protected $_need_login = false;
    
    public function indexAction() {
        $code = \Comm\Arg::get('code', FILTER_DEFAULT, null, true);
        
        $config = \Model\Config::showBatch(['github_client_secret', 'github_client_id']);
        
        $api = \Api\Github\Oauth::init();
        $oauth = $api->accessToken($config['github_client_id'], $config['github_client_secret'], $code);
        
        if($oauth->access_token) {
            $_SESSION['github-access-token'] = $oauth->access_token;
        }
        
        //获取用户UID
        $github_user = new \Api\Github\Users();
        $user = $github_user->user();
        
        var_dump($user);
        exit;
        

        /**
         * @todo 获取用户信息后写入SESSION
         */
        $_SESSION['uid'] = $uid;
        
        return false;
        
        
    }
    
}
