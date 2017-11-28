<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 12:14
 */

namespace Lenog\Contracts\Filesystem;


interface Factory
{
    /**
     * 获取一个文件系统实例
     * @param string $name
     * @return \Lenog\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}