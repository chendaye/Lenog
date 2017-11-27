<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 12:06
 */

namespace Lenog\Contracts\Console;


interface Kernel
{
    /**
     * 处理传入的控制台命令
     * @param \Symfony\Component\Console\Input\InputInterface  $input
     * @param \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function handel($input, $output = null);

    /**
     * 运行一个控制台命令 通过命令名字
     * @param string $command
     * @param array $parameters
     * @return mixed
     */
    public function call($command, array $parameters = []);

    /**
     * 把命令放到队列中
     * @param $command
     * @param array $parameters
     * @return \Lenog\Foundation\Bus\PendingDispatch
     */
    public function queue($command, array $parameters = []);

    /**
     * 获取所有注册的控制台命令
     * @return array
     */
    public function all();

    /**
     * 获取上一条命令的输出
     * @return string
     */
    public function output();
}