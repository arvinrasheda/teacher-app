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
    return view('dashboard');
})->name('dashboard');

Route::prefix("master")->group(function () {
    Route::prefix("kriteria")->group(function () {
        Route::get('', 'KriteriaController@index')->name('kriteria.index');
        Route::get('/create', 'KriteriaController@create')->name('kriteria.create');
        Route::post('/store', 'KriteriaController@store')->name('kriteria.store');
    });
    Route::prefix("nilai-kriteria")->group(function () {
        Route::get('', 'NilaiKriteriaController@index')->name('nilai_kriteria.index');
        Route::get('/create', 'NilaiKriteriaController@create')->name('nilai_kriteria.create');
        Route::post('/store', 'NilaiKriteriaController@store')->name('nilai_kriteria.store');
    });
});

Route::prefix("guru")->group(function () {
    Route::get('', 'GuruController@index')->name('guru.index');
    Route::get('/create', 'GuruController@create')->name('guru.create');
    Route::post('/store', 'GuruController@store')->name('guru.store');
});

Route::prefix("nilai-guru")->group(function () {
    Route::get('', 'NilaiGuruController@index')->name('nilai_guru.index');
    Route::get('/edit/{nip}', 'NilaiGuruController@edit')->name('nilai_guru.edit');
    Route::post('/store/{nip}', 'NilaiGuruController@store')->name('nilai_guru.store');
});
