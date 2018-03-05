<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/5
 * Time: 15:00
 */

namespace Lenog\Support;


use function GuzzleHttp\Psr7\str;
use Lenog\Contracts\Support\Arrayable;
use Lenog\Contracts\Support\Jsonable;
use Lenog\Contracts\Support\MessageProvider;

class MessageBag implements Arrayable, \Countable, Jsonable, \JsonSerializable, MessageBagContract, MessageProvider
{
    /**
     * 所有注册的信息
     *
     * @var array
     */
    protected $messages = [];

    /**
     * message 输出的默认格式
     *
     * @var string
     */
    protected $format = ':message';

    /**
     * 创建一个新的 message bag 实例
     *
     * MessageBag constructor.
     * @param array $messages
     */
    public function __construct($messages = [])
    {
        foreach ($messages as $key => $value){
            $this->messages[$key] = $value instanceof Arrayable ? $value->toarray() : (array)$value;
        }
    }

    /**
     * 获取 message bag 中的key
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->messages);
    }

    /**
     * 增加信息到 bag里
     *
     * @param $key
     * @param $message
     * @return $this
     */
    public function add($key, $message)
    {
        if($this->isUnique($key, $message)){
            $this->messages[$key][] = $message;
        }

        return $this;
    }

    /**
     * 检查对应的键值对是否存在
     *
     * @param $key
     * @param $message
     * @return bool
     */
    protected function isUnique($key, $message)
    {
        $messages = (array) $this->messages;

        return ! isset($message[$key]) || ! in_array($message, $messages[$key]);
    }

    /**
     * 合并一个新的信息数组
     *
     * @param $messages
     * @return $this
     */
    public function merge($messages)
    {
        if($messages instanceof MessageProvider){
            $messages = $messages->getMessageBag()->getMessages();
        }

        $this->messages = array_merge_recursive($this->messages, $messages);

        return $this;
    }

    /**
     * 检查是否存在给定的键值
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        if(is_null($key)){
            return $this->any();
        }

        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $key){
            if($this->first($key) === ''){
                return false;
            }
        }
        return true;
    }

    /**
     * 对任意给定的键值判断是否存在
     *
     * @param array $keys
     * @return bool
     */
    public function hasAny($keys = [])
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        foreach ($keys as $key){
            if($this->has($key)) return true;
        }

        return false;
    }


    /**
     * 获取bag里的第一个信息
     *
     * @param null $key
     * @param null $format
     * @return mixed
     */
    public function first($key = null, $format = null)
    {
        $messages = is_null($key) ? $this->all($format) : $this->get($key, $format);

        $firstMessage = Arr::first($messages, null, '');

        return is_array($firstMessage) ? Arr::first($firstMessage) : $firstMessage;
    }

    /**
     * 获取所有给定键值信息
     *
     * @param $key
     * @param null $format
     * @return array
     */
     public function get($key, $format = null)
     {
         if(array_key_exists($key, $this->messages)){
             return $this->transform($this->messages[$key], $this->checkFormat($format), $key);
         }

         if(Str::contains($key, '*')){
             return $this->getMessagesForWildcardKey($key, $format);
         }

         return [];
     }

    /**
     * 获取键值 用 通配符键
     *
     * @param $key
     * @param $format
     * @return array
     */
     protected function getMessagesForWildcardKey($key, $format)
     {
         return collect($this->messages)
             ->filter(function($messages, $messageKey) use ($key) {
                 return Str::is($key, $messageKey);
             })
             ->map(function($message, $messageKey) use ($format) {
                 return $this->transform($message, $this->checkFormat($format), $messageKey);
             })->all();
     }


    /**
     * 得到bag所有的信息
     *
     * @param null $format
     * @return array
     */
     public function all($format = null)
     {
         $format = $this->checkFormat($format);

         $all = [];

         foreach ($this->messages as $key => $message){
             $all = array_merge($all, $this->transform($message, $format, $key));
         }

         return $all;
     }

    /**
     * 获取所有唯一的信息从bag中
     *
     * @param null $format
     * @return array
     */
     public function unique($format = null)
     {
         return array_unique($this->all($format));
     }

    /**
     * 格式化bag信息
     *
     * @param $message
     * @param $format
     * @param $messageKey
     * @return array
     */
     public function transform($message, $format, $messageKey)
     {
         return collect((array) $message)
             ->map(function($message) use ($format, $messageKey) {
                 return str_replace([':message', ':key'], [$message, $messageKey], $format);
             })->all();
     }

    /**
     * 基于给定的格式获取合适的格式
     *
     * @param $format
     * @return string
     */
     protected function checkFormat($format)
     {
         return $format ? : $this->format;
     }

    /**
     * 获取原始信息
     *
     * @return array
     */
     public function messages()
     {
         return $this->messages;
     }

    /**
     * 获取原始信息
     *
     * @return array
     */
     public function getMessage()
     {
         return $this->messages();
     }

    /**
     * 获取message 实例
     *
     * @return $this
     */
     public function getMessageBag()
     {
         return $this;
     }

    /**
     * 获取默认格式
     *
     * @return string
     */
     public function getFormat()
     {
         return $this->format;
     }

    /**
     * 设置默认的格式
     *
     * @param string $format
     * @return $this
     */
     public function setFormat($format = ':message')
     {
         $this->format = $format;

         return $this;
     }

    /**
     * 检查是否为空
     *
     * @return bool
     */
     public function isEmpty()
     {
         return ! $this->any();
     }

    /**
     * 检查是否不为空
     *
     * @return mixed
     */
     public function isNotEmpty()
     {
         return $this->any();
     }

    /**
     * 检查是否有信息
     *
     * @return bool
     */
     public function any()
     {
         return $this->count() > 0;
     }

    /**
     * 获取bag的 数量信息
     *
     * @return int
     */
     public function count()
     {
         return count($this->messages, COUNT_RECURSIVE) - count($this->messages);
     }

    /**
     * 获取数组形式的实例
     *
     * @return array
     */
     public function toArray()
     {
         return $this->getMessage();
     }

    /**
     * 转化对象为json序列
     *
     * @return array
     */
     public function jsonSerialize()
     {
         return $this->toArray();
     }

    /**
     * 转化对象为json形式
     *
     * @param int $options
     * @return string
     */
     public function toJson($options = 0)
     {
         return json_encode($this->jsonSerialize(), $options);
     }

    /**
     * 转化对象为json形式
     *
     * @return string
     */
     public function __toString()
     {
         return $this->toJson();
     }
}