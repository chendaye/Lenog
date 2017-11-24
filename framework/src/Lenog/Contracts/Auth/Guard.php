<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 16:08
 */

namespace Lenog\Contracts\Auth;


interface Guard
{
    /**
     * 检查当前用户是否被授权
     * @return bool
     */
    public function check();

    /**
     * 检查当前用户是否是一个 guest
     * @return bool
     */
    public function guest();

    /**
     * 获取当前授权用户
     * @return Authenticatable
     */
    public function user();

    /**
     * 当前授权用户的id
     * @return mixed
     */
    public function id();

    /**
     * 验证用户的证书
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = []);

    /**
     * 设置当前用户
     * @param Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user);
}