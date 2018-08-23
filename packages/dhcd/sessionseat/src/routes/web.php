<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/sessionseat/log', 'SessionseatController@log')->name('dhcd.sessionseat.log');
        Route::get('dhcd/sessionseat/data', 'SessionseatController@data')->name('dhcd.sessionseat.data');
        Route::get('dhcd/sessionseat/manage', 'SessionseatController@manage')->where('as','Quản lý sơ đồ chỗ ngồi phiên họp')->name('dhcd.sessionseat.manage');
        Route::get('dhcd/sessionseat/create', 'SessionseatController@create')->name('dhcd.sessionseat.create');
        Route::post('dhcd/sessionseat/add', 'SessionseatController@add')->name('dhcd.sessionseat.add');
        Route::get('dhcd/sessionseat/show', 'SessionseatController@show')->name('dhcd.sessionseat.show');
        Route::put('dhcd/sessionseat/update', 'SessionseatController@update')->name('dhcd.sessionseat.update');
        Route::get('dhcd/sessionseat/delete', 'SessionseatController@delete')->name('dhcd.sessionseat.delete');
        Route::get('dhcd/sessionseat/confirm-delete', 'SessionseatController@getModalDelete')->name('dhcd.sessionseat.confirm-delete');
    });
});