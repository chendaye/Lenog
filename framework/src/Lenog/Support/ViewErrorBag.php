<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/9
 * Time: 17:36
 */

namespace Lenog\Support;


use function GuzzleHttp\Psr7\str;
use Symfony\Component\Translation\MessageCatalogue;

class ViewErrorBag implements \Countable
{
    /**
     * 师徒错误包
     *
     * @var array
     */
    protected $bags = [];

    /**
     * 检查包是否存在
     *
     * @param string $key
     * @return bool
     */
    public function hasBag($key = 'default')
    {
        return isset($this->bags[$key]);
    }

    /**
     * 获取包
     *
     * @param $key
     * @return MessageBag
     */
    public function getBag($key)
    {
        return Arr::get($this->bags, $key) ? : new MessageBag;
    }

    /**
     * Get all bag
     *
     * @return array
     */
    public function getBags()
    {
        return $this->bags;
    }

    /**
     * 增加一个新的 Messagebag 到 bags
     *
     * @param $key
     * @param MessageBagContract $bagContract
     * @return $this
     */
    public function put($key, MessageBagContract $bagContract)
    {
        $this->bags[$key] = $bagContract;

        return $this;
    }

    /**
     * 检查是否为空
     *
     * @return bool
     */
    public function any()
    {
        return $this->count() > 0;
    }

    /**
     * 获取默认包的信息数量
     *
     * @return int
     */
    public function count()
    {
        return $this->getBag('default')->count();
    }

    /**
     * 自动调用默认包的方法
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->getBag('default')->$name(...$arguments);
    }


    /**
     * 自动设置一个错误包
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->put($key, $value);
    }

    /**
     * 转换默认包 为字符串形式
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getBag('default');
    }
}