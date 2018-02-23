<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/7
 * Time: 18:36
 */


namespace Lenog\Support;



use Lenog\Support\Traits\Macroable;

class Arr
{
    use Macroable;

    /**
     * 检查给定的值是否 可以以数组访问
     * @param $value
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }

    /**
     * 增加数组元素
     * @param array $array
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public static function add($array, $key, $value)
    {
        if(is_null(static::get($array, $key))){
            static::set($array, $key, $value);
        }

        return $array;
    }


    /**
     *将数组折叠成单个数组
     * @param array $array
     * @return array
     */
    public static function collapse($array)
    {
        $result = [];
        foreach ($array as $value){
            if($value instanceof Collection){
                $value = $value->all();
            } elseif (! is_array($value)) {
                continue;
            }
            $result = array_merge($result, $value);
        }

        return $result;
    }



    /**
     * 按键值 把数组分成2个
     * @param array $array
     * @return array
     */
    public static function divide($array)
    {
        return [
            array_keys($array),
            array_values($array),
        ];
    }

    /**
     * 将多为关联数组压平
     * @param array $array
     * @param string $prepend
     * @return array
     */
    public static function dot($array, $prepend = '')
    {
        $result = [];

        foreach ($array as $key => $val){
            if(is_array($val) && !empty($val)){
                $result = array_merge($result, static::dot($val, $prepend.$key.'.'));
            } else {
                $result[$prepend.$key] = $val;
            }
        }

        return $result;
    }

    /**
     * 获取所有给定数组，除了指定的键数组
     * @param $array
     * @param $keys
     * @return mixed
     */
    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }

    /**
     * 返回数组的第一个元素
     * @param $array
     * @param callable|null $callback
     * @param null $default
     * @return mixed
     */
    public static function first($array, callable $callback = null, $default = null)
    {
        if(is_null($callback)){
            if(empty($array)){
                return value($default);
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if(call_user_func($callback, $value, $key)){
                return $value;
            }
        }

        return value($default);
    }

    /**
     * 获取最后一个元素
     * @param $array
     * @param callable|null $callback
     * @param null $default
     * @return mixed
     */
    public static function last($array, callable $callback = null, $default = null)
    {
        if(is_null($callback)){
            return empty($array) ? value($default) : end($array);
        }

        return static::first(array_reverse($array), $callback, $default);
    }

    /**
     * 将多维数组变为一维数组
     * @param array $array
     * @param int $depth
     * @return array
     */
    public static function flatten($array, $depth = INF)
    {
        return array_reduce($array, function($result, $item) use ($depth) {
            $item = $item instanceof Collection ? $item->all() : $item;

            if(! is_array($item)){
                return array_merge($result, [$item]);
            } elseif ($depth === 1){
                return array_merge($result, array_values($item));
            } else {
                return array_merge($result, static::flatten($item, $depth - 1));
            }
        });
    }

    /**
     * 使用“点”标记从给定数组中删除一个或多个数组项。
     * @param array $array
     * @param $keys
     */
    public static function forget(&$array, $keys)
    {
        $original = &$array;
        $keys = (array)$keys;
        if(count($keys) === 0) return;
        foreach ($keys as $key) {
            if(static::exists($array, $key)){
                unset($array[$key]);
                continue;
            }

            $part = explode('.', $key);
            //clean up before each pass
            $array = &$original;

            while (count($part) > 1) {
                $first = array_shift($part);

                if(isset($array[$first]) && is_array($array[$first])){
                    $array = &$array[$first];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($part)]);
        }
    }



    /**
     * 获取数组元素的值
     * @param array|\ArrayAccess $array
     * @param string|int $key
     * @param null $default
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        //闭包或者值
        if(! static::accessible($array))return value($default);
        //key 为空返回整个数组
        if(is_null($key)) return $array;
        //键值存在返回 值1
        if(static::exists($array, $key)) return $array[$key];
        //key 存在，且非嵌套调用  ?? 相当于三元运算符的简写
        if(strpos($key, '.') === false) return $array[$key] ?? value($default);

        //嵌套调用
        foreach (explode('.', $key) as $segment){
            if(static::accessible($array) && static::exists($array, $segment)){
                //todo；厉害 给数组赋值
                $array = $array[$segment];
            }else{
                return value($default);
            }
        }

        return $array;
    }

    /**
     * 检查数组中是否有给定的键值
     * @param array $array
     * @param string|array $keys
     * @return bool
     */
    public static function has($array, $keys)
    {
        if(is_null($keys)) return false;
        $keys = (array)$keys;
        if(! $array) return false;
        if($keys === []) return false;

        foreach ($keys as $key) {
            $subKeyArray = $array;

            if(static::exists($array, $key)) continue;

            foreach (explode('.', $key) as $segment) {
                if(static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)){
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 确定数组是否具有关联
     *
     * 没有从0开始的顺序数字键值
     * @param array $array
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * 从给定的数组中获取项目的一个子集
     * @param array $array
     * @param array|string $keys
     * @return array
     */
    public static function only($array, $keys){
        //array_intersect_key() 函数使用键名比较计算数组的交集  array_flip — 交换数组中的键和值
        return array_intersect_key($array, array_flip((array)$keys));
    }

    /**
     * 从数组里取出一个数组
     * @param $array
     * @param $value
     * @param null $key
     * @return array|mixed
     */
    public static function pluck($array, $value, $key = null){
        $results = [];
        //list() 函数用于在一次操作中给一组变量赋值。
        list($value, $key) = static::explodePluckParameters($value, $key);

        foreach ($array as $item) {
            $itemValue = data_get($item, $value);

            if(is_null($key)){
                $results[] = $itemValue;
            }else{
                $itemKey = data_get($item, $key);

                if(is_object($itemKey) && method_exists($itemKey, 'toString')){
                    $itemKey = (string)$itemKey;
                }

                $results[$itemKey] = $itemValue;
            }
        }
        return $results;
    }

    public static function explodePluckParameters($value, $key)
    {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $value);

        return [$value, $key];
    }

    /**
     * 在数组的开头追加一个元素
     * @param array $array
     * @param mixed $value
     * @param mixed $key
     * @return array
     */
    public static function prepend($array, $value, $key = null)
    {
        if(is_null($key)){
            //array_unshift() 函数用于向数组插入新元素。新数组的值将被插入到数组的开头
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }
        return $array;
    }

    /**
     * 从数组中获取一个值 并删除
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed
     */
    public static function pull(&$array, $key, $default = null)
    {
        $value = static::get($array, $key, $default);
        static::forget($array, $key);
        return $value;
    }

    /**
     * 从数组里获取一个或者多个随机值
     * @param $array
     * @param null $number
     * @return array|int|null
     */
    public static function random($array, $number = null)
    {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            throw new \InvalidArgumentException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }


        if ((int) $number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array) $keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }


    /**
     * 设置数组的值
     * @param array $array
     * @param static}int $key
     * @param mixed $value
     * @return mixed
     */
    public static function set(&$array, $key, $value)
    {
        //key 为空给整个数组赋值
        if(is_null($key)) $array = $value;
        $keys = explode('.', $key);

        while (count($keys) > 1){
            //删除数组中的第一个元素，并返回被删除元素的值
            $key = array_shift($keys);
            if(! isset($array[$keys]) || ! is_array($array[$key])){
                //键值不存在 创建一个新数组
                $array[$key] = [];
            }
            //最开始指向整个数组  改变 $array 的引用地址指向
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;

        return $array;
    }


    /**
     * shuffle() 函数把数组中的元素按随机顺序重新排列
     * @param $array
     * @return mixed
     */
    public static function shuffle($array)
    {
        shuffle($array);
        return $array;
    }

    /**
     * 用给定的回调函数 或者 "dot" notation 排序数组
     * @param $array
     * @param null $callback
     * @return mixed
     */
    public static function sort($array, $callback = null)
    {
        return Collection::make($array)->sortBy($callback)->all();
    }

    /**
     * 递归地按键和值对数组进行排序。
     * @param $array
     * @return mixed
     */
    public static function sortRecursive($array)
    {
        foreach ($array as &$value) {
            if(is_array($value)){
                $value = static::sortRecursive($value);
            }
        }

        if(static::isAssoc($array)){
            ksort($array);
        }else{
            sort($array);
        }
        return $array;
    }

    /**
     * 检查给定的键值 在数组中是否存在
     * @param array|\ArrayAccess $array
     * @param string|int $key
     * @return bool
     */
    public static function exists($array, $key)
    {
        if($array instanceof \ArrayAccess){
            //偏移量
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }


    /**
     * 如果给定的不是数组 转化成数组
     * @param mixed $value
     * @return array
     */
    public static function wrap($value)
    {
        return ! is_array($value) ? [$value] : $value;
    }
}