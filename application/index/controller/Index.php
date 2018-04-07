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
        // 查询最新发布的文章,取10个
        $art_list = $this->getArticleByPage(1000, 'art_addtime');
        $this->assign('art_list', $art_list);
        return $this->fetch();
    }

}
