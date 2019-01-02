<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(array('prefix' => 'vne/news-rldv/news'), function() {
            Route::get('log', 'NewsController@log')->name('vne.newsrldv.news.log');
            Route::get('data', 'NewsController@data')->name('vne.newsrldv.news.data');
            Route::get('manager', 'NewsController@manager')->name('vne.newsrldv.news.manager')->where('as','Tin tức rldv - Danh sách');
            Route::get('create', 'NewsController@create')->name('vne.newsrldv.news.create');
            Route::post('add', 'NewsController@add')->name('vne.newsrldv.news.add');
            Route::get('show/{news_id}', 'NewsController@show')->where('news_id', '[0-9]+')->name('vne.newsrldv.news.show');
            Route::post('update/{news_id}', 'NewsController@update')->where('news_id', '[0-9]+')->name('vne.newsrldv.news.update');
            Route::get('delete', 'NewsController@delete')->name('vne.newsrldv.news.delete');
            Route::get('confirm-delete', 'NewsController@getModalDelete')->name('vne.newsrldv.news.confirm-delete');

            Route::get('status', 'NewsController@status')->name('vne.newsrldv.news.status');
            Route::get('confirm-status', 'NewsController@getModalStatus')->name('vne.newsrldv.news.confirm-status');

            Route::get('alias', 'NewsController@alias')->name('alias');
        });
        //route news cat
        Route::group(array('prefix' => 'vne/news-rldv/cat'), function() {
            Route::get('log', 'NewsCatController@log')->name('vne.newsrldv.cat.log');
            Route::get('data', 'NewsCatController@data')->name('vne.newsrldv.cat.data');
            Route::get('manager', 'NewsCatController@manager')->name('vne.newsrldv.cat.manager')->where('as','Tin tức rldv - Danh mục');
            Route::get('create', 'NewsCatController@create')->name('vne.newsrldv.cat.create');
            Route::post('add', 'NewsCatController@add')->name('vne.newsrldv.cat.add');
            Route::get('show', 'NewsCatController@show')->where('news_cat_id', '[0-9]+')->name('vne.newsrldv.cat.show');
            Route::post('update', 'NewsCatController@update')->where('news_cat_id', '[0-9]+')->name('vne.newsrldv.cat.update');
            Route::get('delete', 'NewsCatController@delete')->name('vne.newsrldv.cat.delete');
            Route::get('confirm-delete', 'NewsCatController@getModalDelete')->name('vne.newsrldv.cat.confirm-delete');

            Route::get('api/list', 'NewsCatController@getCateApi')->name('vne.api.news.category');
            Route::get('api/list/box', 'NewsBoxController@getBoxApi')->name('vne.api.news.box');
        });

        //route new tag 
        Route::group(array('prefix' => 'vne/news-rldv/tag'), function() {
            Route::get('log', 'NewsTagController@log')->name('vne.newsrldv.tag.log');
            Route::get('data', 'NewsTagController@data')->name('vne.newsrldv.tag.data');
            Route::get('manager', 'NewsTagController@manager')->name('vne.newsrldv.tag.manager')->where('as','Tin tức rldv - Tag');
            Route::get('create', 'NewsTagController@create')->name('vne.newsrldv.tag.create');
            Route::post('add', 'NewsTagController@add')->name('vne.newsrldv.tag.add');
            Route::get('show', 'NewsTagController@show')->where('vne.newsrldv.tag.news_id', '[0-9]+')->name('vne.newsrldv.tag.show');
            Route::post('update', 'NewsTagController@update')->where('news_id', '[0-9]+')->name('vne.newsrldv.tag.update');
            Route::get('delete', 'NewsTagController@delete')->name('vne.newsrldv.tag.delete');
            Route::get('confirm-delete', 'NewsTagController@getModalDelete')->name('vne.newsrldv.tag.confirm-delete');

            Route::post('ajax/add', 'NewsTagController@addAjax')->name('vne.newsrldv.tag.ajax.add');
        });

        //route new box 
        Route::group(array('prefix' => 'vne/news-rldv/box'), function() {
            Route::get('log', 'NewsBoxController@log')->name('vne.newsrldv.box.log');
            Route::get('data', 'NewsBoxController@data')->name('vne.newsrldv.box.data');
            Route::get('manager', 'NewsBoxController@manager')->name('vne.newsrldv.box.manager')->where('as','Tin tức rldv - box');
            Route::get('create', 'NewsBoxController@create')->name('vne.newsrldv.box.create');
            Route::post('add', 'NewsBoxController@add')->name('vne.newsrldv.box.add');
            Route::get('show', 'NewsBoxController@show')->where('news_id', '[0-9]+')->name('vne.newsrldv.box.show');
            Route::post('update', 'NewsBoxController@update')->where('news_id', '[0-9]+')->name('vne.newsrldv.box.update');
            Route::get('delete', 'NewsBoxController@delete')->name('vne.newsrldv.box.delete');
            Route::get('confirm-delete', 'NewsBoxController@getModalDelete')->name('vne.newsrldv.box.confirm-delete');

            Route::post('ajax/add', 'NewsBoxController@addAjax')->name('vne.newsrldv.box.ajax.add');
        });

        //page
        Route::group(array('prefix' => 'vne/news/page'), function() {
            Route::get('log', 'PageController@log')->name('vne.newsrldv.page.log');
            Route::get('data', 'PageController@data')->name('vne.newsrldv.page.data');
            Route::get('manager', 'PageController@manager')->name('vne.newsrldv.page.manager')->where('as','Trang tĩnh rldv - Danh sách');
            Route::get('create', 'PageController@create')->name('vne.newsrldv.page.create');
            Route::post('add', 'PageController@add')->name('vne.newsrldv.page.add');
            Route::get('show', 'PageController@show')->where('news_id', '[0-9]+')->name('vne.newsrldv.page.show');
            Route::post('update', 'PageController@update')->where('news_id', '[0-9]+')->name('vne.newsrldv.page.update');
            Route::get('delete', 'PageController@delete')->name('vne.newsrldv.page.delete');
            Route::get('confirm-delete', 'PageController@getModalDelete')->name('vne.newsrldv.page.confirm-delete');
        });

    });
});
$apiPrefix = config('site.api_prefix');

Route::group(array('prefix' => $apiPrefix), function() {
    Route::group(array('prefix' => 'news'), function() {
        Route::get('list', 'ApiNewsController@getListNewsApi');
        Route::get('detail', 'ApiNewsController@getDetailNewsApi');
        Route::get('list-by-box', 'ApiNewsController@getListNewsByBoxApi');
    });
});