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
    $controller = new $controllerPath();
    $controller->$actionName();
  }
}
