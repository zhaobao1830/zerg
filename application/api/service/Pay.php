<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 11:13
 */

namespace app\api\service;

use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID)
        {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        // 这四个检测的顺序：先检测最有可能发生的，这样一旦有问题，就不用检测其他的了；
        // 消耗系统多的，放后面检测
        // 订单号可能根本不存在
        // 订单号确实是存在的，但是，订单号和当前用户是不匹配的
        // 订单可能已经被支付
        // 进行库存量检测
        $this->checkOrderValid();

        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
    }

    private function checkOrderValid(){
        $order = OrderModel::where('id','=',$this->orderID)
            ->find();
        if (!$order){
            throw new OrderException();
        }

        if (!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
    }
}