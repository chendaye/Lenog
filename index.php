<?php
require 'vendor/autoload.php';

$dump = new \Lenog\Support\Debug\Dumper();
//$test->dump(\ReflectionMethod::IS_PUBLIC);
//$test->dump(\ReflectionMethod::IS_PROTECTED);
//$test->dump(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED);
//


/**
 * 复制一个闭包，绑定指定的$this对象和类作用域。
 *
 * @author 疯狂老司机
 */
class Animal {
    private static $cat = "cat";
    private $dog = "dog";
    public $pig = "pig";

    public $test = 9;
}

$a = new Animal();


/*
 * 获取Animal类静态私有成员属性
 */
$cat = static function() {
    return Animal::$cat;
};

/*
 * 获取Animal实例私有成员属性
 */
$dog = function() {
    return $this->dog;
};

/*
 * 获取Animal实例公有成员属性
 */
$pig = function() {
    return $this->pig;
};

$test = function() {
    $this->test += 1;
};

$bindTest = Closure::bind($test, $a);

$bindTest();

function set(&$array, $key, $value)
{
    $a = &$array;
    if (is_null($key)) {
        return $array = $value;
    }

    $keys = explode('.', $key);

    while (count($keys) > 1) {
        $key = array_shift($keys);

        if (! isset($array[$key]) || ! is_array($array[$key])) {
            $array[$key] = [];
        }

        $a = &$a[$key];
    }
    $a[array_shift($keys)] = $value;

    return $a;
}


function dot($array, $prepend = '')
{
    $result = [];

    foreach ($array as $key => $val){
        if(is_array($val) && !empty($val)){
            $result = array_merge($result, dot($val, $prepend.$key.'.'));
        } else {
            $result[$prepend.$key] = $val;
        }
    }

    return $result;
}

$arr = [
    'a' => [
        'b' => [
          'c' => [
              'd' => 1324
          ],
        ],
    ],
];

$ret = set($arr, 'a.b.c.d', '79879');

$dump->dump(dot($arr));
$dump->dump($ret);
$dump->dump($arr);

//$bindCat = Closure::bind($cat, null, new Animal());// 给闭包绑定了Animal实例的作用域，但未给闭包绑定$this对象
//$bindCats = Closure::bind($cat, null, Animal::class);// 给闭包绑定了Animal实例的作用域，但未给闭包绑定$this对象
//$bindDog = Closure::bind($dog, new Animal(), 'Animal');// 给闭包绑定了Animal类的作用域，同时将Animal实例对象作为$this对象绑定给闭包
//$bindPig = Closure::bind($pig, new Animal());// 将Animal实例对象作为$this对象绑定给闭包,保留闭包原有作用域
//echo $bindCat(),'<br>';// 根据绑定规则，允许闭包通过作用域限定操作符获取Animal类静态私有成员属性
//echo $bindCats(),'<br>';// 根据绑定规则，允许闭包通过作用域限定操作符获取Animal类静态私有成员属性
//echo $bindDog(),'<br>';// 根据绑定规则，允许闭包通过绑定的$this对象(Animal实例对象)获取Animal实例私有成员属性
//echo $bindPig(),'<br>';// 根据绑定规则，允许闭包通过绑定的$this对象获取Animal实例公有成员属性