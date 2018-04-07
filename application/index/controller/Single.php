<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Single extends Base
{
    /**
     * 前台首页
     *
     * @return mixed
     */
    public function index() {
        // 根据art_id获取文章信息
        $sing_id   = Request::instance()->param()['sing_id'];
        $sing_info = \app\common\model\Single::get($sing_id);
        $this->assign('sing_info', $sing_info);
        return $this->fetch();
    }

}
