<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 18:00
 */

namespace Lenog\Contracts\Session;


interface Session
{
    /**
     * 获取session 名
     * @return string
     */
    public function getName();

    /**
     *当前session ID
     * @return string
     */
    public function getId();

    /**
     * 设置session ID
     * @return void
     */
    public function setId();

    /**
     * 开启session 从handle中获取数据
     * @return bool
     */
    public function start();

    /**
     * 保存session数据
     * @return bool
     */
    public function save();

    /**
     * 获取所有的session数据
     * @return array
     */
    public function all();

    /**
     * 检查key值是否存在
     * @param string|array $key
     * @return bool
     */
    public function exists($key);

    /**
     * 检查key是否存在，并且不为空
     * @param string|array $key
     * @return bool
     */
    public function has($key);

    /**
     * 获取session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * 更新一个键值对或者一组键值对
     * @param string|array $key
     * @param null $value
     * @return void
     */
    public function put($key, $value = null);

    /**
     * 获取 CSRF token 的值
     * @return string
     */
    public function token();

    /**
     * 删除一个session 并返回它的值
     * @param string $key
     * @return mixed
     */
    public function remove($key);

    /**
     * 删除一个或者多个session
     * @param string|array $keys
     * @return void
     */
    public function forget($keys);

    /**
     * 清空所有session
     * @return void
     */
    public function flush();

    /**
     * 生成一个新的sessionID
     * @param bool $destroy
     * @return bool
     */
    public function migrate($destroy = false);

    /**
     * 检查session是否被开启
     * @return bool
     */
    public function isStarted();

    /**
     * 从session中获取先前的url
     * @return string
     */
    public function previousUrl();

    /**
     * 在session中设置先前的url
     * @param string $url
     * @return void
     */
    public function setPreviousUrl($url);

    /**
     * 获取 session handle 的实例
     * @return \SessionHandlerInterface
     */
    public function getHandle();

    /**
     * j检查 session handle 需要 request
     * @return bool
     */
    public function handlerNeedsRequest();

    /**
     * 在 session Handler 上设置请求
     * @param \Lenog\Http\Request  $request
     * @return void
     */
    public function setRequestOnHandler($request);

}