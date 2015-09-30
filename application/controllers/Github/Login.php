<?php

/**
 * Github登录
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
class Github_LoginController extends Yaf_Controller_Abstract {

    
    //Github登录
    public function indexAction() {
        $url = \Model\Github::showLoginUrl();
        return $this->redirect($url);
    }
    
}
