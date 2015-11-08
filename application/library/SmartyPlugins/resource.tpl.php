<?php
use Model;
/**
 * Smarty资源流（tpl）
 *
 * @author chengxuan <i@chengxuan.li>
 */
class Smarty_Tpl_Mysql extends Smarty_Resource_Custom {
    
    /**
     * 模板ID
     * 
     * @var int
     */
    protected $_tpl_id = 1;
    
    /**
     * 构造方法
     * 
     * @return void
     */
    public function __construct() {
        
        //设置模板ID
        if(Yaf_Registry::get('tpl_id')) {
            $tpl_id = Yaf_Registry::get('tpl_id');
            if(Model\Tpl\Main::show($tpl_id)) {
                $this->_tpl_id = $tpl_id;
            }
        }
    }
    
    /**
     * Fetch a template and its modification time from database
     *
     * @param string $name template name
     * @param string $source template source
     * @param integer $mtime template modification timestamp (epoch)
     * @return void
     */
    protected function fetch($name, &$source, &$mtime) {
        $result = Model\Tpl\Resource::showByName($this->_tpl_id, $name);
        
        if($result) {
            $source = $result['content'];
            $mtime = strtotime($result['update_time']);
        } else {
            $source = null;
            $mtime = null;
        }
    }
    
    /**
     * Fetch a template's modification time from database
     *
     * @note implementing this method is optional. Only implement it if modification times can be accessed faster than loading the comple template source.
     * @param string $name template name
     * @return integer timestamp (epoch) the template was modified
     */
    protected function fetchTimestamp($name) {
        $result = Model\Tpl\Resource::showByName($this->_tpl_id, $name);
        if($result) {
            $mtime = strtotime($result['update_time']);
        } else {
            $mtime = 0;
        }
        return $mtime;
    }
}
