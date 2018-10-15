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

    // 读取器，返回的信息里的这俩个字段进行json处理
    public function getSnapItemsAttr($value){
        if (empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if (empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid,$page=1,$size=15){
        $pagingData = self::where('user_id','=',$uid)
            ->order('create_time','desc')
            ->paginate($size,true,['page'=>$page]);
        return $pagingData;
    }

    public static function getSummaryByPage($page=1, $size=20){
        $pagingData = self::order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }
}