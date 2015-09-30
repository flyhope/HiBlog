<?php

/**
 * HTTP Request请求，支持批量处理
 *
 * @author    Chengxuan <i@chengxuan.li>
 * @package   Comm
 */
namespace Comm\Request;
class Single {

    /**
     * CURL资源
     *
     * @var resource
     */
    protected $_ch;
	protected $_host = false;
    /**
     * CURL配置
     *
     * @var array
     */
    protected $_option = array();

    /**
     * 构造方法
     *
     * @param   string  $url        URL
     * @param   array   $post_data  提交的数据内容
     *
     * @return  void
     */
    public function __construct($url=null, array $post_data=null) {
        $this->_ch = curl_init();
        $this->_option[CURLOPT_RETURNTRANSFER] = true;
        $url !== null && $this->setUrl($url);
        $post_data !== null && $this->setPostData($post_data);
    }

    /**
     * 设置请求的URL
     *
     * @param string $url URL
     *
     * @return \Comm\Request\Single
     */
    public function setUrl($url) {
		// if(stripos($url, 'i.api.card.weibo.com') !== false) {
		// 	$url = str_replace('i.api.card.weibo.com', '10.75.5.25', $url);
		// 	$this->_host = 'i.api.card.weibo.com';
		// }
        $this->_option[CURLOPT_URL] = $url;
        return $this;
    }

    /**
     * 设置提交参数
     * @param   mixed                   $post_param     提交参数，字符串或数组
     * @param   boolean                 $build_query    是否自动执行http_build_query
     *
     * @return  \Comm\Request\Single
     */
    public function setPostData($post_param, $build_query=true) {
        $build_query && is_array($post_param) && $post_param = http_build_query($post_param);
        $this->_option[CURLOPT_POSTFIELDS] = $post_param;
        return $this;
    }

    /**
     * 请求头
     *
     * @param string $header HTTP头信息
     *
     * @return \Comm\Request\Single
     */
    public function setHeader($header) {
		if($this->_host) {
			$header[] = 'Host: '.$this->_host; 
		}
        $this->_option[CURLOPT_HTTPHEADER] = $header;
        return $this;
    }
    
    /**
     * 设置用户代理
     * 
     * @param string $user_agent 用户代理字符串
     * 
     * @return \Comm\Request\Single
     */
    public function setUserAgent($user_agent) {
        $this->_option[CURLOPT_USERAGENT] = $user_agent;
        return $this;
    }
    
    /**
     * 设置CURL选项
     * 
     * @param int   $key
     * @param mixed $value
     * 
     * @return \Comm\Request\Single
     */
    public function setOption($key, $value) {
        $this->_option[$key] = $value;
        return $this;
    }
    


    /**
     * 设置超时时间
     *
     * @param int $timeout 设置超时时间
     *
     * @return \Comm\Request\Single
     */
    public function setTimeout($timeout) {
        if(defined('CURLOPT_TIMEOUT_MS')) {
            $timeout *= 1000;
            $this->_option[CURLOPT_TIMEOUT_MS] = $timeout;
        } else {
            $this->_option[CURLOPT_TIMEOUT] = ceil($timeout);
        }

        return $this;
    }

    /**
     * 获取CURL资源
     *
     * @return resource
     */
    public function fetchCurl() {
        curl_setopt_array($this->_ch, $this->_option);
        return $this->_ch;
    }

    /**
     * 获取CLI命令行中的curl命令
     *
     * @return string
     */
    public function fetchCurlCli() {
        $url = addslashes($this->_option[CURLOPT_URL]);
        $result = "curl '{$url}'";
        if(isset($this->_option[CURLOPT_COOKIE])) {
            $cookie = addslashes($this->_option[CURLOPT_COOKIE]);
            $result .= " -b '{$cookie}'";
        }
        if(isset($this->_option[CURLOPT_USERAGENT])) {
            $user_agent = addslashes($this->_option[CURLOPT_USERAGENT]);
            $result .= " -A '{$user_agent}'";
        }
        if(isset($this->_option[CURLOPT_POSTFIELDS])) {
            $post = addslashes($this->_option[CURLOPT_POSTFIELDS]);
            $result .= " -d '{$post}'";
        }
        if(isset($this->_option[CURLOPT_HTTPHEADER])) {
            foreach($this->_option[CURLOPT_HTTPHEADER] as $header) {
                $header = addslashes($header);
                $result .= " -H '{$header}'";
            }
        }
        return $result;
    }

    /**
     * 执行CURL请求
     *
     * @return string
     */
    public function exec() {
        $this->fetchCurl($this->_ch);
        $result = curl_exec($this->_ch);
        curl_close($this->_ch);
        return $result;
    }

}
