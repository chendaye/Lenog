<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/30
 * Time: 17:35
 */


namespace Tests\Support\Debug;


use Lenog\Support\Debug\Dumper;
use PHPUnit\Framework\TestCase;

class DumperTest extends TestCase
{
    public function testDumper()
    {
        $this->expectOutputString('QWER');
        $dump = new Dumper();
        $dump->dump('QWER');
    }
}