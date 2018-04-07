<?php

namespace app\admin\controller;

use think\Config;
use think\Request;

class Single extends \app\admin\controller\Base
{
    public function index() {
        $this->setAsideName();
        $sing_model = new \app\common\model\Single;
        $sql        = "select * from bg_single where is_del='0'";
        $sing_list  = $sing_model->query($sql);
        $this->assign('sing_list', $sing_list);
        return $this->fetch();
    }

    /**
     * 添加文章页面
     */
    public function addPage() {
        $this->setAsideName();
        return $this->fetch('add');
    }

    public function add() {
        $request = Request::instance();
        // 获取所有参数
        $param                 = $request->param();
        $param['sing_addtime'] = strtotime($param['sing_addtime']);
        // 数据入库
        $article = \app\common\model\Single::create($param);
        if (is_null($article)) {
            $this->error('添加单页面失败!');
            return;
        }
        $this->redirect(Config::get('api') . 'admin/single/index', 302);
    }

    /**
     * 更新文章页面
     */
    public function update() {
        $this->setAsideName();
        $request = Request::instance();
        // 获取所有参数
        $param     = $request->param();
        $sing_info = \app\common\model\Single::get($param['sing_id']);
        $this->assign('sing_info', $sing_info);
        return $this->fetch();
    }

    /**
     * 更新文章
     */
    public function updateArt() {
        $request = Request::instance();
        // 获取所有参数
        $param                 = $request->param();
        $param['sing_addtime'] = strtotime($param['sing_addtime']);
        // 实例化模型->获取所有栏目
        $sing_info = \app\common\model\Single::where('sing_id', $param['sing_id'])->update($param);
        if ($sing_info) {
            // 成功,刷新页面
            $this->redirect(Config::get('api') . 'admin/single/index', 302);
//            $this->success('更新成功!', Config::get('api').'admin/article/index');
            return;
        }
        $this->error('更新失败!', Config::get('api') . 'admin/single/index');
    }

    /**
     * 删除文章
     *
     * @throws \think\exception\DbException
     */
    public function delete() {
        $request = Request::instance();
        // 获取所有参数
        $param = $request->param();
        // 实例化模型->删除栏目
        $single         = \app\common\model\Single::get($param['sing_id']);
        $single->is_del = 1;
        $sing_info      = $single->save();
        if ($sing_info) {
            $this->redirect(Config::get('api') . 'admin/single/index', 302);
            return;
        }
        $this->error('删除失败!', Config::get('api') . 'admin/single/index');
    }

    /**
     * 更改文章发布状态
     *
     * @throws \think\exception\DbException
     */
    public function release() {
        $request = Request::instance();
        // 获取所有参数
        $param = $request->param();
        // 实例化模型->删除栏目
        $single                  = \app\common\model\Single::get($param['sing_id']);
        $single->sing_visibility = $param['visibility'];
        $sing_info               = $single->save();
        if ($sing_info) {
            $this->redirect(Config::get('api') . 'admin/single/index', 302);
            return;
        }
        $this->error('发布失败!', Config::get('api') . 'admin/single/index');
    }
}

?>