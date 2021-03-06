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
  private $dsn = '';

  // 查询结果类型
  protected $fetchType = PDO::FETCH_ASSOC;
  // 字段属性大小写
  protected $attrCase = PDO::CASE_LOWER;

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
    $this->execute($DB);
    return $this->_pdoPreStatement->fetch($this->fetchType);
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
    $this->execute($DB);
    return $this->_pdoPreStatement->fetchAll($this->fetchType);
  }

  /**
   * pdo执行方法
   *
   * @param \Framework\Orm\DB $DB
   * @author cavinHUang
   * @date   2018/7/7 0007 下午 2:25
   *
   */
  public function execute (DB $DB) {
    $this->_pdoPreStatement->execute();
    $DB->lastSql = $DB->showQuery($this->_pdoPreStatement->queryString, $DB->params);
    $DB->clearParmas();
  }

  /**
   * 取得数据表的字段信息
   * @access public
   * @param string $tableName
   * @return array
   */
  public function getFields(DB $DB)
  {
    list($tableName) = explode(' ', $DB->tableName);
    if (false === strpos($tableName, '`')) {
      if (strpos($tableName, '.')) {
        $tableName = str_replace('.', '`.`', $tableName);
      }
      $tableName = '`' . $tableName . '`';
    }
    $sql    = 'SHOW COLUMNS FROM ' . $tableName;
    $this->_pdoPreStatement = $this->_pdo->prepare($sql);
    $this->execute($DB);
    $result = $this->_pdoPreStatement->fetchAll($this->fetchType);
    $info   = [];
    if ($result) {
      foreach ($result as $key => $val) {
        $val                 = array_change_key_case($val);
        $info[$val['field']] = [
          'name'    => $val['field'],
          'type'    => $val['type'],
          'notnull' => (bool) ('' === $val['null']), // not null is empty, null is yes
          'default' => $val['default'],
          'primary' => (strtolower($val['key']) == 'pri'),
          'autoinc' => (strtolower($val['extra']) == 'auto_increment'),
        ];
      }
    }
    return $this->fieldCase($info);
  }

  /**
   * 对返数据表字段信息进行大小写转换出来
   * @access public
   * @param array $info 字段信息
   * @return array
   */
  public function fieldCase($info)
  {
    // 字段大小写转换
    switch ($this->attrCase) {
      case PDO::CASE_LOWER:
        $info = array_change_key_case($info);
        break;
      case PDO::CASE_UPPER:
        $info = array_change_key_case($info, CASE_UPPER);
        break;
      case PDO::CASE_NATURAL:
      default:
        // 不做转换
    }
    return $info;
  }

  /**
   * insert data
   *
   * @param \Framework\Orm\DB $DB
   * @return mixed
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function insert(DB $DB) {
    $this->_pdoPreStatement = $this->_pdo->prepare($DB->sql);
    $this->bindValue($DB);
    $this->execute($DB);
    return $DB->lastId = $this->_pdo->lastInsertId();
  }

  /**
   * update data
   *
   * @param  DB     $db DB instance
   * @return boolean
   */
  public function update(DB $DB)
  {
    $this->_pdoPreStatement = $this->_pdo->prepare($DB->sql);
    $this->bindValue($DB);
    return $this->execute($DB);
  }

  /**
   * 删除
   *
   * @author cavinHUang
   * @date   2018/7/9 0009 下午 4:06
   *
   */
  public function delete (DB $DB) {
    $this->_pdoPreStatement = $this->_pdo->prepare($DB->sql);
    $this->bindValue($DB);
    return $this->execute($DB);
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
      $db->clearParmas();
      return;
    }
    foreach ($db->params as $k => $v) {
      $this->_pdoPreStatement->bindValue(":{$k}", $v);
    }
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
