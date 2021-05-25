<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::get('/', function(){
    return redirect('/users');
});

// ====== orders Routes =========//
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::post('/users/add', [App\Http\Controllers\UserController::class, 'addUser'])->name('users.add');
Route::post('/users/update', [App\Http\Controllers\UserController::class, 'editUser'])->name('users.edit');
Route::get('/users/get', [App\Http\Controllers\UserController::class, 'getUsers'])->name('users.get');
Route::get('/users/get_all', [App\Http\Controllers\UserController::class, 'getAllUsers'])->name('users.get');
Route::get('/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');