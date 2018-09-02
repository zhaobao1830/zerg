<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/1
 * Time: 21:59
 */

namespace app\api\controller\v1;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\lib\exception\ProductException;

class Product
{
    public function getByCategory($count=15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
}