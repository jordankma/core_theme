<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function () {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/timeline/log', 'TimelineController@log')->name('vne.timeline.log');
        Route::get('vne/timeline/data', 'TimelineController@data')->name('vne.timeline.data');
        Route::get('vne/timeline/manage', 'TimelineController@manage')->name('vne.timeline.manage');
        Route::get('vne/timeline/create', 'TimelineController@create')->where('as', 'Timeline')->name('vne.timeline.create');
        Route::post('vne/timeline/add', 'TimelineController@add')->name('vne.timeline.add');
        Route::get('vne/timeline/show', 'TimelineController@show')->name('vne.timeline.show');
        Route::put('vne/timeline/update', 'TimelineController@update')->name('vne.timeline.update');
        Route::post('vne/timeline/update', 'TimelineController@update')->name('vne.timeline.update');
        Route::get('vne/timeline/delete', 'TimelineController@delete')->name('vne.timeline.delete');
        Route::get('vne/timeline/confirm-delete', 'TimelineController@getModalDelete')->name('vne.timeline.confirm-delete');
    });
});

$apiPrefix = config('site.api_prefix');
Route::group(array('prefix' => $apiPrefix), function () {
//    Route::group(['middleware' => 'adtech.bearer'], function () {
        Route::get('vne/gettimeline', 'TimelineController@gettimeline')->name('vne.gettimeline');
//    });
});