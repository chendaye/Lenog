<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/5
 * Time: 14:22
 */

namespace Lenog\Support;
use DateInterval;
use DateTimeInterface;

trait InteractsWithTime
{
    /**
     * 给定日期的秒数
     *
     * @param $delay
     * @return int|mixed
     */
    protected function secondsUntil($delay)
    {
        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTimeInterface ?
            max(0, $this->getTimestamp() - $this->currentTime())
            : (int)$delay;

    }

    /**
     * 获取可用的 Unix 时间戳
     *
     * @param int $delay
     * @return int
     */
    protected function availableAt($delay = 0)
    {
        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTimeInterface
            ? $delay->getTimestamp()
            : Carbon::now()->addSeconds($delay)->getTimestamp();
    }

    /**
     * 如果给定的只 是 Interval 转化为 DateTime 实例
     *
     * @param $delay
     * @return mixed
     */
    protected function parseDateInterval($delay)
    {
        if($delay instanceof  DateInterval){
            $delay = Carbon::now()->add($delay);
        }

        return $delay;
    }

    /**
     * 当前unix时间戳
     *
     * @return int
     */
    protected function currentTime()
    {
        return Carbon::now()->getTimestamp();
    }
}