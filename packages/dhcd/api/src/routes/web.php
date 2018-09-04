<?php
$apiPrefix = config('site.api_prefix');
Route::group(array('prefix' => $apiPrefix), function() {
    Route::get('news-category', 'NewsController@listNewsCate')->name('dhcd.api.news.category');
    Route::get('tailieu-category', 'DocumentController@listDocCate')->name('dhcd.api.tailieu.category');
});

$apiPrefix = '/apk';
Route::group(array('prefix' => $apiPrefix), function () {
    Route::get('app-debug', 'SettingController@appDebug');
});

//if (App::environment('production')) {
    $apiPrefix = '/resource';
    Route::group(array('prefix' => $apiPrefix), function () {
        Route::get('{route_hash}', 'GlobalController@get');
    });
//} else {
//    $apiPrefix = config('site.api_prefix');
//    Route::group(array('prefix' => $apiPrefix), function() {
//
//        Route::get('menu', 'MenuController@getMenu');
//        Route::get('events', 'EventsController@getEvents');
//
//        Route::get('news-home', 'NewsController@getNewshome');
//        Route::get('news', 'NewsController@getNews');
//        Route::get('detail-new', 'NewsController@getNewsdetail');
//
//        Route::get('forum', 'ForumController@getForum');
//        Route::get('getuserinfo', 'MemberController@getMember');
//    });
//}
