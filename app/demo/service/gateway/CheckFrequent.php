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

use Framework\App;
use Framework\Exceptions\HttpException;
use Framework\Request;

/**
 * 检验接口访问频率
 */
class CheckFrequent extends Check
{
    /**
     * 限定时间段
     *
     * 单位：seconds
     *
     * @var integer
     */
    private $timeScope = 60;

    /**
     * 限定次数
     *
     * @var integer
     */
    private $times = 60;

  /**
   * 校验方法
   * @param Request $request 请求对象
   * @throws \Framework\Exceptions\HttpException
   * @throws \Exception
   */
  public function doCheck(Request $request)
    {
        try {
          $key = 'Gateway-client-ip:' . $request->clientIp;
          $redis = App::$container->getSingle('redis');
          $value = $redis->get($key);
          if (! $value) {
            $redis->setex($key, $this->timeScope, 0);
          }
          if ($value >= $this->times) {
            throw new HttpException(1,"too many request per {$this->timeScope} seconds");
          }
          $redis->incr($key);
        } catch (HttpException $e) {
          var_dump($e);
        }
    }
}
