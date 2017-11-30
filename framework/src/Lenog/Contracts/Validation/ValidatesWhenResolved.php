<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 10:23
 */

namespace Lenog\Contracts\Validation;


interface ValidatesWhenResolved
{
    /**
     * 验证给定的类实例
     * @return string
     */
    public function validate();
}