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

Route::get('', 'MainController@login');

Route::get('logout', 'MainController@logout');

Route::get('beranda', 'MainController@index');

Route::get('daftar-beasiswa', 'MainController@daftarbeasiswa');

Route::get('add-beasiswa', 'MainController@addbeasiswa');

Route::get('detail-beasiswa/{id}', 'MainController@detailbeasiswa');

//Route::get('/createScholarship', 'ScholarshipController@create');
Route::get('test', 'ScholarshipController@test');

Route::get('createScholarship',[
   'middleware' => 'authSSO',
   'uses' => 'ScholarshipController@create',
]);

Route::post('/insertScholarship', 'ScholarshipController@insert');
