<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 18:25
 */

namespace Lenog\Contracts\Encryption;


interface Encrypter
{
    /**
     * 加密给定的值
     * @param $value
     * @param bool $serialize
     * @return string
     */
    public function encrypt($value, $serialize = true);

    /**
     * 解密给定的值
     * @param $payload
     * @param bool $unserialize
     * @return mixed
     */
    public function decrypt($payload, $unserialize = true);
}