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

Route::get('/user', 'UserController@index');
Route::get('/user/{user}', 'UserController@show');
Route::post('/user', 'UserController@store');
Route::post('/user/{user}', 'UserController@update');
Route::post('/login', 'UserController@login');
Route::delete('/user/{user}', 'UserController@destroy');
