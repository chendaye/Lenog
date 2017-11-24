<?php

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 18:44
 */

namespace Lenog\Contracts\Bus;

interface Dispatcher
{
    /**
     * 分发事件给合适的处理程序
     * @param $command
     * @return mixed
     */
    public function dispatch($command);

    /**
     * 在当前进程中分发事件给合适的处理程序
     * @param $command
     * @param null $hander
     * @return mixed
     */
    public function dispatchNow($command, $hander = null);

    /**
     * 在调度之前设置管道命令
     * @param array $pipes
     * @return mixed
     */
    public function pipeThrough(array $pipes);
}