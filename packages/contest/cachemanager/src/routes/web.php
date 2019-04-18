<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(['prefix' => 'contest/cachemanager/contest_cache/', 'as' => 'contest.cachemanager.contest_cache.'], function () {
            Route::get('log', 'ContestCacheController@log')->name('log');
            Route::get('data', 'ContestCacheController@data')->name('data');
            Route::get('manage', 'ContestCacheController@manage')->where('as','Danh sách cache')->name('manage');
            Route::get('create', 'ContestCacheController@create')->name('create');
            Route::post('add', 'ContestCacheController@add')->name('add');
            Route::get('show', 'ContestCacheController@show')->name('show');
            Route::put('update', 'ContestCacheController@update')->name('update');
            Route::get('delete', 'ContestCacheController@delete')->name('delete');
            Route::get('reload', 'ContestCacheController@reload')->name('reload');
            Route::get('confirm-delete', 'ContestCacheController@getModalDelete')->name('confirm-delete');

        });
    });
});