<?php

namespace app\index\controller;

use think\Controller;

class Index extends Base
{
    /**
     * 前台首页
     *
     * @return mixed
     */
    public function index() {
        // 查询最新发布的文章,取5个
        // 热门文章
        $art_List = $this->getArticleByPage(5, 'art_addtime');
        $this->assign('art_List', $art_List);
        $this->initAside();
        return $this->fetch();
    }

}
