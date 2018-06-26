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

define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/..');

require(ROOT_PATH . '/framework/Loader.php');
require(ROOT_PATH . '/framework/App.php');


try {
  Loader::register();

  $app = new App();

  $app->load(function(){
    return new ErrorHandle();
  });

  $app->load(function(){
    return new ExceptionHandle();
  });

  $app->load(function(){
    return new RouteHandle();
  });
} catch (HttpException $e) {
  HttpException::response($e);
}
