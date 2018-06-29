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

class NosqlHandle implements Handle {

  public function register (App $app) {
    $config = $app::$container->getSingle('config');
    $config = $config->config['nosql'];
    foreach ($config as $k => $v) {
      $className = 'Framework\Nosql\\' . ucfirst($k);
      new $className();
    }
  }
}
