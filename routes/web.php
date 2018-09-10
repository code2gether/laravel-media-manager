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

Route::get('files', 'FilesController@index')->name('files.index');
Route::get('files/create', 'FilesController@create')->name('files.create');
Route::post('files/store', 'FilesController@store')->name('files.store');
Route::get('files/{id}/edit', 'FilesController@edit')->name('files.edit');
Route::patch('files/{id}', 'FilesController@update')->name('files.update');
Route::get('files/{id}', 'FilesController@show')->name('files.show');
