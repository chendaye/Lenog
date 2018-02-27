<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/2/27
 * Time: 16:42
 */

namespace Lenog\Support;


use Lenog\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

class Composer
{
    /**
     * 文件系统实例
     *
     * @var \Lenog\Filesystem\Filesystem
     */
    protected $files;

    /**
     * 工作目录
     *
     * @var string
     */
    protected $workingPath;

    /**
     * 创建一个新的composer管理实例
     *
     * Composer constructor.
     * @param Filesystem $files
     * @param null $workingPath
     */
    public function __construct(Filesystem $files, $workingPath = null)
    {
        $this->files = $files;
        $this->workingPath = $workingPath;
    }

    /**
     * 生成composer自动加载文件
     *
     * @param string $extra
     */
    public function dumpAutoloads($extra = '')
    {
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().'dump-autoload'.$extra));
        $process->run();
    }

    /**
     * 优化自动加载文件
     */
    public function dumpOptimized()
    {
        $this->dumpAutoloads('--optimized');
    }

    /**
     * 获取composer命令
     *
     * @return string
     */
    protected function findComposer()
    {
        if($this->files->exists($this->workingPath.'/composer.phar')){
            return ProcessUtils::escapeArguement((new PhpExecutableFinder)->find(false)).'composer.phar';
        }

        return 'composer';
    }

    /**
     * 获取 Symfony 进程实例
     *
     * @return Process
     */
    protected function getProcess()
    {
        return (new Process('', $this->workingPath))->setTimeout(null);
    }

    /**
     * 设置工作目录
     *
     * @param string $path
     * @return $this
     */
    public function setWorkingPath($path)
    {
        $this->workingPath = realpath($path);

        return $this;
    }

}