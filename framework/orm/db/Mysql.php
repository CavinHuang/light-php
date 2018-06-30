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

class Mysql {

  public function __construct () {
    $config = App::$container->getSingle('config')->config;
    $dbConfig = $config['database'];

    $connect  = "{$dbConfig['dbtype']}:dbname={$dbConfig['dbname']};host={$dbConfig['host']};";
    $pdo      = new \PDO(
      $connect,
      $dbConfig['username'],
      $dbConfig['password']
    );

  }
}
