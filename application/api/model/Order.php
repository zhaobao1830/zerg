<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/7
 * Time: 18:12
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;   //自动返回当前时间戳
}