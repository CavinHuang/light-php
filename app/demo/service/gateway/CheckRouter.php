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

namespace App\Demo\Service\Gateway;

use Framework\Request;

/**
 * 网关路由
 */
class CheckRouter extends Check
{
    /**
     * 网关路由规则
     *
     * @param Request $request 请求对象
     */
    public function doCheck(Request $request)
    {
        # do nothing ...
      echo 1;
    }
}
