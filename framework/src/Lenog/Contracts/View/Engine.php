<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 10:42
 */

namespace Lenog\Contracts\View;


interface Engine
{
    /**
     * 获取视图内容
     * @param string $path
     * @param array $data
     * @return string
     */
    public function get($path, array $data = []);


}