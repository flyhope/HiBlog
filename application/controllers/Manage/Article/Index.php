<?php

/**
 * 文章列表页
 *
 * @package Controller
 * @author  chengxuan <i@chengxuan.li>
 */
class Manage_Article_IndexController extends AbsController {
    
    /**
     * 默认每页条数
     * 
     * @var int
     */
    protected $_limit = 20;

    
    public function indexAction() {
        $current_page = Comm\Arg::get('current_page', FILTER_VALIDATE_INT, ['min_range' => 0]);
        ($page = Comm\Arg::get('page', FILTER_VALIDATE_INT, ['min_range' => 1])) || ($page = 1);
        $next_since_id = Comm\Arg::get('next_since_id', FILTER_VALIDATE_INT, ['min_range' => 0]);
        $prev_since_id = Comm\Arg::get('prev_since_id', FILTER_VALIDATE_INT, ['min_range' => 0]);

        //获取用户的博客配置中的分页设置
        $blog = Model\Blog::show();
        empty($blog['data']['page_count']) || $this->_limit = $blog['data']['page_count'];
        
        
        $result = Model\Article::showUserList($current_page, $page, $this->_limit, $next_since_id, $prev_since_id);

        $this->viewDisplay(array(
            'result' => $result,
        ));
    }
    
} 
