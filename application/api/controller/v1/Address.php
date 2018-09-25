<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25
 * Time: 21:51
 */

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;

class Address
{
    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress()
    {
        (new Address())->goCheck();
        // 根据Token来获取UID
        // 根据UID来查找用户数据，判断用户是否存在，如果不存在就跑出异常
        // 获取用户从客户端提交来的地址
        // 根据用户地址信息是否存在，从而判断是添加还是更新地址
        $uid = TokenService::getCurrentUid();
    }
}