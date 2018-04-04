<?php

namespace CrCms\Module\Http\Controllers\Api\Manage;

use CrCms\Foundation\App\Http\Controllers\Controller;
use CrCms\Foundation\App\Http\Controllers\Traits\AttributeTrait;
use CrCms\Module\Attributes\ModuleAttribute;
use CrCms\Module\Http\Requests\Module\StoreRequest;
use CrCms\Module\Http\Requests\Module\UpdateRequest;
use CrCms\Module\Http\Resources\ModuleResource;
use CrCms\Module\Repositories\ModuleRepository;

class ModuleController extends Controller
{
    use AttributeTrait;

    /**
     * ModuleController constructor.
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(ModuleRepository $moduleRepository)
    {
        parent::__construct();
        $this->repository = $moduleRepository;
        $this->attributeClassName = ModuleAttribute::class;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $models = $this->repository->all();
        return $this->response->collection($models, ModuleResource::class);
    }

    /**
     * @param StoreRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreRequest $request)
    {
        $model = $this->repository->create($request->all());

        return $this->response->resource($model, ModuleResource::class);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateRequest $request,int $id)
    {
        $model = $this->repository->update($request->all(), $id);

        return $this->response->resource($model, ModuleResource::class);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(int $id)
    {
        $row = $this->repository->delete(intval($id));
        return $this->response->noContent();
    }
}