<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 17:02
 */

namespace Lenog\Contracts\Auth;


interface StatefulGuard extends Guard
{
    /**
     * 用给定的证书验证一个用户
     * @param array $credentials
     * @param bool $remember
     * @return mixed
     */
    public function attempt(array $credentials = [], $remember = false);

    /**
     * 不记录session或者cookie登陆应用
     * @param array $credentials
     * @return mixed
     */
    public function once(array $credentials = []);

    /**
     * 用户登陆
     * @param Authenticatable $user
     * @param bool $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false);

    /**
     * 用给定的用户id登陆应用
     * @param $id
     * @param bool $remember
     * @return mixed
     */
    public function loginUsingId($id, $remember = false);

    /**
     * 不记录session cookie  用id登陆应用
     * @param $id
     * @return mixed
     */
    public function onceUsingId($id);

    /**
     * 检查用户是否记录cookie
     * @return mixed
     */
    public function viaRemember();

    /**
     * 登出
     * @return mixed
     */
    public function logout();
}