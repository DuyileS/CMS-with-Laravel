<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/post/{post}', 'App\Http\Controllers\PostController@show');

Route::middleware('auth')->group(function(){

    Route::get('/admin', 'App\Http\Controllers\AdminsController@index');
    Route::get('/admin/post/create', 'App\Http\Controllers\PostController@create');
    Route::post('/admin/post', 'App\Http\Controllers\PostController@store');
    Route::get('/admin/post/index', 'App\Http\Controllers\PostController@index')->name('post.index');
    Route::get('/admin/post/{post}/edit', 'App\Http\Controllers\PostController@edit')->name('post.edit');
    Route::delete('/admin/post/{post}/destroy', 'App\Http\Controllers\PostController@destroy')->name('post.destroy');
    Route::patch('/admin/post/{post}/update', 'App\Http\Controllers\PostController@update')->name('post.update');


    Route::put('/admin/users/{user}/update', 'App\Http\Controllers\UserController@update')->name('user.profile.update');
    Route::delete('/admin/users/{user}/destroy', 'App\Http\Controllers\UserController@destroy')->name('user.destroy');
});

Route::middleware('role:Admin')->group(function(){

    Route::get('/admin/users', 'App\Http\Controllers\UserController@index')->name('users.index');
    Route::put('/admin/users/{user}/attach', 'App\Http\Controllers\UserController@attach')->name('user.role.attach');
    Route::put('/admin/users/{user}/detach', 'App\Http\Controllers\UserController@detach')->name('user.role.detach');

});

Route::middleware(['can:view,user'])->group(function(){

    Route::get('/admin/users/{user}/profile', 'App\Http\Controllers\UserController@show')->name('user.profile.show');

});