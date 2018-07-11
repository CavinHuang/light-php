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
 * Class Request
 *
 * 请求
 *
 * @package Framework
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class Request {

  /**
   * 请求的环境参数
   *
   * @var array
   */
  public $serverParams = [];

  /**
   * GET参数集合
   *
   * @var array
   */
  public $getParams = [];

  /**
   * POST参数集合
   *
   * @var array
   */
  public $postParams = [];

  /**
   * request 参数集合
   *
   * @var array
   */
  public $requestParams = [];

  /**
   * 请求参数
   *
   * @var array
   */
  private $envParams = [];

  /**
   * http方法名称
   * @var string
   */
  public $method = '';

  /**
   * 服务ip
   * @var string
   */
  public $serverIp = '';

  /**
   * 客户端ip
   * @var string
   */
  public $clientIp = '';

  /**
   * 请求开始时间
   * @var float
   */
  public $beginTime = 0;

  /**
   * 请求结束时间
   * @var float
   */
  public $endTime = 0;

  /**
   * 请求消耗时间
   *
   * 毫秒
   *
   * @var int
   */
  public $consumeTime = 0;

  /**
   * 构造函数
   *
   * Request constructor.
   */
  public function __construct (App $app) {

    $this->serverParams = $_SERVER;
    $this->method       = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
    $this->serverIp     = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : '';
    $this->clientIp     = isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR'] : '';
    $this->beginTime    = isset($_SERVER['REQUEST_TIME_FLOAT'])? $_SERVER['REQUEST_TIME_FLOAT'] : time();
    if ($app->isCli === 'yes') {
      // cli 模式
      $this->requestParams = $_REQUEST['argv'];
      $this->getParams     = $_REQUEST['argv'];
      $this->postParams    = $_REQUEST['argv'];
    } else {
      $this->requestParams = $_REQUEST;
      $this->getParams     = $_GET;
      $this->postParams    = $_POST;
    }

  }

  /**
   * 魔法函数__get.
   *
   * @param string $name 属性名称
   *
   * @return mixed
   */
  public function __get($name = '')
  {
    return $this->$name;
  }

  /**
   * 魔法函数__set.
   *
   * @param string $name  属性名称
   * @param mixed  $value 属性值
   *
   * @return mixed
   */
  public function __set($name = '', $value = '')
  {
    $this->$name = $value;
  }

  /**
   * 获取GET参数
   *
   * @param  string $value 参数名
   * @return mixed
   */
  public function get($value = '')
  {
    if (!empty($value)) {
      if (isset($this->getParams[$value])) return $this->getParams[$value];
      return '';
    }
    return $this->getParams;
  }

  /**
   * 获取POST参数
   *
   * @param  string $value 参数名
   * @return mixed
   */
  public function post($value = '')
  {
    if (!empty($value)) {
      if (isset($this->postParams[$value])) return $this->postParams[$value];
      return '';
    }
    return $this->postParams;
  }

  /**
   * 获取POST参数
   *
   * @param  string $value 参数名
   * @return mixed
   */
  public function request($value = '')
  {
    if (!empty($value)) {
      if (isset($this->requestParams[$value])) return $this->requestParams[$value];
      return '';
    }
    return $this->requestParams;
  }

  /**
   * 获取SERVER参数
   *
   * @param  string $value 参数名
   * @return mixed
   */
  public function server($value = '')
  {
    if (isset($this->serverParams[$value])) {
      return $this->serverParams[$value];
    }
    return '';
  }

  /**
   * 获取所有参数
   *
   * @return array
   */
  public function all()
  {
    return $this->requestParams;
  }

  /**
   * 获取env参数
   *
   * @param  string $value 参数名
   * @return mixed
   */
  public function env($value = '')
  {
    if (isset($this->envParams[$value])) {
      return $this->envParams[$value];
    }
    return '';
  }
}
