<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/24
 * Time: 17:36
 */

namespace Lenog\Contracts\Auth;


interface SupportsBasicAuth
{
    /**
     * 用HTTP基本身份验证 进行 验证
     * @param string $field
     * @param array $extraConditions
     * @return  \Symfony\Component\HttpFoundation\Response|null
     */
    public function basic($field = 'email', $extraConditions = []);

    /**
     * 执行一次无状态的http 登陆尝试
     * @param string $field
     * @param array $extraConditions
     * @return  \Symfony\Component\HttpFoundation\Response|null
     */
    public function onceBasic($field = 'email', $extraConditions = []);
}