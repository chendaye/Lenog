<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 18:18
 */

namespace Lenog\Contracts\Debug;
use Exception;

interface ExceptionHandler
{
    /**
     * 报告或记录异常
     * @param Exception $exception
     * @return mixed
     */
    public function report(Exception $exception);

    /**
     * 将异常呈现为HTTP响应
     * @param $request
     * @param Exception $exception
     * @return mixed
     */
     public function render($request, Exception $exception);

    /**
     * 将异常呈现到控制台
     * @param $output
     * @param Exception $exception
     * @return mixed
     */
     public function renderForConsole($output, Exception $exception);
}