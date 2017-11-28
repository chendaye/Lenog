<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 16:19
 */

namespace Lenog\Contracts\Notifications;


interface Dispatcher
{
    /**
     * 将给定的通知发送给给定的通知实体
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