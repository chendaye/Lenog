<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 14:25
 */

namespace Lenog\Contracts\Queue;


interface Monitor
{
    /**
     * 注册一个回调函数，在每个迭代中通过队列循环执行
     * @param mixed $callback
     * @return void
     */
    public function looping($callback);

    /**
     * 注册一个回调函数，当作业在重试最大次数之后失败时执行
     * @param mixed $callback
     * @return void
     */
    public function failing($callback);

    /**
     * 注册一个回调函数，当守护进程队列停止的时候执行
     * @param mixed $callback
     * @return void
     */
    public function stopping($callback);
}