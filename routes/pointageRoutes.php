<?php

use App\Http\Controllers\PointageSuiviController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PointageController ;
use \App\Http\Controllers\PointageRapportController ;

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
        Route::get('getDT/{selected?}', [PointageController::class, 'getDT']);
        Route::get('getElevesDT/{selected?}/{pointage_id}',[PointageController::class,'getElevesDT']);
        Route::get('get/{id}', [PointageController::class, 'get']);
        Route::get('getTab/{id}/{tab}', [PointageController::class, 'getTab']);
        Route::get('add', [PointageController::class, 'formAdd']);
        Route::post('add', [PointageController::class, 'add']);
        Route::post('addPointageDetails/{eleves}', [PointageController::class, 'addPointageDetails']);
        Route::post('edit', [PointageController::class, 'edit']);
        Route::get('delete/{id}', [PointageController::class, 'delete']);
        Route::post('exportPdf',[PointageController::class, 'ExportPdf']);
        Route::post('exportExcel', [PointageController::class, 'exportExcel']);
//        Route::get('addPresence/{persone_id}/{presence_id}/{pointage_id}', [PointageController::class, 'addPresence']);
        Route::post('validerPointge/{pointage_id}',[PointageController::class,'validerPointage']);
    }
);

//rapport Controller
Route::group([
        'prefix' => 'pointages/rapports',
        'middleware' => ['web', 'auth', 'roles'],
        'roles' => [1]
    ],
    function () {
        Route::get('', [PointageRapportController::class, 'index']);
        Route::get('getDT/{selected?}', [PointageRapportController::class, 'getDT']);
        Route::post('exportPdf',[PointageRapportController::class, 'ExportPdf']);
        Route::post('exportExcel', [PointageRapportController::class, 'exportExcel']);
    }
);

//Suivis Controller
Route::group([
        'prefix' => 'pointages/suivis',
        'middleware' => ['web', 'auth', 'roles'],
        'roles' => [1]
    ],
    function () {
        Route::get('', [PointageSuiviController::class, 'index']);
        Route::get('getEleve/{eleve}', [PointageSuiviController::class, 'getEleve']);
        Route::get('getDetEleve/{id}/{date_debut?}/{date_fin?}', [PointageSuiviController::class, 'getDetEleve']);
        Route::post('exportPdf',[PointageSuiviController::class, 'ExportPdf']);
    }
);
