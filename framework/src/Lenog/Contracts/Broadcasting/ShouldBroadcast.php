<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 18:37
 */

namespace Lenog\Contracts\Broadcasting;


interface ShouldBroadcast
{
    /**
     * 获取要广播事件的频道
     * @return mixed
     */
    public function broadcastOn();
}