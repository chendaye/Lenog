<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 17:53
 */

namespace Lenog\Contracts\Cookie;


interface QueueingFactory extends Factory
{
    /**
     *  ...标记以表示函数接受可变数目的参数。参数将作为一个数组传递给给定的变量(一个变量也是如此)
     *
     * 把cookie放在队列中发送给下一次请求
     * @param array ...$parameters
     * @return mixed
     */
    public function queue(...$parameters);

    /**
     * 从队列中移除cookie
     * @param string $name
     * @return void
     */
    public function unqueue($name);

    /**
     * 获取已经在队列中 以备下次请求的cookie
     * @return array
     */
    public function getQueuedCookies();


}