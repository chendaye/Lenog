<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 18:34
 */

namespace Lenog\Contracts\Broadcasting;


interface Factory
{
    /**
     * 通过name获取广播实例
     * @param null $name
     * @return mixed
     */
    public function connection($name = null);
}