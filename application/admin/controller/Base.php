<?php

namespace app\admin\controller;

use think\Request;
use think\Controller;
use think\Session;

class Base extends Controller
{

    public function __construct() {
        Parent::__construct();
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
                $this->redirect('http://www.tp.cc/public/index.php/admin/manage/index');
            }
            return;
        }
        // 如果session没值,说明没登录
        if (!$is_land) {
            // 当没有登陆->直接跳转到登陆页面
            $this->error('请登录后继续操作!', '/public/index.php/admin/admin/index');
            return;
        }
    }


}
