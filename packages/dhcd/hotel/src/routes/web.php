<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/hotel/log', 'HotelController@log')->name('dhcd.hotel.log');
        Route::get('dhcd/hotel/data', 'HotelController@data')->name('dhcd.hotel.data');
        Route::get('dhcd/hotel/manage', 'HotelController@manage')->where('as','Quản lý khách sạn')->name('dhcd.hotel.manage');
        Route::get('dhcd/hotel/create', 'HotelController@create')->name('dhcd.hotel.create');
        Route::post('dhcd/hotel/add', 'HotelController@add')->name('dhcd.hotel.add');
        Route::get('dhcd/hotel/show', 'HotelController@show')->name('dhcd.hotel.show');
        Route::put('dhcd/hotel/update', 'HotelController@update')->name('dhcd.hotel.update');
        Route::get('dhcd/hotel/delete', 'HotelController@delete')->name('dhcd.hotel.delete');
        Route::get('dhcd/hotel/confirm-delete', 'HotelController@getModalDelete')->name('dhcd.hotel.confirm-delete');
    });
});