<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 11:19
 */

namespace Lenog\Contracts\Cache;


interface Store
{
    /**
     * 在缓存中通过键值检索获取对应项
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * 通过键值检索多个值，如果缓存中没有此项给一个null值
     * @param array $keys
     * @return mixed
     */
    public function many(array $keys);

    /**
     * 多项缓存给定的时间
     * @param array $values
     * @param $minutes
     * @return mixed
     */
    public function putMany(array $values, $minutes);

    /**
     * 增加缓存项的值
     * @param $key
     * @param mixed $value
     * @return int|bool
     */
    public function increment($key, $value = 1);

    /**
     * 减少缓存项的值
     * @param $key
     * @param mixed $value
     * @return int|bool
     */
    public function decrement($key, $value = 1);

    /**
     * 无限期缓存某项
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function forever($key, $value);

    /**
     * 删除缓存
     * @param string $key
     * @return bool
     */
    public function forget($key);

    /**
     * 清空所有缓存
     * @return bool
     */
    public function flush();

    /**
     * 获取缓存前缀
     * @return mixed
     */
    public function getPrefix();
}