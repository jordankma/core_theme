<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/member/demo/log', 'DemoController@log')->name('vne.member.demo.log');
        Route::get('vne/member/demo/data', 'DemoController@data')->name('vne.member.demo.data');
        Route::get('vne/member/demo/manage', 'DemoController@manage')->name('vne.member.demo.manage');
        Route::get('vne/member/demo/create', 'DemoController@create')->name('vne.member.demo.create');
        Route::post('vne/member/demo/add', 'DemoController@add')->name('vne.member.demo.add');
        Route::get('vne/member/demo/show', 'DemoController@show')->name('vne.member.demo.show');
        Route::put('vne/member/demo/update', 'DemoController@update')->name('vne.member.demo.update');
        Route::get('vne/member/demo/delete', 'DemoController@delete')->name('vne.member.demo.delete');
        Route::get('vne/member/demo/confirm-delete', 'DemoController@getModalDelete')->name('vne.member.demo.confirm-delete');
    });
});