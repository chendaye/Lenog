<?php

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 18:44
 */
namespace Lenog\Contracts\Auth\Access;

interface Authorizable
{
    /**
     * 是否有权限
     * @param string $ability
     * @param array|mixed $arguments
     * @return boolean
     */
    public function can($ability, $arguments = []);
}