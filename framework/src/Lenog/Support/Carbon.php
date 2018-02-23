<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/27
 * Time: 14:41
 */


namespace Lenog\Support;
use JsonSerializable;
use Carbon\Carbon as BaseCarbon;
use Lenog\Support\Traits\Macroable;

class Carbon extends BaseCarbon implements JsonSerializable
{
    use Macroable;

    /**
     * The custom Carbon JSON serializer.
     * @var callable|null
     */
    protected static $serializer;

    /**
     * 准备JSON序列化的对象
     * @return mixed
     */
    public function jsonSerialize()
    {
        if(static::$serializer) {
            return call_user_func(static::$serializer, $this);
        }

        $carbon = $this;

        return call_user_func(function () use ($carbon){
            //get_object_vars — 返回由对象属性组成的关联数组
           return get_object_vars($carbon);
        });
    }

    /**
     *
     * @param $callback
     */
    public static function serializeUsing($callback)
    {
        static::$serializer = $callback;
    }

}