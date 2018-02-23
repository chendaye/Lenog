<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/1
 * Time: 18:05
 */


namespace Lenog\Support\Facades;
use Lenog\Contracts\Foundation\Application;
use Mockery\MockInterface;
use Mockery;
class Facade
{
    /**
     * 门脸化的应用实例
     * @var Application
     */
    protected static $app;

    /**
     * 解析对象实例
     * @var array
     */
    protected static $resolveInstance;

    /**
     * 把facade转化为 伪装对象
     */
    public static function spy()
    {
        if(! static::isMock()){
            //根类名
            $class = static::getMockableClass();

            static::swap($class ? Mockery::spy($class) : Mockery::spy());
        }
    }

    /**
     * 为给定的类擦混关键一个新的 Mock实例
     * @return Mockery\Exception
     */
    public function createFreshMockInstance()
    {
        return tap(static::createMock(), function ($mock){
            static::swap($mock);
            $this->shouldAllowMockingProtectedMethods();
        });
    }

    /**
     * 给类创建一个新的 伪装对象实例
     * @return MockInterface
     */
    public static function createMock()
    {
        //类名
        $class =static::getMockableClass();

        return $class ? Mockery::spy($class) : Mockery::spy();
    }

    /**
     *  Determines whether a mock is set as the instance of the facade.
     * 检查 一个模拟对象是否被设置为一个门脸实例
     * @return bool
     */
    protected static function isMock()
    {
        //注册的组件名称
        $register = static::getFacadeAccessor();
        return isset(static::$resolveInstance[$register]) && static::$resolveInstance[$register] instanceof MockInterface;
    }

    /**
     *获取组件的注册名称  子类中没实现这个方法 默认抛出异常
     * @return  string
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        throw new \RuntimeException("Facade没有实现getFacadeAccessor方法");
    }

    /**
     * 在 fadace 上初始化一个 exception
     * @return \Mockery\Expectation
     */
    public static function shouldReceive()
    {
        //门脸类的类名
        $name = static::getFacadeAccessor();

        $mock = static::isMock() ? static::$resolveInstance[$name] : static::createFreshMockInstance();

        //func_get_args() 获取参数数组
        return $mock->shouldReceive(...func_get_args());

    }


    /**
     * Hotswap背后的底层实例
     * @param $instance
     */
    public static function swap($instance)
    {
        //设置实例
        static::$resolveInstance[static::getFacadeAccessor()] = $instance;

        if(isset(static::$app)) static::$app->instance(static::getFacadeAccessor(), $instance);
    }

    /**
     * 在facade 之后获取root对象
     * @return bool|mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * @return string
     */
    public static function getMockableClass()
    {
        if($root = static::getFacadeRoot()) return get_class($root);
    }

    /**
     * 从容器中解析facade根实例
     * @param string $name
     * @return bool|mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if(is_object($name)) return $name;

        if(isset(static::$resolveInstance[$name])) return static::$resolveInstance[$name];

        return static::$resolveInstance[$name] == static::$app[$name];
    }

    /**
     * 销毁一个门脸实例
     * @param static $name
     */
    public static function clearResolvedInstance($name)
    {
        unset(static::$resolveInstance[$name]);
    }

    /**
     * 清空所有facade实例
     */
    public static function clearResolvedInstances()
    {
        static::$resolveInstance = [];
    }

    /**
     * 获取应用实例
     * @return Application
     */
    public static function getFacadeApplication()
    {
        return static::$app;
    }

    /**
     * @param Application $app
     */
    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }

    /**
     * 静态调用方法
     * @param static $method
     * @param array $args
     */
    public static function __callStatic($method, $args)
    {
        //获取对象实例
        $instance = static::getFacadeRoot();
        //检查对象是否设置
        if(! $instance) throw new \RuntimeException("facade root 没有设置");
        //调用类的方法
        $instance->$method(...$args);
    }

}