<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/2/27
 * Time: 17:40
 */

namespace Lenog\Support;


use Lenog\Contracts\Support\Arrayable;
use Lenog\Contracts\Support\Jsonable;

class Fluent implements \ArrayAccess, Arrayable, Jsonable, \JsonSerializable
{
    /**
     * 容器上设置的所有属性
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * 创建一个新的链式容器实例
     *
     * Fluent constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $val){
            $this->attributes[$key] = $val;
        }
    }

    /**
     * 从容器里得到属性
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if(array_key_exists($key, $this->attributes)){
            return $this->attributes[$key];
        }

        return value($default);
    }

    /**
     * 得到所有容器属性
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * 转化容器实例为数组
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * 转化对象为json序列
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * 转化对象为json
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * 检查给定的属性是否存在
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * 获取指定的属性
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * 设置指定的属性值
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * 销毁属性
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * 自动调用设置属性
     *
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->attributes[$name] = count($arguments) > 0 ? $arguments[0] : true;

        return $this;
    }

    /**
     * 动态检索属性值
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * 动态设置属性值
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * 动态检查属性是否存在
     *
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

}