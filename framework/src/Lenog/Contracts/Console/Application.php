<?php

/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 11:59
 */

namespace Lenog\Contracts\Console;

interface Application
{
    /**
     * 调用控制台应用程序命令
     * @param $command
     * @param array $parameters
     * @return mixed
     */
    public function call($command, array $parameters = []);

    /**
     * 从上一条命令获取输出
     * @return mixed
     */
    public function output();
}