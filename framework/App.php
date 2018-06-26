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

// namespace Framework;

/**
 * Class App
 *
 * 框架自身应用
 *
 * @package Framework
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class App {

  /**
   * 用于加载各种方法
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:12
   *
   */
  public function load($handle)
  {
    $handle()->register();
  }
}
