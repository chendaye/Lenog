<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 17:47
 */

namespace Lenog\Contracts\Auth;


interface UserProvider
{
    /**
     * 用唯一识别标志，检索用户
     * @param $identifier
     * @return mixed
     */
    public function retrieveById($identifier);

    /**
     * 用唯一的token检索用户
     * @param $identifier
     * @param $token
     * @return mixed
     */
    public function retrieveByToken($identifier, $token);

    /**
     * 为给定的用户更新token
     * @param Authenticatable $user
     * @param $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token);

    /**
     * 通过给定凭证检索用户
     * @param array $credentials
     * @return mixed
     */
    public function retrieveByCredentials(array $credentials);

    /**
     * 根据给定凭证验证用户
     * @param Authenticatable $user
     * @param array $credentials
     * @return mixed
     */
    public function validateCredentials(Authenticatable $user, array $credentials);
}