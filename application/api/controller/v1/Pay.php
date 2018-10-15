<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 11:10
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    // 生成预订单信息
    public function getPreOrder($id=''){
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        // 返回支付参数
        return $pay->pay();
    }

    // 微信支付回调处理
    public function receiveNotify(){
       //通知频率为15/15/30/180/1800/1800/1800/3600,单位:秒

        //1.检查库存量,有可能超卖
        //2.更新这个订单的status状态
        //3.减库存
        //如果成功处理，返回微信成功处理信息,否则返回未成功处理信息

        //微信返回的数据特点：post,xml格式,不会携带参数
        // 使用SDK的好处 可以处理XML格式
        $notify = new WxNotify();
        $notify->Handle();
    }
}