<?php

/**
 * 复制主题
 *
 * @package Controller
 * @author  chengxuan <i@chengxuan.li>
 */
class Aj_Manage_Theme_CopyController extends Aj_AbsController {
    
    //控制器入口
    public function actionIndex() {
        
        Model\Theme\Main::a;
        Comm\Response::json(100000, '操作成功', ['id' => $id], false);
    }
    
}
