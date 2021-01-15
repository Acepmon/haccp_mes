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

Route::post('/sanctum/token', 'SanctumController@token');

Route::group([
    'namespace' => 'APP',
    'as' => 'app.',
    'middleware' => 'auth:sanctum'
], function () {
    Route::post('haccp/apprequest', 'AppController@apprequest')->name('haccp.apprequest');
});

Route::group([
    'namespace' => 'API',
    'prefix' => 'auth'
], function () {
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::get('user/notifications', 'AuthController@notifications');
        Route::get('user/notifications/unread', 'AuthController@unreadNotifications');
        Route::post('user/notifications', 'AuthController@readAllNotifications');
        Route::delete('user/notifications', 'AuthController@deleteNotifications');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group([
    'namespace' => 'API',
    'as' => 'api.',
    // 'middleware' => 'auth:sanctum',
], function () {
    Route::get('user/download', 'UserController@download')->name('user.download');
    Route::put('user/{userId}/password', 'UserController@password')->name('user.password');
    Route::apiResource('user', 'UserController');

    Route::apiResource('login_hist', 'LoginHistController');

    Route::get('code', 'CommCdController@code')->name('code');
    Route::post('comm_cd/{comm1cd}/sync', 'CommCdController@sync');
    Route::apiResource('comm_cd', 'CommCdController')->except(['show', 'store', 'update']);

    Route::apiResource('comp_info', 'CompInfoController')->except(['show', 'update']);

    Route::get('worker/download', 'WorkerController@download')->name('worker.download');
    Route::apiResource('worker', 'WorkerController');

    Route::get('haccp_mst_file/download', 'HaccpMstFileController@download')->name('haccp_mst_file.download');
    Route::get('haccp_mst_file/{REV_SEQ}/att_file/{ATT_SEQ}/download', 'HaccpMstFileController@downloadAttFile')->name('haccp_mst_file.att_file.download');
    Route::apiResource('haccp_mst_file', 'HaccpMstFileController');

    Route::get('doc_mgmt/download', 'DocMgmtController@download')->name('doc_mgmt.download');
    Route::get('doc_mgmt/{REV_SEQ}/att_file/{ATT_SEQ}/download', 'DocMgmtController@downloadAttFile')->name('doc_mgmt.att_file.download');
    Route::apiResource('doc_mgmt', 'DocMgmtController');

    Route::get('edoc_file/{DOC_ID}/preview', 'EdocFileController@preview')->name('edoc_file.preview');
    Route::get('edoc_file/{DOC_ID}/qr_write', 'EdocFileController@qrWrite')->name('edoc_file.qr_write');
    Route::get('edoc_file/{DOC_ID}/qr_approval', 'EdocFileController@qrApproval')->name('edoc_file.qr_approval');
    Route::get('edoc_file/download', 'EdocFileController@download')->name('edoc_file.download');
    Route::apiResource('edoc_file', 'EdocFileController')->except(['store', 'show', 'destroy']);

    Route::get('secu_doc_mgmt/download', 'SecuDocMgmtController@download')->name('secu_doc_mgmt.download');
    Route::get('secu_doc_mgmt/{REV_SEQ}/att_file/{ATT_SEQ}/download', 'SecuDocMgmtController@downloadAttFile')->name('secu_doc_mgmt.att_file.download');
    Route::apiResource('secu_doc_mgmt', 'SecuDocMgmtController');

    Route::get('item_mst/export', 'ItemMstController@export')->name('item_mst.export');
    Route::post('item_mst/import', 'ItemMstController@import')->name('item_mst.import');
    Route::post('item_mst/sync', 'ItemMstController@sync')->name('item_mst.sync');
    Route::apiResource('item_mst', 'ItemMstController');

    Route::get('cust_info/export', 'CustInfoController@export')->name('cust_info.export');
    Route::post('cust_info/import', 'CustInfoController@import')->name('cust_info.import');
    Route::post('cust_info/sync', 'CustInfoController@sync')->name('cust_info.sync');
    Route::apiResource('cust_info', 'CustInfoController');
    
    //Route::get('lot_info/export', 'LotInfoController@export')->name('lot_info.export');
    Route::post('lot_info/import', 'LotInfoController@import')->name('lot_info.import');
    Route::post('lot_info/sync', 'LotInfoController@sync')->name('lot_info.sync');
    Route::apiResource('lot_info', 'LotInfoController');

    Route::get('bom_config/export', 'BomConfigController@export')->name('bom_config.export');
    Route::post('bom_config/import', 'BomConfigController@import')->name('bom_config.import');
    Route::post('bom_config/sync', 'BomConfigController@sync')->name('bom_config.sync');
    Route::apiResource('bom_config', 'BomConfigController');

    Route::get('proc_dtl/export', 'ProcDtlController@export')->name('proc_dtl.export');
    Route::post('proc_dtl/import', 'ProcDtlController@import')->name('proc_dtl.import');
    Route::post('proc_dtl/sync', 'ProcDtlController@sync')->name('proc_dtl.sync');
    Route::apiResource('proc_dtl', 'ProcDtlController');

    Route::get('proc_src/export', 'ProcSrcController@export')->name('proc_src.export');
    Route::post('proc_src/import', 'ProcSrcController@import')->name('proc_src.import');
    Route::post('proc_src/sync', 'ProcSrcController@sync')->name('proc_src.sync');
    Route::apiResource('proc_src', 'ProcSrcController');

    Route::apiResource('proc_dtl_sub', 'ProcDtlSubController');

    Route::post('proc_unified/import', 'ProcUnifiedController@import')->name('proc_unified.import');

    Route::get('job_ord/export', 'JobOrdController@export')->name('job_ord.export');
    Route::get('job_ord/summary_export', 'JobOrdController@summaryExport')->name('job_ord.summary_export');
    Route::get('job_ord/summary_details', 'JobOrdController@summaryDetails')->name('job_ord.summary_details');
    Route::post('job_ord/import', 'JobOrdController@import')->name('job_ord.import');
    Route::post('job_ord/sync', 'JobOrdController@sync')->name('job_ord.sync');
    Route::apiResource('job_ord', 'JobOrdController');

    Route::get('job_ord_dtl/export', 'JobOrdDtlController@export')->name('job_ord_dtl.export');
    Route::post('job_ord_dtl/import', 'JobOrdDtlController@import')->name('job_ord_dtl.import');
    Route::post('job_ord_dtl/sync', 'JobOrdDtlController@sync')->name('job_ord_dtl.sync');
    Route::apiResource('job_ord_dtl', 'JobOrdDtlController');

    Route::get('haccp_monitor/ccp_data', 'HaccpMonitorController@ccp_data');
    Route::get('haccp_monitor/ccp_data/{DEVICE_ID}', 'HaccpMonitorController@ccp_data_details');

    Route::apiResource('ccp_limit', 'CcpLimitController');

    Route::apiResource('ccp_esc_data', 'CcpEscDataController');

    Route::apiResource('edoc_file_haccp', 'EdocFileHaccpController');
});