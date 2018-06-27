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

use App\Demo\Controllers\Index;
use Test\TestCase;

/**
 * 单元测试 示例
 *
 */
class DemoTest extends TestCase
{
    /**
     *　演示测试
     */
    public function testDemo()
    {
        $index = new Index();

        $this->assertEquals(
            'Hello Easy PHP',
            $index->index()
        );
    }
}
