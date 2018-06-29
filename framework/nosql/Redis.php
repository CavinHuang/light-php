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

namespace Framework\Nosql;

use Framework\App;
use \Redis as rootRedis;

class Redis {
  /**
   * 构造函数
   */
  public function __construct()
  {
    $config = App::$container->getSingle('config');
    $config = $config->config['nosql']['redis'];
    $redis = new rootRedis();
    $redis->connect($config['host'], $config['port']);
    App::$container->setSingle('redis', $redis);
  }
}
