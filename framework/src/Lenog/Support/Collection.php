<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/26
 * Time: 17:07
 */


namespace Lenog\Support;

use stdClass;
use Countable;
use Exception;
use ArrayAccess;
use Traversable;
use ArrayIterator;
use CachingIterator;
use JsonSerializable;
use IteratorAggregate;
use Lenog\Support\Debug\Dumper;
use Lenog\Support\Traits\Macroable;
use Lenog\Contracts\Support\Jsonable;
use Lenog\Contracts\Support\Arrayable;

class Collection implements ArrayAccess,Arrayable,Countable,IteratorAggregate,Jsonable,JsonSerializable
{
    use Macroable;

    /**
     * 包含在集合中的项目
     * @var array
     */
    protected $items = [];

    /**
     * 可以代理的方法
     * @var array
     */
    protected static $proxies = [
        'average', 'avg', 'contains', 'each', 'every', 'filter', 'first', 'flatMap',
        'keyBy', 'map', 'partition', 'reject', 'sortBy', 'sortByDesc', 'sum',
    ];

    /**
     * 创建一个新的 集合
     * Collection constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        $this->items = $this->getArrayableItems($this->items);
    }

    /**
     * 创建一个新的集合实例
     * @param array $items
     * @return static
     */
    public static function make($items = [])
    {
        return new static($items);
    }

    /**
     * 把给定的值变成集合
     * @param $value
     * @return static
     */
    public static function wrap($value)
    {
        return $value instanceof self
            ? new static($value)
            : new static(Arr::wrap($value));
    }

    /**
     * 从给定的集合中获取基础的项
     * @param array|static $value
     * @return array|self
     */
    public static function unwrap($value)
    {
        return $value instanceof self ? $value->all() : $value;
    }

    /**
     * 调用一个回调函数若干次，创建一个新的集合
     * @param int $times
     * @param callable|null $callback
     * @return static
     */
    public static function times($times, callable $callback = null)
    {
        if($times < 1) return new static();
        //range() 函数创建一个包含指定范围的元素的数组
        if(is_null($callback)) return new static(range(1, $times));

        return (new static(range(1, $times)))->map($callback);
    }

    /**
     * 获取集合所有项目
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * 求平均值
     * @param null|string|callable $callback
     * @return float
     */
    public function avg($callback = null)
    {
        if($count = $this->count()) return $this->sum($callback) / $count;
    }

    /**
     * avg 方法的别名
     * @param null|string|callable $callback
     * @return float
     */
    public function average($callback = null)
    {
        return $this->avg($callback);
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function median($key = null)
    {
        $count = $this->count();

        if($count == 0) return;

        $values = (isset($key) ? $this->pluck($key) : $this)->sort()->values();

        $middle = (int) ($count / 2);

        if($count % 2){
            return $values->get($middle);
        }

        return (new static([$values->get($middle - 1), $values->get($middle)]))->average();
    }

    /**
     * 获取给定键的模式
     * @param null $key
     */
    public function mode($key = null)
    {
        $count = $this->count();

        if($count == 0) return;

        $collection = isset($key) ? $this->pluck($key) : $this;

        $counts = new self();

        $collection->each(function($value) use ($counts){
            $counts[$value] = isset($counts[$value]) ? $counts[$value] + 1 : 1;
        });

        $sorted =$counts->sort();

        $heightestValue =$sorted->last();

        return $sorted->filter(function($value) use ($heightestValue){
            return $value = $heightestValue;
        })->sort()->keys()->all();
    }

    /**
     * 集合元素到单个数组
     * @return static
     */
    public function collapse()
    {
        //new static()  就是指当前类 没有层级继承关系
        return new static(Arr::collapse($this->items));
    }


    /**
     * 检查项目是否存在于集合中
     * @param $key
     * @param null $operator
     * @param null $value
     * @return bool
     */
    public function contains($key, $operator = null, $value = null)
    {
        if(func_num_args() == 1){
            if($this->useAsCallable($key)){
                $placeholder = new stdClass();

                return $this->first($key, $placeholder) !== $placeholder;
            }

            return in_array($key, $this->items);
        }

        if(func_num_args() == 2){
            $value = $operator;
            $operator = '=';
        }

        return $this->contains($this->operatorForWhere($key, $operator, $value));
    }

    /**
     * 严格检查项目是否存在于集合中
     * @param $key
     * @param null $value
     * @return bool
     */
    public function containsStrict($key, $value = null)
    {
        if(func_num_args() == 2){
            return $this->contains(function($item) use ($key, $value) {
                return data_get($item, $key) === $value;
            });
        }

        if($this->useAsCallable($key)){
            return ! is_null($this->first($key));
        }

        return in_array($key, $this->items, true);
    }

    /**
     * 交叉连接指定的数组，返回所有可能的排列
     * @param array ...$arrays
     * @return array
     */
    public function crossJoin(...$arrays)
    {
        $result = [[]];
        foreach ($arrays as $index => $array) {
            $append = [];
            foreach ($result as $product) {
                foreach ($array as $item) {
                    //循环数组参数
                    $product[$index] = $item;
                    $append[] = $product;
                }
            }
            $result = $append;
        }
        return $result;
    }


    /**
     * 打印集合
     */
    public function dd()
    {
        dd($this->all());
    }


    /**
     * 输出集合
     * @return $this
     */
    public function dump()
    {
        (new static(func_get_args()))->push($this)
            ->each(function($item){
                (new Dumper())->dump($item);
            });

        return $this;
    }

    /**
     * 得到不在当前给定范围的集合元素
     * @param $items
     * @return static
     */
    public function diff($items)
    {
        //array_diff() 函数返回两个数组的差集数组。该数组包括了所有在被比较的数组中，但是不在任何其他参数数组中的键值
        return new static(array_diff($this->items, $this->getArrayableItems($items)));
    }

    /**
     * 得到 键和值 不在当前给定范围的集合元素
     * @param $items
     * @return static
     */
    public function diffAssoc($items)
    {
        //array_diff_assoc() 函数用于比较两个（或更多个）数组的键名和键值 ，并返回差集。
        return new static(array_diff_assoc($this->items, $this->getArrayableItems($items)));
    }

    /**
     * 比较两个（或更多个）数组的键名 ，并返回差集
     * @param $items
     * @return static
     */
    public function diffKeys($items)
    {
        //array_diff_key() 函数用于比较两个（或更多个）数组的键名 ，并返回差集。
        return new static(array_diff_key($this->items, $this->getArrayableItems($items)));
    }


    /**
     * 用回调函数遍历集合每一个元素
     * @param callable $callback
     * @return $this|bool
     */
    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if($callback($item, $key)) return false;
        }

        return $this;
    }


    /**
     * 用回调函数遍历每一个集合分组
     * @param callable $callback
     * @return bool|Collection
     */
    public function eachSpread(callable $callback)
    {
        return $this->each(function($chunk, $key) use ($callback) {
            $chunk[] = $key;

            return $callback(...$chunk);
        });
    }

    /**
     * 用给定的测试 检查所有集合项目
     * @param $key
     * @param null $operator
     * @param null $value
     * @return bool
     */
    public function every($key, $operator = null, $value = null)
    {
        if(func_num_args() == 1) {
            $callback = $this->valueRetriever($key);

            foreach ($this->items as $k => $v) {
                if(! $callback($v, $k)) return false;
            }

            return true;
        }

        if(func_num_args() == 2){
            $value = $operator;

            $operator = '=';
        }

        return $this->every($this->operatorForWhere($key, $operator, $value));
    }

    /**
     * 排除给定的键值获取其余集合元素
     * @param $keys
     * @return static
     */
    public function except($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        return new static(Arr::except($this->items, $keys));
    }

    /**
     * 用回调函数过滤集合
     * @param callable|null $callback
     * @return static
     */
    public function filter(callable $callback = null)
    {
        if($callback) return new static(Arr::where($this->items, $callback));

        return new static(array_filter($this->items));
    }


    /**
     * 如果值是 真，则应用回调
     * @param $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     */
    public function when($value, callable $callback, callable $default = null)
    {
        if($value){
            return $callback($this);
        } elseif ($default) {
            return $default($this);
        }

        return $this;
    }

    /**
     * 值为假则应用回调
     * @param $value
     * @param callable $callback
     * @param callable|null $default
     * @return Collection
     */
    public function unless($value, callable $callback, callable $default = null)
    {
        return $this->when(! $value, $callback, $default);
    }


    /**
     * 用给定的键值对过滤集合
     * @param $key
     * @param $operate
     * @param null $value
     * @return Collection
     */
    public function where($key, $operate, $value = null)
    {
        if(func_num_args() == 2) {
            $value = $operate;

            $operate = '=';
        }

        return $this->filter($this->operatorForWhere($key, $operate, $value));
    }


    /**
     *Get an operator checker callback.
     * @param $key
     * @param $operate
     * @param $value
     * @return \Closure
     */
    public function operatorForWhere($key, $operate, $value)
    {
        return function ($item) use ($key, $operate, $value) {
            $retrieved = data_get($item, $key);

            try {
                switch ($operate) {
                    default:
                    case '=':
                    case '==':  return $retrieved == $value;
                    case '!=':
                    case '<>':  return $retrieved != $value;
                    case '<':   return $retrieved < $value;
                    case '>':   return $retrieved > $value;
                    case '<=':  return $retrieved <= $value;
                    case '>=':  return $retrieved >= $value;
                    case '===': return $retrieved === $value;
                    case '!==': return $retrieved !== $value;
                }
            } catch (Exception $e) {
                return false;
            }
        };
    }


    /**
     * 过滤集合元素通过严格比较给定的键值对
     * @param $key
     * @param $value
     * @return Collection
     */
    public function whereStrict($key, $value)
    {
        return $this->where($key, '===', $value);
    }

    /**
     * 过滤集合元素通过给定的键值对
     * @param $key
     * @param $values
     * @param bool $strict
     * @return Collection
     */
    public function whereIn($key, $values, $strict = false)
    {
        $values = $this->getArrayableItems($values);

        return $this->filter(function($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    }


    /**
     * 严格比较
     * @param $key
     * @param $values
     * @return Collection
     */
    public function whereInStrict($key, $values)
    {
        return $this->where($key, $values, true);
    }

    /**
     * 不在给定集合的元素
     * @param $key
     * @param $values
     * @param bool $strict
     * @return Collection
     */
    public function whereNotIn($key, $values, $strict = false)
    {
        $values = $this->getArrayableItems($values);

        return $this->reject(function($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    }

    /**
     * 严格比较
     * @param $key
     * @param $value
     * @return Collection
     */
    public function whereNotInStrict($key, $value)
    {
        return $this->whereNotIn($key, $value, true);
    }

    /**
     * Get the first item from the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        return Arr::first($this->items, $callback, $default);
    }


    /**
     * 改为一维数组
     * @param $depth
     * @return static
     */
    public function flatten($depth = INF)
    {
        return new static($this->items, $depth);
    }

    /**
     * 翻转集合元素
     * @return static
     */
    public function flip()
    {
        return new static(array_flip($this->items));
    }

    /**
     * 销毁集合元素
     * @param $keys
     * @return $this
     */
    public function forget($keys)
    {
        foreach ((array)$keys as $key) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * 通过键值获取集合元素
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if($this->offsetExists($key)) return $this->items[$key];

        return value($default);
    }

    /**
     * 用回调函数给集合分组
     * @param $groupBy
     * @param bool $preserveKeys
     * @return static
     */
    public function groupBy($groupBy, $preserveKeys = false)
    {
        $groupBy = $this->valueRetriever($groupBy);
        $results = [];

        foreach ($this->items as $key => $value) {
            $groupKeys = $groupBy($value, $key);

            if(! is_array($groupKeys)) $groupKeys = [$groupKeys];

            foreach ($groupKeys as $groupKey){
                $groupKey = is_bool($groupKey) ? (int)$groupKey : $groupKey;

                if(! array_key_exists($groupKey, $results)){
                    $results[$groupKey] = new static();
                }

                $results[$groupKey]->offsetSet($preserveKeys ? $key : null, $value);
            }
        }

        return new static($results);
    }

    /**
     * @param $keyBy
     * @return static
     */
    public function keyBy($keyBy)
    {
        $keyBy = $this->valueRetriever($keyBy);
        $results = [];

        foreach ($this->items as $key => $item) {
            $resolvedKey = $keyBy($item, $key);

            if(is_object($resolvedKey)) {
                $resolvedKey = (string) $resolvedKey;
            }

            $results[$resolvedKey] = $item;
        }

        return new static($results);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        $keys = is_array($key) ? $key :func_get_args();

        foreach ($keys as $value) {
            if(! $this->offsetExists($value)) return false;
        }

        return true;
    }

    /**
     * 集合变成字符串
     * @param $value
     * @param null $glue
     * @return string
     */
    public function implode($value, $glue = null)
    {
        $first = $this->first();

        if(is_array($first) || is_object($first)){
            return implode($glue, $this->pluck($value)->all());
        }

        return implode($value, $this->items);
    }

    /**
     * 取交集
     * @param $items
     * @return static
     */
    public function intersect($items)
    {
        return new static(array_intersect($this->items, $this->getArrayableItems($items)));
    }

    /**
     * 比较键名 返回交集
     * @param $items
     * @return static
     */
    public function intersectByKeys($items)
    {
        return new static(array_intersect_key($this->items, $this->getArrayableItems($items)));
    }

    /**
     * 检查是否为空
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * 检查是否不为空
     * @return bool
     */
    public function isNotEmpty()
    {
        return ! $this->isEmpty();
    }

    /**
     * 检查给定值是否是可调用的不是字符串
     * @param $value
     * @return bool
     */
    protected function useAsCallable($value)
    {
        return ! is_string($value) && is_callable($value);
    }

    /**
     * 得到键的集合
     * @return static
     */
    public function keys()
    {
        return new  static(array_keys($this->items));
    }

    /**
     * 最后一个元素
     * @param callable|null $callback
     * @param null $default
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        return Arr::last($this->items, $callback, $default);
    }

    /**
     * 获取给定键的值
     * @param $value
     * @param null $key
     * @return static
     */
    public function pluck($value, $key = null)
    {
        return new static(Arr::pluck($this->items, $value, $key));
    }

    /**
     * 对集合的每一项执行回调函数
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = array_keys($this->items);
        //array_map() 函数将用户自定义函数作用到数组中的每个值上，并返回用户自定义函数作用后的带有新值的数组
        $items = array_map($callback, $this->items, $keys);
        //array_combine() 函数通过合并两个数组来创建一个新数组，其中的一个数组是键名，另一个数组的值为键值
        return new static(array_combine($keys, $items));
    }

    /**
     *对每一个 项目块 执行 回调函数
     * @param callable $callback
     * @return Collection
     */
    public function mapSpread(callable $callback)
    {
        return $this->map(function ($chunk, $key) use ($callback){
            $chunk[] = $key;

            return $callback(...$chunk);
        });
    }

    /**
     * Run a dictionary map over the items.
     * 回调函数应该返回一个单一的键值对
     * @param callable $callback
     * @return static
     */
    public function mapToDictionary(callable $callback)
    {
        $dictionary = $this->map($callback)->reduce(function($group, $pair){
            $group[key($pair)][] = reset($pair);
            return $group;
        }, []);

        return new static($dictionary);
    }

    /**
     * Run a grouping map over the items.
     * 回调函数应该返回一个单一的键值对
     * @param callable $callback
     * @return Collection
     */
    public function mapToGroups(callable $callback)
    {
        $group = $this->mapToDictionary($callback);
        return $group->map([$this, 'make']);
    }

    /**
     * 回调函数应该返回一个单一的键值对
     * @param callable $callback
     * @return static
     */
    public function mapWithKeys(callable $callback)
    {
        $result = [];
        foreach ($this->items as $key => $value) {
            $assoc = $callback($value, $key);
            foreach ($assoc as $mapKey => $mapValue){
                $result[$mapKey] = $mapValue;
            }
        }

        return new static($result );
    }

    /**
     * Map a collection and flatten the result by a single level.
     *
     * @param callable $callback
     * @return mixed
     */
    public function flatMap(callable $callback)
    {
        return $this->map($callback)->collapse();
    }

    /**
     * 映射值到类中
     * @param $class
     * @return Collection
     */
    public function mapInto($class)
    {
        return $this->map(function($value, $key) use ($class) {
            return new $class($value, $key);
        });
    }

    /**
     * 获取最大值
     * @param null $callback
     * @return mixed
     */
    public function max($callback = null)
    {
        $callback = $this->valueRetriever($callback);

        return $this->filter(function($value){
            return ! is_null($value);
        })->reduce(function($result, $item) use($callback) {
            $value = $callback($item);

            return is_null($result) || $value > $result ? $value : $result;
        });
    }


    /**
     * 合并集合和给定的元素
     * @param $items
     * @return static
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $this->getArrayableItems($items)));
    }

    /**
     * 创建一个集合 用一个集合做值 来一个集合做键
     * @param mixed $values
     * @return static
     */
    public function combine($values)
    {
        //array_combine() 函数通过合并两个数组来创建一个新数组，其中的一个数组是键名，另一个数组的值为键值
        return new static(array_combine($this->all(), $this->getArrayableItems($values)));
    }

    /**
     * 联合给定的值
     * @param mixed $items
     * @return static
     */
    public function union($items)
    {
        return new static($this->items + $this->getArrayableItems($items));
    }


    /**
     * 获取最小值
     * @param  callable|string|null  $callback
     * @return mixed
     */
    public function min($callback = null)
    {
        $callback = $this->valueRetriever($callback);

        return $this->filter(function ($value) {
            return ! is_null($value);
        })->reduce(function ($result, $item) use ($callback) {
            $value = $callback($item);

            return is_null($result) || $value < $result ? $value : $result;
        });
    }

    /**
     * 每多少个元素创建一个新的集合
     * @param $step
     * @param int $offset
     * @return static
     */
    public function nth($step, $offset = 0)
    {
        $new = [];
        $position = 0;
        foreach ($this->items as $item){
            if($position % $step === $offset) {
                $new[] = $item;
            }
            $position ++;
        }

        return new static($new);
    }

    /**
     * 获取指定的元素
     * @param $keys
     * @return static
     */
    public function only($keys)
    {
        if(is_null($keys)) return new static($this->items);

        $keys = is_array($keys) ? $keys : func_get_args();

        return new static(Arr::only($this->items, $keys));
    }

    /**
     * 把集合分片
     * @param $page
     * @param $perPage
     * @return mixed
     */
    public function forPage($page, $perPage)
    {
        $offset = max(0, ($page - 1) * $perPage);

        return $this->slice($offset, $perPage);
    }


    /**
     * 区分集合为2个数组 用给定的回调函数或 keys
     * @param $callback
     * @return static
     */
    public function partition($callback)
    {
        $partition = [new static(), new static()];

        $callback = $this->valueRetriever($callback);

        foreach ($this->items as $key => $item) {
            $partition[(int) ! $callback($item, $key)][$key] = $item;
        }

        return new static($partition);
    }


    /**
     * 传递一个集合到给定的回调函数 并返回值
     * @param callable $callback
     * @return mixed
     */
    public function pipe(callable $callback)
    {
        return $callback($this);
    }

    /**
     * 获取并且删除集合的最后一个元素
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }


    /**
     * 在集合前面追加值
     * @param mixed $value
     * @param null|mixed $key
     * @return $this
     */
    public function prepend($value, $key = null)
    {
        $this->items = Arr::prepend($this->items, $value, $key);
        return $this;
    }

    /**
     * 在集合的末尾追加元素
     * @param $value
     * @return $this
     */
    public function push($value)
    {
        $this->offsetSet(null, $value);

        return $this;
    }

    /**
     * 推送所有给定的元素到集合
     * @param \Traversable $source
     * @return static
     */
    public function concat($source)
    {
        $result = new static($this);

        foreach ($source as $item){
            $result->push($item);
        }

        return $result;
    }

    /**
     * 从集合中获取并且删除元素
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        return Arr::pull($this->items, $key, $default);
    }


    /**
     * 在集合中设置一个元素
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function put($key, $value)
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    /**
     * 随机获取具体数量的集合成员
     * @param null $number
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function random($number = null)
    {
        if (is_null($number)) {
            return Arr::random($this->items);
        }

        return new static(Arr::random($this->items, $number));
    }

    /**
     *将集合化为单一值
     * @param callable $callback
     * @param null $initial
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        //array_reduce() 函数向用户自定义函数发送数组中的值，并返回一个字符串  用回调函数迭代地将数组简化为单一的值
        return array_reduce($this->items, $callback, $initial);
    }


    /**
     * 获取没有通过测试的所有集合元素
     * @param $callback
     * @return Collection
     */
    public function reject($callback)
    {
        if($this->useAsCallable($callback)){
            return $this->filter(function($value, $key) use ($callback){
                return ! $callback($value, $key);
            });
        }

        return $this->filter(function($item) use ($callback) {
            return $item != $callback;
        });
    }

    /**
     * 反序集合元素
     * @return static
     */
    public function reverse()
    {
        //array_reverse() 函数以相反的元素顺序返回数组
        return new static(array_reverse($this->items, true));
    }

    /**
     * 在集合中查找元素
     * @param $value
     * @param bool $strict
     * @return bool|int|mixed|string
     */
    public function search($value, $strict = false)
    {
        if(! $this->useAsCallable($value)){
            return array_search($value, $this->items, $strict);
        }

        foreach ($this->items as $key => $item) {
            if(call_user_func($value, $item, $key)) return $key;
        }

        return false;
    }

    /**
     * 删除数组中第一个元素，并返回被删除元素的值
     * @return mixed
     */
    public function shift()
    {
        //array_shift() 函数删除数组中第一个元素，并返回被删除元素的值。
        return array_shift($this->items);

    }

    /**
     * 打乱集合顺序
     * @param null $seed
     * @return static
     */
    public function shuffle($seed = null)
    {
        $items = $this->items;

        if (is_null($seed)) {
            //shuffle() 函数把数组中的元素按随机顺序重新排列
            shuffle($items);
        } else {
            //srand() 函数播下随机数发生器种子
            srand($seed);
            ////usort() 通过用户自定义的比较函数对数组进行排序
            usort($items, function () {
                return rand(-1, 1);
            });
        }

        return new static($items);
    }

    /**
     * 集合元素分片
     * @param $offset
     * @param null $length
     * @return static
     */
    public function slice($offset, $length = null)
    {
        //array_slice() 函数在数组中根据条件取出一段值，并返回
        return new static(array_slice($this->items, $offset, $length, true));
    }



    /**
     * 切分集合
     * @param int $numberOfGroups
     * @return static
     */
    public function split($numberOfGroups)
    {
        if($this->isEmpty()) return new static();

        $groupSize = ceil($this->count() / $numberOfGroups);

        return $this->chunk($groupSize);
    }

    /**
     * 集合分组
     * @param $size
     * @return static
     */
    public function chunk($size)
    {
        if($size < 0) return new static();

        $chunks = [];

        foreach (array_chunk($this->items, $size, true) as $chunk){
            $chunks[] = new static($chunk);
        }

        return new static($chunks);
    }

    /**
     * 集合排序
     * @param callable|null $callback
     * @return static
     */
    public function sort(callable $callback = null)
    {
        $items = $this->items;

        //uasort() 函数使用用户自定义的比较函数对数组排序，并保持索引关联（不为元素分配新的键）。
        //asort() 函数对关联数组按照键值进行升序排序
        $callback ? uasort($items, $callback) : asort($items);

        return new static($items);
    }

    /**
     * 排序
     * @param $callback
     * @param int $options
     * @param bool $descending
     * @return static
     */
    public function sortBy($callback, $options = SORT_REGULAR, $descending = false)
    {
        $results = [];
        $callback = $this->valueRetriever($callback);

        //回调函数处理集合元素 获取排序值
        foreach ($this->items as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        //排序  arsort asort 按照键值进行
        $descending ? arsort($results, $options) : asort($results, $options);

        //用排好的 key 在获取对应的原集合中的值 达到排序的目的
        foreach (array_keys($results) as $key) {
            $results[$key] = $this->items[$key];
        }

        return new static($results);
    }

    /**
     * 倒序排列
     * @param $callback
     * @param int $options
     * @return Collection
     */
    public function sortByDesc($callback, $options = SORT_REGULAR){
        return $this->sortBy($callback, $options = SORT_REGULAR, true);
    }

    /**
     * 将底层集合数组的一部分拼接起来
     * @param $offset
     * @param null $length
     * @param array $replacement
     * @return static
     */
    public function splice($offset, $length = null, $replacement = [])
    {
        //func_num_args() 函数参数个数
        //array_splice() 函数从数组中移除选定的元素，并用新元素取代它。该函数也将返回包含被移除元素的数组
        if(func_num_args() == 1) return new static(array_splice($this->items, $offset));

        return new static(array_splice($this->items, $offset, $length, $replacement));
    }


    /**
     * 集合求和
     * @param null $callback
     * @return float|int|mixed
     */
    public function sum($callback = null)
    {
        if(is_null($callback)) return array_sum($this->items);

        $callback = $this->valueRetriever($callback);

        return $this->reduce(function($result, $item) use ($callback) {
            return $result + $callback($item);
        }, 0);
    }


    /**
     * 获取集合前几项或者最后几项
     * @param $limit
     * @return Collection
     */
    public function take($limit)
    {
        if($limit < 0){
            //abs() 函数返回一个数的绝对值
            return $this->slice($limit, abs($limit));
        }

        return $this->slice(0, $limit);
    }

    /**
     * 将集合传递给给定的回调，然后返回它。
     * @param callable $callback
     * @return $this
     */
    public function tab(callable $callback)
    {
        $callback(new static($this->items));

        return $this;
    }

    /**
     * 用回调函数对集合的每一项进行转换
     * @param callable $callback
     * @return $this
     */
    public function transform(callable $callback)
    {
        $this->items = $this->map($callback)->all();

        return $this;
    }

    /**
     * 集合元素去重
     * @param null $key
     * @param bool $strict
     * @return Collection|static
     */
    public function unique($key = null, $strict = false)
    {
        if(is_null($key)) return new static(array_unique($this->items, SORT_REGULAR));

        $callback = $this->valueRetriever($key);

        $exist = [];

        return $this->reject(function ($item, $key) use ($callback, $strict, &$exist) {
            if(in_array($id = $callback($item, $key), $exist, $strict)){
                return true;
            }
            $exist[] = $id;
        });
    }

    /**
     * 集合元素去重严格比较
     * @param null $key
     * @return Collection
     */
    public function uniqueStrict($key = null)
    {
        return $this->unique($key, true);
    }

    /**
     * 重置底层数组键值
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->items));
    }


    /**
     * 获取一个值检索回调
     * @param $value
     * @return \Closure
     */
    protected function valueRetriever($value)
    {
        if($this->useAsCallable($value)) return $value;

        return function ($item) use($value){
            return data_get($item, $value);
        };
    }

    /**
     *用一个或多个数组将集合压缩到一起
     * new Collection([1, 2, 3])->zip([4, 5, 6]);
     *      => [[1, 4], [2, 5], [3, 6]]
     * @param $items
     * @return static
     */
    public function zip($items)
    {
        $arrayableItems = array_map(function ($items){
            return $this->getArrayableItems($items);
        }, func_get_args());

        $params = array_merge([
            function(){
            return new static(func_get_args());
            },
            $this->items,
        ], $arrayableItems);

        return new static(call_user_func_array('array_map', $params));
    }

    /**
     * 将集合集合到指定长度并具有一个值
     * @param $size
     * @param $value
     * @return static
     */
    public function pad($size, $value)
    {
        return new static(array_pad($this->items,$size, $value));
    }

    /**
     * 以数组形式获取集合的值
     * @return array
     */
    public function toArray()
    {
        //array_map() 函数将用户自定义函数作用到数组中的每个值上，并返回用户自定义函数作用后的带有新值的数组
        return array_map(function ($value){
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->items);
    }

    /**
     * 把对象转化成json序列
     * @return array
     */
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if($value instanceof JsonSerializable){
                return $value->jsonSerialize();
            } elseif ($value instanceof Jsonable){
                return json_encode($value->toJson(), true);
            }elseif ($value instanceof Arrayable){
                return $value->toArray();
            } else {
                return $value;
            }
        }, $this->items);
    }

    /**
     * 以json形式获取集合的值
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * 获取元素的迭代器
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * 获取 CachingIterator 的实例
     * @param int $flags
     * @return CachingIterator
     */
    public function getCachingIterator($flags = CachingIterator::CALL_TOSTRING)
    {
        return new CachingIterator($this->getIterator(), $flags);
    }

    /**
     * 集合元素的个数
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * 在现有集合基础上获取实例
     * @return Collection
     */
    public function toBase()
    {
        return new self($this);
    }


    /**
     * 判断键值是否存在
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * 通过键获取值
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * 设置集合元素
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if(is_null($offset)){
            $this->items[] = $value;
        }else{
            $this->items[$offset] = $value;
        }
    }


    /**
     * 销毁给定的键值
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * 集合转化为字符串
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }



    /**
     * 从集合或数组中获得的项的数组
     * @param $items
     * @return array|mixed|string
     */
    public function getArrayableItems($items)
    {
        if(is_array($items)){
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_encode($items->toJson(), true);
        } elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array)$items;
    }


    /**
     * Add a method to the list of proxied methods.
     * @param $method
     */
    public function proxy($method)
    {
        static::$proxies[] = $method;
    }

    /**
     * 自动获取属性
     * @param $key
     * @return HigherOrderCollectionProxy
     * @throws Exception
     */
    public function __get($key)
    {
        if(! in_array($key, static::$proxies)) {
            throw new Exception("当前集合不存在 [{$key}] 属性");
        }

        return new HigherOrderCollectionProxy($this, $key);
    }

}




















