<?php
/*************************************************
 *                  light PHP                    *
 *                                               *
 *    A Lightweight Full-Stack PHP Framework     *
 *                                               *
 *                  cavinHuang                   *
 *        <https://github.com/TIGERB>            *
 *                                               *
 *************************************************/

namespace app\demo\controllers;

use Framework\App;
use Framework\Orm\DB;

class Index {

  public function hello () {
    $get = App::$container->getSingle('request')->get();
    return ['text' => 'Hello lightPHP', 'get' => $get];
  }

  /**
   * demo
   *
   * @return json
   */
  public function get()
  {
    return App::$container->getSingle('request')
      ->get('password', 'aaa');
  }
  /**
   * 框架内部调用演示
   *
   * 极大的简化了内部模块依赖的问题
   *
   * 可构建微单体建构
   *
   * @example domain/Demo/Index/micro
   * @return  json
   */
  public function micro()
  {
    return App::$app->get('demo/index/hello', [
      'user' => 'TIGERB'
    ]);
  }

  /**
   * @author cavinHUang
   * @date   xxx
   **/
  public function orm () {
    $instance = DB::table('test');
     $last = $instance->where(['id' => 1])->fetch();
     // var_dump($instance->getTableInfo());exit;
     //$last2 = $instance->where('id', 1)->fetch();
     // $res = $instance->where('id', '>', 1)->fetch();

     //$fetchAll = $instance->field('id,name')->where('id', '>', 1)->order('id desc')->limit('0,4')->fetchAll();

    // $res = $instance->insert(['name' => 'cavinhuang', 'age' => 33]);

     // $isUpdate = $instance->where('age', '26')->update(['name' => 'light-php']);
      $res = $instance->avg('age as age');

     return ['result' => $res,  'lastId' => $instance, 'lastSql' => $instance->lastSql];
  }
}
