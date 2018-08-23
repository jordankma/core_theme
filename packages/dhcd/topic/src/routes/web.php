<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/topic/topic/log', 'TopicController@log')->name('dhcd.topic.topic.log');
        Route::get('dhcd/topic/topic/data', 'TopicController@data')->name('dhcd.topic.topic.data');
        Route::get('dhcd/topic/topic/manage', 'TopicController@manage')->name('dhcd.topic.topic.manage') ->where('as','Topic - Danh sách');
        
        Route::get('dhcd/topic/topic/create', 'TopicController@create')->name('dhcd.topic.topic.create');
        Route::post('dhcd/topic/topic/add', 'TopicController@add')->name('dhcd.topic.topic.add');
       
        Route::get('dhcd/topic/topic/show', 'TopicController@show')->name('dhcd.topic.topic.show');
        Route::post('dhcd/topic/topic/update', 'TopicController@update')->name('dhcd.topic.topic.update');
        
        Route::get('dhcd/topic/topic/delete', 'TopicController@delete')->name('dhcd.topic.topic.delete');
        Route::get('dhcd/topic/topic/confirm-delete', 'TopicController@getModalDelete')->name('dhcd.topic.topic.confirm-delete');

        Route::get('dhcd/topic/topic/status', 'TopicController@status')->name('dhcd.topic.topic.status');
        Route::get('dhcd/topic/topic/confirm-status', 'TopicController@getModalstatus')->name('dhcd.topic.topic.confirm-status');

        Route::get('dhcd/topic/topic/add-all-member', 'TopicController@addAllMember')->name('dhcd.topic.topic.add_all_member');
        Route::get('dhcd/topic/topic/confirm-add-all-member', 'TopicController@getModalAddAllMember')->name('dhcd.topic.topic.confirm_add_all_member');

        Route::get('dhcd/topic/topic/create/member', 'TopicController@createMember')->name('dhcd.topic.topic.create.member');
        Route::post('dhcd/topic/topic/add/member', 'TopicController@addMember')->name('dhcd.topic.topic.add.member');
        Route::get('dhcd/topic/topic/data/member', 'TopicController@dataMember')->name('dhcd.topic.topic.data.member');
        Route::get('dhcd/topic/topic/delete/member', 'TopicController@deleteMember')->name('dhcd.topic.topic.delete.member');
        Route::get('dhcd/topic/topic/confirm-delete/member', 'TopicController@getModalDeleteMember')->name('dhcd.topic.topic.confirm-delete.member');
        Route::get('dhcd/topic/topic/search/member', 'TopicController@searchMember')->name('dhcd.topic.topic.search.member');
    });
});
Route::group(array('prefix' => 'dev'), function() {
    Route::get('get/topic', 'ApiTopicController@getTopic');    
});