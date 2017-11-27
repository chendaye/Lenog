<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 18:30
 */

namespace Lenog\Contracts\Events;


interface Dispatcher
{
    /**
     * 注册一个事件监听器
     * @param string|array $events
     * @param mixed $listener
     * @return void
     */
    public function listen($events, $listener);

    /**
     * 检查给定的事件是否有监听器
     * @param string $eventName
     * @return bool
     */
    public function hasListeners($eventName);

    /**
     * 注册一个事件订阅者
     * @param object|string $subscriber
     * @return void
     */
    public function subscribe($subscriber);

    /**
     * 分发一个事件，直到返回第一个非空响应
     * @param object|string $event
     * @param mixed $payload
     * @return array|null
     */
    public function until($event, $payload = []);

    /**
     * 分发事件并且调用监听器
     * @param object|string $event
     * @param mixed $payload
     * @param bool $halt
     * @return array|null
     */
    public function dispatch($event, $payload = [], $halt = false);

    /**
     * 注册一个事件和有效负载后再被触发
     * @param string $event
     * @param array $payload
     * @return void
     */
    public function push($event, $payload = []);

    /**
     * 刷新一组推送事件
     * @param string $event
     * @return void
     */
    public function flush($event);

    /**
     * 删除一组监听器
     * @param string $event
     * @return void
     */
    public function forget($event);

    /**
     * 移除所有监听器
     * @return void
     */
    public function forgetPushed();
}