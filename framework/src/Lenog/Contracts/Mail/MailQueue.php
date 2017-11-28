<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 16:13
 */

namespace Lenog\Contracts\Mail;


interface MailQueue
{
    /**
     * 在队列中放入邮件
     * @param $view
     * @param null $queue
     * @return mixed
     */
    public function queue($view, $queue = null);

    /**
     * Queue a new e-mail message for sending after (n) seconds.
     *
     * @param  \DateTimeInterface|\DateInterval|int  $delay
     * @param  string|array|MailableContract  $view
     * @param  string  $queue
     * @return mixed
     */
    public function later($delay, $view, $queue = null);
}