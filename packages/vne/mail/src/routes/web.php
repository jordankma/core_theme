<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/mail/demo/log', 'DemoController@log')->name('vne.mail.demo.log');
        Route::get('vne/mail/demo/data', 'DemoController@data')->name('vne.mail.demo.data');
        Route::get('vne/mail/demo/manage', 'DemoController@manage')->name('vne.mail.demo.manage');
        Route::get('vne/mail/demo/create', 'DemoController@create')->name('vne.mail.demo.create');
        Route::post('vne/mail/demo/add', 'DemoController@add')->name('vne.mail.demo.add');
        Route::get('vne/mail/demo/show', 'DemoController@show')->name('vne.mail.demo.show');
        Route::put('vne/mail/demo/update', 'DemoController@update')->name('vne.mail.demo.update');
        Route::get('vne/mail/demo/delete', 'DemoController@delete')->name('vne.mail.demo.delete');
        Route::get('vne/mail/demo/confirm-delete', 'DemoController@getModalDelete')->name('vne.mail.demo.confirm-delete');
    });
});