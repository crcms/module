<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->middleware(['api'])->group(function () {
    Route::prefix('manage')->middleware([])->namespace('CrCms\Module\Http\Controllers\Api\Manage')->group(function(){
        Route::get('modules/attributes/{type?}', 'ModuleController@getAttributes')->where('type', '[A-Za-z_]+');
        Route::resource('modules', 'ModuleController');
    });
});

