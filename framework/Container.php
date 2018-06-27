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
use Framework\Exceptions\HttpException;

/**
 * Class Container
 *
 * 服务容器
 *
 * @package Framework
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class Container {

  /**
   * 类映射集合
   *
   * @var array
   */
  private $_classMap = [];

  /**
   * class 实例集合
   *
   * @var array
   */
  private $_instanceMap = [];

  public function __construct () { }

  /**
   * 注入class
   *
   * @param string $alias
   * @param string $class
   * @author cavinHUang
   * @date   2018/6/27 0027 下午 2:23
   *
   */
  public function set ($alias = '', $class = '')
  {
    $this->_classMap[$alias] = $class;
  }

  /**
   * 获取一个class
   * @author cavinHUang
   * @date   2018/6/27 0027 下午 2:27
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function get ($alias = '')
  {
    if (!array_key_exists($alias, $this->_classMap)) {
      if (is_callable($this->_classMap[$alias])) {
        return $this->_classMap[$alias]();
      }
      return new $this->_classMap[$alias];
    }
    throw new HttpException(404, $alias.":");
  }

  /**
   * 注入一个单例
   * @param string $alias 别名或者类名
   * @param object||closure||string $object 实例或闭包或类名
   * @return callable|null|string
   * @author       cavinHUang
   * @date         2018/6/27 0027 下午 2:42
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function setSingle($alias = '', $obj = null)
  {
    // 判断两个参数是否作为函数调用
    if (is_callable($alias)) {
      $instance = $alias();
      $className = get_class_name($instance);
      $this->_instanceMap[$className] = $instance;
      return true;
    }

    if (!is_null($obj) && is_callable($obj)) {
      if (!empty($alias)) {
        $this->_instanceMap[$alias] = $obj;
        return true;
      }
      throw new HttpException(400, $alias.' is empty.');
    }

    // 判断两个参数是否是对象
    if (!is_null($obj) && is_object($obj)) {
      $className = get_class($alias);
      if (!array_key_exists($className, $this->_instanceMap)) {
        $this->_instanceMap[$className] = $alias;
        return true;
      }
      throw new HttpException(400, $alias.' already exists.');
    }

    if (empty($alias) && empty($object)) {
      throw new HttpException(
        400,
        "{$alias} and {$obj} is empty"
      );
    }
    $this->_instanceMap[$alias] = new $alias();
  }

  /**
   * 获取一个单例类
   * @param  string $alias 类名或别名
   * @return object
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function getSingle($alias = '')
  {
    if (array_key_exists($alias, $this->_instanceMap)) {
      return $this->_instanceMap[$alias];
    }
    throw new HttpException(
      404,
      'Class:' . $alias
    );
  }
}
