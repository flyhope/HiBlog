<?php
/**
 * 更新附近的极客信息
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.sina.com.cn>
 */
class Server_Near_UpdateController extends AbsController {
    
    public function indexAction() {
        $access_token = $this->getRequest()->getPost('access_token');
        Yaf_Registry::set('access_token', $access_token);
        $result = Model\Server\Near::update();
        Comm\Response::json(100000, '保存成功', ['result' => $result], false);
    }
    
    
}
