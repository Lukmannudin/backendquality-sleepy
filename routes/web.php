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

Route::get('/', function () {
    return view('welcome/index');
});

Route::get('admin', 'AdminController@ceklogin');
Route::get('admin/home', 'Informasi\DashboardController@lihat');
Route::get('privacypolicy', function () {
    return view('welcome/privacypolicy');
});
//data artikel admin
Route::get('admin/artikel', 'Informasi\ArtikelController@index');
Route::get('admin/artikel/detail/{id}', 'Informasi\ArtikelController@detail');
Route::get('admin/artikel/create', 'Informasi\ArtikelController@buat');
Route::post('admin/artikel/create/post', 'Informasi\ArtikelController@create');
Route::get('admin/artikel/edit/{id}', 'Informasi\ArtikelController@ubah');
Route::post('admin/artikel/edit/{id}', 'Informasi\ArtikelController@edit');
Route::get('admin/artikel/delete/{id}', 'Informasi\ArtikelController@delete');


//data tips admin
Route::get('admin/tips', 'Informasi\TipsController@index');
Route::get('admin/tips/detail/{id}', 'Informasi\TipsController@detail');
Route::get('admin/tips/create', 'Informasi\TipsController@buat');
Route::post('admin/tips/create/post', 'Informasi\TipsController@create');
Route::get('admin/tips/edit/{id}', 'Informasi\TipsController@ubah');
Route::post('admin/tips/edit/{id}', 'Informasi\TipsController@edit');
Route::get('admin/tips/delete/{id}', 'Informasi\TipsController@delete');




Route::post('admin', 'AdminController@login');

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api'], function()
{
    Route::get('tes', 'PostingController@tes');
    Route::get('posting/artikel/{page}', 'PostingController@tampilArtikel')->name('tampilArtikel');
    Route::post('posting/tips', 'PostingController@tampilTips')->name('tampilTips');
    Route::get('posting/tips/{kategori}/{page}', 'PostingController@tampilTipsByKategori')->name('tampilTipsByKategori');
    //{kualitastidur} - diisi dengan hasil getKualitasTidur terakhir yang telah diurutkan berdasarkan kebutuhan pengguna paling penting. contoh berikut
    // 2-1-5-3-6-4 
    //sama dengan
    // Durasi Tidur , Latensi Tidur, Penggunaan Obat, Efisiensi Kebiasaan Tidur, Disfungsi Siang Hari, Gangguan Tidur
    //
    
    Route::post('user/login', 'UserController@loginDaftarUser')->name('loginDaftarUser');
    Route::post('user/tidur/tampil', 'UserController@tampilTidur')->name('tampilTidur');
    Route::post('user/tidur/list', 'UserController@tampilTidurPageList')->name('tampilTidurPageList');
    Route::post('user/tidur/tampilhariini', 'UserController@tampilTidurHariIni')->name('tampilTidurHariIni');
    Route::post('user/tidur/simpan', 'UserController@simpanTidur')->name('simpanTidur');
	Route::post('posting/tidur/kualitastidurterakhir', 'PostingController@getKualitasTidurTerakhir')->name('getKualitasTidurTerakhir');
    
    Route::post('user/storedevice', 'UserDeviceController@storeDevice')->name('tambahDeviceUser');

    Route::post('user/hasilhitungkualitastidur/simpan', 'UserController@simpanKualitasTidur')->name('simpanKualitasTidur');
    Route::post('user/hasilhitungkualitastidur/hapus', 'UserController@hapusPenghitunganKualitasTidur')->name('hapusPenghitunganKualitasTidur');
    Route::post('user/historihitungkualitastidur', 'UserController@tampilHistoriHitungKualitas')->name('tampilHistoriHitungKualitas');

});
