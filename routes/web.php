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

use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\GroupManager\CourseController;
use App\Http\Controllers\GroupManager\ReportController;
use App\Http\Controllers\GroupManager\SelectionController;
use App\Http\Controllers\GroupManager\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('reset-password',[HomeController::class, 'resetPassword'])->name('auth.reset-password');
Route::post('set-password', [HomeController::class, 'setPassword'])->name('auth.set-password');

Route::get('/',function (){
    $homePage = [
        'student' => 'register.create',
        'group_manager' => 'group-manager.user.index',
        'admin' => 'admin.user.index'
    ];

    if(auth()->guest())
        return to_route('login');
    else
        return to_route($homePage[auth()->user()->getRoleNames()[0]]);
});

Route::get('/test', [HomeController::class, 'test']);

Route::group(['middleware' => \App\Http\Middleware\Transactioner::class], function (){

    Route::group(['prefix' => 'register', 'as' => 'register.','middleware' => ['role:student']], function() {
        Route::post('',[RegisterController::class, 'store'])->name('store');
        Route::get('create',[RegisterController::class, 'create'])->name('create');
        Route::get('edit',[RegisterController::class, 'edit'])->name('edit');
        Route::post('confirm',[RegisterController::class, 'confirm'])->name('confirm');
    });

    Route::resource('term',TermController::class);
    Route::resource('admin/user',AdminUserController::class)->middleware(['role:admin'])->names('admin.user');

    Route::resource('course',CourseController::class);
    Route::resource('selection',SelectionController::class);
    Route::group(['prefix' => 'group-manager', 'as' => 'group-manager.','middleware' => ['role:group_manager']], function() {
        Route::get('user/import-file',[UserController::class, 'createFromFile'])->name('user.create-from-file');
        Route::post('user/import-file',[UserController::class, 'storeFromFile'])->name('user.store-from-file');
        Route::delete('user/bulk-delete',[UserController::class, 'bulkDelete'])->name('user.bulk-delete');
        Route::resource('user',UserController::class);
    });
    Route::group(['prefix' => 'report', 'as' => 'report.','middleware' => ['role:group_manager']], function() {
        Route::get('',[ReportController::class, 'index'])->name('index');
        Route::get('students',[ReportController::class, 'students'])->name('students');
        Route::get('courses/{user}',[ReportController::class, 'courses'])->name('courses');
    });
});
