<?php

namespace app\admin\controller;

use think\Config;
use think\Request;

class Article extends \app\admin\controller\Base
{
    public function index() {
        $this->setAsideName();
        // 初始化分页
        $art_list = $this->initPage(10);
        $this->assign('art_list', $art_list);
        return $this->fetch();
    }

    /**
     * 添加文章页面
     */
    public function addPage() {
        $this->setAsideName();
        // 读取栏目列表
        // 实例化模型->获取所有栏目
        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);
        return $this->fetch('add');
    }

    public function add() {
        $request = Request::instance();
        // 获取所有参数
        $param                = $request->param();
        $param['art_addtime'] = strtotime($param['art_addtime']);
        // 数据入库
        $article = \app\common\model\Article::create($param);
        if (is_null($article)) {
            $this->error('发布文章失败!');
            return;
        }
        $this->redirect(Config::get('api') . 'admin/article/index', 302);
    }

    /**
     * 更新文章页面
     */
    public function update() {
        $this->setAsideName();
        $request = Request::instance();
        // 获取所有参数
        $param    = $request->param();
        $art_info = \app\common\model\Article::get($param['art_id']);
        $this->assign('art_info', $art_info);
        $cate_list = \app\common\model\Category::all();
        $this->assign('cate_list', $cate_list);
        return $this->fetch();
    }

    /**
     * 更新文章
     */
    public function updateArt() {
        $request = Request::instance();
        // 获取所有参数
        $param                = $request->param();
        $param['art_addtime'] = strtotime($param['art_addtime']);
        // 实例化模型->获取所有栏目
        $art_info = \app\common\model\Article::where('art_id', $param['art_id'])->update($param);
        if ($art_info) {
            // 成功,刷新页面
            $this->redirect(Config::get('api') . 'admin/article/index', 302);
            return;
        }
        $this->error('更新失败!');
    }

    /**
     * 文章点击对应分类,进入该分类下的文章列表页
     */
    public function listPage() {
        $this->setAsideName();
        $request = Request::instance();
        // 获取所有参数
        $param    = $request->param();
        $art_list = $this->initPage(10, $param['cate_id']);
        $this->assign('art_list', $art_list);
        return $this->fetch('list');
    }

    public function search() {
        $this->setAsideName();
        $request = Request::instance();
        // 获取所有参数
        $srarch_value = $request->param()['srarch_value'];
        $art_list     = $this->initPage(10, '', "art_title like '%{$srarch_value}%' or art_content like '%{$srarch_value}%'");
        $this->assign('art_list', $art_list);
        return $this->fetch('list');
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
        $article         = \app\common\model\Article::get($param['art_id']);
        $article->is_del = 1;
        $article_info    = $article->save();
        if ($article_info) {
            $this->redirect(Config::get('api') . 'admin/article/index', 302);
            return;
        }
        $this->error('删除失败!', Config::get('api') . 'admin/article/index');
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
        $article                 = \app\common\model\Article::get($param['art_id']);
        $article->art_visibility = $param['visibility'];
        $article_info            = $article->save();
        if ($article_info) {
            $this->redirect($request->header()['referer'], 302);
            return;
        }
        $this->error('更新失败!');
    }
}

?>