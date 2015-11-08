<?php
/**
 * Smarty模板（用于生成静态博客页面使用）
 *
 * @author chengxuan <i@chengxuan.li>
 */
namespace Comm;
class Smarty implements \Yaf_View_Interface {
    
    /**
     * Smarty对象
     * 
     * @var \Smarty
     */
    protected $_smarty;
    
    
    /**
     * 单例模式
     * 
     * @return Smarty
     */
    static public function init() {
        static $object = null;
        if($object === null) {
            $object = new self();
        } else {
            $object->clear();
        }
        return $object;
    }
    
    /**
     * 清除变量设置，恢复初始状态
     * 
     * @return void
     */
    public function clear() {
        $this->_smarty->clearAllAssign();
    }

    /**
     * 构造方法
     *
     * @return void
     */
    protected function __construct() {
        \Yaf_Loader::import(APP_PATH . 'library/Thirdpart/Smarty/libs/Smarty.class.php');
        
        $this->_smarty = new \Smarty();
        $this->_smarty->setTemplateDir('');
        $this->_smarty->setCompileDir(TMP_PATH . 'smarty-compile/');
        $this->_smarty->setCacheDir(TMP_PATH . 'smarty-cache/');
        $this->_smarty->setPluginsDir(APP_PATH . 'library/Smarty/Plugins/');
        $this->_smarty->left_delimiter = '<!--{';
        $this->_smarty->right_delimiter = '}-->';
        
    }
    
    /**
     * The setScriptPath purpose
     *
     * @param string $template_dir 模板目录的绝对路径，默认的Yaf_Dispatcher会设置此目录为application.directory  . "/views".
     *
     * @return void
     */
    public function setScriptPath($template_dir) {
        $this->_smarty->setTemplateDir($template_dir);
    }
    
    /**
     * The getScriptPath purpose
     *
     * @return void
     */
    public function getScriptPath() {
        return $this->_smarty->getTemplateDir();
    }
    
    /**
     * 为视图引擎分配一个模板变量
     *
     * @param string $name
     * @param string $value
     *
     * @return Smarty
     */
    public function assign($name, $value = null) {
        if(!$name) {
            return false;
        }
    
        $this->_smarty->assign($name, $value);
        return $this;
    }
    
    /**
     * 渲染一个视图模板, 并直接输出给请求端
     *
     * @param string $tpl
     * @param array $tpl_vars
     *
     * @return bool
     */
    public function display($tpl, $tpl_vars = null) {
        $tpl_vars && $this->_smarty->assign($tpl_vars);
        return $this->_smarty->display($tpl);
    }
    
    /**
     * 渲染一个视图模板
     *
     * @param string $tpl
     * @param array $tpl_vars
     *
     * @return string
     */
    public function render($tpl, $tpl_vars = null) {
        $tpl_vars && $this->_smarty->assign($tpl_vars);
        return $this->_smarty->fetch($tpl);
    }
    
}