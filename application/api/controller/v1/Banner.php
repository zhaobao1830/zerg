<?php
/**
 * Created by PhpStorm.
 * User: zb
 * Date: 2018/7/30
 * Time: 8:30
 */

namespace app\api\controller\v1;


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
       $data = [
           'name' => 'vendor11111',
           'email' => 'venodr@qq.com'
       ];
       $validate = new Validate([
           'name' => 'require|max:10',
           'email' => 'email'
       ]);
       $result = $validate->batch()->check($data);
       var_dump($validate->getError());
   }
}