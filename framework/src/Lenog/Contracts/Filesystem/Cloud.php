<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 12:12
 */

namespace Lenog\Contracts\Filesystem;


interface Cloud extends Filesystem
{
    /**
     * 获取给定路径上文件的URL
     * @param string $path
     * @return mixed
     */
    public function url($path);
}