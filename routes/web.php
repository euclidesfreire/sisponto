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

Route::get('/', 'HomeController@index')->name('home');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@authenticate')->name('authenticate');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
	Route::get('/', 'Admin\HomeController@index')->name('admin.home');
});

Route::group(['prefix' => 'gestor', 'middleware' => ['auth:gestor']], function () {
	Route::get('/', 'Admin\HomeController@index')->name('admin.home');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:user']], function () {
	Route::get('/', 'Admin\HomeController@index')->name('admin.home');
});