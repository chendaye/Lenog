<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 16:04
 */

namespace Lenog\Contracts\Mail;
use Lenog\Contracts\Queue\Factory as Queue;

interface Mailable
{
    /**
     * 用给定的 Mailer 发送信息
     * @param Mailer $mailer
     * @return void
     */
    public function send(Mailer $mailer);

    /**
     * 邮件放入队列中
     * @param Queue $queue
     * @return mixed
     */
    public function queue(Queue $queue);

    /**
     * 在给定的延迟之后发送队列消息
     * @param \DateTime|int  $delay
     * @param Queue $queue
     * @return mixed
     */
    public function later($delay, Queue $queue);
}