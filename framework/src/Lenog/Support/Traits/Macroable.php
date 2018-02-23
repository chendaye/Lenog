<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/7
 * Time: 18:38
 */

namespace Lenog\Support\Traits;


use \BadMethodCallException;
use Closure;

/**
 * 在一般编程中，我们要扩展一个基础类，我们需要进行继承才能扩充。然而Laravel利用PHP的特性，
 * 编写了一套叫做Macroable的Traits，这样，凡是使用Macroable的类，都是可以使用这个方法扩充的
 *
 *
 * Trait Macroable
 * @package Lenog\Support\Traits
 */
trait Macroable
{
    /**
     * 注册字符串宏
     * @var array
     */
    protected static $macros = [];

    /**
     * 注册自定义宏
     * @param string $name
     * @param object}callable $macro
     */
    public static function macros($name, $macro)
    {
        static::$macros[$name] = $macro;
    }

    /**
     * 将另一个对象混合到类中
     * @param $mixin
     */
    public static function mixin($mixin)
    {
        $methods = (new \ReflectionClass($mixin))->getMethods(
            \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            $method->setAccessable(true);
            //反射方法invoke 第一个参数要调用该方法的对象。对于静态方法，将null传递 给此参数
            //第二个参数  将零个或多个参数传递给方法。它接受传递给方法的可变数量的参数
            static::macros($method->name, $method->invoke($mixin));
        }
    }

    /**
     * 检查 macros 是否被注册
     * @param string $name
     * @return bool
     */
    public static function hasMacro($name)
    {
        return isset(static::$macros[$name]);
    }

    /**
     * 动态处理类的调用
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if(! static::$macros[$method]){
            throw new BadMethodCallException("方法 {$method}  不存在！");
        }

        if(static::$macros[$method] instanceof Closure){
            //闭包绑定对象 并调用
            return call_user_func_array(Closure::bind(static::$macros[$method], null, static::class) ,$arguments);
        }

        return call_user_func_array(static::$macros[$method], $arguments);
    }

    /**
     * 自动处理类的调用
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if(! static::hasMacro($method)){
            throw new \BadMethodCallException("方法 {$method} 不存在！");
        }

        $macro = static::$macros[$method];

        if($macro instanceof Closure){
            //闭包绑定当前对象
            return call_user_func_array($macro->bindTo($this, static::class), $arguments);
        }

        return call_user_func_array($macro, $arguments);
    }


}