<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 10:42
 */

namespace Lenog\Contracts\Pagination;


interface Paginator
{
    /**
     * 给指定的页面生成url
     * @param int $page
     * @return string
     */
    public function url($page);

    /**
     * 增加查询参数到url
     * @param array|string $key
     * @param string|null $value
     * @return string
     */
    public function appends($key, $value = null);

    /**
     * 将url片段附加到url上
     * @param null|string $fragment
     * @return $this|string
     */
    public function fragment($fragment = null);

    /**
     * 获取下一个分页的url
     * @return string
     */
    public function nextPageUrl();

    /**
     * 获取前一个分页url
     * @return string
     */
    public function previousPageUrl();

    /**
     * 获取被分页的所有项
     * @return array
     */
    public function items();

    /**
     * 获取被分页的第一项
     * @return int
     */
    public function firstItem();

    /**
     * 获取分页的最后一项
     * @return int
     */
    public function lastItem();

    /**
     * 检查每页有多少项显示
     * @return int
     */
    public function prePage();

    /**
     * 检查当前页面的分页
     * @return int
     */
    public function currentPage();

    /**
     * 检查是否有足够的项目分成多个页面
     * @return bool
     */
    public function hasPages();

    /**
     * 确定数据存储中是否有更多的项
     * @return bool
     */
    public function hasMorePages();

    /**
     * 检查项目是否为空
     * @return bool
     */
    public function isEmpty();

    /**
     * 检查项目是否不为空
     * @return bool
     */
    public function isNotEmpty();

    /**
     * 用给定的视图渲染分页
     * @param null|string $view
     * @param array $data
     * @return string
     */
    public function render($view = null, $data = []);
}