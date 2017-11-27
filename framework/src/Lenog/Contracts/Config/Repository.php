<?php

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 11:42
 */
namespace Lenog\Contracts\Config;

interface Repository
{
    /**
     * 检查配置是否存在
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * 获取指定的配置值
     * @param array|string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * 获取应用程序所有的配置项
     * @return mixed
     */
    public function all();

    /**
     * 设置配置项的值
     * @param $key
     * @param null $value
     * @return mixed
     */
    public function set($key, $value = null);

    /**
     * 追加配置值到数组配置项中
     * @param $key
     * @param $value
     * @return mixed
     */
    public function prepend($key, $value);

    /**
     * 将值推送到数组配置值
     * @param $key
     * @param $value
     * @return mixed
     */
    public function push($key, $value);
}