<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 12:15
 */

namespace Lenog\Contracts\Queue;


interface Job
{
    /**
     * 开始工作
     * @return void
     */
    public function fire();

    /**
     * 释放工作，回到队列
     * @param int $delay
     * @return mixed
     */
    public function release($delay = 0);

    /**
     * 从队列中删除工作
     * @return void
     */
    public function delete();

    /**
     * 检查工作是否在队列中被删除
     * @return bool
     */
    public function isDeleted();

    /**
     * 检查工作是否在队列中被释放或者删除
     * @return bool
     */
    public function idDeletedOrReleased();

    /**
     * 获取job已经被尝试的次数
     * @return int
     */
    public function attempts();

    /**
     * job失败的时候抛出异常
     * @param \Throwable $e
     * @return void
     */
    public function fail($e);

    /**
     * 获取尝试一个job的次数
     * @return int|null
     */
    public function maxTries();

    /**
     * job的超时时间
     * @return int
     */
    public function timeout();

    /**
     * 获取过期时的时间戳
     * @return int|null
     */
    public function timeoutAt();

    /**
     * 获取队列名
     * @return string
     */
    public function getName();

    /**
     * 获取队列作业类的已解析名称
     * @return string
     */
    public function resolveName();

    /**
     * 得到job 所属的 连接名字
     * @return string
     */
    public function getConnectionName();

    /**
     * 得到job所属的队列名称
     * @return string
     */
    public function getQueue();

    /**
     * 获取job的原始字符串
     * @return string
     */
    public function getRawBody();

}