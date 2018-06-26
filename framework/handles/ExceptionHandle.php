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
 * Class ExceptionHandel
 *
 * 异常处理类
 *
 * @package Framework\Handles
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class ExceptionHandle implements Handle {

  public function register()
  {
    set_exception_handler([$this, 'exceptionHandler']);
  }

  public function exceptionHandler($exception)
  {
    $exceptionInfo = [
      'number'  => $exception->getCode(),
      'message' => $exception->getMessage(),
      'file'    => $exception->getFile(),
      'line'    => $exception->getLine(),
      'trace'   => $exception->getTrace(),
    ];

    throw new \Exception(json_encode($exceptionInfo), 500);
  }
}
