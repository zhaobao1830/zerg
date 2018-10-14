<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 11:13
 */

namespace app\api\service;

use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Loader;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

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
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice){
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid){
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);

        // 返回微信支付结果信息
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));

        return $this->getPaySignature($wxOrderData);
    }
    private function getPaySignature($wxOrderData){
        // 统一下单
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' ||
            $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
            //return $wxOrder['return_msg'];
        }
        // prepay_id 如果要向微信发送信息，就需要这个id
        // 把微信服务器传回来的prepay_id更新到数据库里
        $this->recordPreOrder($wxOrder);

        // 生成签名，然后返回信息
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    // 把参数和签名生成后返回到客户端
    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        //生成签名
        $sign = $jsApiPayData->MakeSign();
        // 把签名也放进参数里
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        // 这个数据里有appId，不想让它返回到客户端，所以删除它
        unset($rawValues['appId']);

        return $rawValues;
    }
    private function recordPreOrder($wxOrder){
        OrderModel::where('id','=',$this->orderID)
            ->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    // 对订单进行检测
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

        if ($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException([
                'msg' => '订单状态异常',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;;
        return true;
    }
}