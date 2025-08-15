<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChoferController;
use App\Http\Controllers\AuthController;

//Paso 5 - Crear las rutas para mi autentificacion
Route::post('register', [AuthController::class, 'register']);
Route::post('login',[AuthController::class,'login']);


Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('perfil', [AuthController::class,'perfil']);
});

//Paso 6 - Crear las rutas para recuperar la contrasenia
//Route::post('passoword/forgot', [AuthController::class,'sendResetLink']);
//Route::post('password/reset', [AuthController::class, 'reset']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Rutas para el controlador chofer
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/drivers', 'ChoferController@store');
    Route::get('/drivers','ChoferController@index');
    Route::delete('/drivers/{id}','ChoferController@destroy');
    Route::put('/drivers/{id}','ChoferController@update');
});
//Rutas para el controlador Routes
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/routes', 'RutaController@store');
    Route::get('/routes','RutaController@index');
    Route::get('/routes/{id}','RutaController@show');
    Route::delete('/routes/{id}','RutaController@destroy');
    Route::put('/routes/{id}','RutaController@update');
});
//Rutas para el controlador Puntos de Entrega
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/stops', 'RutEntregaController@index');
    Route::post('/routes/{id}/stops', 'RutEntregaController@store');
    Route::delete('/stops/{id}','RutEntregaController@destroy');
    Route::put('/stops/{id}','RutEntregaController@update');
});
