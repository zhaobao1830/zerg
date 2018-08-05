<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 23:26
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
    /*
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id
     */
    public function items()
    {
        return $this->hasMany('BannerItem','banner_id','id');
    }
    /**
     * @param $id
     * @return mixed
     */
    public static function getBannerById($id)
     {
//         原生sql语句
//        $result = Db::query('select * from banner_item where banner_id=?',[$id]);
//        return json($result);

//        查询构造器
        //Db后面的这部分叫做辅助方法，也叫链式方法
//        $result = Db::table('banner_item')->where('banner_id','=',$id)
//        // 上面操作返回的是query对象
//        //find() 返回以为数组，只有一条数据;select()返回的是二维数组，多条数据
//        // 只有调用了find()或select()才会生成sql语句；find()和select()才是真正的查询方法
//        ->select();
//        return $result;

        //     with(['items','items.img'])  表示查询的条件，items和items里的img
        // items 是model/Banner里的items
        // img 是model/Image里的img
        $banner = self::with(['items','items.img'])
            ->find($id);
        return $banner;
     }
}