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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/{id}/edit', [App\Http\Controllers\HomeController::class, 'edit']);
Route::get('/{id}/delete', [App\Http\Controllers\HomeController::class, 'delete']);
Route::post('/upload', [App\Http\Controllers\HomeController::class, 'upload']);

Route::post('/{id}/save', [App\Http\Controllers\HomeController::class, 'save']);
Route::post('/{id}/run', [App\Http\Controllers\HomeController::class, 'run']);



Route::post('/{id}/find', [App\Http\Controllers\HomeController::class, 'find']);

Route::get('/runpro', [App\Http\Controllers\HomeController::class, 'runpro']);
 