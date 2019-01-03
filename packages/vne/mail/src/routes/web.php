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
        Route::group(array('prefix' => 'vne/mail/sent'), function() {
            Route::get('create/hddtw', 'SentController@createHddtw')->name('vne.mail.sent.create.hddtw');
            Route::post('add/hddtw', 'SentController@addHddtw')->name('vne.mail.sent.add.hddtw');
            Route::get('create/tinh-thanhpho', 'SentController@createTinhThanhPho')->name('vne.mail.sent.create.tinh-thanhpho');
            Route::post('add/tinh-thanhpho', 'SentController@addTinhThanhPho')->name('vne.mail.sent.add.tinh-thanhpho');
            Route::get('create/quan-huyen', 'SentController@createQuanHuyen')->name('vne.mail.sent.create.quan-huyen');
            Route::post('add/quan-huyen', 'SentController@addQuanHuyen')->name('vne.mail.sent.add.quan-huyen');
            Route::get('create/truong', 'SentController@createTruong')->name('vne.mail.sent.create.truong');
            Route::post('add/truong', 'SentController@addTruong')->name('vne.mail.sent.add.truong');
            Route::get('create/phu-huynh', 'SentController@createPhuHuynh')->name('vne.mail.sent.create.phu-huynh');
            Route::post('add/phu-huynh', 'SentController@addPhuHuynh')->name('vne.mail.sent.add.phu-huynh');
        });
    });
});