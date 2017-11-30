<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 10:19
 */

namespace Lenog\Contracts\Validation;


interface Rule
{
    /**
     * 检查验证规则是否通过
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value);

    /**
     * 获取验证的错误信息
     * @return string
     */
    public function message();
}