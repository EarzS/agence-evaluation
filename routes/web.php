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
Route::get('/consultant', 'ConsultantController@index');
Route::get('/consultant/relatory', 'ConsultantController@relatory');
Route::get('/consultant/cake', 'ConsultantController@cake');
Route::get('/consultant/graphic', 'ConsultantController@graphic');

// Client View Routes
Route::get('/client', 'ClientController@index');
Route::get('/client/relatory', 'ClientController@relatory');
Route::get('/client/cake', 'ClientController@cake');
Route::get('/client/graphic', 'ClientController@graphic');