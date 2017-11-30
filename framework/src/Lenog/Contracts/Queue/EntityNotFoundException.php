<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 12:06
 */


namespace Lenog\Contracts\Queue;
use InvalidArgumentException;

class EntityNotFoundException extends InvalidArgumentException
{
    /**
     * 创建一个新的异常实例
     * EntityNotFoundException constructor.
     * @param string $type
     * @param int $id
     */
    public function __construct($type, $id)
    {
        $id = (string)$id;
        parent::__construct("Queueable entity [{$type}] not found for ID [{$id}].");
    }
}