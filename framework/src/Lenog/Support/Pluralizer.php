<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/6
 * Time: 15:00
 */

namespace Lenog\Support;


use Doctrine\Common\Inflector\Inflector;

class Pluralizer
{
    /**
     * 不可数单词表 word forms.
     *
     * @var array
     */
    public static $uncountable = [
        'audio',
        'bison',
        'chassis',
        'compensation',
        'coreopsis',
        'data',
        'deer',
        'education',
        'emoji',
        'equipment',
        'evidence',
        'feedback',
        'firmware',
        'fish',
        'furniture',
        'gold',
        'hardware',
        'information',
        'jedi',
        'knowledge',
        'love',
        'metadata',
        'money',
        'moose',
        'news',
        'nutrition',
        'offspring',
        'plankton',
        'pokemon',
        'police',
        'rain',
        'rice',
        'series',
        'sheep',
        'software',
        'species',
        'swine',
        'traffic',
        'wheat',
    ];

    /**
     * 复数表单词
     *
     * @param $value
     * @param int $count
     * @return mixed
     */
    public static function plural($value, $count = 2)
    {
        if((int) $count === 1 || static::uncountable($value)){
            return $value;
        }

        $plural = Inflector::pluralize($value);

        return static::matchCase($plural, $value);
    }

    /**
     * 单数表单词
     *
     * @param $value
     * @return mixed
     */
    public static function singular($value)
    {
        $singular = Inflector::singularize($value);

        return static::matchCase($singular, $value);
    }

    /**
     * 检查给定的值是否是不可数的
     *
     * @param $value
     * @return bool
     */
    protected static function uncountable($value)
    {
        return in_array(strtolower($value), static::$uncountable);
    }

    /**
     * 尝试匹配大小写在两个字符串间
     *
     * @param $value
     * @param $comparison
     * @return mixed
     */
    protected static function matchCase($value, $comparison)
    {
        $functions = ['mb_strtolower', 'mb_strtoupper', 'ucfirst', 'ucwords'];

        foreach ($functions as $function){
            if(call_user_func($function, $comparison) === $comparison) {
                return call_user_func($function, $value);
            }
        }

        return $value;
    }


}