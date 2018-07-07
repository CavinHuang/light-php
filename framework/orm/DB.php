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
    $this->_dbtype = $config->config['database']['type'];
    $this->decide();

    // 清空条件，不影响本次查询
    $this->clearParmas();
  }

  public function clearParmas () {
    $this->sql = '';
    $this->where = '';
    $this->offset = '';
    $this->orderBy = '';
    $this->field = '';
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
   * 获取一条数据
   * @return mixed
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function fetch() {
    $this->select();
    $this->buildSql();
    $functionName = __FUNCTION__;
    return $this->_dbInstance->$functionName($this);
  }

  /**
   * 获取一条的别名
   * @return mixed
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 10:49
   *
   */
  public function find(){
    return $this->fetch();
  }

  /**
   * 获取多条数据
   * @return mixed
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 10:50
   *
   */
  public function fetchAll(){
    $this->select();
    $this->buildSql();
    $functionName = __FUNCTION__;
    return $this->_dbInstance->$functionName($this);
  }

  /**
   * 构建sql语句
   *
   * @return void
   */
  public function buildSql()
  {
    if (! empty($this->where)) {
      $this->sql .= $this->where;
    }
    if (! empty($this->orderBy)) {
      $this->sql .= $this->orderBy;
    }
    if (! empty($this->limit)) {
      $this->sql .= $this->limit;
    }
  }
}
