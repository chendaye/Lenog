<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 17:32
 */

namespace Lenog\Contracts\Cookie;


interface Factory
{
    /**
     * 创建一个新的cookie实例
     * @param string $name
     * @param string $value
     * @param int $minutes
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function make($name, $value, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true);

    /**
     * 创建一个cookie,永久的（5年）
     * @param string $name
     * @param string $value
     * @param string $path
     * @param null $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function forever($name, $value, $path = null, $domain = null, $secure = false, $httpOnly = true);

    /**
     * (销毁cookie)让cookie过期
     * @param string $name
     * @param null $path
     * @param null $domain
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function forget($name, $path = null, $domain = null);
}