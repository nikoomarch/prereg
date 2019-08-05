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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/',function (){
    return redirect()->route('login');
});

Route::get('/redirection',function(){
    if(Auth::user()->role == 'student')
        return redirect()->route('register.create');
    else
        return redirect()->route('user.index');
})->middleware('auth');

Route::resource('term','TermController');
Route::resource('field','FieldController');
Route::get('/test','UserController@test');

Route::get('user/createFromFile','UserController@createFromFile')->name('user.createFromFile');
Route::post('user/storeFormFile','UserController@storeFromFile')->name('user.storeFromFile');
Route::resource('user','UserController');
Route::resource('course','CourseController');
Route::resource('selection','SelectionController');

Route::post('register/confirm','RegisterController@confirm')->name('register.confirm');
Route::get('register/edit','RegisterController@edit')->name('register.edit');
Route::get('register/create','RegisterController@create')->name('register.create');
Route::post('register','RegisterController@store')->name('register.store');