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
   * 构造函数
   *
   * Request constructor.
   */
  public function __construct () {
    $this->_serverParams = $_SERVER;
    $this->_getParams = $_GET;
    $this->_postParams = $_POST;
    $this->_requestParams = $_REQUEST;
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
    $name = '_'.$name;
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
    $name = '_'.$name;
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
  public function getServer($value = '')
  {
    if (!empty($value)) {
      if (isset($this->_serverParams[$value])) return $this->_serverParams[$value];
      return '';
    }
    return $this->_serverParams;
  }
}
