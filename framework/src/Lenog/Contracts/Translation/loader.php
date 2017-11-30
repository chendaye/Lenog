<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 18:46
 */

namespace Lenog\Contracts\Translation;


interface loader
{
    /**
     * 加载信息 为给定的 locale
     * @param string $locale
     * @param string $group
     * @param string $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null);

    /**
     * 增加 namespace 到 loader
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint);

    /**
     * 增加一个新的 json path 到 loader
     * @param string $path
     * @return void
     */
    public function addJsonPath($path);

    /**
     * 获取所有注册的命名空间
     * @return string
     */
    public function namespaces();
}