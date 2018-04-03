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
        return true;
    }
}

?>