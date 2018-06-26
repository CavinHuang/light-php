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


class Loader {

  public function __construct()
  {
    $this->register();
  }

  /**
   * 注册器
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:14
   *
   */
  public function register () {
    spl_autoload_register([$this, 'autoLoad']);
  }

  /**
   *
   * 自定义自动加载类
   *
   * @param $class
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:15
   */
  public function autoLoad ($class) {
    if (empty($class)) {
      throw new \Exception("Error Processing Request", 1);
    }
    $class_info = explode('\\', $class);
    $class_name = array_pop($class_info);

    foreach ($class_info as &$v) {
      $v = strtolower($v);
    }
    unset($v);
    array_push($class_info, $class_name);
    $class = implode('\\', $class_info);

    require ROOT_PATH.'/'.str_replace('\\', '/', $class).'.php';
  }
}
