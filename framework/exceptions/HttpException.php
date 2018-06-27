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

namespace Framework\Exceptions;

/**
 * Class HttpException
 *
 *  http 异常响应
 *
 * @package Framework\Exceptions
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class HttpException extends \Exception {

  /**
   * 响应异常code
   *
   * @var array
   */
  private $_httpCode = [
    // 参数错误或者必传参数为空
    400 => 'Bad Request',

    // 此次请求没有权限
    403 => 'Forbidden',

    // 请求的资源不存在
    404 => 'Not Found',

    // 服务器发生错误
    500 => 'Internet Server Error',

    // 远程服务发生错误
    503 => 'Service Unavailable'
  ];

  public function __construct ($code = 200, $message = '') {

    if (!$code) throw new \Exception($this->_httpCode[400], 400);

    $this->code = $code;

    if (!isset($this->_httpCode[$code])) throw new \Exception($this->_httpCode[404], 404);

    if (empty($message)) {
      $this->message = $this->_httpCode[$code];
      return;
    }
    $this->message = $message . ' ' . $this->_httpCode[$code];
  }

  /**
   * 请求返回
   *
   * @param $exception
   * @author cavinHUang
   * @date   2018/6/26 0026 下午 5:42
   *
   */
  public static function response ($exception) {
//    header('Content-Type:Application/json; Charset=utf-8');
    if ($exception instanceof HttpException) {
      die(json_encode([
        'coreError' => [
          'code'    => $exception->getCode(),
          'message' => $exception->getMessage(),
          'infomations'  => [
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $exception->getTrace(),
          ]
        ]
      ]));
    }

    die(json_encode([
      'coreError' => [
        'code'    => 500,
        'message' => $exception,
        'infomations'  => [
          'file'  => $exception['file'],
          'line'  => $exception['line'],
        ]
      ]
    ]));
  }
}
