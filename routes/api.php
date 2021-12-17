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


Route::prefix('user')->group(function(){
    Route::put('/register',[UsersController::class,'register']);
    Route::put('/login/{email}/{password}',[UsersController::class,'login']);
    // Route::post('/recoveredPassword',[UsuariosController::class,'recoveredPassword']);
    // Route::get('/listarEmpleados',[UsuariosController::class,'listarEmpleados']);
    // Route::post('/detalleEmpleados',[UsuariosController::class,'detalleEmpleados']);
    // Route::get('/verDatos',[UsuariosController::class,'verDatos']);
});

Route::get('/ruta',function(){})->middleware('permisos');