<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 15:24
 */

namespace Lenog\Contracts\Routing;


interface BindingRegister
{
    /**
     * 增加一个新的路由参数绑定
     * @param string $key
     * @param string|callable $binder
     * @return void
     */
    public function bind($key, $binder);

    /**
     * 获取给定绑定的绑定回调函数
     * @param string $key
     * @return \Closure
     */
    public function getBindingCallback($key);
}