<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/5
 * Time: 22:20
 */

namespace app\api\model;


use think\Model;

class Image extends Model
{
    // 查询的时候，隐藏这些字段
    protected $hidden = ['delete_time', 'id', 'from'];

    // 读取器 get是必须的
    // $value是数据库里的url值
    // 只要加上这个，获取图片的时候，就可以出现完成的路径
    // "url": "http://z.cn/image/banner-4a.png",
    public function getUrlAttr($value, $data)
    {
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}