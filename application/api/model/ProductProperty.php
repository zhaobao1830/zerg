<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/16
 * Time: 18:17
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden=['product_id', 'delete_time', 'id'];
}