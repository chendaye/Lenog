<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 14:08
 */


namespace Lenog\Contracts\Support;


interface MessageBag extends Arrayable
{
    /**
     * 获取key值
     * @return array
     */
    public function keys();

    /**
     * 增加元素到bag里
     * @param string $key
     * @param string $message
     * @return $this
     */
    public function add($key, $message);

    /**
     * 合并一个数组到bag
     * @param \Lenog\Contracts\Support\MessageProvider|array  $messages
     * @return $this
     */
    public function merge($messages);

    /**
     * 判断是否存在给定的key值
     * @param string|array $key
     * @return mixed
     */
    public function has($key);

    /**
     * @param string $key
     * @param string $format
     * @return array
     */
    public function first($key = null, $format = null);

    /**
     * @param string $key
     * @param string $format
     * @return array
     */
    public function get($key, $format = null);

    /**
     * 得到所有信息
     * @param $format
     * @return  array
     */
    public function all($format = null);

    /**
     * 获取容器的信息
     * @return array
     */
    public function getMessages();

    /**
     * 获取容器的数据格式
     * @return mixed
     */
    public function getFormat();

    /**
     * 判断容器是否是空的
     * @return boolean
     */
    public function isEmpty();

    /**
     * 容器是否非空
     * @return boolean
     */
    public function isNotEmpty();

    /**
     * 容器数据数目
     * @return int
     */
    public function count();
}