<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->middleware(['api'])->group(function () {
    Route::prefix('manage')->middleware([])->namespace('CrCms\Module\Http\Controllers\Api\Manage')->group(function () {
        Route::get('modules/attributes', 'AttributeController@index')->name('module.attributes.index');
        Route::get('modules/attributes/{id}', 'AttributeController@show')->where('id', '[A-Za-z_]+')->name('module.attributes.show');
        Route::resource('modules', 'ModuleController');
    });
});

