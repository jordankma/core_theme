<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/events/events/show', 'EventsController@show')->name('dhcd.events.events.show');

        Route::get('dhcd/events/events/log', 'EventsController@log')->name('dhcd.events.events.log');

        Route::get('dhcd/events/events/manage', 'EventsController@manage')->where('as','Quản lý chương trình')->name('dhcd.events.events.manage');

        Route::get('dhcd/events/events/data', 'EventsController@data')->name('dhcd.events.events.data');

        Route::get('dhcd/events/events/create', 'EventsController@create')->where('as','Thêm chương trình')->name('dhcd.events.events.create');

        Route::post('dhcd/events/events/add', 'EventsController@add')->name('dhcd.events.events.add');

        Route::put('dhcd/events/events/update', 'EventsController@update')->where('as','Sửa đổi chương trình')->name('dhcd.events.events.update');

        Route::get('dhcd/events/events/delete', 'EventsController@delete')->name('dhcd.events.events.delete');
        
        Route::get('dhcd/events/events/confirm-delete', 'EventsController@getModalDelete')->name('dhcd.events.events.confirm-delete');
        
        Route::get('dhcd/events/events/detail','EventsController@detail')->name('dhcd.events.events.detail');

    });
});
Route::group(array('prefix' => 'dev'), function(){
 Route::get('get/event','EventsApiController@events');
});
Route::group(array('prefix' => 'dev'), function(){
 Route::get('get/events',function(){
 $url = "http://dev.local.vn/dev/get/event";
 $res = file_get_contents($url);
 $res = str_replace(['\"','"[{','}]"'],['"','[{','}]'], $res);
    // $res = str_replace('\"', '"', $res);
    // $res = str_replace('"[{', '[{', $res);
    // $res = str_replace('}]"', '}]', $res);
    return $res;
 });
});

