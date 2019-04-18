<?php
$apiPrefix = config('site.api_prefix');
Route::group(array('prefix' => $apiPrefix), function () {
    Route::group(['middleware' => ['adtech.bearer']], function () {

    });
});

$adminPrefix = config('site.admin_prefix');
Route::group(['prefix' => 'api/exam/get', 'as' => 'api.exam.get'], function () {
//    \Debugbar::disable();
    Route::get('prepare', 'ExamController@prepare')->name('prepare');
    Route::get('start', 'ExamController@start')->name('start');
    Route::get('end', 'ExamController@end')->name('end');
});
Route::group(array('prefix' => $adminPrefix), function() {


});