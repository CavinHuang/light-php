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
 * Class ErrorHandel
 *
 * 错误处理类
 *
 * @package Framework\Handles
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class ErrorHandle implements Handle {

  public function register ()
  {
    // 注册一个会在php中止时执行的函数
    register_shutdown_function([$this, 'shutdown']);

    // 设置自定义的错误处理函数
    set_error_handler([$this, 'errorHandler']);
  }

  /**
   * 程序终止时运行的函数
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 4:10
   *
   */
  public function shutdown()
  {
    $error = error_get_last();
    if (empty($error)) {
      return;
    }
    $errorInfo = [
      'type'    => $error['type'],
      'message' => $error['message'],
      'file'    => $error['file'],
      'line'    => $error['line'],
    ];

     HttpException::response($errorInfo);
  }

  public function errorHandler($errorNumber, $errorMessage, $errorFile, $errorLine, $errorContext)
  {
    $errorInfo = [
      'type'    => $errorNumber,
      'message' => $errorMessage,
      'file'    => $errorFile,
      'line'    => $errorLine,
      'context' => $errorContext,
    ];
     HttpException::response($errorInfo);
  }
}
