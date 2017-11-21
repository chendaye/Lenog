<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 14:45
 */

namespace Lenog\Contracts\Support;


interface MessageProvider
{
    /**
     * 获取实例的信息
     * @return \Lenog\Contracts\Support\MessageBag
     */
    public function getMessage();
}