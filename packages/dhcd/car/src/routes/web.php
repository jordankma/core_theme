<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/car/log', 'CarController@log')->name('dhcd.car.log');
        Route::get('dhcd/car/data', 'CarController@data')->name('dhcd.car.data');
        Route::get('dhcd/car/manage', 'CarController@manage')->where('as','Quản lý xe')->name('dhcd.car.manage');
        Route::get('dhcd/car/create', 'CarController@create')->name('dhcd.car.create');
        Route::post('dhcd/car/add', 'CarController@add')->name('dhcd.car.add');
        Route::get('dhcd/car/show', 'CarController@show')->name('dhcd.car.show');
        Route::put('dhcd/car/update', 'CarController@update')->name('dhcd.car.update');
        Route::get('dhcd/car/delete', 'CarController@delete')->name('dhcd.car.delete');
        Route::get('dhcd/car/confirm-delete', 'CarController@getModalDelete')->name('dhcd.car.confirm-delete');
    });
});