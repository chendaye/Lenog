<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/5
 * Time: 14:35
 */

namespace Lenog\Support;


use Mockery\Matcher\Closure;
use PharIo\Manifest\InvalidApplicationNameException;
use Psr\Log\InvalidArgumentException;

abstract class Manager
{
    /**
     * 应用实例
     *
     * @var
     */
    protected $app;

    /**
     * 注册自定义设备创建者
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * 创建的设备数组
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * 创建一个新的管理实例
     *
     * Manager constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 获取默认设备名
     *
     * @return mixed
     */
    abstract public function getDefaultDriver();


    /**
     * 获取设备实例
     *
     * @param null $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        $driver = $driver ? : $this->getDefaultDriver();

        if(! isset($this->drivers[$driver])){
            $this->drivers[$driver] =$this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * 创建一个新的设备实例
     *
     * @param $driver
     * @return mixed
     */
    protected function createDriver($driver)
    {
        if(isset($this->customCreators[$driver])){
            return $this->callCustomCreator($driver);
        } else {
            $method = 'created'.Str::studly($driver).'Driver';

            if(method_exists($this, $method)){
                return $this->$method();
            }
        }

        throw new InvalidArgumentException("Driver [$driver] not support.");
    }

    /**
     * 调用自定义设备创建器
     *
     * @param $driver
     * @return mixed
     */
    protected function callCustomCreator($driver)
    {
        return $this->customCreators[$driver]($this->app);
    }

    /**
     * 注册自定义设备创建回调函数
     *
     * @param $driver
     * @param \Closure $closure
     * @return $this
     */
    public function extend($driver, \Closure $closure)
    {
        $this->customCreators[$driver] = $closure;

        return $this;
    }

    /**
     * 获取所有创建的设备
     *
     * @return array
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->driver()->$name(...$arguments);
    }
}