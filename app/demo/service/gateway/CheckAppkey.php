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

use Framework\Exceptions\HttpException;
use Framework\Request;

/**
 * 检验app授权key
 */
class CheckAppkey extends Check
{
  /**
   * 校验app key
   * @param Request $request 请求对象
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function doCheck(Request $request)
    {
        // 获取app key配置
        $appKeyMap = $request->env('app_key_map');
        // app key
        $appKey    = $request->request('app_key');

        if (isset($appKeyMap['map'][$appKey])) {
            return;
        }
        throw new HttpException(404, 'app_key is not found');
    }
}
