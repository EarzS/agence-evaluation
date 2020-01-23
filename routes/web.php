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
Route::get('/', 'ConsultantController@index');

// Consultant View Routes
Route::group(['prefix' => 'consultant', 'as'=>'consultant.'] ,function () {
	Route::get('/', 'ConsultantController@index')->name('index');
    Route::get('/relatory', 'ConsultantController@relatory')->name('relatory');
    Route::get('/cake', 'ConsultantController@cake')->name('cake');
    Route::get('/graphic', 'ConsultantController@graphic')->name('graphic');
});