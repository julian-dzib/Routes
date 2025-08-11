<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChoferController;


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
    Route::post('/routes/{id}/stops', 'RutEntregaController@store');
    Route::delete('/stops/{id}','RutEntregaController@destroy');
    Route::put('/stops/{id}','RutEntregaController@update');
});
