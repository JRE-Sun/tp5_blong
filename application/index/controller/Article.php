<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Article extends Base
{
    public function detail() {
        // 初始化侧边栏
        $this->initAside();
        // 根据art_id获取文章信息
        $art_id   = Request::instance()->param()['art_id'];
        $art_info = \app\common\model\Article::get($art_id);
        $this->assign('art_info', $art_info);
//        $this->console($art_info);
        return $this->fetch();
    }

    /**
     * 获取该栏目下所有文章
     *
     * @return int
     */
    public function art_list() {
        // 初始化侧边栏
        $this->initAside();
        $cate_id   = Request::instance()->param()['cate_id'];
        $art_model = new \app\common\model\Article;
        $sql       = "select * from bg_article left join bg_category on bg_article.cate_id = bg_category.cate_id where bg_category.cate_id = {$cate_id} order by art_addtime";
        $art_list  = $art_model->query($sql);
        $this->assign('art_list', $art_list);
       return $this->fetch('list');
    }

}

?>