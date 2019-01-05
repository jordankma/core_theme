<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('contest/contestclient/demo/log', 'DemoController@log')->name('contest.contestclient.demo.log');
        Route::get('contest/contestclient/demo/data', 'DemoController@data')->name('contest.contestclient.demo.data');
        Route::get('contest/contestclient/demo/manage', 'DemoController@manage')->name('contest.contestclient.demo.manage');
        Route::get('contest/contestclient/demo/create', 'DemoController@create')->name('contest.contestclient.demo.create');
        Route::post('contest/contestclient/demo/add', 'DemoController@add')->name('contest.contestclient.demo.add');
        Route::get('contest/contestclient/demo/show', 'DemoController@show')->name('contest.contestclient.demo.show');
        Route::put('contest/contestclient/demo/update', 'DemoController@update')->name('contest.contestclient.demo.update');
        Route::get('contest/contestclient/demo/delete', 'DemoController@delete')->name('contest.contestclient.demo.delete');
        Route::get('contest/contestclient/demo/confirm-delete', 'DemoController@getModalDelete')->name('contest.contestclient.demo.confirm-delete');
    });
});