<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 15:19
 */

namespace Lenog\Contracts\Redis;


interface Factory
{
    /**
     * 通过名字获取 Redis 连接
     * @param string $name
     * @return mixed
     */
    public function connection($name = null);
}