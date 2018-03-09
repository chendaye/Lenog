<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/6
 * Time: 14:39
 */

namespace Lenog\Support;


class Optional
{
    use Traits\Macroable{
        __call as marcoCall;  //Macroable 中的 __call 方法 取名为 marcoCall 避免重复导致的覆盖
    }

    /**
     * 潜在对象
     *
     * @var
     */
    protected $value;

    /**
     * 创建一个新的可选的 optional实例
     *
     * Optional constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * 自动调用潜在类里的属性
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if(is_object($this->value)) return $this->value->{$name};
    }

    /**
     * 自动传递方法到潜在的类
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if(static::hasMacro($method)){
            return $this->marcoCall($method, $arguments);
        }

        if(is_object($this->value)){
            return $this->value->{$method}(...$arguments);
        }
    }




}