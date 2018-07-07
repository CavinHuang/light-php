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

namespace Framework\Orm\Db;


use Framework\App;
use Framework\Exceptions\HttpException;
use Framework\Orm\DB;
use PDO;
class Mysql {

  /**
   * 数据库地址
   *
   * @var string
   */
  private $_dbhost = '127.0.0.1';

  /**
   * 数据库名
   *
   * @var string
   */
  private $_dbname = '';

  /**
   * 数据库用户
   *
   * @var string
   */
  private $_dbusername = '';

  /**
   * 数据库用户密码
   *
   * @var string
   */
  private $_dbpassword = '';

  /**
   * pdo实例
   *
   * @var null
   */
  private $_pdo = null;

  /**
   * 预处理sql语句
   *
   * @var string
   */
  private $_pdoPreStatement = '';

  /**
   * pdo dsn
   *
   * @var string
   */
  private $_dsn = '';

  /**
   * Mysql constructor.
   */
  public function __construct () {

    $config = App::$container->getSingle('config')->config;
    $dbConfig = $config['database'];

    $dbConfig       = $config['database'];
    $this->_dbhost   = $dbConfig['host'];
    $this->_dbname   = $dbConfig['name'];
    $this->dsn      = "mysql:dbname={$this->_dbname};host={$this->_dbhost};";
    $this->_dbusername = $dbConfig['username'];
    $this->_dbpassword = $dbConfig['password'];

    $this->connent();
  }

  /**
   * pdo链接mysql
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function connent () {
    $this->_pdo = new PDO($this->dsn, $this->_dbusername, $this->_dbpassword);
  }

  /**
   * 获取一行值
   * @param \Framework\Orm\DB $DB
   * @return mixed
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 9:39
   *
   */
  public function fetch (DB $DB) {
    $this->_pdoPreStatement = $this->_pdo->prepare($DB->sql);
    $this->bindValue($DB);
    $this->_pdoPreStatement->execute();
    return $this->_pdoPreStatement->fetch(\PDO::FETCH_ASSOC);
  }

  /**
   * 获取多行的值
   * @param \Framework\Orm\DB $DB
   * @return mixed
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 10:51
   *
   */
  public function fetchAll (DB $DB) {
    $this->_pdoPreStatement = $this->_pdo->prepare($DB->sql);
    $this->bindValue($DB);
    $this->_pdoPreStatement->execute();
    return $this->_pdoPreStatement->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function insert(DB $DB) {
    $this->_pdoPreStatement = $this->_pdo->prepare($DB->sql);
    $this->bindValue($DB);
    $this->_pdoPreStatement->execute();
    return $DB->lastId = $this->_pdo->lastInsertId();
  }

  /**
   * bind value
   *
   * @param  DB     $db DB instance
   * @return void
   */
  public function bindValue(DB $db)
  {
    if (empty($db->params)) {
      return;
    }
    foreach ($db->params as $k => $v) {
      $this->_pdoPreStatement->bindValue(":{$k}", $v);
    }
    $db->clearParmas();
  }

  /**
   * 魔术方法获取变量
   *
   * @param $name
   * @author cavinHUang
   * @date   2018/7/6 0006 下午 5:47
   *
   */
  public function __get ($name) {
    return $this->$name;
  }

  /**
   * 魔术方法设置变量
   *
   * @param $name
   * @param $value
   * @author cavinHUang
   * @date   2018/7/6 0006 下午 5:47
   *
   */
  public function __set ($name, $value) {
    $this->$name = $value;
  }
}
