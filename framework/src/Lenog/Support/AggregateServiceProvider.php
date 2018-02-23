<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/6
 * Time: 18:40
 */


namespace Lenog\Support;


class AggregateServiceProvider extends ServiceProvider
{
    /**
     * provider 类名
     * @var array
     */
    protected $providers = [];

    /**
     * provider 类实例
     * @var array
     */
    protected $instances = [];

    /**
     * 注册服务提供者
     */
    public function register()
    {
        $this->instances = [];
        foreach ($this->providers as $provider) {
            $this->instances = $this->app->register($provider);
        }
    }

    /**
     * 通过provider 提供 services provider
     * @return array
     */
    public function providers()
    {
        $providers = [];
        foreach ($this->providers as $provider) {
            $instance = $this->app->resolveProvider($provider);
            $providers = array_merge($providers, $instance->provides());
        }
        return $providers;
    }
}