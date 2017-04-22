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

Route::get('/list-beasiswa', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@listbeasiswa'
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



Route::get('daftar-beasiswa/{id}',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@daftarBeasiswa'
]);

Route::post('insert-beasiswa',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@insertBeasiswa'
]);

Route::post('update-beasiswa',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@updateBeasiswa'
]);
Route::post('retrieve-prodi', 'ScholarshipController@retrieveProdi');

Route::get('/upload',[
  'middleware' => 'authSSO',
  'uses' => 'UploadController@uploadForm'
]);
Route::post('/upload', 'UploadController@uploadSubmit');

Route::post('register-beasiswa', [
'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@registerBeasiswa'
]);
