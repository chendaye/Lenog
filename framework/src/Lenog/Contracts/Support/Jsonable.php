<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 12:29
 */

namespace Lenog\Contracts\Support;


interface Jsonable
{
    /**
     * 把对象转化为Json格式
     * @param int $options
     * @return mixed
     */
    public function toJson($options = 0);
}