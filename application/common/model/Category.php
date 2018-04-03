<?php

namespace app\common\model;

use think\Model;
use think\Session;

class Category extends Model
{
    /**
     * 插入数据到数据库
     */
    public function insertDb($param) {
        $this->data($param);
        $this->save();
        $cate_id = (!is_null($this)) && $this->getAttr('cate_id');
        return $cate_id;
    }
}

?>