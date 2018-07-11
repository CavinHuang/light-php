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
 * 检验网关公共必传参数
 *
 * check Gateway's common arguments
 */
class CheckArguments extends Check
{
    /**
     * 网关参数
     *
     * common arguments
     *
     * @var
     */
    private $commonArgus = [
        // 签名 signature
        'sign',
        // 授权app key
        'app_key',
        // 毫秒级别时间戳
        'timestamp',
        // 12位随机字符串 round string len 12
        'nonce',
        // 设备id device id
        'device_id'
    ];

  /**
   * 校验公共参数
   * check Gateway's common arguments
   * @param Request $request 请求对象
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function doCheck(Request $request)
    {
        // 获取所有参数
        // get all params
        $params = $request->all();

        foreach ($this->commonArgus as $v) {
            if (! isset($params[$v]) || empty($params[$v])) {
                throw new HttpException(400,"Gateway's common argument [{$v}] is empty");
            }
        }
    }
}
