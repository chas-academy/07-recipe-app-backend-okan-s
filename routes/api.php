<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::GET('profile', 'UserController@getAuthenticatedUser');

    Route::GET('favorite/store/{id}', 'DataController@store'); //Only works with GET?
    Route::GET('favorites', 'DataController@show');
    Route::GET('favorite/check/{id}', 'DataController@check');
    Route::DELETE('favorite/delete/{id}', 'DataController@delete');
});

Route::POST('register', 'UserController@register');
Route::POST('login', 'UserController@login');