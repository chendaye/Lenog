<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 15:57
 */

namespace Lenog\Contracts\Auth;


interface canResetPassword
{
    /**
     * 改密码链接发送的邮件地址
     * @return mixed
     */
    public function getEmailForPasswordReset();

    /**
     * 发送密码重置通知
     * @param $token
     * @return mixed
     */
    public function sendPasswordResetNotification($token);
}