<?php

use Dcs\Core\stabs\App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'menus',
    'middleware' => ['web', 'auth', 'roles'],
    'roles' => [1]],
    function () {
        Route::get('', [MenuItemController::class, 'index']);
        Route::get('getDT/{parent_id}/{selected?}', [MenuItemController::class, 'getDT']);
        Route::get('get/{id}', [MenuItemController::class, 'get']);
        Route::get('getTab/{id}/{tab}', [MenuItemController::class, 'getTab']);
        Route::get('add/{id}', [MenuItemController::class, 'formAdd']);
        Route::post('add', [MenuItemController::class, 'add']);
        Route::get('menu/add', [MenuItemController::class, 'formAddMenu']);
        Route::post('menu/add', [MenuItemController::class, 'addMenu']);
        Route::post('edit', [MenuItemController::class, 'edit']);
        Route::post('editElement', [MenuItemController::class, 'editElement']);
        Route::get('delete/{id}', [MenuItemController::class, 'delete']);
        Route::get('saveOrder/{order}', [MenuItemController::class,'saveOrder']);
        Route::get('getMenuElements/{id}', [MenuItemController::class,'getMenuElements']);
        Route::get('setDynamic/{id}/{is_dynamic}', [MenuItemController::class,'setDynamic']);
        Route::get('getDynamicMenuItems/{id}', [MenuItemController::class,'getDynamicMenuItems']);
    });

