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

namespace Framework\Orm;
use Framework\Exceptions\HttpException;


/**
 * Class interpretater
 *
 * SQL解析器
 *
 * @package Framework\Orm
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class interpretater
{
  /**
   * 表名
   * @var string
   */
  private $_tableName = '';

  /**
   * 当前实例
   *
   * @var null
   */
  private static $_instance = null;

  /**
   * 设置表名
   * @param string $table
   * @author cavinHUang
   * @date   2018/6/29 0029 下午 2:48
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public static function table ($table = '')
  {
    if (empty($table)) {
      throw new HttpException( '400', 'table name is not exits.' );
    }

    if (is_null(self::$_instance) || !self::$_instance instanceof self) {
      self::$_instance = new self();
    }

    // 更新实例表名
    self::$_instance->_setTableName($table);
    // 返回实例
    return self::$_instance;
  }

  /**
   * 设置表明
   *
   * @param string $table   表名
   * @author cavinHUang
   * @date   2018/6/29 0029 下午 2:52
   */
  public function _setTableName ($table = '') {
    $this->_tableName = $table;
  }
}
