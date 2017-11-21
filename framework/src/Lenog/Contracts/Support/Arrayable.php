<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 12:29
 */

namespace Lenog\Contracts\Support;

interface Arrayable
{
    /**
     * 获取一个数组实例
     * @return mixed
     */
    public function toArray();
}