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

namespace Framework;

/**
 * Class Response
 *
 * 响应实体
 *
 * @package Framework
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class Response {

  /**
   * 构造函数
   *
   * Response constructor.
   */
  public function __construct () { }

  /**
   * 响应
   *
   * @param $response   response data
   * @author cavinHUang
   * @date   2018/6/27 0027 上午 11:15
   *
   */
  public function response ($response) {
    header('Content-Type:Application/json; Charset=utf-8');

    die(json_encode($response, JSON_UNESCAPED_UNICODE));
  }

  /**
   * REST风格 成功响应
   *
   * @param  mixed $response 响应内容
   * @return json
   */
  public function restSuccess($response)
  {
    $this->response([
      'code'    => 200,
      'message' => 'OK',
      'result'  => $response
    ]);
  }

  /**
   * REST风格 失败响应
   *
   * @param  mixed $response 响应内容
   * @return json
   */
  public function restFail($code = 500, $message = 'Internet Server Error', $response)
  {
    $this->response([
      'code'    => $code,
      'message' => $message,
      'result'  => $response
    ]);
  }

  /**
   * 魔术方法获取属性
   *
   * @param $name   属性名称
   * @return mixed
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function __get($name)
  {
    return $this->$name;
  }

  /**
   * 魔术方法设置属性
   *
   * @param $name       属性名称
   * @param $value      属性值
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function __set($name, $value){
    $this->$name = $value;
  }

}
