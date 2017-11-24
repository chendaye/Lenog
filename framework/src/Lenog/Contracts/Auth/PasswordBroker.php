<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 16:25
 */

namespace Lenog\Contracts\Auth;


interface PasswordBroker
{
    /**
     * 成功发送提醒
     * @var string
     */
    const RESET_LINK_SENT = 'passwords.sent';

    /**
     * 成功重置
     * @var string
     */
    const PASSWORD_RESET = 'passwords.reset';

    /**
     * 用户没有响应
     * @var string
     */
    const INVALID_USER = 'passwords.user';

    /**
     * 无效密码
     * @var string
     */
    const INVALID_PASSWORD = 'passwords.password';

    /**
     * 无效token
     * @var string
     */
    const INVALID_TOKEN = 'passwords.token';

    /**
     * 给用户发送密码重置链接
     * @param array $credentials
     * @return mixed
     */
    public function sentResetLink(array $credentials);

    /**
     * 为给定的token重置密码
     * @param array $credentials
     * @param \Closure $callback
     * @return mixed
     */
    public function reset(array $credentials, \Closure $callback);

    /**
     * 设置密码验证方式
     * @param \Closure $callback
     * @return void
     */
    public function validator(\Closure $callback);

    /**
     * 检查密码是否与请求相匹配
     * @param array $credentials
     * @return mixed
     */
    public function validateNewPassword(array $credentials);


}