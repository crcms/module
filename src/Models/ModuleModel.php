<?php

namespace CrCms\Module\Models;

use CrCms\Foundation\App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleModel extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @var string
     */
    protected $table = 'modules';

    /**
     * 需要转换成日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $guarded = [];
}