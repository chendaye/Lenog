<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 10:45
 */

namespace Lenog\Contracts\View;


use Mockery\Matcher\Closure;

interface Factory
{
    /**
     * 检查给定的视图是否存在
     * @param string $view
     * @return bool
     */
    public function exists($view);

    /**
     * 获取给定路径视图内容
     * @param string $path
     * @param array $data
     * @param array $mergeData
     * @return \Lenog\Contracts\View\View
     */
    public function file($path, $data = [], $mergeData = []);

    /**
     * 获取给定视图的内容
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return \Lenog\Contracts\View\View
     */
    public function make($view, $data = [], $mergeData = []);

    /**
     * 增加一个共享数据
     * @param array|string $key
     * @param null $value
     * @return mixed
     */
    public function share($key, $value = null);

    /**
     * 注册一个 view composer event
     * @param array|string $views
     * @param \Closure|string $callback
     * @return array
     */
    public function composer($views, $callback);

    /**
     * 注册一个 view creator event
     * @param array|string $views
     * @param \Closure|string $callback
     * @return array
     */
    public function creator($views, $callback);

    /**
     * 给 loader 增加一个新的 namespace
     * @param string $namespace
     * @param string|array $hints
     * @return $this
     */
    public function addNamespace($namespace, $hints);

    /**
     * 替换给定名称空间的名称空间提示
     * @param string $namespace
     * @param string|array $hints
     * @return $this
     */
    public function replaceNamespace($namespace, $hints);



}