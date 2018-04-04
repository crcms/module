<?php

namespace CrCms\Module\Repositories;

use CrCms\Foundation\App\Repositories\AbstractRepository;
use CrCms\Module\Models\ModuleModel;

class ModuleRepository extends AbstractRepository
{
    /**
     * @var array
     */
    protected $guard = ['name', 'sign', 'status', 'namespace'];

    /**
     * @return ModuleModel
     */
    public function newModel(): ModuleModel
    {
        return app(ModuleModel::class);
    }

    /**
     * @return int
     */
    public function updateNamespace(): int
    {
        $namespaces = $this->allNamespace();

        return file_put_contents(config('module.namespace_path'), implode("\n", $namespaces));
    }

    /**
     * @return array
     */
    public function allNamespace(): array
    {
        return $this->all()->map(function (ModuleModel $model) {
            return $model->namespace;
        })->toArray();
    }
}