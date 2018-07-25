<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 23:17
 */

namespace app\sample\controller;


class Test
{
  public function hello($id, $name, $age)
  {
      echo $id;
      echo '|';
      echo $name;
      echo '|';
      echo $age;
//      return 'Hello,zb';
  }
}