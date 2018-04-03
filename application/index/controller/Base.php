<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Session;

class Base extends Controller
{

    public function __construct() {
        Parent::__construct();
    }

    /**
     * 初始化侧边栏
     *
     * @throws \think\exception\DbException
     */
    public function initAside() {
        // 热门文章
        $latest_list = $this->getArticleByPage(3, 'art_hits');
        $this->assign('latest_list', $latest_list);
        // 获取所有栏目
        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);
    }

    /**
     * 通过页数,加载文章列表
     */
    public function getArticleByPage($limit, $file, $page = 1) {
        $article_model = new \app\common\model\Article();
        $start         = ($page - 1) * $limit;
        $end           = $page * $limit;
        $sql           = "select * from bg_article left join bg_category on bg_article.cate_id = bg_category.cate_id order by {$file} desc limit {$start},{$end}";
        return $article_model->query($sql);
    }
}
