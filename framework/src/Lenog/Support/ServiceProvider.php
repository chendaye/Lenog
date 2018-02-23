<?php
/**
 * Created by PhpStorm.
 * User: chendaye
 * Date: 2017/12/6
 * Time: 11:47
 */


namespace Lenog\Support;
use Lenog\Console\Application as Artisan;
use Lenog\Contracts\Foundation\Application;


abstract class ServiceProvider
{
    /**
     * 应用实例
     * @var Application
     */
    protected $app;

    /**
     * 是否延迟加载  provider
     * @var bool
     */
    protected $defer = false;

    /**
     * 应该被公布的路径
     * @var array
     */
    public static $publishes = [];

    /**
     * 应该被公布的一组路径
     * @var array
     */
    public static $publishGroups = [];

    /**
     * ServiceProvider constructor.
     *
     *服务提供者实例
     * @param $app Application
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 将给定的配置安装到已有的配置中
     * @param $path
     * @param $key
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config =$this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge(require $path, $config));
    }

    /**
     * 如果路由没有被缓存加载路由文件
     * @param string $path
     */
    protected function loadRoutesFrom($path)
    {
        if(! $this->app->routesAreCached()) require $path;
    }

    /**
     * 注册视图文件的命名空间
     * @param string $path
     * @param string $namespace
     */
    protected function loadViewFrom($path, $namespace)
    {
        //数组
        if(is_array($this->app->config['view']['paths'])) {
            foreach ($this->app->config['view']['paths'] as $viewPath) {
                //命名空间和路径对应
                if(is_dir($appPath = $viewPath.'/vendor/'.$namespace)) $this->app['view']->addNamespace($namespace, $appPath);
            }
        }
        //字符串
        $this->app['view']->addNamespace($namespace, $path);
    }

    /**
     * 注册translation文件命名空间
     * @param string $path
     * @param string $namespace
     */
    protected function loadTranslationFrom($path, $namespace)
    {
        $this->app['translator']->addNamespace($namespace, $path);
    }

    /**
     * 注册 json translation文件命名空间
     * @param string $path
     */
    protected function loadJsonTranslationFrom($path)
    {
        $this->app['translator']->addJsonPath($path);
    }


    /**
     * 注册数据库migrator 路径
     * @param string|array $paths
     */
    protected function loadMigrationsFrom($paths)
    {
        $this->app->afterResolving('migrator', function ($migrator) use($paths) {
            foreach ((array) $paths as $path) {
                $migrator->path($path);
            }
        });
    }

    /**
     * 注册 publish command. 发布的 路径
     * @param array $paths
     * @param string $group
     */
    protected function publishes(array  $paths, $group = null)
    {
        //确保初始化
        $this->ensurePublishArrayInitialized($class = static::class);

        static::$publishes[$class] = array_merge(static::$publishes[$class], $paths);

        if($group) $this->addPublishGroup($group, $paths);
    }

    /**
     * 确保服务提供者的 publish array 被初始化
     * @param string $class
     */
    protected function ensurePublishArrayInitialized($class)
    {
        //检查键名是否存在于数组中
        if(! array_key_exists($class, static::$publishes)) static::$publishes[$class] = [];
    }

    /**
     * 增加一个共有 group/tag 到 服务提供者
     * @param string $group
     * @param array $paths
     */
    protected function addPublishGroup($group, $paths)
    {
        //初始化
        if(! array_key_exists($group, static::$publishGroups)) static::$publishGroups[$group] = [];

        static::$publishGroups[$group] = array_merge(static::$publishGroups[$group], $paths);
    }

    /**
     * 获取要发布的路径
     * @param string $provider
     * @param string $group
     * @return array
     */
    public static function pathsToPublish($provider = null, $group = null)
    {
        if(! is_null($paths =  static::pathsForProviderAndGroup($provider, $group))) return $paths;

        return collect(static::$publishes)->reduce(function ($paths, $p){
            return array_merge($paths, $p);
        }, []);
    }

    /**
     * 获取 provider 或 group 的路径
     * @param string|null $provider
     * @param string|null $group
     * @return array|mixed
     */
    protected static function pathsForProviderOrGroup($provider, $group)
    {
        if($provider && $group) {
            return static::pathsForProviderAndGroup($provider, $group);
        } elseif ($group && array_key_exists($group, static::$publishGroups)) {
            return static::$publishGroups[$group];
        } elseif ($provider && array_key_exists($provider, static::$publishes)) {
            return static::$publishes[$provider];
        } elseif ($group || $provider) {
            return [];
        }
    }

    /**
     * 得到 provider 和  group 的路径
     * @param string $provider
     * @param string $group
     * @return array
     */
    protected static function pathsForProviderAndGroup($provider, $group)
    {
        if(! empty(static::$publishGroups[$group]) && ! empty(static::$publishes[$provider])) {
            //比较数组键名返回交集
            return array_intersect_key(static::$publishes[$provider], static::$publishGroups[$group]);
        }
        return [];
    }

    /**
     * 获取可用的服务提供者发布
     * @return array
     */
    public static function publishableProviders()
    {
        return array_keys(static::$publishes);
    }

    /***
     * 获取可用的组发布
     * @return array
     */
    public static function publishableGroups()
    {
        return array_keys(static::$publishGroups);
    }

    /**
     * 注册自定义artisan命令
     * @param $commands
     */
    public function commands($commands)
    {
        //func_get_args 返回包含函数的参数列表的数组
        $commands = is_array($commands) ? $commands : func_get_args();

        Artisan::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }

    /**
     * 获取服务提供者
     * @return array
     */
    public function providers()
    {
        return [];
    }

    /**
     * 得到触发这个服务提供者注册的事件
     * @return array
     */
    public function when()
    {
        return [];
    }

    /**
     * 检查服务提供者是否是延迟
     * @return bool
     */
    public function isDeferred()
    {
        return $this->defer;
    }


}