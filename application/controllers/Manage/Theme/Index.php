<?php
/**
 * 模板列表
 *
 * @package Controller
 * @author  chengxuan <i@chengxuan.li>
 */
class Manage_Theme_IndexController extends AbsController {
    
    
    public function indexAction() {
        $themes = Model\Theme\Main::userTpls();
        $this->viewDisplay(array(
            'themes' => $themes,
        ));
    }
    
}
