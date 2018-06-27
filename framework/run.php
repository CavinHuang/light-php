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

define('ROOT_PATH', __DIR__ . '/..');

require(ROOT_PATH . '/framework/Loader.php');

try {
  Loader::register();

  $app = new App();

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

  $app->load(function(){
    return new RouteHandle();
  });

  $app->run(function(){
    return new Request();
  });

  $app->response(function (){
    return new Response();
  });

} catch (HttpException $e) {
  $e->response($e);
}
