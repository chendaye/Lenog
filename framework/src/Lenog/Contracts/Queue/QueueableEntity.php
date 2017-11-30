<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 15:13
 */

namespace Lenog\Contracts\Queue;


interface QueueableEntity
{
    /**
     * 为该实体获取可排队的标识
     * @return string|null
     */
    public function getQueueableId();

    /**
     * 为实体获取连接
     * @return string|null
     */
    public function getQueueableConnection();
}