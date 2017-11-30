<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 18:56
 */

namespace Lenog\Contracts\Translation;


interface Translator
{
    /**
     * Get the translation for a given key.
     * @param string $key
     * @param array $replace
     * @param string $locale
     * @return mixed
     */
    public function trans($key, array $replace = [], $locale = null);

    /**
     * 根据整型值获取 translation
     * @param string $key
     * @param int|array|\Countable $number
     * @param array $replace
     * @param string $locale
     * @return string mixed
     */
    public function transChoice($key, $number, array $replace = [], $locale);

    /**
     * 获取默认被使用的 locale
     * @return string
     */
    public function getLocale();

    /**
     * 设置默认locale
     * @param string $locale
     * @return void
     */
    public function setLocale($locale);




}