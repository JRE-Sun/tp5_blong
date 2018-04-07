<?php

namespace app\admin\model;

use think\Model;
use think\Session;

class Admin extends Model
{
    /**
     * 管理员登陆
     *
     * @param $parm
     *
     * @return null|static
     * @throws \think\exception\DbException
     */
    public function login($parm) {
//        $captcha = new Captcha();
//        if (!$captcha->check($parm['admin_code'])) {
//            return false;
//        }
        $admin_info = Admin::get(['admin_name' => $parm['admin_name'], 'admin_pass' => $parm['admin_pass']]);
        // 如果查询用户失败
        if (!$admin_info) {
            return false;
        }
        // 查询成功
        Session::set('admin_info', $admin_info);
        // 更新ip,登录次数,登录时间
        $admin_info->login_ip   = $_SERVER['REMOTE_ADDR'];
        $admin_info->login_nums = $admin_info->login_nums + 1;
        $admin_info->login_time = time();
        $admin_info->save();
        return true;
    }
}

?>