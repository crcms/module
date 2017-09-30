<?php

namespace CrCms\Module;

use CrCms\Module\Commands\ModuleMakeCommand;
use CrCms\Module\Commands\ModuleRemoveCommand;
use CrCms\Module\Commands\ModuleStatusCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelServiceProvider
 *
 * @package CrCms\ElasticSearch
 * @author simon
 */
class LaravelServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $packagePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

    /**
     * @var array
     */
    protected $commands = [
        ModuleMakeCommand::class,
        ModuleRemoveCommand::class,
        ModuleStatusCommand::class,
    ];

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->packagePath . 'config' => config_path(),
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        //merge config
        $this->mergeConfig();

        //register commands
        $this->registerCommands();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands($this->commands);
    }

    /**
     * @return void
     */
    protected function  mergeConfig()
    {
        $configFile = $this->packagePath . 'config/module.php';
        if (file_exists($configFile)) {
            $this->mergeConfigFrom($configFile, 'module');
        }
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return $this->commands;
    }
}