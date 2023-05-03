<?php

use App\Models\Classe;
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

Route::middleware('auth:sanctum')->group(function (){

});
Route::post('login', function (){
    request()->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);

    $user = SysUser::query()->where('email', request()->input('email'))->first();

    if (!$user || !Hash::check(request()->input('password'), $user->password)) {
//        throw ValidationException::withMessages([
//            'msg' => trans('auth.failed'),
//        ]);
        return response()->json(['msg' => trans('auth.failed')], 422);
    }

    $token = $user->createToken(request()->input('device_name'))->plainTextToken;


    $response = [
        'user' => $user,
        'token' => $token,
    ];
    return response()->json($response);

});
Route::get('/classes',function(){
    $classes = Classe::all();
    return response()->json($classes);
});
Route::get('/listEleve/{casseId}' , function($id){
    $eleves = Classe::query()->firstwhere('id' ,$id)->pr_stagieres;
    $classe = Classe::find($id);
    return response()->json(['eleves'=>$eleves ,'classe'=> $classe]);
});
Route::get('/refPresent',function(){
    $etats = RefPresent::all();
    return response()->json(['etats'=>$etats]) ;
});
