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
use PDO;
/**
 * Class interpretater
 *
 * SQL解析器
 *
 * @package Framework\Orm
 * @VERSION
 * @AUTHOR  cavinHuang
 */
trait interpretater
{
  /**
   * 表名称
   *
   * table name
   *
   * @var string
   */
  private $tableName = '';

  /**
   * 查询条件
   *
   * query where condition
   *
   * @var string
   */
  private $where     = '';

  /**
   * 查询参数
   *
   * query params
   *
   * @var string
   */
  public  $params    = [];

  /**
   * 排序条件
   *
   * sort condition
   *
   * @var string
   */
  private $orderBy   = '';

  /**
   * 查询限制
   *
   * query quantity limit
   *
   * @var string
   */
  private $limit     = '';

  /**
   * 查询偏移量
   *
   * query offset
   *
   * @var string
   */
  private $offset    = '';

  /**
   * 查询字段限制
   *
   * @var string
   */
  private $field = '*';

  /**
   * 表名称
   *
   * table name
   *
   * @var string
   */
  public $sql       = '';

  /**
   * 数据表信息
   *
   * @var array
   */
  protected static $info = [];

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

  /**
   *  查找一条数据
   *
   * @return mixed
   */
  public function select($data=[])
  {
    $this->sql = "SELECT {$this->field} FROM `{$this->tableName}`";
  }

  /**
   * 字段限制
   *
   * @param string|array $field  字段限制
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function field ($field = '*') {
    if (is_array($field)) {
      $this->field = $this->buildField($field);
    } else {
      $this->field = $this->buildField(explode(',', $field));
    }
    return $this;
  }

  /**
   * 组装字段
   *
   * @param array $fields 字段
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 11:08
   *
   */
  private function buildField ($fields = []) {
    $fieldStr = '';

    foreach ($fields as $v) {
      $fieldStr .= "`{$v}`,";
    }
    unset($v);
    return substr($fieldStr, 0, strlen($fieldStr) - 1);
  }

  /**
   * 插入数据
   * @param array $data
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 11:22
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function insert (Array $data = []) {
    if (empty($data)) throw new HttpException(401, 'db insert data is empty.');

    $this->parseInsertData($data);

    return $this->_dbInstance->insert($this);
  }

  /**
   * 解析插入的数据
   *
   * @param array $data
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 11:25
   *
   */
  public function parseInsertData(Array $data = []) {
    $field = '';
    $value = '';

    foreach ($data as $k => $v) {
      $field .= "`{$k}`, ";
      $value .= ":{$k}, ";
      $this->params[$k] = $v;
    }
    unset($v);
    unset($k);
    $field = substr($field, 0, strlen($field) - 2);
    $value = substr($value, 0, strlen($value) - 2);
    $this->sql = "INSERT INTO {$this->tableName} ({$field}) VALUES ({$value});";
  }

  /**
   * 更新数据库
   * @param array $data
   * @author cavinHUang
   * @date   xxx
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function update (Array $data = []) {
    if (empty($this->where)) throw new HttpException(401, 'update where is empty.');
    if (empty($data)) throw new HttpException(401, 'update data is empty.');

    $this->parseUpdateData($data);
    $this->buildSql();
    return $this->_dbInstance->update($this);
  }

  /**
   * 解析更新的数据
   *
   * @param array $data
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 11:25
   *
   */
  public function parseUpdateData(Array $data = []) {
    $str = '';

    foreach ($data as $k => $v) {
      $str .= "{$k}=:$k, ";
      $this->params[$k] = $v;
    }
    unset($v);
    unset($k);
    $str = substr($str, 0, strlen($str) - 2);
    $this->sql = "UPDATE {$this->tableName} SET {$str}";
  }

  /**
   * 删除数据
   * @param string $ids
   * @author cavinHUang
   * @date   xxx
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function delete ($ids = '') {
    if (empty($this->where) && empty($ids)) {
      throw new HttpException('401', 'delete argument is null');
    } else if (empty($this->where) && !empty($ids)){
      $this->where($this->info['pk'], $ids);
    }
    $this->sql = "DELETE FROM {$this->tableName}";
    $this->buildSql();
    return $this->_dbInstance->delete($this);
  }

  /**
   * 获取数据表信息
   * @access public
   * @param mixed  $tableName 数据表名 留空自动获取
   * @param string $fetch     获取信息类型 包括 fields type bind pk
   * @return mixed
   */
  public function getTableInfo($tableName = '', $fetch = '')
  {
    if (!$tableName) {
      $tableName = $this->tableName;
    }
    if (is_array($tableName)) {
      $tableName = key($tableName) ?: current($tableName);
    }

    /*if (strpos($tableName, ',')) {
      // 多表不获取字段信息
      return false;
    } else {
      $tableName = $this->parseSqlTable($tableName);
    }*/

    // 修正子查询作为表名的问题
    if (strpos($tableName, ')')) {
      return [];
    }

    list($guid) = explode(' ', $tableName);
    $db         = $this->config['name'];
    if (!isset(self::$info[$db . '.' . $guid])) {
      if (!strpos($guid, '.')) {
        $schema = $db . '.' . $guid;
      } else {
        $schema = $guid;
      }
      $info = $this->_dbInstance->getFields($this);
      $fields = array_keys($info);
      $bind   = $type   = [];
      foreach ($info as $key => $val) {
        // 记录字段类型
        $type[$key] = $val['type'];
        $bind[$key] = $this->getFieldBindType($val['type']);
        if (!empty($val['primary'])) {
          $pk[] = $key;
        }
      }
      if (isset($pk)) {
        // 设置主键
        $pk = count($pk) > 1 ? $pk : $pk[0];
      } else {
        $pk = null;
      }
      self::$info[$db . '.' . $guid] = ['fields' => $fields, 'type' => $type, 'bind' => $bind, 'pk' => $pk];
    }
    return $fetch ? self::$info[$db . '.' . $guid][$fetch] : self::$info[$db . '.' . $guid];
  }

  /**
   * 获取字段绑定类型
   * @access public
   * @param string $type 字段类型
   * @return integer
   */
  protected function getFieldBindType($type)
  {
    if (0 === strpos($type, 'set') || 0 === strpos($type, 'enum')) {
      $bind = PDO::PARAM_STR;
    } elseif (preg_match('/(int|double|float|decimal|real|numeric|serial|bit)/is', $type)) {
      $bind = PDO::PARAM_INT;
    } elseif (preg_match('/bool/is', $type)) {
      $bind = PDO::PARAM_BOOL;
    } else {
      $bind = PDO::PARAM_STR;
    }
    return $bind;
  }

  /**
   * where 条件
   *
   * @param string|array $data 第一个参数，可以是一个数组，一个字段名
   * @param string $value 第二个参数，可以是一个查询值或者一个查询条件比如 >, =, <等
   * @param string $pre 查询值
   * @return $this|void
   * @author cavinHUang
   * @date   xxx
   *
   */
  public function where($field = '', $value = '', $pre = '')
  {
    if (empty($field)) {
      return;
    }

    $data = [];

    if (is_string($field)) {
      if (!empty($value)){
        if (!empty($pre)) {
          $data[$field] = [$value, $pre];
        } else {
          $data[$field] = $value;
        }
      }
    } else {
      $data = $field;
    }

    $count = count($data);

    /* 单条件 */
    if ($count === 1) {
      $field = array_keys($data)[0];
      $value = array_values($data)[0];
      if (! is_array($value)){
        $this->where  = " WHERE `{$field}` = :{$field}";
        $this->params = $data;
        return $this;
      }
      $this->where = " WHERE `{$field}` {$value[0]} :{$field}";
      $this->params[$field] = $value[1];
      return $this;
    }
    /* 多条件 */
    $tmp  = $data;
    $last = array_pop($tmp);
    foreach ($data as $k => $v) {
      if ($v === $last) {
        if (! is_array($v)){
          $this->where .= "`{$k}` = :{$k}";
          $this->params[$k] = $v;
          continue;
        }
        $this->where .= "`{$k}` {$v[0]} :{$k}";
        $this->params[$k] = $v[1];
        continue;
      }
      if (! is_array($v)){
        $this->where  .= " WHERE `{$k}` = :{$k} AND ";
        $this->params[$k] = $v;
        continue;
      }
      $this->where .= " WHERE `{$k}` {$v[0]} :{$k} AND ";
      $this->params[$k] = $v[1];
      continue;
    }
    return $this;
  }

  /**
   * order byd
   *
   * @param string $order
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 11:00
   *
   */
  public function order ($order = '') {
    if (empty($order)) return;

    $this->orderBy = ' ORDER BY '. $order;
    return $this;
  }

  /**
   * limit
   *
   * @author cavinHUang
   * @date   2018/7/7 0007 上午 11:03
   *
   */
  public function limit ($limit) {
    if (empty($limit)) return;

    $this->limit = ' LIMIT '. $limit;
    return $this;
  }
}
