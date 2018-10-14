<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/14
 * Time: 16:50
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use think\Db;
use think\Exception;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
class WxNotify extends \WxPayNotify
{
    // $data 微信返回来的是XML，但是已经被SDK转换成数组了
    public function NotifyProcess($data, &$msg){
        if ($data['result_code'] == 'SUCCESS'){
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try{
                $order = OrderModel::where('order_no','=',$orderNo)
                    ->lock(true)
                    ->find();
                if ($order->status == OrderStatusEnum::UNPAID){
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);
                    // 库存量检测通过
                    if($stockStatus['pass']){
                        $this->updateOrderStatus($order->id,true);
                        $this->reduceStock($stockStatus);
                    }else{
                        $this->updateOrderStatus($order->id,false);
                    }
                }
                Db::commit();
                return true;
            }catch (Exception $ex){
                Db::rollback();
                Log::error($ex);
                return false;
            }
        }else{
//            备注：这里的true和false，只是为了控制微信服务器是否向你继续发送信息
//            所以在我们已经知道返回的信息是支付失败的时候，也要return true，终止微信服务器
//            继续发送信息
            return true;
        }
    }

    private function updateOrderStatus($orderID,$success){
        $status = $success?OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id','=',$orderID)->update(['status' => $status]);
    }

    private function reduceStock($stockStatus){
        foreach ($stockStatus['pStatusArray'] as $singlePStatus){
            Product::where('id','=',$singlePStatus['id'])->
            setDec('stock',$singlePStatus['count']);
        }
    }
}