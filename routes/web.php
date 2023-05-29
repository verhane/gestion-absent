<?php

use App\Http\Controllers\PointageSuiviController;
use App\Models\Classe;
use App\Models\Pointage;
use App\Models\PrStagiaire;
use Dcs\Admin\Models\SysUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PointageController ;
use \App\Http\Controllers\PointageRapportController ;
require 'pointageRoutes.php' ;

Route::get('/lang/{locale}', function ($locale) {

    Session::put('language', $locale);

    return redirect()->back();

})->name('lang');

//route for testing laravel api
Route::get('/getLastPointages/{user_id}',function($userId){
    $pointagesLast = Pointage::query()->where('sys_user_id',$userId)->with(['classe','pointeur'])->latest()->limit(3)->get();
    return response()->json($pointagesLast);
});
Route::get('/getdetailPointageTous/{pointageId}/{etat}',function ($pointageId,$etat){
    $stagiaires = PrStagiaire::query()->whereHas('details_pointages',$res= function ($q) use($pointageId,$etat){
        if ($etat==0)
        $q->where('pointage_id',$pointageId);
        else
        $q->where('pointage_id',$pointageId)->where('ref_etats_presence_id',$etat);
    })->with(['details_pointages'=>$res])->get();
    return response()->json($stagiaires);
});
