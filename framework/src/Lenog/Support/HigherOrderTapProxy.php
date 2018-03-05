<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/5
 * Time: 12:21
 */

namespace Lenog\Support;


class HigherOrderTapProxy
{
    /**
     * 被触发的目标
     *
     * @var
     */
    public $target;


    /**
     * 初始化target
     *
     * HigherOrderTapProxy constructor.
     * @param $target
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * 自动调用target方法
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $this->target->{$name}(...$arguments);

        return $this->target;
    }

}