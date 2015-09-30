<?php

/**
 * API抽象类
 *
 * @package Api
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Api;
abstract class Abs {

    /**
     * API基础URL，继承后重写，用于拼拼完整URL
     *
     * @var string
     */
    protected static $_url_basic = '';
    
    /**
     * 用户浏览器代理
     *
     * @var string
     */
    protected static $_user_agent = 'Chengxuan-GithuBlog-App';
    
    /**
     * 是否是批量请求
     * 
     * @var boolean
     */
    protected $_multi_request = false;
    
    /**
     * 超时时间
     * 
     * @var int
     */
    protected $_time_out = 10;
    
    
    /**
     * 构造方法
     * 
     * @param boolean $multi_request 是否采用批量请求
     */
    protected function __construct($multi_request = false) {
        $this->_multi_request = $multi_request;
    }
    
    protected function _get($path, array $param = null, $timeout = null) {
        if($param) {
            $query_string = http_build_query($param);
            $path .= (strpos($path, '?') ? '&' : '?') . $query_string;
        }
        
        $request = $this->_fetchRequestSingle($path, $timeout);
        return $this->_returnRequest($request);
    }
    
    protected function _post() {
        
    }
    
    
    protected function _returnRequest($request) {
        if($this->_multi_request) {
            return $request;
        } else {
            
        }
    }
    
    public function mAdd() {
        if($this->_multi_request) {
            
        }
    }
    
    
    /**
     * 批量执行
     */
    public function mExecute() {
        if(!$this->_multi_request) {
            
        }
    }
    
    /**
     * 获取Request请求对象
     * 
     * @param string $path    请求路径
     * @param string $timeout 超时时间
     * 
     * @return \Comm\Request\Single
     */
    protected function _fetchRequestSingle($path, $timeout = null) {
        $timeout || $timeout = $this->_time_out;
        $request = new \Comm\Request\Single($this->_url($path));
        $request->setUserAgent(static::$_user_agent)->setTimeout($timeout);
        return $request;
    }

    
    /**
     * 根据相对路径获取URL
     * 
     * @param string $path
     * 
     * @return string
     */
    protected function _url($path) {
        return static::$_url_basic . $$path;
    }
    
    protected function _process() {
        
    }
    
    
    
    
} 