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
Route::get('/homepage', 'MainController@index');
Route::get('/', function() {return redirect('/homepage');});

Route::get('/login', 'MainController@login');
Route::get('/logout', 'MainController@logout');

Route::get('/daftar-beasiswa', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@daftarbeasiswa'
]);
Route::get('/detail-beasiswa/{id}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@detailbeasiswa'
]);

Route::get('add-beasiswa', [
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@addbeasiswa'
]);

Route::get('edit-beasiswa/{id}',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@edit'
]);

Route::get('delete-beasiswa/{id}',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@delete'
]);

Route::get('make-public-beasiswa/{id}',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@makePublic'
]);

Route::get('noaccess',[
  'middleware' => 'authSSO',
  'uses' => 'MainController@noaccess'
]);
Route::get('test', 'ScholarshipController@retrieveProdi');
Route::post('retrieve-prodi', 'ScholarshipController@retrieveProdi');
Route::post('insert-beasiswa', 'ScholarshipController@insertBeasiswa');
Route::post('update-beasiswa', 'ScholarshipController@updateBeasiswa');
