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


Route::get('/', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('/', 'Auth\LoginController@authenticate')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
	Route::get('/', 'Admin\HomeController@index')->name('admin.home');

	Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\Auth\LoginController@authenticate')->name('admin.login');
	Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'manager', 'middleware' => ['auth:manager']], function () {
	Route::get('/', 'Manager\HomeController@index')->name('manager.home');

	Route::group(['prefix' => 'batidas'], function () {
		Route::get('/read', 'Manager\BatidasController@getRead')->name('manager.batidas.read');
		Route::post('/read', 'Manager\BatidasController@postRead')->name('manager.batidas.read');
		Route::post('/edit', 'Manager\HomeController@edit')->name('manager.batidas.edit');
		Route::get('/edit', 'Manager\HomeController@edit')->name('manager.batidas.edit');
	});
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:user']], function () {
	Route::get('/', 'User\HomeController@index')->name('user.home');
	
	Route::group(['prefix' => 'batidas'], function () {
		Route::get('/read', 'User\BatidasController@getRead')->name('user.batidas.read');
		Route::post('/read', 'User\BatidasController@postRead')->name('user.batidas.read');
		Route::post('/edit', 'User\HomeController@edit')->name('user.batidas.edit');
		Route::get('/edit', 'User\HomeController@edit')->name('user.batidas.edit');
	});
});