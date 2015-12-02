<?php
/**
 * 内容发布器
 *
 * @author chengxuan <i@chengxuan.li>
 */
namespace Model;
class Publish extends Abs {

    /**
     * 发布文章
     * 
     * @param array $article
     * @param array $user
     * 
     * @return array
     */
    static public function article(array $article, array $user) {
        $path = sprintf('article/%u.html', $article['id']);
        $message = sprintf('update article %u [%s]', $article['id'], date('Y-m-d H:i:s'));

        $smarty = \Comm\Smarty::init();
        $content = $smarty->render('tpl:article', array(
            'article' => $article,
        ));
        
        $result = self::publishUserRespos($path, $content, $message);
        
        //发布成功，更新发布时间与发布状态
        if(!empty($result->content) && !empty($result->commit)) {
            Article::update($article, ['state' => 1, 'publish_time' => date('Y-m-d H:i:s')]);
        }

        return $result;
    }
    
    /**
     * 发布域名，并写入数据库
     * 
     * @param string $domain
     * 
     * @return \stdClass
     * 
     * @throws \Exception\Msg
     */
    static public function domain($domain) {
        $user = User::show();
        $repo = Github::showDefaultBlogRepoName($user['metadata']['login']);
        
        if($domain) {
            $dns = dns_get_record($domain, DNS_CNAME);
            if(!$dns) {
                throw new \Exception\Msg('指定域名没有设置CNAME记录');
            }
            if(count($dns) > 1) {
                throw new \Exception\Msg('指定域名CNAME记录设置超过一个');
            }
            if($dns[0]['target'] !== $repo) {
                throw new \Exception\Msg(sprintf('指定域名CNAME错误(错误记录为：%s)', $dns[0]['target']));
            }
            
            $message = sprintf('Bind domain %s', $domain);
        } else {
            $message = sprintf('Remove domain');
        }

        $path = 'CNAME';
        $result = self::publishUserRespos($path, $domain, $message);
    
        //上传文件成功，更新数据库
        if(!empty($result->content) && !empty($result->commit)) {
            Blog::save(array(
                'domain' => $domain,
            ));
        }
        
        return $result;
    }
    
    /**
     * 发布主分类数据
     * 
     * @param boolean $use_master 是否使用主库
     * 
     * @return \stdClass
     */
    static public function categoryMain($use_master = false) {
        $categorys = Category::showUserAll(false, true, true);
        
        $smarty = \Comm\Smarty::init();
        $content = $smarty->render('tpl:category', array(
            'categorys' => $categorys,
        ));
        
        $path = 'block/category.html';
        $message = sprintf('update category [%s]', date('Y-m-d H:i:s'));
        return self::publishUserRespos($path, $content, $message);
    }
    
    /**
     * 发布一个分类下的文章列表
     * @param unknown $category_id
     */
    static public function articleListByCategory($category_id) {
        
    }
    
    /**
     * 发布首页内容
     */
    static public function home() {
        
    }
    
    /**
     * 直接向当前用户的博客源发布一个数据
     * 
     * @param sting $path    路径
     * @param sting $content 文件内容
     * @param sting $message 注释
     * 
     * @return \stdClass
     */
    static public function publishUserRespos($path, $content, $message) {
        $user = User::show();
        $login = $user['metadata']['login'];
        $repo = Github::showDefaultBlogRepoName($user['metadata']['login']);
        
        $respositories = new \Api\Github\Respositories();
        return $respositories->replace($login, $repo, $path, $content, $message);
    }

}
