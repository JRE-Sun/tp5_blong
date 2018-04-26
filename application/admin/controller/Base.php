<?php

namespace app\admin\controller;

use think\Request;
use think\Controller;
use think\Session;
use think\Config;

class Base extends Controller
{
    public $data = [];

    public function __construct() {
        Parent::__construct();
        // error 1代表失败,0代表成功
        $this->data['error'] = 1;
        $this->checkLogin();
    }

    public function setAsideName() {
        $request = Request::instance();
        $this->assign('aside_active', mb_strtolower($request->controller()));
    }

    public function getNotEmptyParam($val) {
        $is_empty = empty(trim($val));
        return $is_empty ? $this->failException : trim($val);
    }

    /**
     * 检查用户是否登陆
     *
     * @return mixed
     */
    public function checkLogin() {
        // 排除不需要判断是否登陆的页面
        $c_array = array(
            'Admin' => array('index', 'login', 'createcode'),
        );
        $request = Request::instance();
        // 获取当前控制器和方法
        $action     = $request->action();
        $controller = $request->controller();
        $is_land    = Session::get('admin_info');
        // 判断当前控制器和方法是对否存在于$c_array
        if (in_array($controller, array_keys($c_array)) && in_array($action, $c_array[$controller])) {
            if ($is_land) {
                // 如果登陆了
                $this->redirect(Config::get('api') . 'admin/manage/index');
            }
            return;
        }
        // 如果session没值,说明没登录
        if (!$is_land) {
            // 当没有登陆->直接跳转到登陆页面
            $this->error('请登录后继续操作!', Config::get('api') . 'admin/admin/index');
            return;
        }
    }

    /**
     * 初始化分页
     */
    public function initPage($every_page_nums, $cate_id = "", $like = "", $is_del = 0) {
        if (empty($cate_id)) {
            // 如果第二个参数为空
            $count_cate_id  = '';
            $select_cate_id = '';
        } else {
            $count_cate_id  = 'and bg_article.cate_id=' . $cate_id;
            $select_cate_id = 'and bg_category.cate_id=' . $cate_id;
        }
        if (!empty($like)) {
            $like = ' and ( ' . $like . ' )';
        }
        $request = Request::instance();
        // 获取当前页数,,默认1
        $page_index = (count($request->param()) == 0 || !in_array('page_index', array_keys($request->param()))) ? 1 : $request->param()['page_index'];
        $art_model  = new \app\common\model\Article;
        $sql        = "select count(*) from bg_article where bg_article.is_del='" . $is_del . "' {$count_cate_id} {$like}";
        // 文章总数
        $art_total = $art_model->query($sql)[0]['count(*)'];
        // 每页多少篇文章 $every_page_nums
        $start_rows = ($page_index - 1) * $every_page_nums;
        // 分页的html
        $page      = new \page\Page($page_index, $art_total, $every_page_nums, $request->url());
        $page_html = $page->create_page();
        $this->assign('page_html', $page_html);
        $sql      = "select * from bg_article, bg_category where bg_article.is_del='" . $is_del . "' and bg_category.cate_id=bg_article.cate_id {$select_cate_id} {$like} order by art_addtime desc limit {$start_rows},{$every_page_nums}";
        $art_list = $art_model->query($sql);
        return $art_list;
    }
}