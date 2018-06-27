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

use Framework\Exceptions\HttpException;

class Loader {

  public static $map = [];

  /**
   * 注册器
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:14
   *
   */
  public static function register () {
    spl_autoload_register(['Loader', 'autoLoad']);
    // 引入composer自加载文件
    require(ROOT_PATH . '/vendor/autoload.php');
  }

  /**
   * 自定义自动加载类
   * @param $class
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:15
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public static function autoLoad ($class) {

    $classOrigin = $class;
    $classInfo = explode('\\', $class);
    $className = array_pop($classInfo);
    foreach ($classInfo as &$v) {
      $v = strtolower($v);
    }
    unset($v);
    array_push($classInfo, $className);
    $class       = implode('\\', $classInfo);
    $classPath   = ROOT_PATH.'/'.str_replace('\\', '/', $class).'.php';
    if (!file_exists($classPath)) {
      throw new HttpException(404, "$classPath Not Found");
    }
    self::$map[$classOrigin] = $classPath;
    require $classPath;

  }
}
