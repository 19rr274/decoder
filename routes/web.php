<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');}); 
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/guest', [App\Http\Controllers\HomeController::class, 'guest']);
Route::get('/{id}/edit', [App\Http\Controllers\HomeController::class, 'edit']);
Route::get('/{id}/delete', [App\Http\Controllers\HomeController::class, 'delete']);
Route::get('/load', [App\Http\Controllers\HomeController::class, 'loaddb']);

Route::post('/upload', [App\Http\Controllers\HomeController::class, 'upload']);
Route::post('/save', [App\Http\Controllers\HomeController::class, 'save']);
Route::post('/find', [App\Http\Controllers\HomeController::class, 'find']);
Route::post('/runpro', [App\Http\Controllers\HomeController::class, 'runpro']);
 