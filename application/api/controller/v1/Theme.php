<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\lib\exception\ThemeException;
use think\Controller;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
     /*
      * @url /theme?ids=id1,id2...
      * @return 一组theme模型
      * */
    public function getSimpleList($ids = '')
    {
//        $validate = new IDCollection();
//        $validate->goCheck();
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
//        if ($result->isEmpty()) {
//            throw new ThemeException();
//        }
        return $result;
    }

    public function getComplexOne($id)
    {
//        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw new ThemeException();
        }
        return $theme;
    }
}
