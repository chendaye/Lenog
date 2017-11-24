<?php

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 18:18
 */

namespace Lenog\Contracts\Broadcasting;

interface Broadcaster
{
    /**
     * 为给定的频道验证请求
     * @param \Lenog\Http\Request $request
     * @return mixed
     */
    public function auth($request);

    /**
     * 返回有效的身份验证响应
     * @param \Lenog\Http\Request $request
     * @param $result
     * @return mixed
     */
    public function validAuthenticationResponse($request, $result);

    /**
     * 广播给定的事件
     * @param array $channels
     * @param $event
     * @param array $payload
     * @return mixed
     */
    public function broadcast(array $channels, $event, array $payload = []);
}