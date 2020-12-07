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

// Route::group([
//     'namespace' => 'API',
//     'prefix' => 'auth'
// ], function () {
//     Route::post('register', 'AuthController@register');
//     Route::post('login', 'AuthController@login');
//     Route::get('refresh', 'AuthController@refresh');

//     Route::group(['middleware' => 'auth:api'], function () {
//         Route::get('user', 'AuthController@user');
//         Route::post('logout', 'AuthController@logout');
//     });
// });

Route::group([
    'namespace' => 'API',
    'as' => 'api.'
    // 'middleware' => 'auth:api',
], function () {
    Route::get('user/download', 'UserController@download')->name('user.download');
    Route::apiResource('user', 'UserController');

    Route::apiResource('login_hist', 'LoginHistController');

    Route::get('comm_cd/roles', 'CommCdController@roles')->name('comm_cd.roles');
    Route::get('comm_cd/approvals', 'CommCdController@approvals')->name('comm_cd.approvals');
    Route::get('comm_cd/jobs', 'CommCdController@jobs')->name('comm_cd.jobs');
    Route::apiResource('comm_cd', 'CommCdController')->except(['show', 'store', 'destroy', 'update']);
});