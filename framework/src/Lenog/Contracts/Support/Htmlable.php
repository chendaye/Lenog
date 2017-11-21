<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 12:29
 */

namespace Lenog\Contracts\Support;

interface Htmlable
{
    /**
     * 把字符串转成HTML格式
     * @return mixed
     */
    public function toHtml();
}