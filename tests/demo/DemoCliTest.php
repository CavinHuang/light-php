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

namespace Tests\Demo;


use Framework\App;
use Tests\TestCase;

class DemoCliTest extends TestCase {

  /**
   *　演示测试
   */
  public function testDemo()
  {

    $this->assertEquals(
      'Hello Easy PHP',
      App::$app->get('demo.index.hello')
    );
  }

}
