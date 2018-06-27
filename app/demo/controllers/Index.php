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

class Index {

  public function hello () {

    return 'Hello lightPHP';
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
}
