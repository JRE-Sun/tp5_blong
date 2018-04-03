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
        $latest_list = \app\common\model\Article::all(function ($query) {
            $query->limit(3)->order('art_hits', 'desc');
        });
        $this->assign('latest_list', $latest_list);
        // 获取所有栏目

        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);

        return $this->fetch();
    }

}
