<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2018-04-16 18:14
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Module\Http\Resources;

use CrCms\Foundation\App\Http\Resources\Resource;
use CrCms\Module\Attributes\ModuleAttribute;
use Illuminate\Support\Arr;

/**
 * Class AttributeResource
 * @package CrCms\Module\Http\Resources
 */
class AttributeResource extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $all = [
            'status' => ModuleAttribute::getStaticTransform(ModuleAttribute::KEY_STATUS),
        ];

        return $this->resource ? Arr::only($all, $this->resource) : $all;
    }
}