<?php
namespace app\admin\controller;
use think\captcha\Captcha;
use think\Config;
use think\Request;
use think\Session;
class Admin extends Base
{
    /**
     * 后台首页->没有登陆会自动跳转到这个页面
     *
     * @return mixed
     */
    public function index() {
        return $this->fetch('login');
    }
    /**
     * 接收登陆请求
     *
     * @param Request $request
     */
    public function login(Request $request) {
        // 实例化IndexModel
        $admin = new \app\admin\model\Admin();
        if (!$admin->login($request->param())) {
            $this->error('登陆失败!');
            return;
        }
        $this->success('登陆成功!', Config::get('api') . 'admin/manage/index/');
    }
    /**
     * 注销登陆
     */
    public function loginOut() {
        Session::clear();
        $this->success('注销成功!', Config::get('api') . 'admin/admin/index/');
    }
    public function createCode() {
        $captcha = new Captcha();
        return $captcha->entry();
    }
    /**
     * 更新网站管理员信息
     */
    public function update() {
        $request = Request::instance();
        // 获取所有参数
        $param = $request->param();
        // 判断参数是否有 空
        $has_empty = true;
        foreach ($param as $value) {
            // 当有空会返回 false
            $has_empty = $this->getNotEmptyParam($value);
        }
        // 当有空参数 或 两次新密码不一致
        if (!$has_empty || $param['admin_pass'] != $param['admin_new_pass'] || empty($param['admin_pass'])) {
            $this->error('更新失败!');
            return;
        }
        // 查询旧密码
        $admin_info     = \app\admin\model\Admin::get($param['admin_id']);
        $admin_old_pass = $admin_info->admin_pass;
        if ($admin_old_pass != $param['admin_old_pass']) {
            $this->error('密码输入错误!');
            return;
        }
        // 更新admin
        $admin_info = \app\admin\model\Admin::where('admin_id', $param['admin_id'])->update([
            'admin_name' => $param['admin_name'],
            'admin_pass' => $param['admin_new_pass'],
        ]);
        if ($admin_info) {
            // 成功,刷新页面
            $this->success('更新成功!', Config::get('api') . 'admin/category/index');
            return;
        }
        $this->error('更新失败!');
    }
}