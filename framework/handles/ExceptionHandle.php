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
use Framework\App;

/**
 * Class ExceptionHandel
 *
 * 异常处理类
 *
 * @package Framework\Handles
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class ExceptionHandle implements Handle {

  /**
   * 构造函数
   */
  public function __construct()
  {
    # code...
  }

  public function register(App $app)
  {
    set_exception_handler([$this, 'exceptionHandler']);
  }

  public function exceptionHandler($exception)
  {
    throw $exception;
  }
}
