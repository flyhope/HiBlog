<?php

/**
 * 首页入口
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
class IndexController extends AbsController {
    
    /**
     * 允许未登录访问
     *
     * @var boolean
     */
    protected $_need_login = false;
    
    public function indexAction() {
        $login = \Comm\Arg::get('login', FILTER_VALIDATE_BOOLEAN);
        if(Yaf_Registry::get('current_uid') && !$login) {
            //已登录，跳至管理页
            return $this->redirect(\Comm\View::path('manage/basic'));
        } else {
            //未登录，展示介绍页
            $this->viewDisplay();
        }
    }
}
