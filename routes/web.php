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

use App\Guru;

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['check.session.auth'])->get('/', 'HomeController@index')->name('dashboard');

Route::prefix("master")->middleware(['check.session.auth'])->group(function () {
    Route::prefix("kriteria")->group(function () {
        Route::get('', 'KriteriaController@index')->name('kriteria.index');
        Route::get('/create', 'KriteriaController@create')->name('kriteria.create');
        Route::post('/store', 'KriteriaController@store')->name('kriteria.store');
        Route::get('/edit/{id}', 'KriteriaController@edit')->name('kriteria.edit');
        Route::post('/update', 'KriteriaController@update')->name('kriteria.update');
        Route::delete('/destroy/{id}', 'KriteriaController@destroy')->name('kriteria.destroy');
    });
    Route::prefix("nilai-kriteria")->group(function () {
        Route::get('', 'NilaiKriteriaController@index')->name('nilai_kriteria.index');
        Route::get('/create', 'NilaiKriteriaController@create')->name('nilai_kriteria.create');
        Route::post('/store', 'NilaiKriteriaController@store')->name('nilai_kriteria.store');
        Route::get('/edit/{id}', 'NilaiKriteriaController@edit')->name('nilai_kriteria.edit');
        Route::post('/update', 'NilaiKriteriaController@update')->name('nilai_kriteria.update');
        Route::delete('/destroy/{id}', 'NilaiKriteriaController@destroy')->name('nilai_kriteria.destroy');
    });
});

Route::middleware(['check.session.auth'])->prefix("guru")->group(function () {
    Route::get('', 'GuruController@index')->name('guru.index');
    Route::get('/create', 'GuruController@create')->name('guru.create');
    Route::post('/store', 'GuruController@store')->name('guru.store');
    Route::get('/edit/{id}', 'GuruController@edit')->name('guru.edit');
    Route::post('/update', 'GuruController@update')->name('guru.update');
    Route::delete('/destroy/{id}', 'GuruController@destroy')->name('guru.destroy');
});

Route::middleware(['check.session.auth'])->prefix("nilai-guru")->group(function () {
    Route::get('', 'NilaiGuruController@index')->name('nilai_guru.index');
    Route::get('/edit/{nip}', 'NilaiGuruController@edit')->name('nilai_guru.edit');
    Route::post('/store/{nip}', 'NilaiGuruController@store')->name('nilai_guru.store');
    Route::post('/add', 'NilaiGuruController@addFromTahunAjaran')->name('nilai_guru.addFromTahunAjaran');
});

Route::middleware(['check.session.auth'])->prefix("hasil")->group(function () {
    Route::get('', 'HasilController@index')->name('hasil.index');
    Route::get('/generate-pdf', 'HasilController@generatePdf')->name('hasil.generate');
});
Route::middleware(['check.session.auth'])->prefix("password")->group(function () {
    Route::get('', 'PasswordController@index')->name('password.index');
    Route::post('/store', 'PasswordController@change')->name('password.store');
});
