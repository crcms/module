<?php

namespace CrCms\Module;

use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelServiceProvider
 *
 * @package CrCms\Module
 * @author simon
 */
class LaravelServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $packagePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

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
}