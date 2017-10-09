<?php

namespace CrCms\Module;

use CrCms\Module\Commands\ModuleMakeCommand;
use CrCms\Module\Commands\ModuleRemoveCommand;
use CrCms\Module\Commands\ModuleStatusCommand;
use Illuminate\Support\ServiceProvider;
use Modules\Test\Providers\TestServiceProvider;

//use Modules\Test\Providers\TestServiceProvider;

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

        $this->registerModules();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        //$this->app->singleton('module.make',ModuleMakeCommand::class);
        $this->commands($this->commands);
    }

    /**
     * @return void
     */
    protected function registerModules()
    {
        $this->app->register(TestServiceProvider::class);
        dd(2);
//        dd(TestServiceProvider::class);
        $basePath = config('module.base_path');

        $composers = glob($basePath . DIRECTORY_SEPARATOR . '*/composer.json');

        foreach ($composers as $composer) {
            $currentComposer = json_decode(file_get_contents($composer), true);

            if (isset($currentComposer['extra']['status']) && $currentComposer['extra']['status'] === 1) {
                $providerPath = dirname($composer) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Providers' . DIRECTORY_SEPARATOR;
                $providers = str_replace($providerPath, '', glob($providerPath . '*.php'));

                foreach ($providers as $provider) {
                    $namespace = array_keys($currentComposer['autoload']['psr-4'])[0];
                    //$this->app->register($namespace . 'Providers\\' . str_replace('.php', '', $provider));
                    $this->app->register('Modules\Test\Providers\TestServiceProvider');
                }
            }
        }
    }

    /**
     * @return void
     */
    protected function mergeConfig()
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
        //return [];
    }
}