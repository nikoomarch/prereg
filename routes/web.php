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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('index');
Route::get('/course/register','HomeController@create')->name('course.register');
Route::post('/course/store', 'HomeController@store')->name('store');
Route::post('/course/confirm','HomeController@confirm')->name('confirm');
Route::get('/course/edit',"HomeController@edit")->name('edit');
Route::post('/course/update','HomeController@update')->name('update');
//authentication routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');