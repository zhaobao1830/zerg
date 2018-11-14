<?php
/**
 * Created by PhpStorm.
 * User: zb
 * Date: 2018/7/30
 * Time: 8:30
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
   /**
    * 获取指定id的banner信息
    * @url /banner/:id
    * @http GET
    * @id banner的id
    */
   public function getBanner($id)
   {
       // AOP 面向切面编程
 //      $banner = BannerModel::get($id);
//       $validate = new IDMustBePositiveInt();
//       $validate->goCheck();
       (new IDMustBePositiveInt())->goCheck();
       $banner = BannerModel::getBannerById($id);
       if(!$banner) {
           throw new BannerMissException('内部错误');
       }
       return $banner;
   }
}