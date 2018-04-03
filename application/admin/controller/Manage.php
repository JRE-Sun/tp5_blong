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
        // 实例化admin用户
        return $this->fetch();
    }
}

?>