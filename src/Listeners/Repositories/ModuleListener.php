<?php

namespace CrCms\Module\Listeners\Repositories;

use CrCms\Module\Models\ModuleModel;
use CrCms\Module\Repositories\ModuleRepository;

class ModuleListener
{
    /**
     * @param ModuleRepository $repository
     * @param ModuleModel $model
     */
    public function created(ModuleRepository $repository, ModuleModel $model)
    {
        $repository->updateNamespace();
    }

    /**
     * @param ModuleRepository $repository
     * @param ModuleModel $model
     */
    public function updated(ModuleRepository $repository, ModuleModel $model)
    {
        $repository->updateNamespace();
    }
}