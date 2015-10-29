<?php

/**
 * 分页类
 *
 * @package Comm
 * @author  chengxuan <i@chengxuan.li>
 */
namespace Comm;
class Pager {

    /**
     * 数据总数
     * 
     * @var int
     */
    public $total = 0;
    
    /**
     * 第几页
     * 
     * @var int
     */
    public $page = 1;
    
    /**
     * 每页多少项
     * 
     * @var int
     */
    public $count = 10;
    
    /**
     * 当前请求时是第几页
     * 
     * @var int
     */
    public $current_page;
    
    /**
     * 当前请求时最后一个ID
     * 
     * @var int
     */
    public $next_since_id;
    
    /**
     * 当前请求时第一个ID
     * 
     * @var int
     */
    public $prev_since_id;
    
    /**
     * 构造方法
     * 
     * @param int $total         总数
     * @param int $page          第几页
     * @param int $count         每页多少项
     * @param int $current_page  当前请求时是第几页
     * @param int $next_since_id 当前请求最后一个ID
     * @param int $prev_since_id 当前请求第一个ID
     */
    public function __constract($total, $page, $count, $current_page, $last_current_page, $next_since_id, $prev_since_id) {
        $this->total = $total;
        $this->page = $page;
        $this->count = $count;
        $this->current_page = $current_page;
        $this->next_since_id = $next_since_id;
        $this->prev_since_id = $prev_since_id;
    }
    
    public function getFlip($show_max = 10) {
        
    }
    
}
