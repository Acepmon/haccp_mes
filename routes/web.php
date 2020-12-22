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

Route::get('/login', 'LoginController@login')->name('login');
Route::get('/reset-password', 'LoginController@resetPassword')->name('reset-password');
Route::post('/auth', 'LoginController@authenticate')->name('auth');
Route::post('/logout', 'LoginController@logout')->name('logout');

Route::get('/{any}', 'ApplicationController')->where('any', '.*')->middleware('auth:sanctum');
// Route::get('/{any}', 'ApplicationController')->where('any', '.*');
