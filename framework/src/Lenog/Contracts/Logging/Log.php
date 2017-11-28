<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 14:59
 */

namespace Lenog\Contracts\Logging;


interface Log
{
    /**
     * 记录一个修改信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function alert($message, array $context = []);

    /**
     * 记录一个临界信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function critical($message, array $context = []);

    /**
     * 记录错误信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = []);

    /**
     * 记录警告信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function warning($message, array $context = []);

    /**
     * 记录注意信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function notice($message, array $context = []);

    /**
     * 记录 informational 信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = []);

    /**
     * 记录debug信息到日志
     * @param string $message
     * @param array $context
     * @return void
     */
    public function debug($message, array $context = []);

    /**
     * 记录信息到日志
     * @param string $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = []);

    /**
     * 注册一个文件日志处理程序
     * @param string $path
     * @param string $level
     * @return void
     */
    public function useFiles($path, $level = 'debug');

    /**
     * 注册一个日常文件日志处理程序
     * @param string $path
     * @param int $days
     * @param string $level
     * @return void
     */
    public function useDailyFlies($path, $days = 0, $level = 'debug');
}