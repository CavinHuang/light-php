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
 * 检验接口服务访问权限
 */
class CheckAuthority extends Check
{
    /**
     * 校验方法
     *
     * @param Request $request 请求对象
     */
    public function doCheck(Request $request)
    {
        # do nothing...
      echo 1;
    }
}
