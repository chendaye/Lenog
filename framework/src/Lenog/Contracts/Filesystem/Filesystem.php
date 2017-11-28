<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/28
 * Time: 11:36
 */

namespace Lenog\Contracts\Filesystem;


interface Filesystem
{
    /**
     * 可见性设置
     * @var string
     */
    const VISIBILITY_PUBLIC = 'public';

    /**
     * 可见性设置
     * @var string
     */
    const VISIBILITY_PRIVATE = 'private';

    /**
     * 检查文件是否存在
     * @param string $path
     * @return bool
     */
    public function exists($path);

    /**
     * 获取文件内容
     * @param string $path
     * @return string
     *
     * @throws \Lenog\Contracts\Filesystem\FileNotFoundException
     */
    public function get($path);

    /**
     * 向文件中写入内容
     * @param string $path
     * @param string|resource $content
     * @param mixed $options
     * @return bool
     */
    public function put($path, $content, $options = []);

    /**
     * 获取文件可见性
     * @param string $path
     * @return string
     */
    public function getVisibility($path);

    /**
     * 设置文件的可见性
     * @param string $path
     * @param string $visibility
     * @return void
     */
    public function setVisibility($path, $visibility);

    /**
     * 向文件开头追加内容
     * @param string $path
     * @param string $data
     * @return int
     */
    public function prepend($path, $data);

    /**
     * 向文件末尾追加内容
     * @param string $path
     * @param string $data
     * @return int
     */
    public function append($path, $data);

    /**
     * 删除给定的文件
     * @param string|array $paths
     * @return bool
     */
    public function delete($paths);

    /**
     * 复制文件到指定位置
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function copy($from, $to);

    /**移动文件到指定位置
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function move($from, $to);

    /**
     * 获取文件的大小
     * @param string $path
     * @return int
     */
    public function size($path);

    /**
     * 获取文件最近一次修改时间
     * @param string $path
     * @return int
     */
    public function lastModified($path);

    /**
     * 获取文件夹内所有文件
     * @param null|string $directory
     * @param bool $recursive
     * @return array
     */
    public function files($directory = null, $recursive = false);

    /**
     * 递归获取文件夹中的所有文件
     * @param null|string $directory
     * @return array
     */
    public function allFiles($directory = null);

    /**
     * 获取所有文件夹
     * @param null|string $directory
     * @param bool $recursive
     * @return array
     */
    public function directories($directory = null, $recursive = false);

    /**
     * 递归获取所有文件夹
     * @param null|string $directory
     * @return array
     */
    public function allDirectories($directory = null);

    /**
     * 创建一个文件夹
     * @param string $path
     * @return bool
     */
    public function makeDirectory($path);

    /**
     * 递归删除一个文件夹
     * @param string $directory
     * @return bool
     */
    public function deleteDirectory($directory);


}