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

Route::get('/', 'WebController@index')->name('index');


Auth::routes();

// BACKEND
Route::get('/home', 'HomeController@index')->name('home');

//USER ADMINISTRATION BACKEND
Route::get('/users', 'backend\UserController@index')->name('users');
Route::get('/users/new', 'backend\UserController@create')->name('create.user');
Route::post('/users/new', "backend\UserController@store")->name('store.user');
Route::get('/users/edit/{id}', 'backend\UserController@edit')->name('edit.user');
Route::post('/users/edit/{id}', 'backend\UserController@update')->name('update.user');
Route::get('/users/delete/{id}', 'backend\UserController@destroy')->name('destroy.user');
