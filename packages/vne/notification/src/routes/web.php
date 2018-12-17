<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(array('prefix' => 'vne/notification/notification'), function() {
            Route::get('log', 'NotificationController@log')->name('vne.notification.notification.log');
            Route::get('data', 'NotificationController@data')->name('vne.notification.notification.data');
            Route::get('manage', 'NotificationController@manage')->name('vne.notification.notification.manage')->where('as','Thông báo - Danh sách');
            Route::get('create', 'NotificationController@create')->name('vne.notification.notification.create');
            Route::post('add', 'NotificationController@add')->name('vne.notification.notification.add');
            Route::get('show', 'NotificationController@show')->name('vne.notification.notification.show');
            Route::post('update', 'NotificationController@update')->name('vne.notification.notification.update');
            Route::get('delete', 'NotificationController@delete')->name('vne.notification.notification.delete');
            Route::get('confirm-delete', 'NotificationController@getModalDelete')->name('vne.notification.notification.confirm-delete');
            //get modal sent notificatio
            Route::post('sent', 'NotificationController@sent')->name('vne.notification.notification.sent');
            Route::get('confirm-sent', 'NotificationController@getModalSent')->name('vne.notification.notification.confirm-sent');
            //route log sent
        });
        Route::group(array('prefix' => 'vne/notification/log-sent'), function() {
            Route::get('data', 'LogSentController@data')->name('vne.notification.log-sent.data');
            Route::get('manage', 'LogSentController@manage')->name('vne.notification.log-sent.manage')->where('as','Thông báo đã gửi - Danh sách');
            Route::get('delete', 'LogSentController@delete')->name('vne.notification.log-sent.delete');
            Route::get('confirm-delete', 'LogSentController@getModalDelete')->name('vne.notification.log-sent.confirm-delete');
        });    

        Route::get('api/notification/notification-list', 'NotificationController@notificationList');
    });
});
$apiPrefix = config('site.api_prefix');
Route::group(array('prefix' => $apiPrefix), function() {
	Route::group(array('prefix' => 'notification'), function() {
    	Route::get('list', 'LogSentController@getList');
    });
});