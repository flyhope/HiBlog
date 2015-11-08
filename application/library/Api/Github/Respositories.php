<?php

/**
 * Github资源库API
 *
 * @package Api
 * @author  chengxuan <i@chengxuan.li>
 */
namespace Api\Github; 
class Respositories extends Abs {
    
    /**
     * 获取当前用户的资源库
     * 
     * @param string $visibility  可见性（all, public, or private. Default: all）
     * @param string $affiliation owner,collaborator,organization_member
     * @param string $type        all, owner, public, private, member. Default: all
     * @param string $sort        排序字段：created, updated, pushed, full_name，默认：full_name
     * @param string $direction   排序方式:asc or desc. 默认: when using full_name: asc; otherwise desc
     * 
     * @return \array
     */
    public function userRepos($visibility = null, $affiliation = null, $type = null, $sort = null, $direction = null) {
        return $this->_get('user/repos', array(
            'visibility'  => $visibility,
            'affiliation' => $affiliation,
            'type'        => $type,
            'sort'        => $sort,
            'direction'   => $direction,
        ));
    }
    
    /**
     * 获取一个repos的分支列表
     * 
     * @param string $owner
     * @param string $repo
     * 
     * @return \array
     */
    public function reposBranches($owner, $repo) {
        $url = 'repos/%s/%s/branches';
        $url = sprintf($url, $owner, $repo);
        return $this->_get($url);
    }
    
    /**
     * 获取一个Repos信息
     * 
     * @param string $owner
     * @param string $repo
     * 
     * @return \array
     */
    public function getRepos($owner, $repo) {
        $url = 'repos/%s/%s';
        $url = sprintf($url, $owner, $repo);
        return $this->_get($url);
    }
    
    /**
     * 初始化对象
     *
     * @return \Api\Github\Respositories
     */
    static public function init() {
        return parent::init();
    }
    
    
    
}