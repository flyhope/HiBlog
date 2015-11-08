<?php
/**
 * Smarty测试
 *
 * @author chengxuan <i@chengxuan.li>
 */
class Test_SmartyController extends Yaf_Controller_Abstract {

    public function indexAction() {
        $smarty = Comm\Smarty::init();
        $smarty->assign(['var' => '<u>b</u>']);
        $smarty->display('tpl:article');
        return false;
    }
    
}
