<?php
/**
 * 附近的极客
 *
 * @package Controller
 * @author  chengxuan <chengxuan@staff.sina.com.cn>
 */
class Server_Community_NearController extends AbsController {

    /**
     * 允许未登录访问
     *
     * @var boolean
     */
    protected $_need_login = true;

    public function indexAction() {
        $result = Model\Near::showNear(1, 100);
        $this->viewDisplay(array(
            'result' => $result,
        ));
        
    }
}
