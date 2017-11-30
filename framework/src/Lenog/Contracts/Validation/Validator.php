<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 10:25
 */

namespace Lenog\Contracts\Validation;


use Lenog\Contracts\Support\MessageProvider;

interface Validator extends MessageProvider
{
    /**
     * 检查数据是否没有通过验证
     * @return bool
     */
    public function fails();

    /**
     * 获取失败的验证规则
     * @return array
     */
    public function failed();

    /**
     * 基于闭包增加条件到一个给定的字段
     * @param string $attribute
     * @param array|string $rules
     * @param callable $callback
     * @return $this
     */
    public function sometimes($attribute, $rules, callable $callback);

    /**
     * 经过验证后回调
     * @param callable|string $callback
     * @return $this
     */
    public function after($callback);

    /**
     * 得到所有的错误验证信息
     * @return MessageProvider
     */
    public function errors();
}