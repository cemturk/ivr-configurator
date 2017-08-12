<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

Route::post('/user/login', 'UserController@login');
Route::get('/user/getByToken', 'UserController@getByToken');

Route::resource('/config', 'ConfigController');
Route::resource('/user', 'UserController');

Route::resource('/call-logs', 'CallLogsController');

