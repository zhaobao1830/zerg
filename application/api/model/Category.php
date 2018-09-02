<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2
 * Time: 15:36
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'create_time', 'update_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}