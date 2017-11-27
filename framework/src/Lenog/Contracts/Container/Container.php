<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 16:36
 */

namespace Lenog\Contracts\Container;
use Closure;
use Psr\Container\ContainerInterface;

interface Container extends ContainerInterface
{
    /**
     * 检查给定的抽象类型是否被绑定
     * @param $abstract
     * @return bool
     */
    public function bound($abstract);

    /**
     * 给类型取别名
     * @param string $abstract
     * @param string $alias
     * @return mixed
     */
    public function alias($abstract, $alias);

    /**
     * 给绑定的类型打一个标签
     * @param string|array $abstract
     * @param string|array $tags
     * @return void
     */
    public function tag($abstract, $tags);

    /**
     * 解析给定标签的所有绑定
     * @param array $tag
     * @return array
     */
    public function tagged($tag);

    /**
     * 在容器中注册一个绑定类型
     * @param $abstract
     * @param \Closure|string|null  $concrete
     * @param bool $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = null);

    /**
     * 如果容器中不存在就绑定类型
     * @param $abstract
     * @param \Closure|string|null  $concrete
     * @param bool $shared
     * @return void
     */
    public function bindIf($abstract, $concrete = null, $shared = null);

    /**
     * 在容器中注册一个共享的绑定类型(单例)
     * @param string|array $abstract
     * @param \Closure|string|null  $concrete
     * @return void
     */
    public function singleton($abstract, $concrete = null);

    /**
     * 在容器中扩展一个抽象类型
     * @param string $abstract
     * @param Closure $closure
     * @return void
     */
    public function extend($abstract, Closure $closure);

    /**
     * 在容器中注册一个已经存在的实例，用于共享
     * @param string $abstract
     * @param string $instance
     * @return mixed
     */
    public function instance($abstract, $instance);

    /**
     * 定义一个上下文的绑定
     * @param  string  $concrete
     * @return \Lenog\Contracts\Container\ContextualBindingBuilder
     */
    public function when($concrete);

    /**
     * 从容器中获得一个闭包来解析给定的类型。
     * @param string $abstract
     * @return \Closure
     */
    public function factory($abstract);

    /**
     * 解析容器中给定的类型
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make($abstract, $parameters = []);

    /**
     * 调用给定的闭包或者类方法注入依赖
     * @param callable|string $callback
     * @param array $parameters
     * @param null|string $defaultMethod
     * @return mixed
     */
    public function call($callback, array $parameters = [], $defaultMethod = null);

    /**
     * 检查给定的抽象类型是否被解析
     * @param string $abstract
     * @return bool
     */
    public function resolved($abstract);

    /**
     * 注册一个新的解析回调函数
     * @param $abstract
     * @param Closure|null $closure
     * @return mixed
     */
    public function resolving($abstract, Closure $closure = null);

    /**
     * 注册一个新的后调用 回调函数
     * @param $abstract
     * @param Closure|null $closure
     * @return mixed
     */
    public function afterResolving($abstract, Closure $closure = null);
}