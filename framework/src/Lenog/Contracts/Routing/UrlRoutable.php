<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 17:42
 */

namespace Lenog\Contracts\Routing;


interface UrlRoutable
{
    /**
     * 获取 model 的 key 值
     * @return string
     */
    public function getRouteKey();

    /**
     * 获取 model 的 route key
     * @return string
     */
    public function getRouteKeyName();

    /**
     * 给绑定的值检索模型
     * @param mixed $value
     * @return \Lenog\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value);
}