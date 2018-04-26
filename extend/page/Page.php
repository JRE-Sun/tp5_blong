<?php

namespace page;

class Page
{
    private $curr_page; // 当前第几页
    private $art_total; // 一共多少文章
    private $every_page_nums; // 每页多少文章
    private $url; // url
    private $page_total; // 一共多少页
    private $most_page; // 最多同时出现几个page标签

    /**
     * @param int $curr_page
     * @param     $art_total
     * @param     $every_page_nums
     * @param     $url
     */
    public function __construct($curr_page = 0, $art_total, $every_page_nums, $url) {
        $this->curr_page       = $curr_page;
        $this->art_total       = $art_total;
        $this->every_page_nums = $every_page_nums;
        $this->url             = substr($url, 0, strpos($url, "page_index") + 11);
        $this->page_total      = ceil($art_total / $every_page_nums);
        $this->most_page       = 4;
    }

    /**
     * 生成page Html
     */
    public function create_page() {
        if ($this->page_total == 1) {
            return '';
        }
        $page_html   = '';
        $start_index = $this->curr_page; // for循环开始
        if ($start_index > $this->page_total) {
            $start_index     = 1;
            $this->curr_page = 1;
        }
        $max_start = $this->page_total - $this->most_page;
        if ($start_index > $max_start) {
            $start_index = $max_start;
        }
        if ($start_index < 1) {
            $start_index = 1;
        }
        $end_index = $start_index + $this->most_page; // for循环结束
        if ($end_index > $this->page_total) {
            $end_index = $this->page_total;
        }
        // 当前是第一页
        if ($this->curr_page != 1) {
            $page_html = $page_html . '<li><a href="' . $this->url . ($this->curr_page - 1) . '">&laquo;</a></li>';
        }
        for ($i = $start_index; $i <= $end_index; $i++) {
            if ($i == $this->curr_page) {
                $page_html = $page_html . '<li class="active"><a href="#">' . $i . '</a></li>';
            } else {
                $page_html = $page_html . '<li><a href="' . $this->url . $i . '">' . $i . '</a></li>';
            }
        }
        // 当前不是是最后一页
        if ($this->curr_page != $this->page_total) {
            $page_html = $page_html . '<li><a href="' . $this->url . ($this->curr_page + 1) . '">&raquo;</a></li>';
        }
        return '<ul class="pagination" style="margin:10px 0;float:right;">' . $page_html . '</ul>';
    }
}