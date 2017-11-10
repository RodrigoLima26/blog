<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',         ['as' => 'home',   'uses' => 'JediController@index']);
Route::get('toggle/{id}',         ['as' => 'toggle',   'uses' => 'JediController@toggleLightsaberStatus']);
Route::get('notify/{id}',         ['as' => 'notify',   'uses' => 'JediController@notifyJedi']);
Route::get('status/{id}',         ['as' => 'notify',   'uses' => 'JediController@notifyJedi']);
Route::get('send', 'JediController@send');
