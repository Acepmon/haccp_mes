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

// Route::middleware('auth:sanctum')->get('/session', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'namespace' => 'API',
    'prefix' => 'auth'
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group([
    'namespace' => 'API',
    'as' => 'api.',
    // 'middleware' => 'auth:sanctum',
], function () {
    Route::get('user/download', 'UserController@download')->name('user.download');
    Route::apiResource('user', 'UserController');

    Route::apiResource('login_hist', 'LoginHistController');

    Route::get('code', 'CommCdController@code')->name('code');
    Route::post('comm_cd/{comm1cd}/sync', 'CommCdController@sync');
    Route::apiResource('comm_cd', 'CommCdController')->except(['show', 'store', 'destroy', 'update']);

    Route::apiResource('comp_info', 'CompInfoController')->except(['show', 'update']);

    Route::get('worker/download', 'WorkerController@download')->name('worker.download');
    Route::apiResource('worker', 'WorkerController');

    Route::get('haccp_mst_file/download', 'HaccpMstFileController@download')->name('haccp_mst_file.download');
    Route::get('haccp_mst_file/{REV_SEQ}/att_file/{ATT_SEQ}/download', 'HaccpMstFileController@downloadAttFile')->name('haccp_mst_file.att_file.download');
    Route::apiResource('haccp_mst_file', 'HaccpMstFileController');

    Route::get('doc_mgmt/download', 'DocMgmtController@download')->name('doc_mgmt.download');
    Route::get('doc_mgmt/{REV_SEQ}/att_file/{ATT_SEQ}/download', 'DocMgmtController@downloadAttFile')->name('doc_mgmt.att_file.download');
    Route::apiResource('doc_mgmt', 'DocMgmtController');

    Route::get('edoc_file/download', 'EdocFileController@download')->name('edoc_file.download');
    Route::apiResource('edoc_file', 'EdocFileController')->except(['store', 'show', 'destroy']);

    Route::get('secu_doc_mgmt/download', 'SecuDocMgmtController@download')->name('secu_doc_mgmt.download');
    Route::get('secu_doc_mgmt/{REV_SEQ}/att_file/{ATT_SEQ}/download', 'SecuDocMgmtController@downloadAttFile')->name('secu_doc_mgmt.att_file.download');
    Route::apiResource('secu_doc_mgmt', 'SecuDocMgmtController');
});