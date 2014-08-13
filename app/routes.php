<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


Route::group(['before' => 'twitter'], function () {

    Route::api(['version' => 'v1', 'protected' => true], function () {

        Route::resource('users', '\\Twitter\\Api\\User\\UsersController');
        Route::resource('tweets', '\\Twitter\\Api\\Tweet\\TweetsController');
        Route::resource('messages', '\\Twitter\\Api\\Message\\MessagesController');

        Route::get('users/{id}/tweets', '\\Twitter\\Api\\User\\UsersController@tweets');
        Route::get('users/{id}/messagesfrom', '\\Twitter\\Api\\User\\UsersController@messagesFrom');
        Route::get('users/{id}/messagesto', '\\Twitter\\Api\\User\\UsersController@messagesTo');
    });
});

