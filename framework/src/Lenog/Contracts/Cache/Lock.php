<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 10:34
 */

namespace Lenog\Contracts\Cache;


interface Lock
{
    /**
     * 尝试获取锁
     * @param null $callback
     * @return bool
     */
    public function get($callback = null);

    /**
     * 获取给定秒数的锁
     * @param $second
     * @param null $callback
     * @return bool
     */
    public function block($second, $callback = null);

    /**
     * 释放锁
     * @return void
     */
    public function release();
}