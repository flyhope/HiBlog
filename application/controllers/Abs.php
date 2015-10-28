<?php

/**
 * 控制器抽象类
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
abstract class AbsController extends Yaf_Controller_Abstract {
    
    /**
     * 是否需要登录（默认需要）
     * 
     * @var Boolean
     */
    protected $_need_login = true;

    /**
     * (non-PHPdoc)
     * @see Yaf_Controller_Abstract::init()
     */
    public function init() {
        //开启SESSION
        session_name('GITHUBLOG_SID');
        session_start();
        
        //获取用户UID
        $uid = \Comm\Arg::session('uid', FILTER_VALIDATE_INT);
        Yaf_Registry::set('current_uid', $uid);
        
        //判断用户是否登录
        if($this->_need_login && !$uid) {
            throw new \Exception\Nologin('no login');
        }


    }
    
    /**
     * 渲染模板
     * 
     * @param array  $assign   模板变量
     * @param string $tpl_path 模板路径（不填则是当前Controller）
     */
    public function viewDisplay(array $assign = array(), $tpl_path = null) {
        $view = new \Comm\View();
        $tpl_name = $this->getRequest()->getControllerName();
        if($tpl_path) {
            $tpl_path .= '.phtml';
        } else {
            $tpl_path = strtolower(str_replace('_', '/', $tpl_name)) . '.phtml';
        }
        $view->display($tpl_path, $assign);
    }
    
} 