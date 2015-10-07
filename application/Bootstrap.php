<?php
/**
 * 引导文件定义
 *
 * @author chengxuan <i@chengxuan.li>
 */
class Bootstrap extends Yaf_Bootstrap_Abstract {

    /**
     * 注册本地类名前缀, 这部分类名将会在本地类库查找 
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initLoader(Yaf_Dispatcher $dispatcher) {
       Yaf_Loader::getInstance()->registerLocalNameSpace(
            array(
                'Api',
                'Cache', 
                'Comm',
                'Data', 
                'Entity',
				'Model',
            )
        );
    }
    
    /**
     * 初始化视图
     * 
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initView(Yaf_Dispatcher $dispatcher) {
        $dispatcher->setView(new \Comm\View());
    }
}
