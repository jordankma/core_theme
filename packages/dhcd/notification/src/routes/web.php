<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/notification/notification/log', 'NotificationController@log')->name('dhcd.notification.notification.log');
        Route::get('dhcd/notification/notification/data', 'NotificationController@data')->name('dhcd.notification.notification.data');
        Route::get('dhcd/notification/notification/manage', 'NotificationController@manage')->name('dhcd.notification.notification.manage')->where('as','Thông báo - Danh sách');
        Route::get('dhcd/notification/notification/create', 'NotificationController@create')->name('dhcd.notification.notification.create');
        Route::post('dhcd/notification/notification/add', 'NotificationController@add')->name('dhcd.notification.notification.add');
        Route::get('dhcd/notification/notification/show', 'NotificationController@show')->name('dhcd.notification.notification.show');
        Route::post('dhcd/notification/notification/update', 'NotificationController@update')->name('dhcd.notification.notification.update');
        Route::get('dhcd/notification/notification/delete', 'NotificationController@delete')->name('dhcd.notification.notification.delete');
        Route::get('dhcd/notification/notification/confirm-delete', 'NotificationController@getModalDelete')->name('dhcd.notification.notification.confirm-delete');
        //get modal sent notificatio
        Route::post('dhcd/notification/notification/sent', 'NotificationController@sent')->name('dhcd.notification.notification.sent');
        Route::get('dhcd/notification/notification/confirm-sent', 'NotificationController@getModalSent')->name('dhcd.notification.notification.confirm-sent');
        //route log sent

        Route::get('dhcd/notification/log-sent/data', 'LogSentController@data')->name('dhcd.notification.log-sent.data');
        Route::get('dhcd/notification/log-sent/manage', 'LogSentController@manage')->name('dhcd.notification.log-sent.manage')->where('as','Thông báo đã gửi - Danh sách');
        Route::get('dhcd/notification/log-sent/delete', 'LogSentController@delete')->name('dhcd.notification.log-sent.delete');
        Route::get('dhcd/notification/log-sent/confirm-delete', 'LogSentController@getModalDelete')->name('dhcd.notification.log-sent.confirm-delete');

        Route::get('api/notification/notification-list', 'NotificationController@notificationList');

    });
});