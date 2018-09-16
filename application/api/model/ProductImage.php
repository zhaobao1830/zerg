<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/16
 * Time: 18:14
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];
    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}