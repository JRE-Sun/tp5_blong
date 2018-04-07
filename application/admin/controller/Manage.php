<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;
use think\Session;

class Manage extends Base
{
    public function index() {
        $this->setAsideName();
        // 获取所有文章
        $art_total = \app\common\model\Article::count();
        $this->assign('art_total', $art_total);
        // 获取分类数量
        $cat_total = \app\common\model\Category::count();
        $this->assign('cat_total', $cat_total);
        // 获取点击量
        $web_info = \app\common\model\Web::get(1);
        $this->assign('web_info', $web_info);
        // 获取单页面总数
        $single_total = \app\common\model\Single::count();
        $this->assign('single_total', $single_total);
        // 实例化admin用户
        return $this->fetch();
    }
}

?>