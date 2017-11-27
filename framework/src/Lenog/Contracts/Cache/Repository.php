<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 10:50
 */

namespace Lenog\Contracts\Cache;
use Closure;
use Psr\SimpleCache\CacheInterface;

interface Repository extends CacheInterface
{
    /**
     * 检查某项是否在缓存中
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * 通过键值检索获取换存
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * 通过键值检索获取缓存 并删除
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function pull($key, $default = null);

    /**
     * 缓存某项
     * @param $key
     * @param $value
     * @param \DateTimeInterface|\DateInterval|float|int  $minutes
     * @return void
     */
    public function put($key, $value, $minutes);

    /**
     * 如果键值不存在就缓存此项
     * @param $key
     * @param $value
     * @param \DateTimeInterface|\DateInterval|float|int  $minutes
     * @return void
     */
    public function add($key, $value, $minutes);

    /**
     * 在缓存中增加项的值
     * @param $key
     * @param int $value
     * @return int|bool
     */
    public function increment($key, $value = 1);

    /**
     * 在缓存中减少项的值
     * @param $key
     * @param int $value
     * @return int|bool
     */
    public function decrement($key, $value = 1);

    /**
     * 在缓存中无限期的存储一个值
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function forever($key, $value);

    /**
     * 获取一个缓存项或者存储默认值
     * @param $key
     * @param \DateTimeInterface|\DateInterval|float|int  $minutes
     * @param Closure $closure
     * @return mixed
     */
    public function remember($key, $minutes, Closure $closure);

    /**
     * 获取缓存项或者无限期存错默认值
     * @param $key
     * @param Closure $closure
     * @return mixed
     */
    public function sear($key, Closure $closure);

    /**
     * 获取缓存项或者无限期存储默认值
     * @param string $key
     * @param Closure $closure
     * @return mixed
     */
    public function rememberForever($key, Closure $closure);

    /**
     * 删除缓存
     * @param string $key
     * @return void
     */
    public function forget($key);

    /**
     * 获取存储实例
     * @return \Lenog\Contracts\Cache\Store
     */
    public function getStore();
}