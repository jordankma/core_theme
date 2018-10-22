<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(array('prefix' => 'vne/news/news','as' => 'vne.news.news'), function() {
            Route::get('log', 'NewsController@log')->name('log');
            Route::get('data', 'NewsController@data')->name('data');
            Route::get('manager', 'NewsController@manager')->name('manager')->where('as','Tin tức - Danh sách');
            Route::get('create', 'NewsController@create')->name('create');
            Route::post('add', 'NewsController@add')->name('add');
            Route::get('show/{news_id}', 'NewsController@show')->where('news_id', '[0-9]+')->name('show');
            Route::post('update/{news_id}', 'NewsController@update')->where('news_id', '[0-9]+')->name('update');
            Route::get('delete', 'NewsController@delete')->name('delete');
            Route::get('confirm-delete', 'NewsController@getModalDelete')->name('confirm-delete');

            Route::get('alias', 'NewsController@alias')->name('alias');
        });
        //route news cat
        Route::group(array('prefix' => 'vne/news/cat','as' => 'vne.news.cat'), function() {
            Route::get('log', 'NewsCatController@log')->name('log');
            Route::get('data', 'NewsCatController@data')->name('data');
            Route::get('manager', 'NewsCatController@manager')->name('manager')->where('as','Tin tức - Danh mục');
            Route::get('create', 'NewsCatController@create')->name('create');
            Route::post('add', 'NewsCatController@add')->name('add');
            Route::get('show', 'NewsCatController@show')->where('news_cat_id', '[0-9]+')->name('show');
            Route::post('update', 'NewsCatController@update')->where('news_cat_id', '[0-9]+')->name('update');
            Route::get('delete', 'NewsCatController@delete')->name('delete');
            Route::get('confirm-delete', 'NewsCatController@getModalDelete')->name('confirm-delete');

            Route::get('api/list', 'NewsCatController@getCateApi')->name('vne.api.news.category');
        });

        //route new tag 
        Route::group(array('prefix' => 'vne/news/tag','as' => 'vne.news.tag'), function() {
            Route::get('log', 'NewsTagController@log')->name('log');
            Route::get('data', 'NewsTagController@data')->name('data');
            Route::get('manager', 'NewsTagController@manager')->name('manager')->where('as','Tin tức - Tag');
            Route::get('create', 'NewsTagController@create')->name('create');
            Route::post('add', 'NewsTagController@add')->name('add');
            Route::get('show', 'NewsTagController@show')->where('news_id', '[0-9]+')->name('show');
            Route::post('update', 'NewsTagController@update')->where('news_id', '[0-9]+')->name('update');
            Route::get('delete', 'NewsTagController@delete')->name('delete');
            Route::get('confirm-delete', 'NewsTagController@getModalDelete')->name('confirm-delete');

            Route::post('ajax/add', 'NewsTagController@addAjax')->name('ajax.add');
        });

        //route new box 
        Route::group(array('prefix' => 'vne/news/box','as' => 'vne.news.box'), function() {
            Route::get('log', 'NewsBoxController@log')->name('log');
            Route::get('data', 'NewsBoxController@data')->name('data');
            Route::get('manager', 'NewsBoxController@manager')->name('manager')->where('as','Tin tức - box');
            Route::get('create', 'NewsBoxController@create')->name('create');
            Route::post('add', 'NewsBoxController@add')->name('add');
            Route::get('show', 'NewsBoxController@show')->where('news_id', '[0-9]+')->name('show');
            Route::post('update', 'NewsBoxController@update')->where('news_id', '[0-9]+')->name('update');
            Route::get('delete', 'NewsBoxController@delete')->name('delete');
            Route::get('confirm-delete', 'NewsBoxController@getModalDelete')->name('confirm-delete');

            Route::post('ajax/add', 'NewsBoxController@addAjax')->name('vne.news.box.ajax.add');
        });

        //page
        Route::group(array('prefix' => 'vne/news/page','as' => 'vne.news.page'), function() {
            Route::get('log', 'PageController@log')->name('log');
            Route::get('data', 'PageController@data')->name('data');
            Route::get('manager', 'PageController@manager')->name('manager')->where('as','Trang tĩnh - Danh sách');
            Route::get('create', 'PageController@create')->name('create');
            Route::post('add', 'PageController@add')->name('add');
            Route::get('show', 'PageController@show')->where('news_id', '[0-9]+')->name('show');
            Route::post('update', 'PageController@update')->where('news_id', '[0-9]+')->name('update');
            Route::get('delete', 'PageController@delete')->name('delete');
            Route::get('confirm-delete', 'PageController@getModalDelete')->name('confirm-delete');
        });

    });
    Route::group(array('prefix' => 'resouce/api/news'), function() {
        Route::get('list', 'ApiNewsController@getListNewsApi');
        Route::get('detail', 'ApiNewsController@getDetailNewsApi');
        Route::get('list-by-box', 'ApiNewsController@getListNewsByBoxApi');

    });
});