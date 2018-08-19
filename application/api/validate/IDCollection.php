<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 22:44
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule=[
        'ids'=>'require'
    ];

    protected $message=[
        'ids'=>'ids参数必须是以逗号分隔的多个正整数'
    ];

    // $value为传进去的ids
    protected function checkIDs($value)
    {
        // 使用,号分割
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                // 必须是正整数
                return false;
            }
        }
        return true;
    }
}