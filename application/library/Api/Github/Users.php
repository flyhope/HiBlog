<?php

/**
 * Github 用户API
 *
 * @package Api
 * @author  chengxuan <chengxuan@staff.weibo.com>
 */
namespace Api\Github;
class Users extends Abs {
    
    
    
    public function show() {
        return $this->_get('');
    }
    
} 