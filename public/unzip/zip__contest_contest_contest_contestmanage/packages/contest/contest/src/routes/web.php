<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['prefix' => 'api/', 'as' => 'api.'], function () {
        \Debugbar::disable();
        Route::get('', 'ContestController@getApi')->name('api');
        Route::get('test_question_pack', 'ApiController@testQuestionPack')->name('testQuestionPack');
        Route::get('get_contest_config', 'ApiController@getContestConfig')->name('get_contest_config');
    });
    Route::group(['prefix' => 'api/contest/list', 'as' => 'api.contest.list.'], function () {
        Route::get('list_contest', 'ContestController@getList')->name('list_contest');
        Route::get('get_contest', 'ContestController@getContest')->name('get_contest');
    });

    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(['prefix' => 'contest/contest/contest_list', 'as' => 'contest.contest.contest_list.'], function () {
            Route::get('log', 'ContestController@log')->name('log');
            Route::get('data', 'ContestController@data')->name('data');
            Route::get('manage', 'ContestController@manage')->where('as','Danh sách cuộc thi')->name('manage');
            Route::get('create', 'ContestController@create')->name('create');
            Route::post('add', 'ContestController@add')->name('add');
            Route::get('show', 'ContestController@show')->name('show');
            Route::put('update', 'ContestController@update')->name('update');
            Route::get('delete', 'ContestController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestController@getModalDelete')->name('confirm-delete');
        });
    });
});