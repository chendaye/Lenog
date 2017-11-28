<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 14:43
 */

namespace Lenog\Contracts\Hashing;


interface Hasher
{
    /**
     * Hash 给定的值
     * @param string $value
     * @param array $options
     * @return string
     */
    public function make($value, array $options = []);

    /**
     * 用hash 值检查一个给定的值
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = []);

    /**
     * 检查值是否用给定的选项进行了hash
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = []);
}