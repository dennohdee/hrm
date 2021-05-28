<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/users/get_all', [App\Http\Controllers\UserController::class, 'getAllUsers'])->name('users.get');
Route::any('/users/add', [App\Http\Controllers\UserController::class, 'addUser'])->name('users.add');
Route::post('/users/update', [App\Http\Controllers\UserController::class, 'editUser'])->name('users.edit');
Route::get('/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');