<?php

namespace app\admin\controller;

use think\Request;

class Article extends \app\admin\controller\Base
{
    public function index() {
        $this->setAsideName();
        $art_model = new \app\common\model\Article;
        $sql       = 'select * from bg_article, bg_category where bg_category.cate_id=bg_article.cate_id ';
        $art_list  = $art_model->query($sql);
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
        $param               = $request->param();
        $param['art_author'] = $request->session('admin_info')['admin_name'];
        // 数据入库
        $article = \app\common\model\Article::create($param);
        if (is_null($article)) {
            $this->error('发布文章失败!');
            return;
        }
        $this->success('发布成功!', '/public/index.php/admin/article/index');
    }
}

?>