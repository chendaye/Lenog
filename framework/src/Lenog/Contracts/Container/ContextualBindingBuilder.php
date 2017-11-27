<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 17:25
 */

namespace Lenog\Contracts\Container;


interface ContextualBindingBuilder
{
    /**
     * 根据上下文定义抽象目标
     * @param string $abstract
     * @return $this
     */
    public function needs($abstract);

    /**
     * 定义上下文绑定的实现
     * @param \Closure|string  $implementation
     * @return void
     */
    public function give($implementation);
}