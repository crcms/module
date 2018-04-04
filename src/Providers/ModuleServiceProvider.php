<?php

namespace CrCms\Module\Providers;

use CrCms\Foundation\App\Providers\ModuleServiceProvider as BaseModuleServiceProvider;
use CrCms\Module\Listeners\Repositories\ModuleListener;
use CrCms\Module\Repositories\ModuleRepository;

/**
 * Class ModuleServiceProvider
 * @package CrCms\Module\Providers
 */
class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * @var string
     */
    protected $basePath = __DIR__ . '/../../';

    /**
     * @var string
     */
    protected $name = 'module';

    /**
     * @return void
     */
    protected function repositoryListener(): void
    {
        ModuleRepository::observer(ModuleListener::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        $this->publishes([
            $this->basePath . 'config/config.php' => config_path("{$this->name}.php"),
            $this->basePath . 'resources/lang' => resource_path("lang/vendor/{$this->name}"),
        ]);
    }

    /**
     * @return void
     */
    public function register(): void
    {
        parent::register(); // TODO: Change the autogenerated stub

        $this->loadPackages();
    }

    /**
     * @return void
     */
    protected function loadPackages(): void
    {
        $file = $this->app['config']->get('module.namespace_path');

        if (!file_exists($file)) {
            return ;
        }

        foreach (file($file) as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }
}