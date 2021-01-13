<?php

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/flowers', 'FlowersController@index');
    Route::post('/flowers', 'FlowersController@store');
    Route::get('/flowers/{flower}', 'FlowersController@show');
    Route::put('/flowers/{flower}', 'FlowersController@update');
    Route::delete('/flowers/{flower}', 'FlowersController@destroy');
    Route::get('/cards', 'CardsController@index');
    Route::get('/cards/{card}', 'CardsController@show');
    Route::post('/cards', 'CardsController@store');
    Route::put('/cards/{card}', 'CardsController@update');
    Route::delete('/cards/{card}', 'CardsController@destroy');
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
