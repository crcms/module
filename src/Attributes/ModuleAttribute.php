<?php

namespace CrCms\Module\Attributes;

use CrCms\AttributeContract\AbstractAttributeContract;

/**
 * Class ModuleAttribute
 * @package CrCms\Module\Attributes
 */
class ModuleAttribute extends AbstractAttributeContract
{
    /**
     *
     */
    const STATUS_UNDEFINED = 0;

    /**
     *
     */
    const STATUS_ENABLE = 1;

    /**
     *
     */
    const STATUS_HIDDEN = 2;

    /**
     *
     */
    const STATUS_DISABLE = 3;

    /**
     *
     */
    const KEY_STATUS = 'status';

    /**
     * @return array
     */
    protected function attributes(): array
    {
        return [
            static::KEY_STATUS => [
                static::STATUS_UNDEFINED => trans('module::lang.status.undefined'),
                static::STATUS_ENABLE => trans('module::lang.status.enable'),
                static::STATUS_HIDDEN => trans('module::lang.status.hidden'),
                static::STATUS_DISABLE => trans('module::lang.status.disable')
            ]
        ];
    }
}