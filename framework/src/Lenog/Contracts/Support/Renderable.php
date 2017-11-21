<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 14:46
 */

namespace Lenog\Contracts\Support;


interface Renderable
{
    /**
     * 获取对象内容的值
     * @return string
     */
    public function render();
}