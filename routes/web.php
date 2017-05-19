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

Route::get('sudah-mendaftar',[
  'middleware' => 'authSSO',
  'uses' => 'MainController@sudahDaftar'
]);



Route::get('daftar-beasiswa/{id}',[

  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@daftarBeasiswa'
]);

Route::post('register-beasiswa',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@registerBeasiswa'
]);

Route::post('insert-beasiswa',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@insertBeasiswa'
]);

Route::get('seleksi/{id}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@seleksi'
]);

Route::get('seleksi', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@pageSeleksi'
]);

Route::get('seleksi-beasiswa/{idBeasiswa}/{idTahapan}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@seleksiBeasiswa'
]);

Route::get('seleksi-luar/{idBeasiswa}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@seleksiLuar'
]);


Route::post('save-draft', 'MainController@saveDraft');
Route::post('save-draft-check', 'MainController@saveDraftCheck');
Route::post('finalize-result', 'MainController@finalizeResult');
Route::post('finalize-result-checked', 'MainController@finalizeResultChecked');
Route::post('retrieve-nama', 'MainController@retrieveNama');


Route::get('savedraft', 'MainController@savedraftest');

//seleksi-tahapan/{id_beasiswa}/{id_tahapan}/{id_penyeleksi}

Route::post('update-beasiswa',[
  'middleware' => 'authSSO',
  'uses' => 'ScholarshipController@updateBeasiswa'
]);
Route::post('retrieve-prodi', 'ScholarshipController@retrieveProdi');

//Route::post('insert-beasiswa', 'ScholarshipController@insertBeasiswa');
//Route::post('update-beasiswa', 'ScholarshipController@updateBeasiswa');

Route::post('update-profil',[
  'middleware' => 'authSSO',
  'uses' => 'MainController@updateProfil'
]);

Route::get('/profil', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@profil'
]);

Route::get('/edit-profil', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@editProfil'
]);

Route::get('/pendaftar-beasiswa/{id}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@pendaftarBeasiswa'
]);

Route::get('/lihat-berkas-mahasiswa/{idbeasiswa}/{iduser}', [
  'middleware' => 'authSSO',
'as' => 'lihatBerkas', 'uses' => 'MainController@lihatBerkas']);

Route::get('seleksi/{id}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@seleksi'
]);

Route::get('seleksi', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@pageSeleksi'
]);

Route::get('seleksi-beasiswa/{idBeasiswa}/{idTahapan}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@seleksiBeasiswa'
]);

Route::get('seleksi-luar/{idBeasiswa}', [
  'middleware' => 'authSSO',
  'uses' => 'MainController@seleksiLuar'
]);


Route::post('save-draft', 'MainController@saveDraft');
Route::post('save-draft-check', 'MainController@saveDraftCheck');
Route::post('finalize-result', 'MainController@finalizeResult');
Route::post('finalize-result-checked', 'MainController@finalizeResultChecked');
Route::post('retrieve-nama', 'MainController@retrieveNama');


Route::get('savedraft', 'MainController@savedraftest');

// Route::get('/lihat-berkas-mahasiswa/{id}', [
//   'middleware' => 'authSSO',
//   'uses' => 'MainController@lihatBerkas'
// ]);

Route::get('nama-penerima/{idBeasiswa}',[
  'middleware' => 'authSSO',
  'uses' => 'MainController@penerimaBeasiswa'
]);

// Route::get('sendbasicemail','MailController@basic_email');
// Route::get('sendhtmlemail','MailController@html_email');
// Route::get('sendattachmentemail','MailController@attachment_email');
Route::post('download-berkas',[
  'middleware' => 'authSSO',
  'uses' => 'MainController@download'
]);

Route::post('unduh-dk',[
  'middleware' => 'authSSO',
  'uses' => 'MainController@unduhDK'
]);

Route::get('upload-berkas-umum',[
  'middleware' => 'authSSO',
  'uses' => 'UploadController@uploadForm'
]);
Route::post('upload',[
  'middleware' => 'authSSO',
  'uses' => 'UploadController@uploadSubmit'
]);

Route::post('filter-pegawai-fakultas', 'ScholarshipController@filterPegawaiFakultas');

Route::get('email/{idBeasiswa}', 'MailController@sendEmail')->middleware('authSSO');

//Alvin sprint 3
Route::get('unggah-dokumen-kerjasama/{idBeasiswa}',[
  'middleware' => 'authSSO',
  'uses' => 'UploadController@unggahDokumenKerjasama'
]);
Route::post('unggahDK',[
  'middleware' => 'authSSO',
  'uses' => 'UploadController@unggahDKsubmit'
]);


Route::get('statistik', 'ChartController@statistik')->middleware('authSSO');
Route::get('statistik-persebaran', 'ChartController@persebaran')->middleware('authSSO');
Route::get('statistik-penerima', 'ChartController@penerima')->middleware('authSSO');
Route::get('lihat-statistik', 'ChartController@index')->middleware('authSSO');
Route::get('lihat-statistik4', 'ChartController@index4')->middleware('authSSO');
Route::post('lihat-statistik4', 'ChartController@index4filter')->middleware('authSSO');
Route::get('lihat-statistik2', 'ChartController@statistikAll')->middleware('authSSO');
Route::get('lihat-statistik3', 'ChartController@pendaftarFakultas')->middleware('authSSO');

Route::get('lihat-statistik5', 'ChartController@index5')->middleware('authSSO');
Route::post('lihat-statistik5', 'ChartController@index5filter')->middleware('authSSO');

Route::get('lihat-statistik6', 'ChartController@index6')->middleware('authSSO');
Route::post('lihat-statistik6', 'ChartController@index6filter')->middleware('authSSO');
Route::get('lihat-statistik7', 'ChartController@beasiswaPerProdi')->middleware('authSSO');
Route::post('lihat-statistik7', 'ChartController@beasiswaPerProdi2')->middleware('authSSO');

Route::get('lihat-statistik-dana', 'ChartController@danaBeasiswa')->middleware('authSSO');
