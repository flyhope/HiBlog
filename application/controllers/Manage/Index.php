<?php

/**
 * 管理入口
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
class Manage_IndexController extends AbsController {
    
    /**
     * 允许未登录访问
     *
     * @var boolean
     */
    protected $_need_login = false;
    
    public function indexAction() {
        if(Yaf_Registry::get('current_uid')) {
            //已登录，跳至管理页
            return $this->redirect(\Comm\Tpl::path('manage/main'));
        } else {
            //未登录，展示介绍页
            
        }
        
        
    }
    
    
}
