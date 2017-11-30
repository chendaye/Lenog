<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 15:34
 */

namespace Lenog\Contracts\Routing;


interface Registrar
{
    /**
     * 注册一个  GET  路由
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function get($uri, $action);

    /**
     * 注册一个  POST  路由
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function post($uri, $action);

    /**
     * 注册一个  PUT  路由
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function put($uri, $action);

    /**
     * 注册一个  DELETE  路由
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function delete($uri, $action);

    /**
     * 注册一个  PATCH  路由
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function patch($uri, $action);

    /**
     * 注册一个  OPTIONS  路由
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function options($uri, $action);

    /**
     * @param array|string $methods
     * @param string $uri
     * @param \Closure|array|string $action
     * @return \Lenog\Routing\Route
     */
    public function match($methods, $uri, $action);

    /***
     * @param string $name
     * @param string $controller
     * @param array $options
     * @return \Lenog\Routing\PendingResourceRegistration
     */
    public function resource($name, $controller, array $options = []);

    /**
     * 创建一个路由组共享属性
     * @param array $attributes
     * @param \Closure|string $route
     * @return void
     */
    public function group(array $attributes, $route);

    /**
     *将路由绑定替换到路由上
     * @param  \Lenog\Routing\Route  $route
     * @return \Lenog\Routing\Route
     */
    public function substituteBindings($route);

    /**
     *替换隐式模型绑定
     * @param  \Lenog\Routing\Route  $route
     * @return void
     */
    public function substituteImplicitBindings($route);

}