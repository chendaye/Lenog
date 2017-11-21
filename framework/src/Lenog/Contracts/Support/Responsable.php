<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/21
 * Time: 14:50
 */

namespace Lenog\Contracts\Support;


interface Responsable
{
    /**
     * 创建一个HTTP响应
     * @param \Lenog\Http\Request $request
     * @return \Lenog\Http\Response
     */
    public function toResponse($request);
}