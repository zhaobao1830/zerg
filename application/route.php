<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//配置式路由
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

////动态路由
//use think\Route;

//Route::rule('路由表达式', '请求地址', '请求类型', '路由参数（数组）', '变了规则（数组）');

//GET,POST,DELETE,PUT,*

//(1)、第一种写法
//Route::rule('hello', 'sample/Test/hello', 'GET', ['https'=>true]);
//Route::rule('hello', 'sample/Test/hello', 'GET|POST', ['https'=>true]);
//(2)、第二种写法
//Route::post('hello/:id', 'sample/Test/hello');
//Route::post();
//Route::any();

//动态路由
use think\Route;

Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');