<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 15:04
 */

namespace Lenog\Contracts\Queue;


interface QueueableCollection
{
    /**
     * 获取放在队列中的类型实体
     * @return string|null
     */
    public function getQueueableClass();

    /**
     * 得到所有实体的ID
     * @return array
     */
    public function getQueueableId();

    /**
     * 获取队列中实体的连接
     * @return string|null
     */
    public function getQueueableConnection();
}