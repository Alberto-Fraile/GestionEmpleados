<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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


Route::post('/login',[UsersController::class,'login']);

Route::prefix('user')->group(function(){
    Route::post('/recuperarPassword',[UsersController::class,'recuperarPassword']);
    //Route::put('/register',[UsersController::class,'register']);
});

Route::middleware('api_token', 'permisos')->prefix('user')->group(function(){
	Route::put('/register',[UsersController::class,'register']);
	Route::get('/listar',[UsersController::class,'listar']);
});

Route::middleware('api_token')->prefix('user')->group(function(){
    Route::get('/verPerfil',[UsersController::class,'verPerfil']);
});   