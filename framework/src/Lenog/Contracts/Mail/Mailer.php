<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 15:25
 */

namespace Lenog\Contracts\Mail;


interface Mailer
{
    /**
     * 开始一个发邮件的过程
     * @param mixed $users
     * @return \Lenog\Mail\PendingMail
     */
    public function to($users);

    /**
     * 开始一个发邮件的过程
     * @param mixed $users
     * @return \Lenog\Mail\PendingMail
     */
    public function bcc($users);

    /**
     * 当只有文本信息时发送信息
     * @param string $text
     * @param mixed $callback
     * @return void
     */
    public function raw($text, $callback);

    /**
     * 用视图发送一个新的信息
     * @param string|array|MailableContract  $view
     * @param array $date
     * @param \Closure|string  $callback
     * @return void
     */
    public function send($view, array $date = [], $callback = null);

    /**
     * 获取失败的收件人数组
     * @return mixed
     */
    public function failures();
}