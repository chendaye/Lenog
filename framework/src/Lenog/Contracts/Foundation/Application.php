<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 12:20
 */

namespace Lenog\Contracts\Foundation;


use Lenog\Contracts\Container\Container;

interface Application extends Container
{
    /**
     * 获取应用的版本号
     * @return string
     */
    public function version();

    /**
     * 获取 Lenog 安装的基础路径
     * @return mixed
     */
    public function basePath();

    /**
     * 获取或检查当前应用的环境
     * @return string
     */
    public function environment();

    /**
     * 检查是否运行在控制台中
     * @return bool
     */
    public function runningInConsole();

    /**
     * 检查应用程序是否正在进行维护
     * @return bool
     */
    public function idDownForMaintenance();

    /**
     * 注册所有配置的 Provider
     * @return void
     */
    public function registerConfigureProviders();

    /**
     * 给应用注册 service provider
     * @param \Lenog\Support\ServiceProvider|string  $provider $provider
     * @param array $options
     * @param bool $force
     * @return \Lenog\Support\ServiceProvider
     */
    public function register($provider, $options = [], $force = false);

    /**
     * 注册一个延迟的   provider 和 service
     * @param string $provider
     * @param null|string $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null);

    /**
     * 启动应用程序的服务提供者
     * @return void
     */
    public function boot();

    /**
     * 注册一个新的  boot 的监听器
     * @param mixed $callback
     * @return void
     */
    public function booting($callback);

    /**
     * 注册一个 booted 的监听器
     * @param mixed $callback
     * @return void
     */
    public function booted($callback);

    /**
     * 获取路径 缓存 services.php 文件
     * @return string
     */
    public function getCachedServicesPath();

    /**
     * 获取路径 缓存 packages.php  文件
     * @return string
     */
    public function getCachedPackagesPath();
}