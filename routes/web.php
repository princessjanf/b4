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
Route::get('', 'MainController@index');

Route::get('logout', 'MainController@logout');

Route::get('homepage', 'MainController@index');

Route::get('login', 'MainController@login');

Route::get('test', 'ScholarshipController@test');

Route::get('delete/{id}', 'ScholarshipController@delete');

Route::get('detail-beasiswa/{id}', 'MainController@detailbeasiswa');

Route::get('daftar-beasiswa', [
   'middleware' => 'authSSO',
   'uses' => 'MainController@daftarbeasiswa',
]);

Route::get('add-beasiswa', [
   'middleware' => 'authSSO',
   'uses' => 'ScholarshipController@addbeasiswa',
]);

Route::post('/insert-beasiswa', 'ScholarshipController@insertBeasiswa');
