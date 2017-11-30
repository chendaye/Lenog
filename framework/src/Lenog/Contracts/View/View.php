<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 11:22
 */

namespace Lenog\Contracts\View;


interface View
{
    /**
     * 获取视图的名字
     * @return string
     */
    public function name();

    /**
     * 给视图增加一个数据
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function with($key, $value = null);
}