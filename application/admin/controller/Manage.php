<?php

namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
use think\Session;

class Manage extends Base
{
    public function index() {
        $this->setAsideName();
        // 实例化admin用户
        return $this->fetch();
    }
}

?>