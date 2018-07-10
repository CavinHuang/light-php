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


use Framework\App;
use Framework\Exceptions\HttpException;

class DB {

  /**
   * sql解析器
   *
   */
  use interpretater;

  /**
   * 当前执行的数据库类型
   *
   * @var string
   */
  private $_dbtype = '';

  /**
   * 数据库策略映射
   *
   * @var array
   */
  private $_dbStrategyMap = [
    'mysql' => 'Framework\Orm\Db\Mysql', // mysql映射
  ];

  /**
   * 当前数据库实例
   *
   * @var null
   */
  private $_dbInstance = null;

  /**
   * 当前操作的自增id
   *
   * @var string
   */
  public $lastId = '';

  /**
   * 当前初始化的配置
   *
   * @var null
   */
  private $config = null;

  /**
   * 设置当前操作表
   *
   * @param string $tableName
   * @throws \Framework\Exceptions\HttpException
   * @author cavinHUang
   * @date   2018/7/6 0006 下午 5:57
   * @throws \Exception
   */
  public static function table($tableName = '') {
    if (empty($tableName)) {
      throw new HttpException(400, 'table name is empty.');
    }

    $db = new self;
    $DB = APP::$container->setSingle('DB', $db);
    $DB->tableName = $tableName;
    $DB->init();

    return $DB;
  }

  /**
   * 初始化整个操作和配置
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 9:07
   *
   */
  public function init () {
    $config  = APP::$container->getSingle('config');
    $this->config = $config->config['database'];
    $this->_dbtype = $this->config['type'];
    $this->decide();

    // 获取表信息
    $this->info = $this->getTableInfo();

    // 重置条件，不影响本次查询
    $this->clearParmas();
  }

  public function clearParmas () {
    $this->where = '';
    $this->offset = '';
    $this->orderBy = '';
    $this->field = '*';
    $this->limit = '';
    $this->params = [];
  }

  /**
   * 策略决策
   *
   * @return void
   */
  public function decide()
  {
    $dbStrategyName   = $this->_dbStrategyMap[$this->_dbtype];
    $this->_dbInstance = APP::$container->setSingle(
      $this->_dbtype,
      function () use ($dbStrategyName) {
        return new $dbStrategyName();
      }
    );
  }

  /**
   * 魔术方法设置属性
   *
   * @param $name
   * @author cavinHUang
   * @date   2018/7/7 0007 下午 2:16
   *
   */
  public function __get ($name) {
    return $this->$name;
  }

  /**
   * 魔术方法设置属性
   *
   * @param $name
   * @param $value
   * @author cavinHUang
   * @date   2018/7/7 0007 下午 2:16
   *
   */
  public function __set ($name, $value) {
    $this->$name = $value;
  }

  /**
   * 组织最后的sql语句
   *
   * @param $query
   * @param $params
   * @return null|string|string[]
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function showQuery($query, $params)
  {
    $keys = array();
    $values = array();

    # build a regular expression for each parameter
    foreach ($params as $key => $value)
    {
      if (is_string($key))
      {
        $keys[] = '/:'.$key.'/';
      }
      else
      {
        $keys[] = '/[?]/';
      }

      if(is_numeric($value))
      {
        $values[] = intval($value);
      }
      else
      {
        $values[] = '"'.$value .'"';
      }
    }

    $query = preg_replace($keys, $values, $query, 1, $count);
    return $query;
  }
}
