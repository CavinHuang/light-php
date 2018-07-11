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

/**
 * Class ServiceHandel
 *
 * 用户自定义服务加载
 *
 * @package Framework\Handles
 * @VERSION
 * @AUTHOR  cavinHuang
 */
class ServiceHandel implements Handle {

  public function register (App $app) {
    $serviceFile = dirname(dirname($app->rootPath)) .'/app/Service.php';
     if (file_exists($serviceFile)) {
       new \App\Service($app);
     }
  }

}
