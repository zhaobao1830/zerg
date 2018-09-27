<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25
 * Time: 21:51
 */

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

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
        $user = User::get($uid);
        if(!$user){
            throw new UserException([
                'code' => 404,
                'msg' => '用户收获地址不存在',
                'errorCode' => 60001
            ]);
        }
        $dataArray = getDatas();
        $userAddress = $user->address;
        if(!$userAddress)
        {
            // 通过模型找到关联的模型，进行操作
            // 新增
            $user->address()->save($userAddress);
        }else{
            // 更新
            $user->address->save($userAddress);
        }
        return new SuccessMessage();
    }
}