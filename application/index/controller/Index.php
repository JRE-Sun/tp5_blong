<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    /**
     * 前台首页
     *
     * @return mixed
     */
    public function index() {
        // 查询最新发布的文章,取5个
        $art_List = \app\common\model\Article::all();
        $this->assign('art_List', $art_List);
        // 热门文章
        $latest_list = $this->getArticleByPage(3, 'art_hits');
        $this->assign('latest_list', $latest_list);
        // 获取所有栏目
        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);
        return $this->fetch();
    }

    /**
     * 通过页数,加载文章列表
     */
    public function getArticleByPage($limit, $file, $page = 1) {
        $article_model = new \app\common\model\Article();
        $start         = ($page - 1) * $limit;
        $end           = $page * $limit;
        $sql           = "select * from bg_article order by {$file} desc limit {$start},{$end}";
        return $article_model->query($sql);
    }

}
