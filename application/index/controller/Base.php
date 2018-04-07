<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Session;

class Base extends Controller
{

    public function __construct() {
        Parent::__construct();
        // 更新网站点击量
        $this->initWebNums();
        // 获取所有分类
        $this->getAllCate();
        // 获取所有单页面
        $this->getAllSingle();
        // 设置 action,controller
        $this->setACName();
        // 获取网站信息
        $this->getWebInfo();
    }

    public function getWebInfo() {
        $web_list = \app\common\model\Web::all();
        $web_info = $web_list[0];
        $this->assign('web_info', $web_info);
    }

    /**
     * 设置正在执行action,controller的name
     */
    public function setACName() {
        $request = Request::instance();
        $this->assign('action', $request->action());
        $this->assign('controller', $request->controller());
    }

    public function getAllCate() {
        $cate_model = new \app\common\model\Category;
        $sql        = "select * from bg_category where cate_id!=40";
        $cate_list  = $cate_model->query($sql);
        $this->assign('cate_list', $cate_list);
    }

    public function getAllSingle() {
        $sing_model = new \app\common\model\Single;
        $sql        = "select * from bg_single where is_del='0' and sing_visibility='1'";
        $sing_list  = $sing_model->query($sql);
        $this->assign('sing_list', $sing_list);
    }

    /**
     * 每次有人点击页面,都更新网站浏览量
     */
    public function initWebNums() {
        $web_info = new \app\common\model\Web;
        $sql      = "update bg_web set web_click=web_click+1 where web_id=1";
        $web_info->query($sql);
    }

    /**
     * 通过页数,加载文章列表
     */
    public function getArticleByPage($limit, $file, $page = 1) {
        $article_model = new \app\common\model\Article();
        $start         = ($page - 1) * $limit;
        $end           = $page * $limit;
        $sql           = "select * from bg_article left join bg_category on bg_article.cate_id = bg_category.cate_id where bg_article.art_visibility='1' and bg_article.is_del='0' and bg_article.cate_id!=40 order by {$file} desc limit {$start},{$end}";
        return $article_model->query($sql);
    }
}
