<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 11:27
 */

namespace Lenog\Contracts\Pipeline;


interface Hub
{
    /**
     * 通过一个可用的管道发送对象
     * @param mixed $object
     * @param null|string $pipeline
     * @return mixed
     */
    public function pipe($object, $pipeline = null);
}