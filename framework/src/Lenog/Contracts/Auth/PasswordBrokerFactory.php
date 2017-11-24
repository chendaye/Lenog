<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 16:58
 */

namespace Lenog\Contracts\Auth;


interface PasswordBrokerFactory
{
    /**
     * 通过name获取密码代理实例
     * @param null $name
     * @return mixed
     */
    public function broker($name = null);
}