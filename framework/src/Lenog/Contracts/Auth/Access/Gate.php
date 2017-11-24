<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 18:47
 */

namespace Lenog\Contracts\Auth\Access;


interface Gate
{
    /**
     * 检查一个给定的权限是否被定义
     * @param string $ability
     * @return bool
     */
    public function has($ability);

    /**
     * 定义一个权限
     * @param string $ability
     * @param callable|string $callback
     * @return $this
     */
    public function define($ability, $callback);

    /**
     * 为一个给定的类型创建一个策略类
     * @param string $class
     * @param string $policy
     * @return $this
     */
    public function policy($class, $policy);

    /**
     * 注册在Gate检查之前，执行的回调函数
     * @param callable $callback
     * @return $this
     */
    public function before(callable $callback);

    /**
     * 注册在Gate检查之后，执行的回掉函数
     * @param callable $callback
     * @return mixed
     */
    public function after(callable $callback);

    /**
     * 检查当前用户是否有权限
     * @param string $ability
     * @param array|mixed $arguments
     * @return bool
     */
    public function allows($ability, $arguments = []);

    /**
     * 检查是否要否决当前用户的谋权限
     * @param string $ability
     * @param array|mixed $arguments
     * @return bool
     */
    public function denies($ability, $arguments = []);

    /**
     * 检查当前用户的某权限
     * @param string $ability
     * @param array|mixed $arguments
     * @return bool
     */
    public function check($ability, $arguments = []);

    /**
     * 检查是否当前用户有所有给定的权限
     * @param iterable|string $ability
     * @param array|mixed $arguments
     * @return bool
     */
    public function any($abilities, $arguments = []);

    /**
     * 检查给定的权限是否应该被授予当前用户
     * @param string $ability
     * @param array|mixed $arguments
     * @return \Lenog\Auth\Access\Response
     *
     * @throws \Lenog\Auth\Access\AuthorizationException
     */
    public function authorize($ability, $arguments = []);

    /**
     * 为给定的类获取一个策略类实例
     *
     * @param  object|string  $class
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getPolicyFor($ability, $arguments = []);

    /**
     *为给定的用户获取一个gurd实例
     * @param  \Lenog\Contracts\Auth\Authenticatable|mixed  $user
     * @return static
     */
    public function forUser($user);

    /**
     *获取所有定义的权限
     * @return array
     */
    public function abilities();

}