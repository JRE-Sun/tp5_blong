<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Article extends Base
{
    public function detail() {
        // 根据art_id获取文章信息
        $art_id    = Request::instance()->param()['art_id'];
        $art_model = new \app\common\model\Article;
        $sql       = "select * from bg_article left join bg_category on bg_article.cate_id = bg_category.cate_id  where bg_article.art_id={$art_id}";
        $art_info  = $art_model->query($sql);
        if (count($art_info) == 0) {
            $this->error('该文章已经飞走啦!3s后自动返回首页.', '/public/index.php');
            return;
        }
        $art_info = $art_info[0];
        $this->assign('art_info', $art_info);
        // 根据当前文章分类,获取该分类下的上一篇,下一篇文章
        // 上一篇::id小于当前id的
        $sql      = "select * from bg_article left join bg_category on bg_article.cate_id = bg_category.cate_id  where bg_category.cate_id={$art_info['cate_id']} and bg_article.art_id<{$art_info['art_id']}";
        $pre_info = $art_model->query($sql);
        $pre_info = count($pre_info) != 0 ? $pre_info[0] : $pre_info;
        $this->assign('pre_info', $pre_info);
        // 下一篇::id大于当前id的
        $sql       = "select * from bg_article left join bg_category on bg_article.cate_id = bg_category.cate_id  where bg_category.cate_id={$art_info['cate_id']} and bg_article.art_id>{$art_info['art_id']}";
        $next_info = $art_model->query($sql);
        $next_info = count($next_info) != 0 ? $next_info[0] : $next_info;
        $this->assign('next_info', $next_info);
        return $this->fetch();
    }

    /**
     * 文章详情页点击对应分类
     * 进入该分类下的文章列表页
     */
    public function listPage() {
        $request = Request::instance();
        // 获取所有参数
        $param     = $request->param();
        $art_model = new \app\common\model\Article;
        $sql       = "select * from bg_article, bg_category where is_del='0' and bg_category.cate_id=bg_article.cate_id and bg_category.cate_id={$param['cate_id']}";
        $art_list  = $art_model->query($sql);
        $this->assign('art_list', $art_list);
        return $this->fetch('list');
    }
}

?>