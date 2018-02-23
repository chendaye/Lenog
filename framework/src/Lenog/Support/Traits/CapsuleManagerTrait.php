<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/26
 * Time: 14:30
 */

namespace Lenog\Support\Traits;

use Lenog\Support\Fluent;
use Lenog\Contracts\Container\Container;

trait CapsuleManagerTrait
{
    /**
     * 当前全局使用的实例
     * @var object
     */
    protected static $instance;

    /**
     * 容器实例
     * @var Container
     */
    protected $container;

    /**
     * 设置 IOC容器实例
     * @param Container $container
     */
    protected function setupContainer(Container $container){
        $this->container = $container;

        if(! $this->container->bound('config')){
            $this->container->instance('config', new Fluent());
        }
    }

    /**
     *设置实例全局可用
     */
    public function setAsGlobal(){
        static::$instance = $this;
    }

    /**
     * 获取容器
     * @return Container
     */
    public function getContainer(){
        return $this->container;
    }

    /**
     * 设置 IoC 容器实例
     * @param Container $container
     */
    public function setContainer(Container $container){
        $this->container = $container;
    }

}