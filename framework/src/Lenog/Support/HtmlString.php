<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/5
 * Time: 12:30
 */

namespace Lenog\Support;


class HtmlString
{
    /**
     * htmlstring
     *
     * @var
     */
    protected $html;

    /**
     * 创建一个HTMLstring实例
     *
     * HtmlString constructor.
     * @param $html
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * 获取HTML字符串
     *
     * @return mixed
     */
    public function toHtml()
    {
        return $this->html;
    }

    /**
     * 获取html字符串
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}