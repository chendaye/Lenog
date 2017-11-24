<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 18:51
 */

namespace Lenog\Contracts\Bus;


interface QueueingDispatcher extends Dispatcher
{
    /**
     * 把命令发送到队列
     * @param $command
     * @return mixed
     */
    public function dispatchToQueue($command);
}