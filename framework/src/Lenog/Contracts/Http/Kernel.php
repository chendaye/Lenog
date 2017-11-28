<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 14:50
 */

namespace Lenog\Contracts\Http;


interface Kernel
{
    /**
     * 未HTTP请求  引导程序
     * @return void
     */
    public function bootstrap();

    /**
     * 处理http请求
     * @param \Symfony\Component\HttpFoundation\Response $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request);

    /**
     * 获取 Lenog 应用实例
     * @return \Lenog\Contracts\Foundation\Application
     */
    public function getApplication();
}