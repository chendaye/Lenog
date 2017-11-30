<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 16:40
 */

namespace Lenog\Contracts\Routing;


interface UrlGenerator
{
    /**
     * 获取当前url
     * @return string
     */
    public function current();

    /**
     * @param $path
     * @param array $extra
     * @param null $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null);

    /**
     * 为给定路径生成一个安全、绝对路径的URL
     * @param string $path
     * @param array $parameters
     * @return string
     */
    public function secure($path, $parameters = []);

    /**
     * @param string $path
     * @param null $secure
     * @return string
     */
    public function asset($path, $secure = null);

    /**
     * 根据路由名获取url
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     */
    public function route($name, $parameters = [], $absolute = true);

    /**
     * 获取控制器方法的url
     * @param string $action
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    public function action($action, $parameters = [], $absolute = true);

    /**
     * 设置根控制器的命名空间
     * @param string $rootNamespace
     * @return string
     */
    public function setRootControllerNamespace($rootNamespace);
}