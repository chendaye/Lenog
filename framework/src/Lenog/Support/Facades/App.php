<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/1
 * Time: 17:57
 */


namespace Lenog\Support\Facades;

/**
 * @method static string version()
 * @method static string basePath()
 * @method static string environment()
 * @method static bool isDownForMaintenance()
 * @method static void registerConfiguredProviders()
 * @method static \Lenog\Support\ServiceProvider register(\Lenog\Support\ServiceProvider|string $provider, array $options = [], bool $force = false)
 * @method static void registerDeferredProvider(string $provider, string $service = null)
 * @method static void boot()
 * @method static void booting(mixed $callback)
 * @method static void booted(mixed $callback)
 * @method static string getCachedServicesPath()
 *
 * @see \Lenog\Foundation\Application
 */
class App extends Facade
{
    /**
     * 覆盖父类方法
     * 获取组件的注册名称
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'app';
    }
}