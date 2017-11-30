<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 11:29
 */

namespace Lenog\Contracts\Pipeline;
use Closure;

interface Pipeline
{
    /**
     * 设置管道中药传输的对象
     * @param mixed $traveler
     * @return $this
     */
    public function send($traveler);

    /**
     * 设置管道上的止点
     * @param dynamic|array $stops
     * @return $this
     */
    public function through($stops);

    /**
     * 设置调用 stops 的方法
     * @param string $method
     * @return $this
     */
    public function via($method);

    /**
     * 使用最终目标回调函数运行管道
     * @param Closure $destination
     * @return mixed
     */
    public function then(Closure $destination);
}