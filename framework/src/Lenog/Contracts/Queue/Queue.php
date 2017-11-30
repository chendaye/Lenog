<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 14:31
 */

namespace Lenog\Contracts\Queue;


interface Queue
{
    /**
     * 获取队列的大小
     * @param string $queue
     * @return int
     */
    public function size($queue = null);

    /**
     * 把一个新的工作放入队列中
     * @param string|object $job
     * @param mixed $data
     * @param string $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null);

    /**
     * 推送一个新的工作到队列
     * @param string $queue
     * @param string|object $job
     * @param string $data
     * @return mixed
     */
    public function pushOn($queue, $job, $data = '');

    /**
     * 将原始负载推入队列中
     * @param string $payload
     * @param string $queue
     * @param array $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = []);

    /**
     * 一段延迟之后推送一个新的任务到队列
     * @param \DateTimeInterface|\DateInterval|int  $delay
     * @param string|object $job
     * @param string $data
     * @param array $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null);

    /**
     * 一段延迟之后推送一个新的任务到队列
     * @param \DateTimeInterface|\DateInterval|int  $delay
     * @param string|object $job
     * @param string $data
     * @param array $queue
     * @return mixed
     */
    public function laterOn($delay, $job, $data = '', $queue = null);

    /**
     * 把一组任务放入队列中
     * @param array $job
     * @param mixed $data
     * @param string $queue
     * @return mixed
     */
    public function bulk($job, $data, $queue = null);

    /**
     * 弹出队列中的下一个作业
     * @param string $queue
     * @return mixed
     */
    public function pop($queue = null);

    /**
     * 得到队列的连接名
     * @return mixed
     */
    public function getConnectName();

    /**
     * 设置队列连接名
     * @param string $name
     * @return mixed
     */
    public function setConnectName($name);

}