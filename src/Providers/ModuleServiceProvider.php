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
}