<?php

use App\Models\AnneesScolaire;
use App\Models\Classe;
use App\Models\DetailsPointage;
use App\Models\Pointage;
use App\Models\PrStagiaire;
use App\Models\RefEtatsPresence;
use App\Models\RefPresent;
use App\Models\User;
use Dcs\Admin\Models\SysUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
    |
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', function (){
    request()->validate([
        'password' => 'required',
        'device_name' => 'required'
    ]);
    $user = SysUser::query()->orWhere('email', request()->input('email'))->orWhere('username',request()->input('email'))->first();

    if (!$user || !Hash::check(request()->input('password'), $user->password)) {
        return response()->json(['msg' => trans('auth.failed')], 422);
    }
    $token = $user->createToken(request()->input('device_name'))->plainTextToken;
    $response = [
        'user' => $user,
        'token' => $token,
    ];
    return response()->json($response);
});

Route::middleware('auth:sanctum')->group(function (){
            Route::get('/getLastPointages/{user_id}',function($userId){
                $pointagesLast = Pointage::query()->where('sys_user_id',request()->user()->id)->with(['classe','pointeur'])->latest()->limit(3)->get();
                $sys_user = request()->user()->name ;
                return response()->json([$pointagesLast ,$sys_user]);
            });
            Route::get('/classes',function(){
                $classes = Classe::query()->whereHas('annees_scolaire',function($q){
                    $q->where('actif',1);
                })->get();
//                  $classes = Classe::all();
//                $classes =Classe::query()->whereIn('annees_scolaire_id',AnneesScolaire::query()->where('actif',1)->select('id'))->get();
                return response()->json($classes);
            });

            Route::get('/listEleve/{classeId}' , function($id){
                $eleves = Classe::query()->firstwhere('id' ,$id)->pr_stagiaires;
                $classe = Classe::find($id);
                return response()->json(['eleves'=>$eleves ,'classe'=> $classe]);
            });

            Route::get('/refPresent',function(){
                $etats = RefEtatsPresence::all();
                return response()->json(['etats'=>$etats]) ;
            });

            Route::post('/createPointage',function(){
                request()->validate([
                    'date' => 'required',
                    'time' => 'required',
                    'classe'=>'required'
                ]);
                $pointages = Pointage::query()->where('classe_id' ,request()->input('classe'))
                    ->where('date',request()->input('date'))
                    ->where('heure',request()->input('time'))->exists();

                if($pointages){
                    return response()->json(['msg' => trans('pointage exist')], 422);
                }else{
                    $pointage = new Pointage();
                    $pointage->classe_id = request()->input('classe');
                    $pointage->sys_user_id =request()->user()->id;
                    $pointage->date = request()->input('date');
                    $pointage->heure = request()->input('time');
                    $pointage->ref_etats_pointage_id=1 ;
                    $pointage->save();
                    $pointag = Pointage::find($pointage->id) ;
                    foreach ($pointage->classe->pr_stagiaires as $eleve) {
                        $detailsPointage = new DetailsPointage();
                        $detailsPointage->pr_stagiaire_id = $eleve->id;
                        $detailsPointage->pointage_id = $pointage->id;
                        $detailsPointage->ref_etats_presence_id = 1; // present
                        $detailsPointage->save();
                    }

                    return response()->json(['pointage_id'=> $pointage->id ,'pointage'=>$pointag], 200);
                }

            });
            Route::get('/detaislPointageAbsent/{eleve_id}/{pointageId}',function ($eleve_id , $pointage_id){
                $pointage = Pointage::find($pointage_id);
                $detail_pointage = $pointage->details_pointages->firstWhere('pr_stagiaire_id' ,$eleve_id);
                if ($detail_pointage){
                    $detailaPointage = DetailsPointage::find($detail_pointage->id);
                    $detailaPointage->ref_etats_presence_id =2;
                    $detailaPointage->save();
                    return response()->json(['detailsPointage'=>$detailaPointage]);
                }

            });

            Route::get('/detaislPointageAbsentJust/{eleve_id}/{pointageId}',function ($eleve_id , $pointage_id){
                $pointage = Pointage::find($pointage_id);
                $detail_pointage = $pointage->details_pointages->firstWhere('pr_stagiaire_id' ,$eleve_id);
                if ($detail_pointage){
                    $detailaPointage = DetailsPointage::find($detail_pointage->id);
                    $detailaPointage->ref_etats_presence_id =3;
                    $detailaPointage->save();
                    return response()->json(['detailsPointage'=>$detailaPointage]);
                }

            });
            Route::get('/detaislPointagePresent/{eleve_id}/{pointageId}',function ($eleve_id , $pointage_id){
                $pointage = Pointage::find($pointage_id);
                $detail_pointage = $pointage->details_pointages->firstWhere('pr_stagiaire_id' ,$eleve_id);
                if ($detail_pointage){
                    $detailaPointage = DetailsPointage::find($detail_pointage->id);
                    $detailaPointage->ref_etats_presence_id =1;
                    $detailaPointage->save();
                    return response()->json(['detailsPointage'=>$detailaPointage]);
                }

            });
            Route::get('/getdetailPointageAbsent/{pointageId}',function ($pointageId){
                $stagiaires = PrStagiaire::whereHas('details_pointages',function ($q) use($pointageId){
                        $q->where('pointage_id',$pointageId)->where('ref_etats_presence_id',2);
                })->get();
                return response()->json(['eleves'=>$stagiaires]);
            });
            Route::get('/getdetailPointagePresent/{pointageId}',function ($pointageId){
                $stagiaires = PrStagiaire::whereHas('details_pointages',function ($q) use($pointageId){
                    $q->where('pointage_id',$pointageId)->where('ref_etats_presence_id',1);;
                })->get();
                return response()->json(['eleves'=>$stagiaires]);
            });
            Route::get('/getdetailPointageAbsJus/{pointageId}',function ($pointageId){
                $stagiaires = PrStagiaire::whereHas('details_pointages',function ($q) use($pointageId){
                    $q->where('pointage_id',$pointageId)->where('ref_etats_presence_id',3);
                })->get();
                return response()->json(['eleves'=>$stagiaires]);
            });
            Route::get('/getdetailPointageTous/{pointageId}/{etat}',function ($pointageId,$etat){
                $stagiaires = PrStagiaire::query()->whereHas('details_pointages',$res= function ($q) use($pointageId,$etat){
                    if ($etat==0)
                        $q->where('pointage_id',$pointageId);
                    else
                        $q->where('pointage_id',$pointageId)->where('ref_etats_presence_id',$etat);
                })->with(['details_pointages'=>$res])->limit(10)->get();
                return response()->json($stagiaires);
            });

});
