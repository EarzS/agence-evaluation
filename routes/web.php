<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/', 'HomeController@index');

// Consultant View Routes
Route::group(['prefix' => 'consultant', 'as'=>'consultant.'/*, 'middleware'=>['auth']*/] ,function () {
	Route::get('/', 'ConsultantController@index')->name('index');
    Route::get('/relatory', 'ConsultantController@relatory')->name('relatory');
    Route::get('/cake', 'ConsultantController@cake')->name('cake');
    Route::get('/graphic', 'ConsultantController@graphic')->name('graphic');
});

// Client View Routes
Route::group(['prefix' => 'client', 'as'=>'client.'/*, 'middleware'=>['auth']*/] ,function () {
	Route::get('/', 'ClientController@index')->name('index');
    Route::get('/relatory', 'ClientController@relatory')->name('relatory');
    Route::get('/cake', 'ClientController@cake')->name('cake');
    Route::get('/graphic', 'ClientController@graphic')->name('graphic');
});