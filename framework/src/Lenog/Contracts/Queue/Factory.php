<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 12:13
 */

namespace Lenog\Contracts\Queue;


interface Factory
{
    /**
     * 解析一个队列连接实例
     * @param string $name
     * @return \Lenog\Contracts\Queue\Queue
     */
    public function connection($name = null);
}