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

define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/..');

require(ROOT_PATH . '/framework/Loader.php');
require(ROOT_PATH . '/framework/App.php');


try {
  new Loader();

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
} catch (\Exception $e) {
  var_dump($e);
}
