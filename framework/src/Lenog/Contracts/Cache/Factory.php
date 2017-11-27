<?php

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 10:30
 */

namespace Lenog\Contracts\Cache;

interface Factory
{
    /**
     * 获取存储的实例
     * @param null $name
     * @return \Lenog\Contracts\Cache\Repository
     */
    public function store($name = null);


}