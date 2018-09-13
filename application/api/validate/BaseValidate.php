<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4
 * Time: 16:40
 */

namespace app\api\validate;



use app\lib\exception\ParameterException;
use think\Exception;
use think\Validate;
use think\Request;
/**
 * Class BaseValidate
 * 验证类的基类
 */
class BaseValidate extends Validate
{
    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * 基类定义了很多自定义验证方法
     * 这些自定义验证方法其实，也可以直接调用
     * @throws ParameterException
     * @return true
     */
    public function goCheck()
    {
        //获取http传入的参数
        // 对这些参数进行校验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->check($params);
        if(!$result){
//            $e = new ParameterException([
            $error = $this->error;
//            ]);
            throw new Exception($error);
//            throw $msg;
        }else{
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }else{
            return false;
        }
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }
}