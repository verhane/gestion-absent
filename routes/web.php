<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PointageController ;
use \App\Http\Controllers\RapportController ;
Route::get('/lang/{locale}', function ($locale) {

    Session::put('language', $locale);

    return redirect()->back();

})->name('lang');

Route::group([
    'prefix' => 'pointages',
    'middleware' => ['web', 'auth', 'roles'],
    'roles' => [1]
],
    function () {
        Route::get('', [PointageController::class, 'index']);
        Route::get('getDT/{classe}/{admin}/{dateD?}/{dateF?}/{selected?}', [PointageController::class, 'getDT']);
        Route::get('get/{id}', [PointageController::class, 'get']);
        Route::get('getTab/{id}/{tab}', [PointageController::class, 'getTab']);
        Route::get('add', [PointageController::class, 'formAdd']);
        Route::post('add', [PointageController::class, 'add']);
        Route::post('addPointageDetails/{eleves}', [PointageController::class, 'addPointageDetails']);
        Route::post('edit', [PointageController::class, 'edit']);
        Route::get('delete/{id}', [PointageController::class, 'delete']);
        Route::get('exportPdf/{classe}/{admin}/{dateD?}/{dateF?}',[PointageController::class, 'ExportPdf']);
        Route::get('exportExcel/{classe}/{admin}/{dateD?}/{dateF?}', [PointageController::class, 'exportExcel']);
        Route::get('addPresence/{persone_id}/{presence_id}/{pointage_id}', [PointageController::class, 'addPresence']);
    });

//rapport Controller
Route::group([
    'prefix' => 'rapports',
    'middleware' => ['web', 'auth', 'roles'],
    'roles' => [1]
],
    function () {
        Route::get('', [RapportController::class, 'index']);
        Route::get('getDT/{classe}/{dateD?}/{dateF?}/{selected?}', [RapportController::class, 'getDT']);
        Route::get('get/{id}', [RapportController::class, 'get']);
        Route::get('getTab/{id}/{tab}', [RapportController::class, 'getTab']);
        Route::get('add', [RapportController::class, 'formAdd']);
        Route::post('add', [RapportController::class, 'add']);
        Route::post('edit', [RapportController::class, 'edit']);
        Route::get('delete/{id}', [RapportController::class, 'delete']);
            Route::get('exportPdf/{classe}/{dateD?}/{dateF?}',[RapportController::class, 'ExportPdf']);
        Route::get('exportExcel/{classe}/{dateD?}/{dateF?}', [RapportController::class, 'exportExcel']);
    });
