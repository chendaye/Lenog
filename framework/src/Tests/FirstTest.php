<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/11/1
 * Time: 11:18
 */


namespace Tests;
use PHPUnit\Framework\TestCase;
use Dragon\UnitTest;

/**
 * 第一个单元测试
 * Class first_test
 * @package Tests
 */
class FirstTest  extends TestCase
{
    public function testgetFirst()
    {
        $unitTest = new UnitTest();
        $this->assertEquals('first unit test', $unitTest->unit_test());
    }

    public function testtwo()
    {
        $unitTest = new UnitTest();
        $this->assertEquals('first unit tests', $unitTest->unit_test());
    }

    public function first()
    {
        echo 777;
    }
}