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

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouteHandle;
use Framework\Exceptions\HttpException;
use Framework\Request;
use Framework\Response;
use Framework\App;
use Framework\Handles\ConfigHandle;
use Framework\Handles\NosqlHandle;

define('ROOT_PATH', __DIR__ . '/..');

require(ROOT_PATH . '/framework/App.php');

try {
  /* 初始化应用 */
  $app = new App(__DIR__ . '/..', function () {
    return require(__DIR__ . '/Loader.php');
  });

  $app->load(function(){
    return new ErrorHandle();
  });

  /*$app->load(function(){
    return new ExceptionHandle();
  });*/

  // 加载预定义配置机制
  $app->load(function() {
    return new ConfigHandle();
  });

  $app->load(function() {
    return new NosqlHandle();
  });

  $app->load(function(){
    return new RouteHandle();
  });

  $app->run(function() use ($app) {
    return new Request($app);
  });

  $app->response(function () {
    return new Response();
  });

} catch (HttpException $e) {
  $e->response($e);
}
