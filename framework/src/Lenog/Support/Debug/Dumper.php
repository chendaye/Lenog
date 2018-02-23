<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 17:22
 */


namespace Lenog\Support\Debug;


use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Dumper
{
    /**
     * 格式化的输出一个值
     * @param mixed $value
     */
    public function dump($value)
    {
        if(class_exists(CliDumper::class)){
            //运行环境检测
            $dumper = in_array(PHP_SAPI, ['cli', 'phpdbg']) ? new CliDumper() : new HtmlDumper();

            $dumper->dump((new VarCloner())->cloneVar($value));
        }else{
            var_dump($value);
        }
    }
}