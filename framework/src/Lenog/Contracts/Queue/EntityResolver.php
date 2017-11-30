<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 12:11
 */

namespace Lenog\Contracts\Queue;


interface EntityResolver
{
    /**
     * 为给定的ID解析实体
     * @param string $type
     * @param $id
     * @return mixed
     */
    public function resolver($type, $id);
}