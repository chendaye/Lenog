<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/27
 * Time: 18:12
 */


namespace Lenog\Contracts\Database;


class ModelIdentifier
{
    /**
     * model 类的名称
     * @var string
     */
    public $class;

    /**
     * model 类的唯一标识
     * 可能是单个id 或者是一组id
     * @var mixed
     */
    public $id;

    /**
     * model  的链接名称
     * @var string|null
     */
    public $connection;

    /**
     * ModelIdentifier constructor.
     * @param string $class
     * @param mixed $id
     * @param mixed $connection
     */
    public function __construct($class, $id, $connection)
    {
        $this->class = $class;
        $this->id = $id;
        $this->connection = $connection;
    }
}