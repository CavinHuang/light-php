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

namespace Framework;

use \Closure;

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
   * 框架自身加载的方法集合
   *
   * @var array
   */
  private $_handleList = [];

  /**
   * 框架自身缓存
   *
   * @var
   */
  public static $app;

  /**
   * 请求对象
   *
   * @var
   */
  public $request;

  /**
   * 响应对象
   *
   * @var
   */
  public $responseData;

  /**
   * 服务容器
   *
   * @var object
   */
  public static $container;

  public function __construct () {
    self::$app = $this;
    self::$container = new Container();
  }

  /**
   * 用于加载各种方法
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:12
   *
   */
  public function load($handle)
  {
    $this->_handleList[] = $handle;
  }

  /**
   * 启动框架
   *
   * @author cavinHUang
   * @date   2018/6/27 0027 上午 9:41
   *
   */
  public function run(Closure $request)
  {
    self::$container->setSingle('request', $request);
    foreach ($this->_handleList as $handle) {
      $handle()->register($this);
    }
  }

  /**
   * 完整跑完整个流程，返回给请求
   *
   * @param \Closure $closure
   * @author cavinHUang
   * @date   2018/6/27 0027 上午 9:41
   *
   */
  public function response(Closure $closure)
  {
    $closure()->restSuccess($this->responseData);
  }

  /**
   * 魔术方法获取变量
   *
   * @author cavinHUang
   * @date   2018/6/27 0027 上午 9:42
   *
   */
  public function __get($name)
  {
    return $this->$name;
  }

  /**
   * 魔术方法设置变量
   *
   * @author cavinHUang
   * @date   2018/6/27 0027 上午 11:07
   *
   */
  public function __set($name, $value)
  {
    $this->$name = $value;
  }
}
