<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 16:01
 */

namespace Lenog\Contracts\Routing;


interface ResponseFactory
{
    /**
     * 从应用里面返回一个新的响应
     * @param string $content
     * @param int $status
     * @param array $header
     * @return \Lenog\Http\Response
     */
    public function make($content = '', $status = 200, array $header = []);

    /**
     * 从应用中返回一个新的视图请求
     * @param string $view
     * @param array $data
     * @param int $status
     * @param array $header
     * @return \Lenog\Http\Response
     */
    public function view($view, $data = [], $status = 200, array $header = []);

    /**
     * 从应用里面返回一个json响应
     * @param array $data
     * @param int $status
     * @param array $header
     * @param int $options
     * @return \Lenog\Http\Response
     */
    public function json($data = [], $status = 200, array $header = [], $options = 0);

    /**
     * 从应用里面返回一个jsonp响应
     * @param string $callback
     * @param array $data
     * @param int $status
     * @param array $header
     * @param int $options
     * @return \Lenog\Http\Response
     */
    public function jsonp($callback, $data = [], $status = 200, array $header = [], $options = 0);

    /**
     * 从应用中返回一个数据流响应 （数据流序列化存储设备）
     * @param $callback
     * @param int $status
     * @param array $header
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function stream($callback, $status = 200, array $header = []);

    /**
     * @param $file
     * @param null $name
     * @param array $header
     * @param string $disposition
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file, $name = null, array $header = [], $disposition = 'attachment');

    /**
     * @param string $path
     * @param int $status
     * @param array $header
     * @param null $secure
     * @return \Lenog\Http\RedirectResponse
     */
    public function redirectTo($path, $status = 302, $header = [], $secure = null);

    /**
     * 创建一个重定向响应到路由
     * @param string $route
     * @param array $parameters
     * @param int $status
     * @param array $header
     * @return \Lenog\Http\RedirectResponse
     */
    public function redirectToRoute($route, $parameters = [], $status = 302, $header = []);

    /**
     * 创建一个重定向响应到控制器方法
     * @param string $route
     * @param array $parameters
     * @param int $status
     * @param array $header
     * @return \Lenog\Http\RedirectResponse
     */
    public function redirectToAction($route, $parameters = [], $status = 302, $header = []);

    /**
     * 把当前url放在session 时，创建一个重定向响应
     * @param string $path
     * @param int $status
     * @param array $header
     * @param null $secure
     * @return \Lenog\Http\RedirectResponse
     */
    public function redirectGuest($path, $status = 302, $header = [], $secure = null);

    /**
     * 创建一个重定向响应到先前目的地
     * @param string $default
     * @param int $status
     * @param array $header
     * @param null|bool $secure
     * @return mixed
     */
    public function redirectToIntended($default = '/', $status = 302, $header = [], $secure = null);
}