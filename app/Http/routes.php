<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you register all of the routes for an application.
| Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('layout');
});

Route::get('/partials/index', function () {
    return view('partials.index');
});

Route::get('/partials/{category}/{action?}', function ($category, $action = 'index') {
    return view(join('.', ['partials', $category, $action]));
});

Route::get('/partials/{category}/{action}/{id}', function ($category, $action = 'index', $id) {
    return view(join('.', ['partials', $category, $action]));
});

// Additional RESTful routes.
Route::post('/api/user/login', 'UserController@login');
Route::get('/api/user/getByToken', 'UserController@getByToken');
Route::post('/api/cm/callback', 'CmController@callback');

// Getting RESTful
Route::resource('/api/config', 'SendSmsController');
Route::resource('/api/user', 'UserController');
Route::resource('/api/calllogs', 'CallLogsController');
Route::resource('/api/cm', 'CmController');

// Catch all undefined routes. Always gotta stay at the bottom since order of routes matters.
Route::any('{undefinedRoute}', function ($undefinedRoute) {
//    Log::info('received callback' . $undefinedRoute);
//    return view('layout');
})->where('undefinedRoute', '([A-z\d-\/_.]+)?');

// Using different syntax for Blade to avoid conflicts with AngularJS.
// You are well-advised to go without any Blade at all.
Blade::setContentTags('<%', '%>'); // For variables and all things Blade.
Blade::setEscapedContentTags('<%%', '%%>'); // For escaped data.
