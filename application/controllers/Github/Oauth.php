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
        
        $access_token = empty($oauth->access_token) ? '' : $oauth->access_token;
        if($access_token) {
            $_SESSION['github-access-token'] = $oauth->access_token;
        }
        
        //获取用户信息
        $github_user = new \Api\Github\Users();
        $user = $github_user->user();
        if(!empty($user->id)) {
            //更新用户数据
            \Model\User::updateLogin($user->id, $access_token);
            $_SESSION['uid'] = $user->id;
            
            return $this->redirect('/manage/basic');
        } else {
            throw new \Exception\Msg('请授权Github账号后再进行操作。');
        }
    }
    
}
