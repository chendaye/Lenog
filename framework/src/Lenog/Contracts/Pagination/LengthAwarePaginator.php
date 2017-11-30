<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/29
 * Time: 11:22
 */

namespace Lenog\Contracts\Pagination;


interface LengthAwarePaginator extends Paginator
{
    /**
     * 给分页的url创建一个范围
     * @param int $start
     * @param int $end
     * @return array
     */
    public function getUrlRange($start, $end);

    /**
     * 检查存储条目的总数
     * @return int
     */
    public function total();

    /**
     * 获取可用的最后一页
     * @return int
     */
    public function lastPage();

}