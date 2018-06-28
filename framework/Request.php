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
  private $_serverParams = [];

  /**
   * GET参数集合
   *
   * @var array
   */
  private $_getParams = [];

  /**
   * POST参数集合
   *
   * @var array
   */
  private $_postParams = [];

  /**
   * request 参数集合
   *
   * @var array
   */
  private $_requestParams = [];

  /**
   * http方法名称
   * @var string
   */
  private $method = '';

  /**
   * 服务ip
   * @var string
   */
  private $serverIp = '';

  /**
   * 客户端ip
   * @var string
   */
  private $clientIp = '';

  /**
   * 请求开始时间
   * @var float
   */
  private $beginTime = 0;

  /**
   * 请求结束时间
   * @var float
   */
  private $endTime = 0;

  /**
   * 请求消耗时间
   *
   * 毫秒
   *
   * @var int
   */
  private $consumeTime = 0;

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
      if (isset($this->_getParams[$value])) return $this->_getParams[$value];
      return '';
    }
    return $this->_getParams;
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
      if (isset($this->_postParams[$value])) return $this->_postParams[$value];
      return '';
    }
    return $this->_postParams;
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
      if (isset($this->_requestParams[$value])) return $this->_requestParams[$value];
      return '';
    }
    return $this->_requestParams;
  }

  /**
   * 获取SERVER参数
   *
   * @param  string $value 参数名
   * @return mixed
   */
  public function server($value = '')
  {
    if (!empty($value)) {
      if (isset($this->_serverParams[$value])) return $this->_serverParams[$value];
      return '';
    }
    return $this->_serverParams;
  }
}
