<?php
namespace Lenog\Contracts\Auth;

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 15:47
 */
interface Authenticatable
{
    /**
     * 获取用户唯一的标识名
     * @return string
     */
    public function getAuthIdentifierName();

    /**
     * 获取用户唯一证明
     * @return mixed
     */
    public function getAuthIdentifier();

    /**
     * 获取用户密码
     * @return mixed
     */
    public function getAuthPassword();

    /**
     * 获取 remember me 的session
     * @return mixed
     */
    public function getRememberToken();

    /**
     * 设置session值
     * @param $value
     * @return void
     */
    public function setRememberToken($value);

    /**
     * 获取 token的名字
     * @return mixed
     */
    public function getRememberTokenName();
}