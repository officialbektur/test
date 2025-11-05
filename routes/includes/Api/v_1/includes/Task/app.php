<?php

use App\Http\Controllers\Api\V_1\Task\DestroyController;
use App\Http\Controllers\Api\V_1\Task\IndexController;
use App\Http\Controllers\Api\V_1\Task\ShowController;
use App\Http\Controllers\Api\V_1\Task\StoreController;
use App\Http\Controllers\Api\V_1\Task\UpdateController;

Route::group(['prefix' => '/tasks'], function () {
    Route::get('/', IndexController::class)->name('tasks.index');
    Route::post('/', StoreController::class)->name('tasks.store');
    Route::get('/{id}', ShowController::class)->name('tasks.show');
    Route::put('/{id}', UpdateController::class)->name('tasks.update');
    Route::delete('/{id}', DestroyController::class)->name('tasks.destroy');
});
