<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 16:04
 */

namespace Lenog\Contracts\Auth;


interface Factory
{
    /**
     * 通过名字获取 guard实例
     * @param null $name
     * @return mixed
     */
    public function guard($name = null);


    /**
     * 设置默认 guard
     * @param string $name
     * @return void
     */
    public function shouldUse($name);
}