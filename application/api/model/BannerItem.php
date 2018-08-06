<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/5
 * Time: 21:53
 */

namespace app\api\model;


use think\Model;

class BannerItem extends Model
{
    // 查询的时候，隐藏这些字段
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time'];
    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}