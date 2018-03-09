<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/5
 * Time: 17:45
 */

namespace Lenog\Support;


class NamespacedItemResolver
{
    /**
     * 缓存解析内容
     *
     * @var array
     */
    protected $parsed = [];

    /**
     * 解析key 为 命名空间 group   item
     *
     * @param $key
     * @return mixed
     */
    public function parseKey($key)
    {
        if(isset($this->parsed[$key])) return $this->parsed[$key];

        if(strpos($key, '::') === false) {
            $segments = explode('.', $key);

            $parsed = $this->parseBasicSegments($segments);
        } else {
            $parsed = $this->parseNamespacedSegments($key);
        }

        return $this->parsed[$key] = $parsed;
    }

    /**
     * 解析一组 basic segment
     *
     * @param array $segment
     * @return array
     */
    protected function parseBasicSegments(array $segment)
    {
        $group = $segment[0];

        $item = count($segment) === 1
            ? null
            : implode('.', array_slice($segment, 1));

        return [null, $group, $item];
    }

    /**
     *解析一组 Namespace segment
     *
     * @param $key
     * @return array
     */
    protected function parseNamespacedSegments($key)
    {
        list($namespace, $item) = explode('::', $key);

        $itemSegments = explode('.', $item);

        $groupAndItem = array_splice($this->parseBasicSegments($itemSegments), 1);

        return array_merge([$namespace], $groupAndItem);
    }

    /**
     * 设置key的解析值
     *
     * @param $key
     * @param $parsed
     */
    public function setParsedKey($key, $parsed)
    {
        $this->parsed[$key] = $parsed;
    }


}