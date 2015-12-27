<?php
/**
 * 演示
 *
 * @package Controller
 * @author chengxuan <i@chengxuan.li>
 */
class Manage_Theme_DemoController extends AbsController {
    
    public function indexAction() {
        $theme = Comm\Arg::get('theme', FILTER_VALIDATE_INT, ['min_range' => 0], true);
        $resource = Comm\Arg::get('resource', FILTER_DEFAULT, null, true);
        
        Yaf_Registry::set('tpl_id', $theme);
        switch($resource) {
            //预览首页
            case 'home' :
                $pager = new Comm\Pager(1000, 20, 1);
                $articles = Model\Article::showUserList($pager);
                Model\Publish::home($articles, $pager, null, false);
                break;
                
            case 'article-list' :
                break;
            
            //预览文章
            case 'article' :
                $articles = Model\Article::showUserList(new Comm\Pager(1, 1, 1));
                $article = reset($articles['result']);
                Model\Publish::article($article, false);
                break;
            case 'home' :
                break;
                
            //预览导航
            case 'sidebar' :
                Model\Publish::sidebar(false, false);
                break;
            default :
                throw new \Exception\Msg('本资源不支持预览');
                
        }

    }
    
}
