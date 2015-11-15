<?php
/**
 * 模板列表
 *
 * @package Controller
 * @author  chengxuan <i@chengxuan.li>
 */
class Theme_Tpl_IndexController extends AbsController {
    
    
    public function indexAction() {
        $tpls = Model\Tpl\Main::userTpls();
        print_r($tpls);exit;
    }
    
}
