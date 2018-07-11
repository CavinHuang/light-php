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

namespace Framework\Handles;


use Framework\App;
use Framework\Exceptions\HttpException;

class ConfigHandle implements Handle {
  /**
   * 框架实例
   *
   * @var object
   */
  private $app;

  /**
   * 构造函数
   */
  public function __construct()
  {
    # code...
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
   * 注册路由处理机制
   *
   * @param  App    $app 框架实例
   * @return void
   */
  public function register(App $app)
  {
    $this->app = $app;
    $app::$container->setSingle('config', $this);
    $this->loadConfig($app);
    $this->loadEnv($app);
  }

  /**
   * 加载.env文件
   * @param \Framework\App $app
   * @throws \Framework\Exceptions\HttpException
   * @author cavinHUang
   * @date   2018/7/11 0011 下午 3:44
   * @throws \Exception
   */
  public function loadEnv (App $app) {
    $env_file = $app->rootPath .'/.env';
    if (!file_exists($env_file)) {
      throw new HttpException(404, '.env file is not exist.');
    }
    $envParmas = parse_ini_file($env_file, true);

    if ($envParmas === false) {
      throw new HttpException(400, '.env parse fail');
    }

    $request = $app::$container->getSingle('request');
    $request->envParams = $envParmas;
  }

  /**
   * 加载配置文件
   *
   * @return void
   */
  public function loadConfig(App $app)
  {
    // 加载默认配置
    $config   = require($app->rootPath . '/framework/config/common.php');
    // 加载默认数据库配置
    $database = require($app->rootPath . '/framework/config/database.php');

    $this->config = array_merge($config, $database);
  }
}
