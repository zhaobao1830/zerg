<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 16:18
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
// 读取器 get是必须的
    // $value是数据库里的url值
    // 只要加上这个，获取图片的时候，就可以出现完成的路径
    // "url": "http://z.cn/image/banner-4a.png",
    public function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}