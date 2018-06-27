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

namespace Framework\Handles;

use Framework\Exceptions\HttpException;
use Framework\App;

/**
 * Class RouteHandel
 *
 * 框架路由处理类
 *
 * @package Framework\Handles
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class RouteHandle implements Handle {

  /**
   * 框架实例
   *
   * @var object
   */
  private $_app;

  /**
   * 构造函数
   */
  public function __construct()
  {
    # code...
  }

  /**
   * 魔法函数__get.
   *
   * @param string $name 属性名称
   *
   * @return mixed
   */
  public function __get($name = '')
  {
    $name = '_'.$name;
    return $this->$name;
  }

  /**
   * 魔法函数__set.
   *
   * @param string $name  属性名称
   * @param mixed  $value 属性值
   *
   * @return mixed
   */
  public function __set($name = '', $value = '')
  {
    $name = '_'.$name;
    $this->$name = $value;
  }


  /**
   * 注册路由处理机制
   *
   * @param  App    $app 框架实例
   * @return void
   */
  public function register(App $app)
  {
    $this->_app = $app;
    $this->route();
  }

  /**
   * 路由映射
   * @throws \Exception
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 5:03
   *
   */
  public function route()
  {

    preg_match_all('/^\/(.*)\?/', $_SERVER['REQUEST_URI'], $uri);
    $uri = $uri[1][0];
    if (empty($uri)) {
      throw new HttpException(404);
    }
    $uri = explode('/', $uri);

    switch (count($uri)) {
      case 3:
        /**
         * 默认模块/控制器/操作逻辑
         */
        $moduleName     = $uri['0'];
        $controllerName = $uri['1'];
        $actionName     = $uri['2'];
        break;

      case 2:
        /**
         * 默认模块
         */

        break;
      case 1:
        /**
         * 默认模块/控制器
         */

        break;

      default:
        /**
         * 默认模块/控制器/操作逻辑
         */
        break;
    }


    $controllerPath = 'App\\' . $moduleName . '\\Controllers\\' . $controllerName;

    $reflaction = new \ReflectionClass($controllerPath);

    if(!$reflaction->hasMethod($actionName)) {
      throw new HttpException(404, 'Action:' . $actionName .' In '. $controllerName . 'Controller');
    }
    $controller = new $controllerPath();
    $controller->$actionName();
  }
}
