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

  public function register()
  {
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
