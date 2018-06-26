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
      throw new \Exception('NOT FOUND', 404);
    }
    $uri = explode('/', $uri);
    if (count($uri) !== 3) {
      throw new \Exception('BAD REQUEST', 400);
    }
    $moduleName = $uri['0'];
    $controllerName = $uri['1'];
    $actionName = $uri['2'];

    $controllerPath = 'App\\' . $moduleName . '\\Controllers\\' . $controllerName;

    $reflaction = new \ReflectionClass($controllerPath);

    if(!$reflaction->hasMethod($actionName)) {
      throw new \Exception('ACTION NOT FOUND', 404);
    }
    $controller = new $controllerPath();
    $controller->$actionName();
  }
}
