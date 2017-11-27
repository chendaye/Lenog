<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 10:41
 */

namespace Lenog\Contracts\Cache;


interface LockProvider
{
    /**
     * 获取锁
     * @param string $name
     * @param int $second
     * @return \Lenog\Contracts\Cache\Lock
     */
    public function lock($name, $second);
}