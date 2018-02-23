<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2018/1/8
 * Time: 15:02
 */


namespace Lenog\Support;


class HigherOrderCollectionProxy
{
    /**
     * 被操作的集合
     * @var Collection
     */
    protected $collection;

    /**
     *被代理的方法
     * @var string
     */
    protected $method;

    /**
     * 创建一个新的代理实例
     * HigherOrderCollectionProxy constructor.
     * @param Collection $collection
     * @param $method
     */
    public function __construct(Collection $collection, $method)
    {
        $this->method = $method;

        $this->collection = $collection;
    }

    /**
     * 访问代理集合的属性
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->collection->{$this->method}(function($value) use ($key) {
            return is_array($value) ? $value[$key] : $value->{$key};
        });
    }

    /**
     * 访问代理集合的方法
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this->collection->{$this->method}(function($value) use ($method, $arguments) {
            return $value->{$method}(...$arguments);
        });
    }
}