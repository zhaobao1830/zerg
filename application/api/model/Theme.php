<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 17:19
 */

namespace app\api\model;


class Theme extends BaseModel
{
    public function topicImg()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }
    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }
}