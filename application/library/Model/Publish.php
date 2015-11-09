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
        $repo = Github::showDefaultBlogRepoName($user['metadata']['login']);
        $message = sprintf('update article %u [%s]', $article['id'], date('Y-m-d H:i:s'));

        $smarty = \Comm\Smarty::init();
        $content = $smarty->render('tpl:article', array(
            'article' => $article,
        ));
        

        $respositories = new \Api\Github\Respositories();
        $result = $respositories->replace($user['metadata']['login'], $repo, $path, $content, $message);
        
        //发布成功，更新发布时间与发布状态
        if(!empty($result->content) && !empty($result->commit)) {
            Article::update($article, ['state' => 1, 'publish_time' => date('Y-m-d H:i:s')]);
        }

        return $result;
    }
    
    /**
     * 发布域名
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
        
        $path = 'CNAME';
        $message = sprintf('Bind domain %s', $domain);

        $respositories = new \Api\Github\Respositories();
        $result = $respositories->replace($user['metadata']['login'], $repo, $path, $domain, $message);
    
        //上传文件成功，更新数据库
        if(!empty($result->content) && !empty($result->commit)) {
            Blog::save(array(
                'domain' => $domain,
            ));
        }
        
        return $result;
    }

}
