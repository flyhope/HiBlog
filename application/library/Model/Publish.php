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
        
        try {
            $respositories = new \Api\Github\Respositories();
            $result = $respositories->update($user['metadata']['login'], $repo, $path, $content, $message);
            
            //发布成功，更新发布时间与发布状态
            if(!empty($result->content) && !empty($result->commit)) {
                Article::update($article, ['state' => 1, 'publish_time' => date('Y-m-d H:i:s')]);
            }
        } catch(\Exception $e) {
            
        }

        return $result;
    }

}
