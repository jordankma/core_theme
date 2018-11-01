<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/companionunit/log', 'CompanionunitController@log')->name('vne.companionunit.log');
        Route::get('vne/companionunit/data', 'CompanionunitController@data')->name('vne.companionunit.data');
        Route::get('vne/companionunit/manage', 'CompanionunitController@manage')->where('as', 'Đơn vị đồng hành')->name('vne.companionunit.manage');
        Route::get('vne/companionunit/create', 'CompanionunitController@create')->name('vne.companionunit.create');
        Route::post('vne/companionunit/add', 'CompanionunitController@add')->name('vne.companionunit.add');
        Route::get('vne/companionunit/show', 'CompanionunitController@show')->name('vne.companionunit.show');
        Route::put('vne/companionunit/update', 'CompanionunitController@update')->name('vne.companionunit.update');
        Route::get('vne/companionunit/delete', 'CompanionunitController@delete')->name('vne.companionunit.delete');
        Route::get('vne/companionunit/confirm-delete', 'CompanionunitController@getModalDelete')->name('vne.companionunit.confirm-delete');

        Route::get('vne/comgroup/create', 'ComgroupController@create')->name('vne.comgroup.create');
        Route::post('vne/comgroup/add', 'ComgroupController@add')->name('vne.comgroup.add');
        Route::get('vne/comgroup/manage', 'ComgroupController@manage')->where('as', 'Đơn vị đồng hành')->name('vne.comgroup.manage');
        Route::get('vne/comgroup/data', 'ComgroupController@data')->name('vne.comgroup.data');
        Route::get('vne/comgroup/show', 'ComgroupController@show')->name('vne.comgroup.show');
        Route::get('vne/comgroup/log', 'ComgroupController@log')->name('vne.comgroup.log');
        Route::put('vne/comgroup/update', 'ComgroupController@update')->name('vne.comgroup.update');
        Route::get('vne/comgroup/delete', 'ComgroupController@delete')->name('vne.comgroup.delete');
        Route::get('vne/comgroup/confirm-delete', 'ComgroupController@getModalDelete')->name('vne.comgroup.confirm-delete');

    });
});
Route::get('vne/getcomunit', 'CompanionunitController@getcomunit')->name('vne.getcomunit');