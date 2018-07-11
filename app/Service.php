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

namespace App;

use Framework\App;

/**
 * Class Service
 *
 *  用户自定义服务
 *
 * @package app
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class Service {

  /**
   * 注册用户自定义执行的类
   *
   * @var array
   */
  private $map = [
    //　演示 加载自定义网关
    'App\Demo\Service\Gateway\Entrance'
  ];

  /**
   * 构造函数
   *
   * 初始化用户自定义类
   *
   * @param App $app 框架实例
   */
  public function __construct(App $app)
  {
    foreach ($this->map as $v) {
      new $v($app);
    }
  }
}
