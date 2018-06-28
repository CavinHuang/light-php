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
use Framework\Exceptions\HttpException;

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
   * 框架实例根目录
   *
   * @var string
   */
  private $rootPath;

  /**
   * 服务容器
   *
   * @var object
   */
  public static $container;

  /**
   * 是否输出响应结果
   *
   * 默认输出
   *
   * cli模式　访问路径为空　不输出
   *
   * @var boolean
   */
  public $notOutput = false;

  public static $isCli = false;

  public function __construct ($rootPath, Closure $loader) {

    // cli模式
    $this->isCli    = getenv('IS_CLI');

    // 根目录
    $this->rootPath = $rootPath;

    // 注册自加载
    $loader();
    Loader::register($this);

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
    if ($this->notOutput) return;
    $closure()->restSuccess($this->responseData);
  }

  /**
   * 内部调用get
   * 可构建微单体架构
   * @param  string $uri 要调用的path
   * @param  array $argus 参数
   * @return object
   */
  public function get($uri = '', $argus = array())
  {
    return $this->callSelf('get', $uri, $argus);
  }

  /**
   * 内部调用post
   * 可构建微单体架构
   * @param  string $uri 要调用的path
   * @param  array $argus 参数
   * @return object
   */
  public function post($uri = '', $argus = array())
  {
    return $this->callSelf('post', $uri, $argus);
  }

  /**
   * 内部调用put
   * 可构建微单体架构
   * @param  string $uri 要调用的path
   * @param  array $argus 参数
   * @return object|void
   */
  public function put($uri = '', $argus = array())
  {
    return $this->callSelf('put', $uri, $argus);
  }

  /**
   * 内部调用delete
   * 可构建微单体架构
   * @param  string $uri 要调用的path
   * @param  array $argus 参数
   * @return object
   */
  public function delete($uri = '', $argus = array())
  {
    return $this->callSelf('delete', $uri, $argus);
  }

  /**
   * 内部调用
   * 可构建微单体架构
   * @param  string $method 模拟的http请求method
   * @param  string $uri    要调用的path
   * @param  array $argus   参数
   * @return object
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function callSelf($method = '', $uri = '', $argus = array())
  {
    $requestUri = explode('/', $uri);
    if (count($requestUri) !== 3) {
      throw new HttpException(400);
    }
    $request = self::$container->getSingle('request');
    $request->method        = $method;
    $request->requestParams = $argus;
    $request->getParams     = $argus;
    $request->postParams    = $argus;
    $router  = self::$container->getSingle('router');
    $router->moduleName     = $requestUri[0];
    $router->controllerName = $requestUri[1];
    $router->actionName     = $requestUri[2];
    $router->routeStrategy  = 'microMonomer';
    $router->route();
    return $this->responseData;
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
