<?php

/**
 * GitHub API 抽象类
 *
 * @package Api
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Api\Github;
abstract class Abs {
    
    /**
     * 用户浏览器代理
     * 
     * @var string
     */
    const USER_AGENT = 'Chengxuan-GithuBlog-App';
    
    protected static $_url_basic = 'https://github.com/';
    
    
    
    
} 
