<?php

namespace app\admin\controller;

use think\Config;
use think\Request;

class Category extends \app\admin\controller\Base
{
    /**
     * 栏目首页
     */
    public function index() {
        $this->setAsideName();
        // 实例化模型->获取所有栏目
        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);
        return $this->fetch();
    }

    /**
     * 添加分类
     */
    public function add() {
        $request = Request::instance();
        // 获取所有参数
        $param = $request->param();
        // 检查数据正确性
        if (!$this->getNotEmptyParam($param['cate_name'])) {
            // 如果类别名称为空
            $this->error('栏目名称填写错误!', Config::get('api') . 'admin/category/index');
            return;
        }
        // 插入数据库
        $cate_model    = new \app\common\model\Category();
        $insert_result = $cate_model->insertDb($param);
        // 失败,弹出错误信息,刷新页面
        if (!$insert_result) {
            $this->error('未知错误!', Config::get('api') . 'admin/category/index');
            return;
        }
        // 成功,刷新页面
        $this->redirect(Config::get('api') . 'admin/category/index', 302);
    }

    public function update() {
        $this->setAsideName();
        $request = Request::instance();
        // 获取所有参数
        $param         = $request->param();
        $category_info = \app\common\model\Category::get($param['cate_id']);
        $this->assign('cate_info', $category_info);
        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);
        return $this->fetch();
    }

    /**
     * 接收更新数据,执行更新
     */
    public function updateCate() {
        $request = Request::instance();
        // 获取所有参数
        $param = $request->param();
        // 实例化模型->获取所有栏目
        $category_info = \app\common\model\Category::where('cate_id', $param['cate_id'])->update($param);
        if ($category_info) {
            // 成功,刷新页面
            $this->redirect(Config::get('api') . 'admin/category/index', 302);
            return;
        }
        $this->error('更新失败!', Config::get('api') . 'admin/category/index');
    }

    public function delete() {
        $request = Request::instance();
        // 获取所有参数
        $param = $request->param();
        // 实例化模型->删除栏目
        $category      = \app\common\model\Category::get($param['cate_id']);
        $category_info = $category->delete();
        if ($category_info) {
            $this->redirect(Config::get('api') . 'admin/category/index', 302);
            return;
        }
        $this->error('删除失败!', Config::get('api') . 'admin/category/index');
    }
}

?>