<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 16:25
 */

namespace Lenog\Contracts\Notifications;


interface Factory
{
    /**
     * 通过名字获取 频道 实例
     * @param null|string $name
     * @return mixed
     */
    public function channel($name = null);

    /**
     * 发送给定的通知
     * @param $notifiables
     * @param $notification
     * @return mixed
     */
    public function send($notifiables, $notification);

    /**
     * 立即发送通知
     * @param \Lenog\Support\Collection|array|mixed  $notifiables
     * @param $notification
     * @return mixed
     */
    public function sendNow($notifiables, $notification);
}