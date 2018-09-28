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
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();
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
        $userAddress = $user->address;
        // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
        $data = $validate->getDataByRule(input('post.'));
        if(!$userAddress)
        {
            // 通过模型找到关联的模型，进行操作
            // 新增
            $user->address()->save($data);
        }else{
            // 更新
            $user->address->save($data);
        }
        // 这地方的想法是，增加或更新后，返回一个状态值，我们把状态值写到SuccessMessage里
        // 备注：SuccessMessage虽然是异常文件，但是思路要想的大点，异常文件也可以返回
        return new SuccessMessage();
    }
}