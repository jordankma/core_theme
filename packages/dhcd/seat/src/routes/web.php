<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/seat/log', 'SeatController@log')->name('dhcd.seat.log');
        Route::get('dhcd/seat/data', 'SeatController@data')->name('dhcd.seat.data');
        Route::get('dhcd/seat/manage', 'SeatController@manage')->where('as','Quản lý chỗ ngồi')->name('dhcd.seat.manage');
        Route::get('dhcd/seat/create', 'SeatController@create')->name('dhcd.seat.create');
        Route::post('dhcd/seat/add', 'SeatController@add')->name('dhcd.seat.add');
        Route::get('dhcd/seat/show', 'SeatController@show')->name('dhcd.seat.show');
        Route::put('dhcd/seat/update', 'SeatController@update')->name('dhcd.seat.update');
        Route::get('dhcd/seat/delete', 'SeatController@delete')->name('dhcd.seat.delete');
        Route::get('dhcd/seat/confirm-delete', 'SeatController@getModalDelete')->name('dhcd.seat.confirm-delete');
    });
});