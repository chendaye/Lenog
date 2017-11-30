<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 10:06
 */

namespace Lenog\Contracts\Validation;


interface Factory
{
    /**
     * 创建一个新的 Validator 实例
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return \Lenog\Contracts\Validation\Validator
     */
    public function make(array $data, array $rules, array $messages = [], array $customAttributes = []);

    /**
     * 注册一个自定义验证器扩展
     * @param string $rule
     * @param \Closure|string $extension
     * @param string $message
     * @return void
     */
    public function extend($rule, $extension, $message = null);

    /**
     * 注册一个隐式的 验证器 扩展
     * @param string $rule
     * @param string|\Closure $extension
     * @param string $message
     * @return void
     */
    public function extendImplicit($rule, $extension, $message = null);

    /**
     * 注册一个隐式的验证器信息替代者
     * @param string $rule
     * @param \Closure|string $replacer
     * @return void
     */
    public function replacer($rule, $replacer);
}